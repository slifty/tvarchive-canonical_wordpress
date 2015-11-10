<?php
// The single post template. Used when a single post is queried. For this and all other query templates, index.php is used if the query template is not present.

// Include wp_link_pages() to support navigation links within a post.
// Display post title and post content.
// The title should be plain text instead of a link pointing to itself.
// Display the post date.
// Respect the date and time format settings unless it's important to the design. (User settings for date and time format are in Administration Panels > Settings > General).
// For output based on the user setting, use the_time( get_option( 'date_format' ) ).
// Display the author name (if appropriate).
// Display post categories and post tags.
// Display an "Edit" link for logged-in users with edit permissions.
// Display comment list and comment form.
// Show navigation links to next and previous post using previous_post_link() and next_post_link().
?>
Single Post