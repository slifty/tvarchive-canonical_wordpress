<?php

// Load the theme config file
include('theme-config.php');

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

    // Set up d3
    wp_deregister_script('d3');
    wp_register_script( 'd3', get_template_directory_uri() . '/js/d3.min.js', array(), '3.5.6' );
    wp_enqueue_script('d3');

    // Set up topojson
    wp_deregister_script('topojson');
    wp_register_script( 'topojson', get_template_directory_uri() . '/js/topojson.min.js', array(), '1.6.9' );
    wp_enqueue_script('topojson');

    // Set up our visualization tool
    wp_deregister_script('d3-eventdrops');
    wp_register_script( 'd3-eventdrops', get_template_directory_uri() . '/js/eventDrops.js', array(), '1.0.0' );
    wp_enqueue_script('d3-eventdrops');

    // Set up datamaps
    wp_deregister_script('datamaps');
    wp_register_script( 'datamaps', get_template_directory_uri() . '/js/datamaps.usa.js', array(), '0.5.0' );
    wp_enqueue_script('datamaps');

    // Load in bootstrap
    wp_enqueue_style( 'bootstrap.css', get_template_directory_uri() . '/css/bootstrap.css' );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'),  '', true );

    // Load in our carousel for the front page
    wp_enqueue_style( 'owl.carousel.css', get_template_directory_uri() . '/css/owl.carousel.css' );
    wp_enqueue_script( 'owl.carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery','bootstrap' ),  '', true );

    // Load the main styles
    wp_enqueue_style( 'style.css', get_stylesheet_uri().'?1' );
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

// Enable embeds because Wordpress is dumb
function change_mce_options( $initArray ) {
    // Comma separated string od extendes tags
    // Command separated string of extended elements
    $ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src]';

    if ( isset( $initArray['extended_valid_elements'] ) ) {
        $initArray['extended_valid_elements'] .= ',' . $ext;
    } else {
        $initArray['extended_valid_elements'] = $ext;
    }
    // maybe; set tiny paramter verify_html
    //$initArray['verify_html'] = false;

    return $initArray;
}
add_filter( 'tiny_mce_before_init', 'change_mce_options' );


?>
