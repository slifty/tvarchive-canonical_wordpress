<div class="row">
    <div class="col-md-12">
        <div id="explore-sponsor_types-title" class="explore-subtitle-row">
            <h3>Sponsor Types</h3>
            <p>Browse ads by sponsor type</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="explore-sponsor_types-content" class="explore-content-row">
           <ol class="explore-list">
            <?php
                $sponsor_types = get_sponsor_types();
                $first = true;
                $highestCount = 0;
                $i = 0;
                foreach($sponsor_types as $sponsor) {
                    $i++;
                    if ($first) {
                      $highestCount = $sponsor_type['count'];
                      $first = false;
                    }
                    ?>
                      <li class="explore-item item clearfix">
                        <div class="explore-label">
                          <h4>
                            <span class="explore-item-rank"><?php echo $i; ?></span>
                          <a href="<?php bloginfo('url'); ?>/browse/?q=<?php echo(urlencode("sponsor_type:\"".$sponsor_type['name']."\""));?>">
                            <?php echo($sponsor_type['name']); ?>
                          </a>
                          </h4>
                        </div>
                        <div class="explore-image">
                          <img src="<?php echo(get_archive_image_url($sponsor_type['name'])); ?>" />
                        </div>
                        <div class="explore-bar-container">
                            <div class="explore-bar" style="width:<?php echo((($sponsor_type['count']/$highestCount)*100).'%;') ?>"></div>
                            <div class="explore-count"><?php echo($sponsor_type['count']); ?>  Ad<?php echo($sponsor_type['count']==1?"":"s");?></div>
                        </div>
                      </li>
                    <?php
                }
            ?>
            </ol>
        </div>
    </div>
</div>
