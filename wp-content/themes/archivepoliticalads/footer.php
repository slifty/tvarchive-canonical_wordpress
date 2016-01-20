            <div id="footer" class="row">
                <div class="footer-section col-xs-12 col-sm-4 col-md-4 ">
                    <div class="footer-title">Political TV Ad Archive</div>
                    <div class="footer-subtitle">by the Internet Archive</div>
                    <div class="footer-copy"><?php the_field('home_description', 'option'); ?></div>
                    <div class="footer-link"><a href="http://archive.org/details/tv">archive.org/details/tv</a></div>
                </div>
                <div id="custom-footer-sidebar" class="footer-section col-sm-4 col-md-4 hidden-xs">
                    <?php get_template_part( 'content', 'footer_blog_posts' ); ?>
                    <a href="<?php bloginfo('url'); ?>/blog">More</a>
                </div>
                <div id="footer-social-links" class="col-sm-4 col-md-4 col-xs-12">
                    <ul>
                        <li><img src="<?php bloginfo('template_directory'); ?>/img/twitter.png" srcset="<?php bloginfo('template_directory'); ?>/img/twitter@2x.png 2x, <?php bloginfo('template_directory'); ?>/img/twitter@3x.png 3x" /></li>
                        <li><img src="<?php bloginfo('template_directory'); ?>/img/mail.png" srcset="<?php bloginfo('template_directory'); ?>/img/mail@2x.png 2x, <?php bloginfo('template_directory'); ?>/img/mail@3x.png 3x" /></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- end container -->
        <?php wp_footer(); ?>
    </body>

</html>
