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

    // Wordpress doesn't load upgrade.php by default
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    
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

    dbDelta( $sql );


    // Create the ad_metadata data table
    $table_name = $wpdb->prefix . 'ad_metadata';
    
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      wp_identifier mediumint(9) NOT NULL,
      ad_sponsor varchar(200),
      ad_sponsor_type varchar(100),
      ad_candidate varchar(200),
      ad_message varchar(100),
      ad_type varchar(100),
      ad_race varchar(100),
      UNIQUE KEY id (id),
      KEY wp_identifier (wp_identifier),
      KEY ad_sponsor (ad_sponsor),
      KEY ad_candidate (ad_candidate),
      KEY ad_message (ad_message),
      KEY ad_type (ad_type),
      KEY ad_race (ad_race)
    ) $charset_collate;";

    dbDelta( $sql );
  }

  /////////////////
  // Utility methods for use in themes
  // TODO: post meta should be stored in a separate table, rather than as meta fields.
  function get_candidates() {
    global $wpdb;    
    $table_name = $wpdb->prefix . 'ad_metadata';
    $query = "SELECT count(*) as ad_count,
                     sponsor as sponsor
                FROM ".$table_name."
            GROUP BY sponsor
            ORDER BY ad_count desc";

    $results = $wpdb->get_results($query);
    print_r($results);
    echo($query);
  }

  function get_sponsors() {

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
      $instances = get_ad_archive_instances($ad_identifier);
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
        $instances = get_ad_archive_instances($ad_identifier, $count);
        if(sizeof($docs) == 0)
          $count = $total;
      }

      // STEP 3: Update metadata based on the instance list
      $metadata = get_ad_archive_metadata($ad_identifier);

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

      $metadata = [
        'embed_url' => $ad_embed_url,
        'ad_id' => $ad_id,
        'ad_sponsor' => $ad_sponsor,
        'ad_candidate' => $ad_candidate,
        'ad_type' => $ad_type,
        'ad_air_count' => $ad_air_count,
        'ad_market_count' => $ad_market_count,
        'ad_network_count' => $ad_network_count,
        'ad_first_seen' => $ad_first_seen,
        'ad_last_seen' => $ad_last_seen
      ];
      save_ad_metadata($wp_identifier, $metadata);
    }
  }


  /**
   * Saves metadata in the appropriate buckets (custom fields or custom table)
   */
  function save_ad_metadata($wp_identifier, $metadata) {
    global $wpdb;

    // Update or save the meta stored in a metadata table
    $update_array = array();
    $update_array['wp_identifier'] = $wp_identifier;
    if(array_key_exists('ad_sponsor', $metadata)) {
      $update_array['ad_sponsor'] = $metadata['ad_sponsor'];
    }
    if(array_key_exists('ad_candidate', $metadata)) {
      $update_array['ad_candidate'] = $metadata['ad_candidate'];
    }
    if(array_key_exists('ad_type', $metadata)) {
      $update_array['ad_type'] = $metadata['ad_type'];
    }
    if(array_key_exists('ad_sponsor_type', $metadata)) {
      $update_array['ad_sponsor_type'] = $metadata['ad_sponsor_type'];
    }
    if(array_key_exists('ad_race', $metadata)) {
      $update_array['ad_race'] = $metadata['ad_race'];
    }
    if(array_key_exists('ad_message', $metadata)) {
      $update_array['ad_message'] = $metadata['ad_message'];
    }
    if(sizeof($update_array) > 0) {

      $table_name = $wpdb->prefix . 'ad_metadata';

      // Check if a row already exists for this
      $query = "SELECT id as id
              FROM ".$table_name."
             WHERE wp_identifier = '".mysql_real_escape_string($wp_identifier)."'";
      
      $results = $wpdb->get_results($query);
      if(sizeof($results) > 0) {
        $wpdb->update(
          $table_name,
          $update_array,
          array('wp_identifier' => $wp_identifier));
      } else {
        $wpdb->insert(
          $table_name,
          $update_array
        );
      }
    }

    // Update the meta stored in custom fields
    if(array_key_exists('embed_url', $metadata)) {
      update_post_meta( $wp_identifier, '_archive_ad_embed_url', $metadata['embed_url'] );
    }
    if(array_key_exists('notes', $metadata)) {
      update_post_meta( $wp_identifier, '_archive_ad_notes', $metadata['notes'] );
    }
    if(array_key_exists('ad_id', $metadata)) {
      update_post_meta( $wp_identifier, '_archive_ad_id', $metadata['ad_id'] );
    }
    if(array_key_exists('ad_air_count', $metadata)) {
      update_post_meta( $wp_identifier, '_archive_ad_air_count', $metadata['ad_air_count'] );
    }
    if(array_key_exists('ad_market_count', $metadata)) {
      update_post_meta( $wp_identifier, '_archive_ad_market_count', $metadata['ad_market_count'] );
    }
    if(array_key_exists('ad_network_count', $metadata)) {
      update_post_meta( $wp_identifier, '_archive_ad_network_count', $metadata['ad_network_count'] );
    }
    if(array_key_exists('ad_first_seen', $metadata)) {
      update_post_meta( $wp_identifier, '_archive_ad_first_seen', $metadata['ad_first_seen'] );
    }
    if(array_key_exists('ad_last_seen', $metadata)) {
      update_post_meta( $wp_identifier, '_archive_ad_last_seen', $metadata['ad_last_seen'] );
    }
  }

  /**
   * Get the metadata for an ad (from table + custom fields)
   */
  function get_ad_metadata($wp_identifier) {
    global $wpdb;

    $ad_metadata = array(
      'embed_url' => "",
      'notes' => "",
      'ad_id' => "",
      'ad_sponsor' => "",
      'ad_candidate' => "",
      'ad_message' => "",
      'ad_race' => "",
      'ad_type' => "",
      'ad_air_count' => "",
      'ad_market_count' => "",
      'ad_network_count' => "",
      'ad_first_seen' => "",
      'ad_last_seen' => ""
    );

    $table_name = $wpdb->prefix . 'ad_metadata';
    $query = "SELECT ad_sponsor as ad_sponsor,
                     ad_sponsor_type as ad_sponsor_type,
                     ad_candidate as ad_candidate,
                     ad_message as ad_message,
                     ad_type as ad_type,
                     ad_race as ad_race
            FROM ".$table_name."
           WHERE wp_identifier = '".mysql_real_escape_string($wp_identifier)."'";

    $results = $wpdb->get_results($query);

    if(sizeof($results) > 0) {
      $results = $results[0];
      $ad_metadata['ad_sponsor'] = $results->ad_sponsor;
      $ad_metadata['ad_candidate'] = $results->ad_sponsor_type;
      $ad_metadata['ad_type'] = $results->ad_type;
      $ad_metadata['ad_race'] = $results->ad_race;
      $ad_metadata['ad_message'] = $results->ad_message;
    }

    $post_metadata = get_post_meta($wp_identifier);
    $ad_metadata['embed_url'] = $post_metadata['_archive_ad_embed_url'][0];
    $ad_metadata['notes'] = $post_metadata['_archive_ad_notes'][0];
    $ad_metadata['ad_id'] = $post_metadata['_archive_ad_id'][0];
    $ad_metadata['ad_air_count'] = $post_metadata['_archive_ad_air_count'][0];
    $ad_metadata['ad_market_count'] = $post_metadata['_archive_ad_market_count'][0];
    $ad_metadata['ad_network_count'] = $post_metadata['_archive_ad_network_count'][0];
    $ad_metadata['ad_first_seen'] = $post_metadata['_archive_ad_first_seen'][0];
    $ad_metadata['ad_last_seen'] = $post_metadata['_archive_ad_last_seen'][0];

    return $ad_metadata;
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

  function get_ad_archive_instances($ad_identifier, $offset=0) {
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

  function get_ad_archive_metadata($ad_identifier) {

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
  // Export API
  // Check out http://coderrr.com/create-an-api-endpoint-in-wordpress/ for approach info

  add_filter('query_vars', 'export_add_query_vars');
  add_action('parse_request', 'export_sniff_requests');
  add_action('init', 'export_add_endpoint');
 
  /** Add public query vars
   * @param array $vars List of current public query vars
   * @return array $vars 
   */
  function export_add_query_vars($vars){
    $vars[] = '__export';
    $vars[] = 'export_options';
    return $vars;
  } 

  /** Add API Endpoint
   * This is where the magic happens - brush up on your regex skillz
   * @return void
   */
  function export_add_endpoint(){
    add_rewrite_rule('^export/?(.*)?/?','index.php?__export=1&export_options=$matches[1]','top');
  }

  /** Sniff Requests
   * This is where we hijack all API requests
   *   If $_GET['__api'] is set, we kill WP and serve up pug bomb awesomeness
   * @return die if API request
   */
  function export_sniff_requests(){
    global $wp;
    if(isset($wp->query_vars['__export'])){
      export_handle_request();
      exit;
    }
  }

  /** Handle Requests
   * This is where we send off for an intense pug bomb package
   * @return void 
   */
  function export_handle_request(){
    global $wp;
    global $wpdb;

    // Collect the data associated with this ad
    $table_name = $wpdb->prefix . 'ad_instances';

    $query = "SELECT id as id,
                     channel as channel,
                     air_time as air_time,
                     ad_identifier as ad_identifier,
                     archive_identifier as archive_identifier,
                     wp_identifier as wp_identifier
            FROM ".$table_name." ";

    if(array_key_exists('ad_identifier', $_GET)) {
      $ad_identifier = $_GET['ad_identifier'];
      $query .= "WHERE ad_identifier = '".mysql_real_escape_string($ad_identifier)."'";
    }
           

    $results = $wpdb->get_results($query);
    $post_id = $results[0]->wp_identifier;

    $ad_embed_url = get_post_meta( $post_id, '_archive_ad_embed_url', true );
    $ad_notes = get_post_meta( $post_id, '_archive_ad_notes', true );
    $ad_id = get_post_meta( $post_id, '_archive_ad_id', true );
    $ad_sponsor = get_post_meta( $post_id, '_archive_ad_sponsor', true );
    $ad_candidate = get_post_meta( $post_id, '_archive_ad_candidate', true );
    $ad_type = get_post_meta( $post_id, '_archive_ad_type', true );
    $ad_race = get_post_meta( $post_id, '_archive_ad_race', true );
    $ad_message = get_post_meta( $post_id, '_archive_ad_message', true );
    $ad_air_count = get_post_meta( $post_id, '_archive_ad_air_count', true );
    $ad_market_count = get_post_meta( $post_id, '_archive_ad_market_count', true );
    $ad_network_count = get_post_meta( $post_id, '_archive_ad_network_count', true );
    $ad_first_seen = get_post_meta( $post_id, '_archive_ad_first_seen', true );
    $ad_last_seen = get_post_meta( $post_id, '_archive_ad_last_seen', true );

    $rows = array();
    $metadata_cache = array();
    foreach($results as $result) {
      $ad_identifier = $result->ad_identifier;
      $channel = $result->channel;
      $air_time = $result->air_time;
      $archive_identifier = $result->archive_identifier;

      // Cache the metadata for this identifier
      if(!array_key_exists($ad_identifier, $metadata_cache)) {
        $wp_meta = get_post_meta($post_id);
        $metadata['ad_embed_url'] = $wp_meta['_archive_ad_embed_url'][0];
        $metadata['ad_notes'] = $wp_meta['_archive_ad_notes'][0];
        $metadata['ad_id'] = $wp_meta['_archive_ad_id'][0];
        $metadata['ad_sponsor'] = $wp_meta['_archive_ad_sponsor'][0];
        $metadata['ad_candidate'] = $wp_meta['_archive_ad_candidate'][0];
        $metadata['ad_type'] = $wp_meta['_archive_ad_type'][0];
        $metadata['ad_race'] = $wp_meta['_archive_ad_race'][0];
        $metadata['ad_message'] = $wp_meta['_archive_ad_message'][0];
        $metadata['ad_air_count'] = $wp_meta['_archive_ad_air_count'][0];
        $metadata['ad_market_count'] = $wp_meta['_archive_ad_market_count'][0];
        $metadata['ad_network_count'] = $wp_meta['_archive_ad_network_count'][0];
        $metadata['ad_first_seen'] = $wp_meta['_archive_ad_first_seen'][0];
        $metadata['ad_last_seen'] = $wp_meta['_archive_ad_last_seen'][0];
        $metadata_cache[$ad_identifier] = $metadata;
      }

      // Load the metadata from the cache
      $ad_embed_url = $metadata_cache[$ad_identifier]['ad_embed_url'];
      $ad_notes = $metadata_cache[$ad_identifier]['ad_notes'];
      $ad_id = $metadata_cache[$ad_identifier]['ad_id'];
      $ad_sponsor = $metadata_cache[$ad_identifier]['ad_sponsor'];
      $ad_candidate = $metadata_cache[$ad_identifier]['ad_candidate'];
      $ad_type = $metadata_cache[$ad_identifier]['ad_type'];
      $ad_race = $metadata_cache[$ad_identifier]['ad_race'];
      $ad_message = $metadata_cache[$ad_identifier]['ad_message'];
      $ad_air_count = $metadata_cache[$ad_identifier]['ad_air_count'];
      $ad_market_count = $metadata_cache[$ad_identifier]['ad_market_count'];
      $ad_network_count = $metadata_cache[$ad_identifier]['ad_network_count'];
      $ad_first_seen = $metadata_cache[$ad_identifier]['ad_first_seen'];
      $ad_last_seen = $metadata_cache[$ad_identifier]['ad_last_seen'];

      // Create the row
      $row = [
        "ad_identifier" => $ad_identifier,
        "channel" => $channel,
        "air_time" => $air_time,
        "archive_identifier" => $archive_identifier,
        "embed_url" => $ad_embed_url,
        "sponsor" => $ad_sponsor,
        "candidate" => $ad_candidate,
        "type" => $ad_type,
        "race" => $ad_race,
        "message" => $ad_message,
        "notes" => $notes
      ];
      array_push($rows, $row);
    }

    export_send_response($rows);
  }

  /** Response Handler
   * This sends a JSON response to the browser
   */
  function export_send_response($rows){
    // output headers so that the file is downloaded rather than displayed
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');
    if(sizeof($rows) == 0)
      exit;

    // Create the header data
    $header = array_keys($rows[0]);

    // create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

    // output the column headings
    fputcsv($output, $header);

    // loop over the rows, outputting them
    foreach($rows as $row) {
      fputcsv($output, $row);
    }

    exit;
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

    $ad_metadata = get_ad_metadata( $post->ID );

    echo('<ul>');

    // Insert the Ad Embed URL form
    $value = get_post_meta( $post->ID, '_archive_ad_embed_url', true );
    echo('<li>');
    echo '<label for="archive_ad_embed_url">';
    _e( 'Embed URL', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_embed_url" name="archive_ad_embed_url" value="' . esc_attr( $ad_metadata['embed_url'] ) . '" size="100" />';
    echo('</li>');

    // Insert the Ad Notes form
    $value = get_post_meta( $post->ID, '_archive_ad_notes', true );
    echo('<li>');
    echo '<label for="archive_ad_notes">';
    _e( 'Notes', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<textarea id="archive_ad_notes" name="archive_ad_notes" rows="5" cols="50">'. esc_attr( $ad_metadata['notes'] ) . '</textarea>';
    echo('</li>');

    // Insert the Ad ID form
    $value = get_post_meta( $post->ID, '_archive_ad_id', true );
    echo('<li>');
    echo '<label for="archive_ad_id">';
    _e( 'Archive ID', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_id" name="archive_ad_id" value="' . esc_attr( $ad_metadata['ad_id'] ) . '" size="50" />';
    echo('</li>');

    // Insert the Ad sponsor form
    $value = get_post_meta( $post->ID, '_archive_ad_sponsor', true );
    echo('<li>');
    echo '<label for="archive_ad_sponsor">';
    _e( 'Sponsor', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_sponsor" name="archive_ad_sponsor" value="' . esc_attr( $ad_metadata['ad_sponsor'] ) . '" size="50" />';
    echo('</li>');

    // Insert the Ad candidate form
    $value = get_post_meta( $post->ID, '_archive_ad_candidate', true );
    echo('<li>');
    echo '<label for="archive_ad_candidate">';
    _e( 'Candidate', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_candidate" name="archive_ad_candidate" value="' . esc_attr( $ad_metadata['ad_candidate'] ) . '" size="50" />';
    echo('</li>');

    // Insert the Ad type form
    $value = get_post_meta( $post->ID, '_archive_ad_type', true );
    echo('<li>');
    echo '<label for="archive_ad_type">';
    _e( 'Type', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_type" name="archive_ad_type" value="' . esc_attr( $ad_metadata['ad_type'] ) . '" size="50" />';
    echo('</li>');

    // Insert the Ad race form
    $value = get_post_meta( $post->ID, '_archive_ad_race', true );
    echo('<li>');
    echo '<label for="archive_ad_race">';
    _e( 'Race', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_race" name="archive_ad_race" value="' . esc_attr( $ad_metadata['ad_race'] ) . '" size="50" />';
    echo('</li>');

    // Insert the Ad message form
    $value = get_post_meta( $post->ID, '_archive_ad_message', true );
    echo('<li>');
    echo '<label for="archive_ad_message">';
    _e( 'Message', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_message" name="archive_ad_message" value="' . esc_attr( $ad_metadata['ad_message'] ) . '" size="50" />';
    echo('</li>');

    // Insert the Ad air count form
    $value = get_post_meta( $post->ID, '_archive_ad_air_count', true );
    echo('<li>');
    echo '<label for="archive_ad_air_count">';
    _e( 'Air Count', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_air_count" name="archive_ad_air_count" value="' . esc_attr( $ad_metadata['ad_air_count'] ) . '" size="5" />';
    echo('</li>');

    // Insert the Ad market count form
    $value = get_post_meta( $post->ID, '_archive_ad_market_count', true );
    echo('<li>');
    echo '<label for="archive_ad_market_count">';
    _e( 'Market Count', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_market_count" name="archive_ad_market_count" value="' . esc_attr( $ad_metadata['ad_market_count'] ) . '" size="5" />';
    echo('</li>');

    // Insert the Ad network count form
    $value = get_post_meta( $post->ID, '_archive_ad_network_count', true );
    echo('<li>');
    echo '<label for="archive_ad_network_count">';
    _e( 'Network Count', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_network_count" name="archive_ad_network_count" value="' . esc_attr( $ad_metadata['ad_network_count'] ) . '" size="5" />';
    echo('</li>');

    // Insert the Ad first seen form
    $value = get_post_meta( $post->ID, '_archive_ad_first_seen', true );
    echo('<li>');
    echo '<label for="archive_ad_first_seen">';
    _e( 'First Seen', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_first_seen" name="archive_ad_first_seen" value="' . esc_attr( $ad_metadata['ad_first_seen'] ) . '" size="5" />';
    echo('</li>');

    // Insert the Ad first seen form
    $value = get_post_meta( $post->ID, '_archive_ad_last_seen', true );
    echo('<li>');
    echo '<label for="archive_ad_last_seen">';
    _e( 'Last Seen', 'archive_ad_textdomain' );
    echo '</label> ';
    echo '<input type="text" id="archive_ad_last_seen" name="archive_ad_last_seen" value="' . esc_attr( $ad_metadata['ad_last_seen'] ) . '" size="5" />';
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

    $metadata = array();
    
    if(isset($_POST['archive_ad_embed_url'])) {
      $metadata['embed_url'] = sanitize_text_field( $_POST['archive_ad_embed_url'] );
    }

    if(isset($_POST['archive_ad_notes'])) {
      $metadata['notes'] = sanitize_text_field( $_POST['archive_ad_notes'] );
    }

    if(isset($_POST['archive_ad_id'])) {
      $metadata['ad_id'] = sanitize_text_field( $_POST['archive_ad_id'] );
    }

    if(isset($_POST['archive_ad_sponsor'])) {
      $metadata['ad_sponsor'] = sanitize_text_field( $_POST['archive_ad_sponsor'] );
    }

    if(isset($_POST['archive_ad_candidate'])) {
      $metadata['ad_candidate'] = sanitize_text_field( $_POST['archive_ad_candidate'] );
    }

    if(isset($_POST['archive_ad_type'])) {
      $metadata['ad_type'] = sanitize_text_field( $_POST['archive_ad_type'] );
    }

    if(isset($_POST['archive_ad_race'])) {
      $metadata['ad_race'] = sanitize_text_field( $_POST['archive_ad_race'] );
    }

    if(isset($_POST['archive_ad_message'])) {
      $metadata['ad_message'] = sanitize_text_field( $_POST['archive_ad_message'] );
    }

    if(isset($_POST['archive_ad_air_count'])) {
      $metadata['ad_air_count'] = sanitize_text_field( $_POST['archive_ad_air_count'] );
    }

    if(isset($_POST['archive_ad_market_count'])) {
      $metadata['ad_market_count'] = sanitize_text_field( $_POST['archive_ad_market_count'] );
    }

    if(isset($_POST['archive_ad_network_count'])) {
      $metadata['ad_network_count'] = sanitize_text_field( $_POST['archive_ad_network_count'] );
    }

    if(isset($_POST['archive_ad_first_seen'])) {
      $metadata['ad_first_seen'] = sanitize_text_field( $_POST['archive_ad_first_seen'] );
    }

    if(isset($_POST['archive_ad_last_seen'])) {
      $metadata['ad_last_seen'] = sanitize_text_field( $_POST['archive_ad_last_seen'] );
    }

    save_ad_metadata($post_id, $metadata);

  }

?>