<div class="row">
    <div class="col-md-12">
        <div id="explore-sponsors-title" class="explore-subtitle-row text-center">
            <h3>Political Ads by Sponsor</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-lg-8 col-lg-offset-2 ">
        <div id="explore-sponsors-content" class="explore-content-row text-center">
            <ol class="explore-list">
                <?php
                    $sponsors = get_sponsors();
                    $first = true;
                    $j = 0;
                    foreach($sponsors as $sponsor) {

                            if ($first) {
                              $highestCount = $sponsor['count'];
                              $first = false;
                            }

                        $j++;

                        ?>
                          <li class="explore-item item">
                            <div class="explore-label">
                              <p>
                                <?php echo($sponsor['name']); ?>
                              </p>
                              <small>
                                  <a href="<?php bloginfo('url'); ?>/browse/?q=<?php echo(urlencode("sponsor:\"".$sponsor['name']."\""));?>">View Ads</a>
                              </small>
                            </div>
                            <div class="explore-bar-container">
                                <div class="explore-bar" style="width:<?php echo((($sponsor['count']/$highestCount)*100).'%;') ?>"></div>
                                <div class="explore-count"><?php echo($sponsor['count']); ?>  Ad<?php echo($sponsor['count']==1?"":"s");?></div>
                            </div>
                          </li>

                <?php

                      if ($j == 4){
                        echo '</ol><div class="collapse" id="seeMoreSponsors"><ol class="explore-list">';
                      }



                    }
                ?>
                </div>
            </ol>
            <button class="btn explore-show-more" role="button" data-toggle="collapse" data-target="#seeMoreSponsors" aria-expanded="false" aria-controls="seeMoreSponsors">Show / Hide <?php echo ($j-4);?> More Sponsors</button>
        </div>
    </div>
</div>
