<?php
/**
 * This sidebar appears on the blog listing and single blog pages
 */
?>
<div id="secondary">
    <div>
        <h3 class="blog-sidebar-title">Subscribe</h3>
        <form id="subscribe-form" class="form-inline" action="">
          <div class="form-group">
            <input type="text" name="subscribe-textbox" id="subscribe-text" class="form-control">
          </div>
          <input name="submit" type="submit" class="btn btn-default"  id="submit-newsletter" tabindex="5" value="Subscribe">
        </form>
     </div>  
    <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
        <div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
            <?php dynamic_sidebar( 'sidebar-1' ); ?>
        </div>
        <!-- #primary-sidebar -->
    <?php endif; ?>
</div>
    <!-- #secondary -->
