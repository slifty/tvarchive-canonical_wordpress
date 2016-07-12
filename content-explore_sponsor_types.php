<div class="row">
    <div class="col-md-12">
        <div id="explore-sponsor_types-title" class="explore-subtitle-row text-center">
            <h3>Browse Ads by Sponsor Type</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-lg-8 col-lg-offset-2 ">
        <div id="explore-sponsor_types-content" class="explore-content-row">
            <ol class="explore-list">
                <?php
                    $sponsor_types = get_sponsor_types();
                    $first = true;
                    $j = 0;
                    foreach($sponsor_types as $sponsor_type) {

                            if ($first) {
                              $highestCount = $sponsor_type['count'];
                              $first = false;
                            }

                        $j++;

                        ?>
                          <li class="explore-item item">
                            <div class="explore-label">
                              <p>
                                <?php echo($sponsor_type['name']); ?>
                              </p>
                              <small>
                                  <a href="<?php bloginfo('url'); ?>/browse/?q=<?php echo(urlencode("sponsor_type:\"".$sponsor_type['name']."\""));?>">View Ads</a>
                              </small>
                            </div>
                            <div class="explore-bar-container">
                                <div class="explore-bar" style="width:<?php echo((($sponsor_type['count']/$highestCount)*100).'%;') ?>"></div>
                                <div class="explore-count"><?php echo($sponsor_type['count']); ?>  Ad<?php echo($sponsor_type['count']==1?"":"s");?></div>
                            </div>
                          </li>

                <?php

                    }
                ?>
                </div>
            </ol>
        </div>
    </div>
</div>
