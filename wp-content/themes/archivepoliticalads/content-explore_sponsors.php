<div class="row">
    <div class="col-md-12">
        <div id="explore-sponsors-title" class="explore-subtitle-row">
            <h3>Sponsors</h3>
            <p>Browse ads by sponsor</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="explore-sponsors-content" class="explore-content-row">
            <ol class="explore-list">
            <?php
                $sponsors = get_sponsors();
                $first = true;
                $highestCount = 0;
                $i = 0;
                foreach($sponsors as $sponsor) {
                    $i++;
                    if ($first) {
                      $highestCount = $sponsor['count'];
                      $first = false;
                    }
                    ?>
                      <li class="explore-item item clearfix">
                        <div class="explore-label">
                          <h4>
                            <span class="explore-item-rank"><?php echo $i; ?></span>
                          <a href="<?php bloginfo('url'); ?>/browse/?q=<?php echo(urlencode("sponsor:\"".$sponsor['name']."\""));?>">
                            <?php echo($sponsor['name']); ?>
                          </a>
                          </h4>
                        </div>
                        <div class="explore-image">
                          <img src="<?php echo(get_archive_image_url($sponsor['name'])); ?>" />
                        </div>
                        <div class="explore-bar-container">
                            <div class="explore-bar" style="width:<?php echo((($sponsor['count']/$highestCount)*100).'%;') ?>"></div>
                            <div class="explore-count"><?php echo($sponsor['count']); ?>  Ad<?php echo($sponsor['count']==1?"":"s");?></div>
                        </div>
                      </li>
                      <?php

                      if ($i == 10){
                        echo '</ol><div class="collapse" id="seeMoreSponsors"><ol class="explore-list">';
                      }

                    }
                ?>
              </div>
            </ol>
            <button class="btn btn-primary explore-show-more" role="button" data-toggle="collapse" data-target="#seeMoreSponsors" aria-expanded="false" aria-controls="seeMoreSponsors">Show / Hide <?php echo ($i-10);?> More Sponsors</button>
        </div>
    </div>
</div>
