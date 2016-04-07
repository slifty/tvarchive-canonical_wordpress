<div class="row">
    <div class="col-md-12">
        <div id="explore-candidates-title" class="explore-subtitle-row">
            <h3>Candidates</h3>
            <p>Browse ads by candidate</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="explore-candidates-content" class="explore-content-row">
            <ol class="explore-list">
            <?php
                $candidates = get_candidates();
                $first = true;
                $highestCount = 0;
                $i = 0;
                foreach($candidates as $candidate) {
                    $i++;
                    if ($first) {
                      $highestCount = $candidate['count'];
                      $first = false;
                    }

                    ?>
                      <li class="explore-item item">
                        <div class="explore-label">
                          <h4>
                            <span class="explore-item-rank"><?php echo $i; ?></span>
                          <a href="<?php bloginfo('url'); ?>/browse/?q=<?php echo(urlencode("candidate:\"".$candidate['name']."\""));?>">
                            <?php echo($candidate['name']); ?>
                          </a>
                          </h4>
                        </div>
                        <div class="explore-image">
                          <img src="<?php echo(get_archive_image_url($candidate['name'])); ?>" />
                        </div>
                        <div class="explore-bar-container">
                            <div class="explore-bar" style="width:<?php echo((($candidate['count']/$highestCount)*100).'%;') ?>"></div>
                            <div class="explore-count"><?php echo($candidate['count']); ?>  Ad<?php echo($candidate['count']==1?"":"s");?></div>
                        </div>
                      </li>

            <?php

                  if ($i == 10){
                    echo '</ol><div class="collapse" id="seeMoreCandidates"><ol class="explore-list">';
                  }

                }
            ?>
            </div>
            </ol>
            <button class="btn explore-show-more" role="button" data-toggle="collapse" data-target="#seeMoreCandidates" aria-expanded="false" aria-controls="seeMoreCandidates">Show / Hide <?php echo ($i-10);?> More Candidates</button>
        </div>
    </div>
</div>

