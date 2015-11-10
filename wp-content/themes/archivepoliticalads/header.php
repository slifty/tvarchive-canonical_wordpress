<?php
// 	Use the proper DOCTYPE.
// The opening <html> tag should include language_attributes().
// The <meta> charset element should be placed before everything else, including the <title> element.
// Use bloginfo() to set the <meta> charset and description elements.
// Use wp_title() to set the <title> element. See why.
// Use Automatic Feed Links to add feed links.
// Add a call to wp_head() before the closing </head> tag. Plugins use this action hook to add their own scripts, stylesheets, and other functionality.
// Do not link the theme stylesheets in the Header template. Use the wp_enqueue_scripts action hook in a theme function instead.
// Here's an example of a correctly-formatted HTML5 compliant head area:
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<title><?php wp_title(); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
		<?php wp_head(); ?>
	</head>

<?php
// The Theme's main navigation should support a custom menu with wp_nav_menu().
// Menus should support long link titles and a large amount of list items. These items should not break the design or layout.
// Submenu items should display correctly. If possible, support drop-down menu styles for submenu items. Drop-downs allowing showing menu depth instead of just showing the top level.
?>