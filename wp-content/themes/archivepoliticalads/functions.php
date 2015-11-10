<?php


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