<?php 
/* 
  Template Name: Browse PAge
*/
?>
    <?php get_header(); ?>
        <div id="browse-header" class="row">
            <div class="col-md-12 col-lg-12">
                <div class="row page-header-row">
                    <div class="col-sm-8 col-md-6">
                        <h1 id="browse-header-title" class="section-header">Search</h1>
                        <p id="browse-header-description">Search and Explore the Political Ad Library</p>
                    </div>
                </div>
                <div id="browse-header-search" class="row page-header-row">
                    <div class="col-xs-8 col-xs-offset-1 col-sm-10 col-md-10">
                        <?php get_search_form(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div id="browse-content" class="page-content">
            <?php

      if(array_key_exists('q', $_GET)) {
        $pagination_index = get_query_var('page', 0);
        $query = $_GET['q'];
        $archive_ids = get_archive_ids_by_custom_search($query);

        $posts = array();
        if(sizeof($archive_ids) > 0) {
          $posts = get_posts(array(
            'post_type'   => 'archive_political_ad',
            'post_status'   => 'publish',
            'posts_per_page'   => 11,
            'offset'           => $pagination_index * 10,
            'meta_query'  => array(
              array(
                'key'   => 'archive_id',
                'value'     => $archive_ids,
                'compare'   => 'IN',
              )
            )
          ));
        }
        ?>
                <div id="search-results-total" class="row">
                    <?php echo(sizeof($archive_ids));?> Results Found</div>
                <?php

        if ( sizeof($archive_ids) > 0) {
          ?>

                    <div id="search-results">
                        <?php
            $has_more = false;
            if(sizeof($posts) == 11) {
              $has_more = true;
              array_pop($posts);
            }

            foreach($posts as $post) {
              setup_postdata( $post );
              $metadata = get_fields();
              ?>
                            <div class="political-ad" class="row">
                                <div class="embed col-lg-3">
                                    <iframe frameborder="0" allowfullscreen src="<?php echo($metadata['embed_url']);?>" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                                </div>
                                <div class="col-lg-9">
                                    <div class="title">
                                        <a href="<?php the_permalink(); ?>" target="_blank">
                                            <?php the_title(); ?>
                                        </a>
                                    </div>
                                    <div class="sponsors">
                                        <span class="browse-label">Sponsor<?php if(sizeof($metadata['ad_sponsors']) != 1) { echo("s"); }?>: </span>
                                        <?php echo(generate_sponsors_string($metadata['ad_sponsors'])); ?>
                                    </div>
                                    <div class="candidates">
                                        <span class="browse-label">Candidate<?php if(sizeof($metadata['ad_candidates']) != 1) { echo("s"); }?>: </span>
                                        <?php  echo(generate_candidates_string($metadata['ad_candidates'])); ?>
                                    </div>
                                    <div class="cell-multiline-value">
                                       <?php echo($metadata['ad_notes']);?>
                                    </div>                            
                                </div>
                            </div>
                            <?php  }  ?>
                    </div>
                    <?php
        } else {
          // TODO: sorry no results lulz
        }

      } else {
          // TODO: embed the browse / explore
      }
    ?>
            
            <div class="row">
                <?php get_template_part('content', 'sponsors'); ?>
                <?php get_template_part('content', 'canidates'); ?>


            </div>
</div>

   


        <?php get_footer(); ?>
