<?php

  // TODO: Some of the stuff in this file should be converted into individual plugins with proper plugin classes / etc.

  // Load the theme config file
  include('theme-config.php');
  include_once('functions-fields.php');

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
      id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      wp_identifier mediumint(9) NOT NULL,
      archive_identifier varchar(100) NOT NULL,
      network varchar(20),
      market varchar(20),
      location varchar(128),
      air_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      UNIQUE KEY instance (archive_identifier, network, air_time),
      KEY archive_identifier (archive_identifier),
      KEY wp_identifier (wp_identifier),
      KEY network (network)
    ) $charset_collate;";
    dbDelta( $sql );
    
  }


  /////////////////
  // Utility methods for use in themes
  function get_candidates() {
    // TODO: Cache the results of this query
    global $wpdb;
    $table_name = $wpdb->prefix . 'postmeta';
    $query = "SELECT count(*) as ad_count,
                     meta_value as ad_candidate
                FROM ".$table_name."
               WHERE meta_key LIKE 'ad_candidates_%_ad_candidate'
                 AND post_id IN (select ID from wp_posts where post_status = 'publish')
            GROUP BY meta_value
            ORDER BY ad_count desc";

    $results = $wpdb->get_results($query);

    $candidates = array();
    foreach($results as $result) {
      array_push($candidates, $result->ad_candidate);
    }
    return $candidates;
  }

  function get_sponsors() {
    // TODO: Cache the results of this query
    global $wpdb;
    $table_name = $wpdb->prefix . 'postmeta';
    $query = "SELECT count(*) as ad_count,
                     meta_value as ad_sponsor
                FROM ".$table_name."
               WHERE meta_key LIKE 'ad_sponsors_%_ad_sponsor'
                 AND post_id IN (select ID from wp_posts where post_status = 'publish')
            GROUP BY meta_value
            ORDER BY ad_count desc";

    $results = $wpdb->get_results($query);

    $sponsors = array();
    foreach($results as $result) {
      array_push($sponsors, $result->ad_sponsor);
    }
    return $sponsors;
  }


  /////////////////
  // Schedule a regular sync with the archive
  
  register_activation_hook(__FILE__, 'activate_archive_sync');
  add_action('archive_sync', 'run_archive_sync');
  //add_action( 'init', 'run_archive_sync' );
  function activate_archive_sync() {
     wp_schedule_event(time(), 'hourly', 'archive_sync');
  }

  function run_archive_sync() {
    ///////
    // STEP 0: Prepare lookup tables
    $network_lookup = get_network_metadata();
    $sponsor_lookup = get_sponsor_metadata();

    ///////
    // STEP 1: Load all newly discovered political ads, creating entries for each new ad

    // STEP 1.1: Get a list of new ads
    $new_ads = get_new_ads();

    // STEP 1.2: Go through the list and make sure there is a "post" for each ad
    foreach($new_ads as $new_ad_identifier) {
      
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


    // STEP 2 + 3: Load the list of ads in wordpress and update the metadata
    global $wpdb;
    $existing_ads = get_posts(array(
      'post_type' => 'archive_political_ad',
      'post_status' => 'any',
      'numberposts' => -1
    ));

    foreach($existing_ads as $existing_ad) {

      $wp_identifier = $existing_ad->ID;
      $ad_identifier = $existing_ad->post_title;

      // STEP 2: Get every instance, and create a record for each instance
      // NOTE: it won't double insert when run more than once due to the unique key
      $instances = get_ad_archive_instances($ad_identifier);

      // Iterate through each instance
      foreach($instances as $instance) {
        $network = $instance->channel;
        $market = array_key_exists($network, $network_lookup)?$network_lookup[$network]['market']:'';
        $location = array_key_exists($network, $network_lookup)?$network_lookup[$network]['location']:'';
        $air_time = $instance->start;
        //$end_time = $instance->end;

        $table_name = $wpdb->prefix . 'ad_instances';  
        $wpdb->insert( 
          $table_name,
          array(
            'wp_identifier' => $wp_identifier, 
            'archive_identifier' => $ad_identifier,
            'network' => $network,
            'market' => $market,
            'location' => $location,
            'air_time' => $air_time
          ) 
        );
      }

      // STEP 3: Update metadata based on the instance list
      // Note: the keys here are defined by the Advanced Custom Fields settings
      $metadata = get_ad_archive_metadata($ad_identifier);

      // Now that we have the data, lets update the metadata for the canonical ad itself
      $table_name = $wpdb->prefix . 'ad_instances';

      $query = "SELECT count(*) as air_count,
                       count(DISTINCT network) as network_count,
                       count(DISTINCT market) as market_count,
                       MIN(air_time) as first_seen,
                       MAX(air_time) as last_seen
                  FROM ".$table_name."
                 WHERE archive_identifier = '".esc_sql($ad_identifier)."'
              GROUP BY archive_identifier";

      $results = $wpdb->get_results($query);
      $results = $results[0];

      $ad_embed_url = 'http://'.ARCHIVE_API_HOST.'/embed/'.$ad_identifier;
      $ad_id = $ad_identifier;
      $ad_type = "Political Ad";
      $ad_race = "";
      $ad_message = "";
      $ad_air_count = $results->air_count;
      $ad_market_count = $results->market_count;
      $ad_network_count = $results->network_count;
      $ad_first_seen = $results->first_seen;
      $ad_last_seen = $results->last_seen;

      // Field values come from advanced custom fields
      update_field('field_566e30c856e35', $ad_embed_url , $wp_identifier); // embed_url
      update_field('field_566e328a943a3', $ad_id, $wp_identifier); // archive_id
      update_field('field_566e359261c2e', $ad_type, $wp_identifier); // ad_type
      update_field('field_566e360961c2f', $ad_message, $wp_identifier); // ad_message
      update_field('field_566e3659fb227', $ad_air_count, $wp_identifier); // air_count
      update_field('field_566e367e962e2', $ad_market_count, $wp_identifier); // market_count
      update_field('field_566e3697962e3', $ad_network_count, $wp_identifier); // network_count
      update_field('field_566e36b0962e4', $ad_first_seen, $wp_identifier); // first_seen
      update_field('field_566e36d5962e5', $ad_last_seen,  $wp_identifier); // last_seen

      // Add new sponsors
      if(is_array($metadata['sponsors'])) {
        $new_sponsors = array();
        foreach($metadata['sponsors'] as $sponsor) {
          if(array_key_exists($sponsor, $sponsor_lookup)) {
            $sponsor_metadata = $sponsor_lookup[$sponsor];
            if(sizeof($sponsor_metadata) > 1) {
              $sponsor_type = "multiple";
            } else {
              $sponsor_type = array_pop(array_keys($sponsor_metadata));
            }
          }
          else {
            $sponsor_type = "unknown";
          }

          $new_sponsor = array(
            'field_566e32fb943a5' => $sponsor, // Name
            'field_566e3353943a6' => $sponsor_type // Type
          );
          $new_sponsors[] = $new_sponsor;
        }
        update_field('field_566e32bd943a4', $new_sponsors, $wp_identifier);
      }

      // Add new candidates
      if(is_array($metadata['candidates'])) {
        $new_candidates = array();
        foreach($metadata['candidates'] as $candidate) {
          $new_candidate = array(
            'field_566e3573943a8' => $candidate // Name
          );
          $new_candidates[] = $new_candidate;
        }
        update_field('field_566e3533943a7', $new_candidates, $wp_identifier);
      }
    }
  }



  /**
   * Get a list of new ads from the archive (used in sync)
   */
  function get_new_ads() {


      // Get a list of ad instances from the archive
      //$url = ARCHIVE_API_HOST.'/details/tv?weekads=1&output=json';

      $url = ARCHIVE_SEARCH_HOST.'/solr/select?indent=yes&omitHeader=true&wt=json&&q=*%3A*&rows=0&facet=on&facet.field=ad_id';

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

      // The result has a list of ad ids and counts
      $facets = $result->facet_counts->facet_fields->ad_id;
      $ads = array();
      foreach($facets as $facet) {
        // is this NOT a count?
        if(!is_numeric($facet)) {
          $ads[] = $facet;
        }
      }

      return $ads;
  }

  /**
   * Get a list of ad instances from the archive (used in sync)
   */
  function get_ad_archive_instances($ad_identifier) {

      $total = -1;
      $count = 0;
      $results = array();
      while($count < $total || $total == -1) {
        // Get a list of ad instances from the archive
        $url = ARCHIVE_SEARCH_HOST.'/solr/select?indent=yes&omitHeader=true&wt=json&start='.$count.'&q=ad_id:'.$ad_identifier;

        // Create the GET
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        // Take in the server's response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Run the CURL
        $curl_result = curl_exec($ch);
        curl_close ($ch);

        // Parse the result
        $decoded_result = json_decode($curl_result);
        $instances = $decoded_result->response;

        // Is this the first iteration?
        if($total = -1) {
          // Update the total number of instances
          $total = $instances->numFound;
        }

        // Merge in the results
        $docs = $instances->docs;

        if(is_array($docs)) {
          $results = array_merge($results, $docs);
          $count += sizeof($docs);
        }

        // Just to be defensive
        if(sizeof($docs) == 0)
          $count = $total;
      }

      return $results;
  }

  /**
   * Get the archive metadata for an ad (used in sync)
   */
  function get_ad_archive_metadata($ad_identifier) {

      // Get a list of ad instances from the archive
      $url = ARCHIVE_SEARCH_HOST.'/solr/select?indent=yes&omitHeader=true&wt=json&start='.$count.'&q=ad_id:'.$ad_identifier;

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

      $sponsors = array();
      $candidates = array();

      if(sizeof($result->response->docs > 0)) {
        $sponsors = $result->response->docs[0]->sponsor;
        $candidates = $result->response->docs[0]->candidate;
      }

      $metadata = array(
        'sponsors' => $sponsors,
        'candidates' => $candidates
      );

      return $metadata;
  }

  /**
   * Get the network -> market / location conversion
   */
  function get_network_metadata() {
    // Get a list of ad instances from the archive
    $url = ARCHIVE_API_HOST.'/tv.php?chan2market=1&output=json';

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

    // Convert results to an expected format
    $networks = array();
    foreach($result as $network => $values) {
      $networks[$network] = array(
        'market' => $values[0],
        'location' => $values[1]
      );
    }

    return $networks;
  }

  /**
   * Load in the sponsor types and other information from CRP
   */
  function get_sponsor_metadata() {
    // Get a list of ad instances from the archive
    $url = 'https://www.opensecrets.org/api/index.php?method=internetArchive&apikey='.OPENSECRETS_API_KEY.'&output=json';

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

    // Process the result
    $sponsors = array();

    foreach($result->response->record as $sponsor) {
      $sponsor = $sponsor->{'@attributes'};
      $sponsor_name = substr($sponsor->sponsorname, 0, -4); // Names have 4 extra characters we don't want
      if(array_key_exists($sponsor_name, $sponsors)) {
        $sponsors[$sponsor_name][$sponsor->type] = $sponsor;
      } else {
        $sponsors[$sponsor_name] = array(
          $sponsor->type => $sponsor
        );
      }
    }

    return $sponsors;
  }

  /////////////////
  // Archive Search

  // add_action('pre_get_posts','override_search');

  /**
   * Return a wordpress query based on a querystring
   */
  function get_archive_ids_by_custom_search($query) {
    $search_terms = array(
      'general' => $query
    );

    return run_archive_search($search_terms);
  }

  

  /**
   * Run a search against the archive and get a list of archive IDs, search terms is an array with the following possible fields:
   *  - 'general'
   *  - 'candidate'
   *  - 'sponsor'
   */
  function run_archive_search($search_terms) {

      // Construct the query
      $query = "";

      if(array_key_exists('general', $search_terms)) {
          $query = 'candidate:"'.$search_terms['general'].'" OR sponsor:"'.$search_terms['general'].'"';
      } else {
        if(array_key_exists('candidate', $search_terms)) {
          $query = 'candidate:"'.$search_terms['candidate'].'"';
        }
        if(array_key_exists('sponsor', $search_terms)) {
          $query = 'sponsor:"'.$search_terms['sponsor'].'"';
        }
      }

      // Construct the request URL
      $url = ARCHIVE_API_HOST.'/details/tv?q='.urlencode($query).'&output=json';

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

      // Pull out the archive id's
      $archive_ids = array();
      foreach($result as $instance) {
        $archive_ids[] = $instance->ad_id;
      }
      $archive_ids = array_unique($archive_ids);

      return $archive_ids;
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

  /**
   * Convert a list of sponsors to a single string
   */
  function generate_sponsors_string($ad_sponsors) {
    
    // Is this the right type?
    if(!is_array($ad_sponsors))
      return "";

    $ad_sponsor_strings = array();

    foreach($ad_sponsors as $ad_sponsor) {
      $sponsor_string = $ad_sponsor['ad_sponsor'];
      if($ad_sponsor['sponsor_type'] != "unknown")
        $string .= " (".$ad_sponsor['sponsor_type'].")";
      $ad_sponsor_strings[] = $sponsor_string;
    }
    return implode(", ", $ad_sponsor_strings);
  }

  /**
   * Convert a list of candidates to a single string
   */
  function generate_candidates_string($ad_candidates) {
    
    // Is this the right type?
    if(!is_array($ad_candidates))
      return "";

    $ad_candidates_strings = array();
    foreach($ad_candidates as $ad_candidate) {
      $ad_candidates_strings[] = $ad_candidate['ad_candidate'];
    }
    return implode(", ", $ad_candidates_strings);
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
                     network as network,
                     air_time as air_time,
                     archive_identifier as archive_identifier,
                     wp_identifier as wp_identifier
            FROM ".$table_name." ";

    if(array_key_exists('ad_identifier', $_GET)) {
      $ad_identifier = $_GET['ad_identifier'];
      $query .= "WHERE archive_identifier = '".esc_sql($ad_identifier)."'";
    }

    $results = $wpdb->get_results($query);
    $rows = array();
    $metadata_cache = array();
    foreach($results as $result) {
      $wp_identifier = $result->wp_identifier;
      $network = $result->network;
      $air_time = $result->air_time;
      $archive_identifier = $result->archive_identifier;

      // Cache the metadata for this identifier
      if(!array_key_exists($ad_identifier, $metadata_cache)) {
        $post_metadata = get_fields($wp_identifier);
        $metadata['ad_embed_url'] = $post_metadata['embed_url'];
        $metadata['ad_notes'] = $post_metadata['notes'];
        $metadata['archive_id'] = $post_metadata['archive_identifier'];
        $metadata['ad_sponsor'] = generate_sponsors_string($post_metadata['ad_sponsors']);
        $metadata['ad_candidate'] = generate_candidates_string($post_metadata['ad_candidates']);
        $metadata['ad_type'] = $post_metadata['ad_type'];
        $metadata['ad_message'] = $post_metadata['ad_message'];
        $metadata['ad_air_count'] = $post_metadata['air_count'];
        $metadata['ad_market_count'] = $post_metadata['market_count'];
        $metadata['ad_first_seen'] = $post_metadata['first_seen'];
        $metadata['ad_last_seen'] = $post_metadata['last_seen'];
        $metadata_cache[$ad_identifier] = $metadata;
      }

      // Load the metadata from the cache
      $ad_embed_url = $metadata_cache[$ad_identifier]['ad_embed_url'];
      $ad_notes = $metadata_cache[$ad_identifier]['ad_notes'];
      $ad_id = $metadata_cache[$ad_identifier]['ad_id'];
      $ad_sponsor = $metadata_cache[$ad_identifier]['ad_sponsor'];
      $ad_candidate = $metadata_cache[$ad_identifier]['ad_candidate'];
      $ad_type = $metadata_cache[$ad_identifier]['ad_type'];
      $ad_message = $metadata_cache[$ad_identifier]['ad_message'];
      $ad_air_count = $metadata_cache[$ad_identifier]['ad_air_count'];
      $ad_market_count = $metadata_cache[$ad_identifier]['ad_market_count'];
      $ad_first_seen = $metadata_cache[$ad_identifier]['ad_first_seen'];
      $ad_last_seen = $metadata_cache[$ad_identifier]['ad_last_seen'];

      // Create the row
      $row = [
        "wp_identifier" => $wp_identifier,
        "network" => $network,
        "air_time" => $air_time,
        "archive_id" => $archive_identifier,
        "embed_url" => $ad_embed_url,
        "sponsor" => $ad_sponsor,
        "candidate" => $ad_candidate,
        "type" => $ad_type,
        "message" => $ad_message,
        "air_count" => $ad_air_count,
        "market_count" => $ad_market_count,
        "first_seen" => $ad_first_seen,
        "last_seen" => $ad_last_seen,
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
    wp_deregister_script('jquery');
    wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery.min.js', array(), '2.1.4' );
    wp_enqueue_script('jquery');

    // Load in bootstrap
    wp_enqueue_style( 'bootstrap.css', get_template_directory_uri() . '/css/bootstrap.css' );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '3.3.5' );

    // Load in our carousel for the front page
    wp_enqueue_style( 'owl.carousel.css', get_template_directory_uri() . '/css/owl.carousel.css' );
    wp_enqueue_script( 'owl.carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), '2.0.50' );

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

?>