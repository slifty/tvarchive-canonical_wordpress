<div class="row">
    <div class="col-md-12">
        <div id="explore-candidates-title" class="explore-subtitle-row text-center">
            <h3>Political Ads by Candidate</h3>
            <p></p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-lg-8 col-lg-offset-2 ">
        <div id="explore-candidates-content" class="explore-content-row text-center">
            <ul class="nav nav-pills" id="candidate-race-pills" role="tablist">
                <?php
                    $races = get_races();
                    $i = 0;
                    foreach($races as $race) {
                    ?>
                    <li role="presentation" <?php if ($i == 0) echo 'class="active"';?>><a href="#<?php echo($race['name']); ?>" aria-controls="<?php echo($race['name']); ?>" role="tab" data-toggle="pill"><?php echo($race['name']); ?></a></li>
                <?php $i++; } ?>
            </ul>
            <div class="tab-content">
                <?php
                    $races = get_races();
                    $i = 0;
                    foreach($races as $race) {
                        $race_name = $race['name'];
                        $highestCount = 0;
                    ?>
                    <div role="tabpanel" class="tab-pane <?php if ($i == 0) echo 'active';?>" id="<?php echo($race['name']); ?>">
                        <ol class="explore-list">
                            <?php
                                $candidates = get_candidates();
                                $first = true;
                                $j = 0;
                                foreach($candidates as $candidate) {



                                    if ($candidate['race'] == $race['name']){

                                        if ($first) {
                                          $highestCount = $candidate['count'];
                                          $first = false;
                                        }

                                    $j++;

                                    ?>
                                      <li class="explore-item item">
                                        <div class="explore-label">
                                          <p>
                                            <?php echo($candidate['name']); ?>
                                          </p>
                                          <small>
                                              <a href="<?php bloginfo('url'); ?>/browse/?q=<?php echo(urlencode("candidate:\"".$candidate['name']."\""));?>">View Ads</a>
                                          </small>
                                        </div>
                                        <div class="explore-bar-container">
                                            <div class="explore-bar" style="width:<?php echo((($candidate['count']/$highestCount)*100).'%;') ?>"></div>
                                            <div class="explore-count"><?php echo($candidate['count']); ?>  Ad<?php echo($candidate['count']==1?"":"s");?></div>
                                        </div>
                                      </li>
                                      <?php } ?>

                            <?php

                                  if ($j == 4){
                                    echo '</ol><div class="collapse" id="seeMoreCandidates'.$race['name'].'"><ol class="explore-list">';
                                  }



                                }
                            ?>
                            </div>
                        </ol>
                        <button class="btn explore-show-more" role="button" data-toggle="collapse" data-target="#seeMoreCandidates<?php echo $race['name']; ?>" aria-expanded="false" aria-controls="seeMoreCandidates">Show / Hide <?php echo ($j-4);?> More Candidates</button>
                    </div>
                <?php $i++; } ?>
            </div>
        </div>
    </div>
</div>

