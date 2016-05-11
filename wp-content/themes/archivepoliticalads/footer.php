                </div>
            </div>
            <div id="footer">
                <div id="footer-video-subheader" class="row header-row">
                    <div class="col-sm-12">
                        <h1>Learn More About the Political TV Ad Archive</h1>
                    </div>
                </div>
                <div id="footer-video" class="row">
                    <div class="col-sm-12">
                        <iframe src="https://archive.org/embed/PolitAdArchiveVideo" frameborder="0" webkitallowfullscreen="true" mozallowfullscreen="true" allowfullscreen></iframe>
                    </div>
                </div>
                <div id="footer-content" class="row">
                    <div class="footer-section col-xs-12 col-sm-12 col-md-4 ">
                        <div class="footer-title">Political TV Ad Archive</div>
                        <div class="footer-subtitle">by the Internet Archive</div>
                        <div class="footer-copy"><?php the_field('home_description', 'option'); ?></div>
                        <div class="footer-link"><a href="http://archive.org/details/tv">archive.org/details/tv</a></div>
                    </div>
                    <div id="custom-footer-sidebar" class="footer-section col-sm-6 col-md-4 hidden-sm hidden-xs">
                        <?php get_template_part( 'content', 'footer_blog_posts' ); ?>
                        <a href="<?php bloginfo('url'); ?>/blog">More</a>
                    </div>
                    <div id="footer-social-links" class="col-sm-6 col-md-4 col-xs-12">
                        <ul>
                            <li><a href="https://twitter.com/PolitAdArchive" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/img/twitter.png" srcset="<?php bloginfo('template_directory'); ?>/img/twitter@2x.png 2x, <?php bloginfo('template_directory'); ?>/img/twitter@3x.png 3x" /></a></li>
                            <li><a href="mailto:nancyw@archive.org"><img src="<?php bloginfo('template_directory'); ?>/img/mail.png" srcset="<?php bloginfo('template_directory'); ?>/img/mail@2x.png 2x, <?php bloginfo('template_directory'); ?>/img/mail@3x.png 3x" /></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- end container -->
        <?php wp_footer(); ?>
    </body>

</html>
