<?php

// Load the theme config file
include('theme-config.php');


/////////////////
// Register the export API
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

/**
 * Route the export API values to match the query vars specified in export_add_query_vars
 * @return void
 */
function export_add_endpoint() {
    $triggering_endpoint = '^export/?(.*)?/?';
    add_rewrite_rule($triggering_endpoint,'index.php?__export=1&export_options=$matches[1]','top');
}

/**
 * Look to see if export is being requested, if so take over and return the export
 * @return die if API request
 */
function export_sniff_requests(){
    global $wp;

    if(isset($wp->query_vars['__export'])){
        if(array_key_exists('q', $_GET))
            $ad_instances = get_ad_instances($_GET['q']);
        else
            $ad_instances = get_ad_instances();

        if(array_key_exists('output', $_GET))
            export_send_response($ad_instances, $_GET['output']);
        else
            export_send_response($ad_instances);

        export_send_response($ad_instances);
        exit;
    }
}


/**
 * Send the output based on the type ('csv' or 'json')
 */
function export_send_response($rows, $output='csv') {
    switch($output) {
        case 'csv':
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
        case 'json':
            header('Content-Type: application/json');
            echo(json_encode($rows));
            exit;
    }
}

  /////////////////
  // Add features image for Blog view
  add_theme_support( 'post-thumbnails' );

  // set blog listing image size
  set_post_thumbnail_size( 776, 253, true);
  add_image_size( 'frontpage-thumb', 380, 230, true);
  add_image_size( 'post-thumb', 776, 253, true );

  // Adjust excerpt length to better match design for Blog view
  function tta_excerpt_length( $length ){
    return 60;
  }
  add_filter( 'excerpt_length', 'tta_excerpt_length', 999 );

    // Add Sidebar Widgets
  function tia_widgets_init() {

	register_sidebar( array(
		'name' => __( 'Blog Sidebar', 'tia' ),
		'id' => 'sidebar-1',
		'description' => __( 'This sidebar appears on the blog listing and single blog pages', 'tia' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="blog-sidebar-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' =>__( 'Search page sidebar', 'tia'),
		'id' => 'sidebar-2',
		'description' => __( 'Appears on the left side of the Search page template', 'tia' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	}

  add_action( 'widgets_init', 'tia_widgets_init' );


/////////////////
// Add styles and scripts
add_action( 'wp_enqueue_scripts', 'archivepoliticalads_scripts' );
function archivepoliticalads_scripts() {

    // Load in jQuery
    wp_deregister_script('jquery');
    wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery.min.js', array(), '2.1.4' );
    wp_enqueue_script('jquery');

    // Load in bootstrap
    wp_enqueue_style( 'bootstrap.css', get_template_directory_uri() . '/css/bootstrap.css' );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'),  '', true );

    // Load in our carousel for the front page
    wp_enqueue_style( 'owl.carousel.css', get_template_directory_uri() . '/css/owl.carousel.css' );
    wp_enqueue_script( 'owl.carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery','bootstrap' ),  '', true );

    // Load the main styles
    wp_enqueue_style( 'style.css', get_stylesheet_uri() );
    // Load the media queries
    wp_enqueue_style( 'media-queries.css', get_template_directory_uri() . '/css/media-queries.css' );
    // Load the addional js
    wp_enqueue_script( 'apps_js', get_template_directory_uri() . '/js/apps.js', array('jquery','bootstrap' ),  '', true );

}

////////////
// Set up some theme options
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Theme Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-settings',
        'capability'    => 'edit_posts',
        'redirect'      => true
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Theme Home Settings',
        'menu_title'    => 'Home',
        'parent_slug'   => 'theme-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Theme Footer Settings',
        'menu_title'    => 'Footer',
        'parent_slug'   => 'theme-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'General Settings',
        'menu_title'    => 'General',
        'parent_slug'   => 'theme-settings',
    ));

}


?>
