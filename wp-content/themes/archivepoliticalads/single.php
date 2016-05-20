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
<?php get_header(); ?>


<div id="blog-header" class="row page-header-row">
    <div class="col-md-6">
        <h1 id="blog-header-title" class="section-header">Blog</h1>
        <p id="blog-header-description">Dispatches from the TV News Team</p>
    </div>
</div>

<div class="row page-content">
    <div class="col-xs-12 col-sm-12 col-md-12  blog-main">
        <?php
            while ( have_posts() ) {
                the_post();
                ?>

                <div class="post">
                    <h2 class="post-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                    <p class="post-date"><?php the_time('F j, Y'); ?></p>
                    <p class="post-author">by <?php the_author(); ?></p>
                    <?php
                        if( get_the_post_thumbnail() ) {
                            ?>
                            <div class="img-container thumbnail">
                                <?php the_post_thumbnail('thumbnail', array( 'class' => 'post-img' ) ); ?>
                            </div>
                            <?php
                        }
                    ?>
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>

                    <div class="comments">
                        <h2>Comments</h2>
                        <?php comments_template(); ?>
                    </div>
                </div>
                <?php
            }
        ?>
    </div>
    <div class="hidden-xs hidden-s col-md-12 blog-sidebar">
        <div class="sidebar-module sidebar-module-inset">
            <div class="sidebar-module">
                <?php get_sidebar( ); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
