<?php

  // TODO: Some of the stuff in this file should be converted into individual plugins with proper plugin classes / etc.

  // Load the theme config file
  include('theme-config.php');

  /////////////////
  // Set up the database on theme activation
  // For more info check out http://codex.wordpress.org/Creating_Tables_with_Plugins
  add_action( 'init', 'create_ad_db' );
  function create_ad_db() {
    global $wpdb;
    global $ad_db_version;

    // Create the ad instances data table
    $table_name = $wpdb->prefix . 'ad_instances';
    
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      wp_identifier mediumint(9) NOT NULL,
      ad_identifier varchar(50) NOT NULL,
      archive_identifier varchar(100) NOT NULL,
      channel varchar(20),
      air_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      UNIQUE KEY id (id),
      UNIQUE KEY archive_identifier (archive_identifier),
      KEY wp_identifier (wp_identifier),
      KEY ad_identifier (ad_identifier),
      KEY channel (channel)
    ) $charset_collate;";

    // Wordpress doesn't load upgrade.php by default
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
  }


  /////////////////
  // Schedule a regular sync with the archive
  register_activation_hook(__FILE__, 'activate_archive_sync');
  add_action('archive_sync', 'run_archive_sync');

  add_action( 'init', 'run_archive_sync' );
  function activate_archive_sync() {
    // wp_schedule_event(// (), 'hourly', 'archive_sync');
  }

  function run_archive_sync() {

    ///////
    // STEP 1: Load all newly discovered political ads, creating entries for each new ad


    // STEP 1.1: Get a list of new ads
    // TODO: wire this up to use the http://www-tracey.archive.org
    $new_ads = get_new_ads();

    // STEP 1.2: Go through the list and make sure there is a "post" for each ad
    foreach($new_ads as $new_ad) {
      $new_ad_identifier = $new_ad->ad_id;
      
      // Does the ad already exist?
      $existing_ad = get_page_by_title( $new_ad_identifier, OBJECT, 'archive_political_ad');
      if($existing_ad)
        continue;

      // Create a new post for the ad
      $post = array(
        'post_name'      => $new_ad_identifier,
        'post_title'     => $new_ad_identifier,
        'post_status'    => 'draft', // Eventually we may want this to be 'publish'
        'post_type'      => 'archive_political_ad'
      );
      wp_insert_post( $post );
    }


    // STEP 2 + 3: Load the list of existing ads update the metadata
    global $wpdb;
    $existing_ads = get_posts(array(
      'post_type' => 'archive_political_ad',
      'post_status' => 'any'
    ));

    foreach($existing_ads as $existing_ad) {

      $wp_identifier = $existing_ad->ID;
      $ad_identifier = $existing_ad->post_title;

      // STEP 2: Get every instance, and create a record for each instance
      // NOTE: it won't double insert when run more than once due to the unique key
      // TODO: maybe we should explicitly check for dupes before entering?
      $instances = get_ad_instances($ad_identifier);
      $total = $instances->numFound;
      $count = 0;
      while($count < $total) {
        $docs = $instances->docs;
        foreach($docs as $doc) {
          $count += 1;
          $archive_identifier = $doc->identifier;
          $channel = $doc->channel;
          $air_time = $doc->start;
          
          $table_name = $wpdb->prefix . 'ad_instances';
          
          $wpdb->insert( 
            $table_name,
            array( 
              'wp_identifier' => $wp_identifier, 
              'ad_identifier' => $ad_identifier, 
              'archive_identifier' => $archive_identifier,
              'channel' => $channel,
              'air_time' => $air_time,
            ) 
          );
        }
        $instances = get_ad_instances($ad_identifier, $count);
        if(sizeof($docs) == 0)
          $count = $total;
      }

      // STEP 3: Update metadata based on the instance list
      $metadata = get_ad_metadata($ad_identifier);

      // Now that we have the data, lets update the metadata for the canonical ad itself
      $table_name = $wpdb->prefix . 'ad_instances';

      $query = "SELECT count(*) as air_count,
                       count(DISTINCT channel) as network_count,
                       MIN(air_time) as first_seen,
                       MAX(air_time) as last_seen
                  FROM ".$table_name."
                 WHERE ad_identifier = '".mysql_real_escape_string($ad_identifier)."'
              GROUP BY ad_identifier";

      $results = $wpdb->get_results($query);
      $results = $results[0];

      $ad_embed_url = 'http://'.ARCHIVE_API_HOST.'/embed/'.$ad_identifier;
      $ad_id = $ad_identifier;
      $ad_sponsor = $metadata->metadata->sponsor;
      $ad_candidate = $metadata->metadata->contributor;
      $ad_type = "Political Ad";
      //$ad_race = "";
      //$ad_message = "";
      $ad_air_count = $results->air_count;
      $ad_market_count = 0;
      $ad_network_count = $results->network_count;
      $ad_first_seen = $results->first_seen;
      $ad_last_seen = $results->last_seen;

      update_post_meta( $wp_identifier, '_archive_ad_embed_url', $ad_embed_url );
      // update_post_meta( $wp_identifier, '_archive_ad_notes', $my_data );
      update_post_meta( $wp_identifier, '_archive_ad_id', $ad_id );
      update_post_meta( $wp_identifier, '_archive_ad_sponsor', $ad_sponsor );
      update_post_meta( $wp_identifier, '_archive_ad_candidate', $ad_candidate );
      update_post_meta( $wp_identifier, '_archive_ad_type', $ad_type );
      //update_post_meta( $wp_identifier, '_archive_ad_race', $ad_race );
      //update_post_meta( $wp_identifier, '_archive_ad_message', $ad_message );
      update_post_meta( $wp_identifier, '_archive_ad_air_count', $ad_air_count );
      update_post_meta( $wp_identifier, '_archive_ad_market_count', $ad_market_count );
      update_post_meta( $wp_identifier, '_archive_ad_network_count', $ad_network_count );
      update_post_meta( $wp_identifier, '_archive_ad_first_seen', $ad_first_seen );
      update_post_meta( $wp_identifier, '_archive_ad_last_seen', $ad_last_seen );
    }
  }
  function get_new_ads() {

      // Get a list of ad instances from the archive
      $url = ARCHIVE_API_HOST.'/details/tv?weekads=1&output=json';

      // Create the GET
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);

      // Take in the server's response
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Run the CURL
      $curl_result = curl_exec($ch);
      curl_close ($ch);

      // Parse the result
      $result = json_decode($curl_result);

      return $result;
  }

  function get_ad_instances($ad_identifier, $offset=0) {
      // Get a list of ad instances from the archive
      $url = ARCHIVE_SEARCH_HOST.'/solr/select?indent=yes&omitHeader=true&wt=json&start='.$offset.'&q=ad_id:'.$ad_identifier;

      // Create the GET
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);

      // Take in the server's response
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Run the CURL
      $curl_result = curl_exec($ch);
      curl_close ($ch);

      // Parse the result
      $result = json_decode($curl_result);

      return $result->response;
  }

  function get_ad_metadata($ad_identifier) {

      // Get a list of ad instances from the archive
      $url = ARCHIVE_API_HOST.'/metadata/'.$ad_identifier;

      // Create the GET
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);

      // Take in the server's response
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Run the CURL
      $curl_result = curl_exec($ch);
      curl_close ($ch);

      // Parse the result
      $result = json_decode($curl_result);

      return $result;
  }

  /////////////////
  // Add styles and scripts
  add_action( 'wp_enqueue_scripts', 'archivepoliticalads_scripts' );
  function archivepoliticalads_scripts() {

    // Load the main styles
    wp_enqueue_style( 'style.css', get_stylesheet_uri() );
    
    // Load in jQuery
    wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery.min.js', array(), '2.1.4', true );

    // Load in bootstrap
    wp_enqueue_style( 'bootstrap.css', get_template_directory_uri() . '/css/bootstrap.css' );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '3.3.5', true );

  }


  /////////////////
  // Register political ads as a special type of post
  // TODO: Ad meta tags https://codex.wordpress.org/Function_Reference/register_post_type
        
  add_action( 'init', 'create_post_type' );
  function create_post_type() {
    register_post_type( 'archive_political_ad',
      array(
        'labels' => array(
          'name' => __( 'Political Ads' ),
          'singular_name' => __( 'Political Ad' ),
          'add_new_item' => __( 'Add New Ad' ),
          'edit_item' => __( 'Edit Ad' ),
          'new_item' => __( 'New Ad' ),
          'view_item' => __( 'View Ad' ),
          'search_items' => __( 'Search Ads' ),
          'not_found' => __( 'No ads found' ),
          'not_found_in_trash' => __( 'No ads found in Trash' ),
          'parent_item_colon' => __( 'Parent Ad' ),
        ),
        'capabilities' => array(
          'edit_post'          => 'edit_ad', 
          'read_post'          => 'read_ad', 
          'delete_post'        => 'delete_ad', 
          'edit_posts'         => 'edit_ads', 
          'edit_others_posts'  => 'edit_others_ads', 
          'publish_posts'      => 'publish_ads',       
          'read_private_posts' => 'read_private_ads', 
          'create_posts'       => 'create_ads', 
        ),
        'description' => __( 'A political ad identified and tracked by the Internet Archive.' ),
        'public' => true,
        'menu_icon' => 'dashicons-media-video',
        'has_archive' => true,
        'supports' => array( 'title')
      )
    );
  }

  /////////////////
  // Set up proper user permissions for editing ads

  add_action( 'admin_init', 'add_theme_capabilities');
  function add_theme_capabilities() {

    $roles = ['author', 'administrator'];

    foreach ( $roles as $roleName ) {

      // Get the author role
      $role = get_role( $roleName );

      // Add full political ad edit capabilities
      $role->add_cap( 'edit_ad' );
      $role->add_cap( 'read_ad' );
      $role->add_cap( 'delete_ad' );
      $role->add_cap( 'edit_ads' );
      $role->add_cap( 'edit_others_ads' );
      $role->add_cap( 'publish_ads' );
      $role->add_cap( 'read_private_ads' );
      $role->add_cap( 'create_ads' );
    }
  }


  /////////////////
  // Register the ad meta fields
  // Documentation: http://codex.wordpress.org/Function_Reference/add_meta_box

  add_action( 'add_meta_boxes', 'archive_ad_meta_box_add' );
  add_action( 'save_post', 'archive_ad_save_meta_box_data' );


  /**
   * Adds a box to the main column on the Political Ad edit screens.
   */
  function archive_ad_meta_box_add() {
    add_meta_box(
      'archive_ad',
      __( 'Political Ad Metadata'),
      'archive_ad_meta_box_callback',
      'archive_political_ad'
    );
  }

  /**
   * Prints the box content.
   * 
   * @param WP_Post $post The object for the current post/page.
   */
  function archive_ad_meta_box_callback( $post ) {

    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'archive_ad_save_meta_box_data', 'archive_ad_meta_box_nonce' );

    echo('<ul>');

    // Insert the Ad Embed URL form
    $value = get_post_meta( $post->ID, '_archive_ad_embed_url', true );
    echo('<li>');
    echo '<label for="archive_ad_embed_url">';
    _e( 'Embed URL', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_embed_url" name="archive_ad_embed_url" value="' . esc_attr( $value ) . '" size="100" />';
    echo('</li>');

    // Insert the Ad Notes form
    $value = get_post_meta( $post->ID, '_archive_ad_notes', true );
    echo('<li>');
    echo '<label for="archive_ad_notes">';
    _e( 'Notes', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<textarea id="archive_ad_notes" name="archive_ad_notes" rows="5" cols="50">'. esc_attr( $value ) . '</textarea>';
    echo('</li>');

    // Insert the Ad ID form
    $value = get_post_meta( $post->ID, '_archive_ad_id', true );
    echo('<li>');
    echo '<label for="archive_ad_id">';
    _e( 'Archive ID', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_id" name="archive_ad_id" value="' . esc_attr( $value ) . '" size="50" />';
    echo('</li>');

    // Insert the Ad sponsor form
    $value = get_post_meta( $post->ID, '_archive_ad_sponsor', true );
    echo('<li>');
    echo '<label for="archive_ad_sponsor">';
    _e( 'Sponsor', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_sponsor" name="archive_ad_sponsor" value="' . esc_attr( $value ) . '" size="50" />';
    echo('</li>');

    // Insert the Ad candidate form
    $value = get_post_meta( $post->ID, '_archive_ad_candidate', true );
    echo('<li>');
    echo '<label for="archive_ad_candidate">';
    _e( 'Candidate', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_candidate" name="archive_ad_candidate" value="' . esc_attr( $value ) . '" size="50" />';
    echo('</li>');

    // Insert the Ad type form
    $value = get_post_meta( $post->ID, '_archive_ad_type', true );
    echo('<li>');
    echo '<label for="archive_ad_type">';
    _e( 'Type', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_type" name="archive_ad_type" value="' . esc_attr( $value ) . '" size="50" />';
    echo('</li>');

    // Insert the Ad race form
    $value = get_post_meta( $post->ID, '_archive_ad_race', true );
    echo('<li>');
    echo '<label for="archive_ad_race">';
    _e( 'Race', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_race" name="archive_ad_race" value="' . esc_attr( $value ) . '" size="50" />';
    echo('</li>');

    // Insert the Ad message form
    $value = get_post_meta( $post->ID, '_archive_ad_message', true );
    echo('<li>');
    echo '<label for="archive_ad_message">';
    _e( 'Message', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_message" name="archive_ad_message" value="' . esc_attr( $value ) . '" size="50" />';
    echo('</li>');

    // Insert the Ad air count form
    $value = get_post_meta( $post->ID, '_archive_ad_air_count', true );
    echo('<li>');
    echo '<label for="archive_ad_air_count">';
    _e( 'Air Count', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_air_count" name="archive_ad_air_count" value="' . esc_attr( $value ) . '" size="5" />';
    echo('</li>');

    // Insert the Ad market count form
    $value = get_post_meta( $post->ID, '_archive_ad_market_count', true );
    echo('<li>');
    echo '<label for="archive_ad_market_count">';
    _e( 'Market Count', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_market_count" name="archive_ad_market_count" value="' . esc_attr( $value ) . '" size="5" />';
    echo('</li>');

    // Insert the Ad network count form
    $value = get_post_meta( $post->ID, '_archive_ad_network_count', true );
    echo('<li>');
    echo '<label for="archive_ad_network_count">';
    _e( 'Network Count', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_network_count" name="archive_ad_network_count" value="' . esc_attr( $value ) . '" size="5" />';
    echo('</li>');

    // Insert the Ad first seen form
    $value = get_post_meta( $post->ID, '_archive_ad_first_seen', true );
    echo('<li>');
    echo '<label for="archive_ad_first_seen">';
    _e( 'First Seen', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_first_seen" name="archive_ad_first_seen" value="' . esc_attr( $value ) . '" size="5" />';
    echo('</li>');

    // Insert the Ad first seen form
    $value = get_post_meta( $post->ID, '_archive_ad_last_seen', true );
    echo('<li>');
    echo '<label for="archive_ad_last_seen">';
    _e( 'Last Seen', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_last_seen" name="archive_ad_last_seen" value="' . esc_attr( $value ) . '" size="5" />';
    echo('</li>');

    echo('</ul>');

  }


  /**
   * When the post is saved, saves our custom data.
   *
   * @param int $post_id The ID of the post being saved.
   */
  function archive_ad_save_meta_box_data( $post_id ) {

    //////////
    // We need to verify this came from our screen and with proper authorization,
    // because the save_post action can be triggered at other times.

    // Check if our nonce is set.
    if( !isset( $_POST['archive_ad_meta_box_nonce'] ) ) {
      return;
    }

    // Verify that the nonce is valid.
    if( ! wp_verify_nonce( $_POST['archive_ad_meta_box_nonce'], 'archive_ad_save_meta_box_data' ) ) {
      return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
      return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'archive_political_ad' == $_POST['post_type'] ) {
      if ( ! current_user_can( 'edit_ad', $post_id ) ) {
        return;
      }
    } else {
      if ( ! current_user_can( 'edit_ad', $post_id ) ) {
        return;
      }
    }

    //////////
    // OK, it's safe for us to save the data now.
    
    if(isset($_POST['archive_ad_embed_url'])) {
      // Sanitize user input.
      $my_data = sanitize_text_field( $_POST['archive_ad_embed_url'] );

      // Update the meta field in the database.
      update_post_meta( $post_id, '_archive_ad_embed_url', $my_data );
    }

    if(isset($_POST['archive_ad_notes'])) {
      // Sanitize user input.
      $my_data = sanitize_text_field( $_POST['archive_ad_notes'] );

      // Update the meta field in the database.
      update_post_meta( $post_id, '_archive_ad_notes', $my_data );
    }

    if(isset($_POST['archive_ad_id'])) {
      // Sanitize user input.
      $my_data = sanitize_text_field( $_POST['archive_ad_id'] );

      // Update the meta field in the database.
      update_post_meta( $post_id, '_archive_ad_id', $my_data );
    }

    if(isset($_POST['archive_ad_sponsor'])) {
      // Sanitize user input.
      $my_data = sanitize_text_field( $_POST['archive_ad_sponsor'] );

      // Update the meta field in the database.
      update_post_meta( $post_id, '_archive_ad_sponsor', $my_data );
    }

    if(isset($_POST['archive_ad_candidate'])) {
      // Sanitize user input.
      $my_data = sanitize_text_field( $_POST['archive_ad_candidate'] );

      // Update the meta field in the database.
      update_post_meta( $post_id, '_archive_ad_candidate', $my_data );
    }

    if(isset($_POST['archive_ad_type'])) {
      // Sanitize user input.
      $my_data = sanitize_text_field( $_POST['archive_ad_type'] );

      // Update the meta field in the database.
      update_post_meta( $post_id, '_archive_ad_type', $my_data );
    }

    if(isset($_POST['archive_ad_race'])) {
      // Sanitize user input.
      $my_data = sanitize_text_field( $_POST['archive_ad_race'] );

      // Update the meta field in the database.
      update_post_meta( $post_id, '_archive_ad_race', $my_data );
    }

    if(isset($_POST['archive_ad_message'])) {
      // Sanitize user input.
      $my_data = sanitize_text_field( $_POST['archive_ad_message'] );

      // Update the meta field in the database.
      update_post_meta( $post_id, '_archive_ad_message', $my_data );
    }

    if(isset($_POST['archive_ad_air_count'])) {
      // Sanitize user input.
      $my_data = sanitize_text_field( $_POST['archive_ad_air_count'] );

      // Update the meta field in the database.
      update_post_meta( $post_id, '_archive_ad_air_count', $my_data );
    }

    if(isset($_POST['archive_ad_market_count'])) {
      // Sanitize user input.
      $my_data = sanitize_text_field( $_POST['archive_ad_market_count'] );

      // Update the meta field in the database.
      update_post_meta( $post_id, '_archive_ad_market_count', $my_data );
    }

    if(isset($_POST['archive_ad_network_count'])) {
      // Sanitize user input.
      $my_data = sanitize_text_field( $_POST['archive_ad_network_count'] );

      // Update the meta field in the database.
      update_post_meta( $post_id, '_archive_ad_network_count', $my_data );
    }

    if(isset($_POST['archive_ad_first_seen'])) {
      // Sanitize user input.
      $my_data = sanitize_text_field( $_POST['archive_ad_first_seen'] );

      // Update the meta field in the database.
      update_post_meta( $post_id, '_archive_ad_first_seen', $my_data );
    }

    if(isset($_POST['archive_ad_last_seen'])) {
      // Sanitize user input.
      $my_data = sanitize_text_field( $_POST['archive_ad_last_seen'] );

      // Update the meta field in the database.
      update_post_meta( $post_id, '_archive_ad_last_seen', $my_data );
    }

  }

?>