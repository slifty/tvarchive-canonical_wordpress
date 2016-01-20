<?php
/**
* Plugin Name: TV Archive Political Ads
* Plugin URI: http://politicaladsarcive.com
* Description: Use data from the Internet Archive's political ad tracker in your wordpress theme
* Version: 1.0
* Author: Daniel Schultz
* Author URI: http://slifty.com
* License:
*/


//////////////
/// Plugin setup methods

/**
 * Create a custom post type for political ads
 * @return [type] [description]
 */
function register_archive_political_ad_type() {
    register_post_type( 'archive_political_ad',
        array(
            'rewrite' => array('with_front' => false, 'slug' => 'ad'),
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
                'delete_posts'       => 'delete_ads',
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

    // Set up role capabilities
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
add_action( 'init', 'register_archive_political_ad_type' );

/**
 * Create a location to store all discovered copies of these political ads
 * @return [type] [description]
 */
function create_ad_instances_table() {
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
        start_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        end_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        UNIQUE KEY instance_key (archive_identifier,network,start_time),
        KEY archive_identifier_key (archive_identifier),
        KEY wp_identifier_key (wp_identifier),
        KEY network_key (network)
    ) $charset_collate;";
    dbDelta( $sql );
}
register_activation_hook( __FILE__, 'create_ad_instances_table');


/**
 * A method that will load in all ad data (metadata, instances, etc)
 * @return [type] [description]
 */
function load_ad_data() {
    write_log("Loading Ad Data");

    ///////
    // STEP 0: Prepare lookup tables
    $network_lookup = get_network_metadata();
    $sponsor_lookup = get_sponsor_metadata();

    ///////
    // STEP 1: Load all newly discovered political ads, creating entries for each new ad

    // STEP 1.1: Get a list of new ads
    $new_ads = get_new_ads();

    // STEP 1.2: Go through the list and make sure there is a "post" for each ad
    foreach($new_ads as $new_ad) {

        $ad_identifier = $new_ad->identifier;
        // Does the ad already exist?
        $existing_ad = get_page_by_title( $ad_identifier, OBJECT, 'archive_political_ad');
        if($existing_ad) {
            $wp_identifier = $existing_ad->ID;
            continue;
        }
        else {
            // Create a new post for the ad
            $post = array(
                'post_name'      => $ad_identifier,
                'post_title'     => $ad_identifier,
                'post_status'    => 'draft', // Eventually we may want this to be 'publish'
                'post_type'      => 'archive_political_ad'
            );
            $wp_identifier = wp_insert_post( $post );
        }

        // Load the metadata for this ad
        $metadata = $new_ad->json;

        // Store the basic information
        $ad_embed_url = 'https://archive.org/embed/'.$ad_identifier;
        $ad_id = $ad_identifier;
        $ad_type = "Political Ad";
        $ad_race = ""; // TODO: look this up
        $ad_message = property_exists($metadata, 'message')?$metadata->message:'unknown';
        update_field('field_566e30c856e35', $ad_embed_url , $wp_identifier); // embed_url
        update_field('field_566e328a943a3', $ad_id, $wp_identifier); // archive_id
        update_field('field_566e359261c2e', $ad_type, $wp_identifier); // ad_type
        update_field('field_566e360961c2f', $ad_message, $wp_identifier); // ad_message

        // Store the sponsors
        // TODO: metadata field should be "sponsors" not "sponsor"
        if(property_exists($metadata, 'sponsor')
        && is_array($metadata->sponsor)) {
            $new_sponsors = array();
            foreach($metadata->sponsor as $sponsor) {
                if(array_key_exists($sponsor, $sponsor_lookup)) {
                    $sponsor_metadata = $sponsor_lookup[$sponsor];

                    if(sizeof($sponsor_metadata) > 1) {
                        $sponsor_type = "multiple";
                    } else {
                        $types = array_keys($sponsor_metadata);
                        $sponsor_type = array_pop($types);
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

        // Store the candidates
        if(property_exists($metadata, 'candidate')
        && is_array($metadata->candidate)) {
            $new_candidates = array();
            foreach($metadata->candidate as $candidate) {
                $new_candidate = array(
                    'field_566e3573943a8' => $candidate // Name
                );
                $new_candidates[] = $new_candidate;
            }
            update_field('field_566e3533943a7', $new_candidates, $wp_identifier);
        }

        // Store the subjects
        if(property_exists($metadata, 'subject')
        && is_array($metadata->subject)) {
            $new_subjects = array();
            foreach($metadata->subject as $subject) {
                $new_subject = array(
                    'field_569d12ec487ef' => $subject // Name
                );
                $new_subjects[] = $new_subject;
            }
            update_field('field_569d12c8487ee', $new_subjects, $wp_identifier);
        }
    }

    // STEP 2: Load the list of instances and update the metadata
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

        // Collect existing instances;
        $existing_instances = array();
        // Collect the data associated with this ad
        $table_name = $wpdb->prefix . 'ad_instances';

        $query = "SELECT id as id,
                         network as network,
                         start_time as start_time,
                         archive_identifier as archive_identifier,
                         wp_identifier as wp_identifier
                    FROM ".$table_name."
                   WHERE archive_identifier = '".esc_sql($ad_identifier)."'";

        $results = $wpdb->get_results($query);
        $rows = array();
        $metadata_cache = array();
        foreach($results as $result) {
            $network = $result->network;
            $start_time = $result->start_time;
            $archive_identifier = $result->archive_identifier;
            if(!array_key_exists($network, $existing_instances)) {
                $existing_instances[$network] = array();
            }
            $existing_instances[$network][] = $start_time;
        }

        // Iterate through each instance
        foreach($instances as $instance) {
            $network = $instance->chan;
            $market = array_key_exists($network, $network_lookup)?$network_lookup[$network]['market']:'';
            $location = array_key_exists($network, $network_lookup)?$network_lookup[$network]['location']:'';
            $start_time = date("Y-m-d H:i:s", $instance->start);
            $end_time = date("Y-m-d H:i:s", $instance->end);

            // Only try to insert if it doesn't exist already
            if(!array_key_exists($network, $existing_instances)
            || !in_array($start_time, $existing_instances[$network])) {
                $table_name = $wpdb->prefix . 'ad_instances';
                $wpdb->insert(
                    $table_name,
                    array(
                        'wp_identifier' => $wp_identifier,
                        'archive_identifier' => $ad_identifier,
                        'network' => $network,
                        'market' => $market,
                        'location' => $location,
                        'start_time' => $start_time,
                        'end_time' => $end_time
                    )
                );
            }
        }
    }

    // STEP 3: Update metadata based on the instance list
    foreach($existing_ads as $existing_ad) {
        $wp_identifier = $existing_ad->ID;
        $ad_identifier = $existing_ad->post_title;

        // We have the data, lets update the metadata for the canonical ad itself
        $table_name = $wpdb->prefix . 'ad_instances';

        $query = "SELECT count(*) as air_count,
                         count(DISTINCT network) as network_count,
                         count(DISTINCT market) as market_count,
                         MIN(start_time) as first_seen,
                         MAX(start_time) as last_seen
                    FROM ".$table_name."
                   WHERE archive_identifier = '".esc_sql($ad_identifier)."'
                GROUP BY archive_identifier";

        $results = $wpdb->get_results($query);

        if(sizeof($results) == 0) {
            $ad_air_count = 0;
            $ad_market_count = 0;
            $ad_network_count = 0;
            $ad_first_seen = '';
            $ad_last_seen = '';
        }
        else {
            $results = $results[0];
            $ad_air_count = $results->air_count;
            $ad_market_count = $results->market_count;
            $ad_network_count = $results->network_count;
            $ad_first_seen = date('Ymd', strtotime($results->first_seen));
            $ad_last_seen = date('Ymd', strtotime($results->last_seen));
        }

        // Note: the keys here are defined by the Advanced Custom Fields settings
        update_field('field_566e3659fb227', $ad_air_count, $wp_identifier); // air_count
        update_field('field_566e367e962e2', $ad_market_count, $wp_identifier); // market_count
        update_field('field_566e3697962e3', $ad_network_count, $wp_identifier); // network_count
        update_field('field_566e36b0962e4', $ad_first_seen, $wp_identifier); // first_seen
        update_field('field_566e36d5962e5', $ad_last_seen,  $wp_identifier); // last_seen
    }
}

add_action('archive_sync', 'load_ad_data');

function activate_archive_sync() {
    // Does the scheduled task exist already?
    if(wp_get_schedule('archive_sync') === false) {
        wp_schedule_event(time(), 'hourly', 'archive_sync');
    }
}
register_activation_hook(__FILE__, 'activate_archive_sync');


function deactivate_archive_sync() {
    // Does the scheduled task exist already?
    $schedule = wp_get_schedule('archive_sync') === false;
    if($schedule) {
        wp_unschedule_event(wp_next_scheduled('archive_sync'), 'archive_sync');
    }
}
register_deactivation_hook( __FILE__, 'deactivate_archive_sync' );


//////////////
/// Methods used during data sync to communicate with APIs

/**
* Get a list of new ads from the archive (used in sync)
*/
function get_new_ads() {
    // Get a list of ad instances from the archive
    $url = 'https://archive.org/details/tv?canonical_ads=1&metadata=1&output=json';
    $url_result = file_get_contents($url);

    // Parse the result
    $ads = json_decode($url_result);
    return $ads;
}

/**
* Get a list of ad instances from the archive (used in sync)
*/
function get_ad_archive_instances($ad_identifier) {
    $url = 'https://archive.org/details/tv?ad_instances='.$ad_identifier.'&output=json';
    $url_result = file_get_contents($url);
    $results = json_decode($url_result);
    return $results;
}


/**
* Get the network -> market / location conversion
*/
function get_network_metadata() {
    // Get a list of ad instances from the archive
    $url = 'https://archive.org/tv.php?chan2market=1&output=json';
    $url_result = file_get_contents($url);
    $results = json_decode($url_result);

    // Convert results to an expected format
    $networks = array();
    foreach($results as $network => $values) {
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
    // TODO: this API key needs to be put in an options page
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
        $sponsor_name = $sponsor->sponsorname;
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


//////////////
/// Methods for use in themes

/**
 * Get a complete list of the candidates with published ads in the system
 * @return [type] [description]
 */
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


/**
 * Get a complete list of the sponsors with published ads in the system
 * @return [type] [description]
 */
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


/**
 * Get a complete list of the sponsor types with published ads in the system
 * @return [type] [description]
 */
function get_sponsor_types() {
    // TODO: Cache the results of this query
    global $wpdb;
    $table_name = $wpdb->prefix . 'postmeta';
    $query = "SELECT count(*) as ad_count,
                     meta_value as ad_sponsor
                FROM ".$table_name."
               WHERE meta_key LIKE 'ad_sponsors_%_sponsor_type'
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


//////////////
/// Methods for political ad search

/**
 * Get a list of political ads based on input parameters
 * @param  array $query The array of fields we want to search in terms of.
 * @return array        The list of results
 */
function search_political_ads($query, $extra_args = array()) {
    global $wpdb;
    $parsed_query = parse_political_ad_query($query);

    // Candidates, Sponsors, and Sponsor Type are nested meta values
    $matched_post_ids = array();
    $use_matched_post_ids = false;
    if(sizeof($parsed_query['candidate'])) {
        $use_matched_post_ids = true;
        foreach($parsed_query['candidate'] as $candidate) {
            $rows = $wpdb->get_results($wpdb->prepare(
                "SELECT *
                   FROM {$wpdb->prefix}postmeta
                  WHERE meta_key LIKE %s
                    AND meta_value LIKE %s
                ",
                'ad_candidates_%_ad_candidate',
                '%'.$candidate.'%'
            ));
            foreach($rows as $row) {
                $matched_post_ids[] = $row->post_id;
            }
        }
    }
    if(sizeof($parsed_query['sponsor'])) {
        $use_matched_post_ids = true;
        foreach($parsed_query['sponsor'] as $sponsor) {
            $rows = $wpdb->get_results($wpdb->prepare(
                "SELECT *
                   FROM {$wpdb->prefix}postmeta
                  WHERE meta_key LIKE %s
                    AND meta_value LIKE %s
                ",
                'ad_sponsors_%_ad_sponsor',
                '%'.$sponsor.'%'
            ));
            foreach($rows as $row) {
                $matched_post_ids[] = $row->post_id;
            }
        }
    }

    if(sizeof($parsed_query['sponsor_type'])) {
        $use_matched_post_ids = true;
        foreach($parsed_query['sponsor_type'] as $sponsor_type) {
            $rows = $wpdb->get_results($wpdb->prepare(
                "SELECT *
                   FROM {$wpdb->prefix}postmeta
                  WHERE meta_key LIKE %s
                    AND meta_value = %s
                ",
                'ad_sponsors_%_sponsor_type',
                $sponsor_type
            ));
            foreach($rows as $row) {
                $matched_post_ids[] = $row->post_id;
            }
        }
    }

    if(sizeof($parsed_query['subject'])) {
        $use_matched_post_ids = true;
        foreach($parsed_query['subject'] as $subject) {
            $rows = $wpdb->get_results($wpdb->prepare(
                "SELECT *
                   FROM {$wpdb->prefix}postmeta
                  WHERE meta_key LIKE %s
                    AND meta_value LIKE %s
                ",
                'ad_subjects_%_ad_subject',
                '%'.$subject.'%'
            ));
            foreach($rows as $row) {
                $matched_post_ids[] = $row->post_id;
            }
        }
    }

    if(sizeof($parsed_query['archive_id'])) {
        $use_matched_post_ids = true;
        foreach($parsed_query['archive_id'] as $archive_id) {
            $rows = $wpdb->get_results($wpdb->prepare(
                "SELECT *
                   FROM {$wpdb->prefix}postmeta
                  WHERE meta_key LIKE %s
                    AND meta_value = %s
                ",
                'archive_id',
                $archive_id
            ));
            foreach($rows as $row) {
                $matched_post_ids[] = $row->post_id;
            }
        }
    }

    // Market, Channel, and Location are instance values
    if(sizeof($parsed_query['network'])) {
        $use_matched_post_ids = true;
        foreach($parsed_query['network'] as $network) {
            $rows = $wpdb->get_results($wpdb->prepare(
                "SELECT *
                   FROM {$wpdb->prefix}ad_instances
                  WHERE network = %s
               GROUP BY wp_identifier
                ",
                $network
            ));
            foreach($rows as $row) {
                $matched_post_ids[] = $row->wp_identifier;
            }
        }
    }
    if(sizeof($parsed_query['market'])) {
        $use_matched_post_ids = true;
        foreach($parsed_query['market'] as $market) {
            $rows = $wpdb->get_results($wpdb->prepare(
                "SELECT *
                   FROM {$wpdb->prefix}ad_instances
                  WHERE market = %s
               GROUP BY wp_identifier
                ",
                $market
            ));
            foreach($rows as $row) {
                $matched_post_ids[] = $row->wp_identifier;
            }
        }
    }
    if(sizeof($parsed_query['location'])) {
        $use_matched_post_ids = true;
        foreach($parsed_query['location'] as $location) {
            $rows = $wpdb->get_results($wpdb->prepare(
                "SELECT *
                   FROM {$wpdb->prefix}ad_instances
                  WHERE location LIKE %s
               GROUP BY wp_identifier
                ",
                '%'.$location.'%'
            ));
            foreach($rows as $row) {
                $matched_post_ids[] = $row->wp_identifier;
            }
        }
    }

    // Remove dupes because why not
    $matched_post_ids = array_unique($matched_post_ids);

    // We have a list of matched post IDs, lets load up
    $base_args = array(
        'post_type'   => 'archive_political_ad',
        'post_status'   => 'publish'
    );
    if($use_matched_post_ids) {
        if(sizeof($matched_post_ids) > 0) {
            $base_args['post__in'] = $matched_post_ids;
        } else {
            $base_args['post__in'] = array(-1);
        }
    }

    $args = array_merge($base_args, $extra_args);

    $wp_query = new WP_Query($args);
    return $wp_query;
}

/**
 * Break a string into an array of categorized terms.
 * @param  [type] $query [description]
 * @return [type]        [description]
 */
function parse_political_ad_query($query) {
    // This will be super simple for now -- anything of the form a:b is a facet.
    $parsed_query = array(
        'general' => array(),
        'archive_id' => array(),
        'sponsor' => array(),
        'subject' => array(),
        'candidate' => array(),
        'sponsor_type' => array(),
        'network' => array(),
        'market' => array(),
        'location' => array(),
        'type' => array()
    );

    // First, break the query into parts, keeping quoted sections as one item
    $query_parts = preg_split("/(?:'[^']*'|\"[^\"]*\")(*SKIP)(*F)|\h+/", $query);

    // Split the parts into buckets
    foreach($query_parts as $query_part) {
        $facet_parts = preg_split('/\:/', $query_part);
        if(sizeof($facet_parts) == 1) {
            $bucket = 'general';
            $value = $facet_parts[0];
        } else {
            $bucket = $facet_parts[0];
            $value = $facet_parts[1];
            // Note: we're just going to ignore if the user did something like a:b:c
        }

        // 'network' and 'channel' are the same
        if($bucket == 'channel')
            $bucket = 'network';

        // remove quotes from the value
        $value = preg_replace('/\"|\'|\\\\/', '', $value);
        if(!array_key_exists($bucket, $parsed_query))
            continue;
        $parsed_query[$bucket][] = $value;
    }

    // Add in 'general' to all the parts
    foreach($parsed_query as $bucket => $values) {
        $parsed_query[$bucket] = array_merge($parsed_query['general'], $parsed_query[$bucket]);
        $parsed_query[$bucket] = array_unique($parsed_query[$bucket]);
    }

    return $parsed_query;
}


//////////////
/// Methods for data export

/**
 * Return a list of ad instances, either for the entire corpus or a single ad
 * @param  string $ad_identifier (Optional) the archive identifier of a specific ad
 * @return array                 a complex object containing information about ad airings
 */
function get_ad_instances($query = ''){
    global $wp;
    global $wpdb;

    $args = array(
        'posts_per_page' => -1,
        'fields' => 'ids'
    );
    $wp_query = search_political_ads($query, $args);
    $ids = $wp_query->posts;



    // Collect the data associated with this ad
    $table_name = $wpdb->prefix . 'ad_instances';

    $query = "SELECT id as id,
                     network as network,
                     market as market,
                     location as location,
                     start_time as start_time,
                     end_time as end_time,
                     archive_identifier as archive_identifier,
                     wp_identifier as wp_identifier
                FROM ".$table_name."
               WHERE wp_identifier IN(".implode(', ', $ids).")";

    if(sizeof($ids) == 0)
        return array();

    $results = $wpdb->get_results($query);
    $rows = array();
    $metadata_cache = array();
    foreach($results as $result) {
        $wp_identifier = $result->wp_identifier;
        $network = $result->network;
        $market = $result->market;
        $location = $result->location;
        $start_time = $result->start_time;
        $end_time = $result->end_time;
        $archive_identifier = $result->archive_identifier;

        // Cache the metadata for this identifier
        if(!array_key_exists($archive_identifier, $metadata_cache)) {
            $post_metadata = get_fields($wp_identifier);
            $metadata['ad_embed_url'] = array_key_exists('embed_url', $post_metadata)?$post_metadata['embed_url']:'';
            $metadata['ad_notes'] = array_key_exists('notes', $post_metadata)?$post_metadata['notes']:'';
            $metadata['archive_id'] = array_key_exists('archive_id', $post_metadata)?$post_metadata['archive_id']:'';
            $metadata['ad_sponsor'] = generate_sponsors_string(array_key_exists('ad_sponsors', $post_metadata)?$post_metadata['ad_sponsors']:'');
            $metadata['ad_candidate'] = generate_candidates_string(array_key_exists('ad_candidates', $post_metadata)?$post_metadata['ad_candidates']:'');
            $metadata['ad_type'] = array_key_exists('ad_type', $post_metadata)?$post_metadata['ad_type']:'';
            $metadata['ad_message'] = array_key_exists('ad_message', $post_metadata)?$post_metadata['ad_message']:'';
            $metadata['ad_air_count'] = array_key_exists('air_count', $post_metadata)?$post_metadata['air_count']:'';
            $metadata['ad_market_count'] = array_key_exists('market_count', $post_metadata)?$post_metadata['market_count']:'';
            $metadata['ad_first_seen'] = array_key_exists('first_seen', $post_metadata)?$post_metadata['first_seen']:'';
            $metadata['ad_last_seen'] =array_key_exists('last_seen', $post_metadata)? $post_metadata['last_seen']:'';
            $metadata_cache[$archive_identifier] = $metadata;
        }

        // Load the metadata from the cache
        $ad_embed_url = $metadata_cache[$archive_identifier]['ad_embed_url'];
        $ad_notes = $metadata_cache[$archive_identifier]['ad_notes'];
        $archive_id = $metadata_cache[$archive_identifier]['archive_id'];
        $ad_sponsor = $metadata_cache[$archive_identifier]['ad_sponsor'];
        $ad_candidate = $metadata_cache[$archive_identifier]['ad_candidate'];
        $ad_type = $metadata_cache[$archive_identifier]['ad_type'];
        $ad_message = $metadata_cache[$archive_identifier]['ad_message'];
        $ad_air_count = $metadata_cache[$archive_identifier]['ad_air_count'];
        $ad_market_count = $metadata_cache[$archive_identifier]['ad_market_count'];
        $ad_first_seen = $metadata_cache[$archive_identifier]['ad_first_seen'];
        $ad_last_seen = $metadata_cache[$archive_identifier]['ad_last_seen'];

        // Create the row
        $row = [
            "wp_identifier" => $wp_identifier,
            "network" => $network,
            "market" => $market,
            "location" => $location,
            "start_time" => $start_time,
            "end_time" => $end_time,
            "archive_id" => $archive_id,
            "embed_url" => $ad_embed_url,
            "sponsor" => $ad_sponsor,
            "candidate" => $ad_candidate,
            "type" => $ad_type,
            "message" => $ad_message,
            "air_count" => $ad_air_count,
            "market_count" => $ad_market_count
        ];
        array_push($rows, $row);
    }
    return $rows;
}


function extract_sponsor_names($ad_sponsors) {
    // Is this the right type?
    if(!is_array($ad_sponsors))
        return "";

    $ad_sponsor_names = array();
    foreach($ad_sponsors as $ad_sponsor) {
        $sponsor_name = $ad_sponsor['ad_sponsor'];
        $ad_sponsor_names[] = $sponsor_name;
    }
    return array_unique($ad_sponsor_names);
}

function extract_sponsor_types($ad_sponsors) {
    // Is this the right type?
    if(!is_array($ad_sponsors))
        return "";

    $ad_sponsor_types = array();
    foreach($ad_sponsors as $ad_sponsor) {
        $sponsor_type = $ad_sponsor['sponsor_type'];
        $ad_sponsor_types[] = $sponsor_type;
    }
    return array_unique($ad_sponsor_types);
}

function get_sponsor_type_value($sponsor_type) {
    $sponsor_type_field = get_field_object('field_566e3353943a6');
    if(array_key_exists($sponsor_type, $sponsor_type_field['choices']))
        return $sponsor_type_field['choices'][$sponsor_type];
    else
        return "";
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
            $sponsor_string .= " (".$ad_sponsor['sponsor_type'].")";
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


function generate_message_string($ad_message) {
    $ad_message_field = get_field_object('field_566e360961c2f');
    return $ad_message_field['choices'][$ad_message];
}


function generate_sponsor_type_string($sponsor_type) {
}



// Helper methods used in the plugin
if (!function_exists('write_log')) {
    function write_log ( $log )  {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
    }
}

?>
