
        
                <div id="resources-content" class="row">
                    <div class="col-sm-12 col-md-7"><!-- left side -->
                        <div id="featured-resource" class="row resource-row page-content-row">
                            <div class="reference col-mg-12"><!--  top left side single-->
                                <h3 class="reference-title"><?php echo($reference['reference_title']); ?></h3>
                                <div class="reference-date"><?php echo($reference['reference_date']); ?> </div>
                                <div class="reference-description"><?php echo($reference['reference_excerpt']); ?></div>
                                <div class="reference-link"><a href="<?php echo($reference['reference_link']); ?>" target="_blank">logo link</a></div>
                            </div>
                        </div>    
                            <?php }
                            while(sizeof($references) > 1)
                                {
                                    ?>
                        <div class="row"><!--  bottom left side row double-->
                             <div class="col-md-12">          
                            <?php
                                for($x = 0; $x < 2; $x++)
                                {
                                if(sizeof($references) == 0)
                                continue;
                            $reference = array_shift($references);
                            ?>
                                        
                            <div class="col-sm-6 col-md-6">
                                <div class="reference">
                                    <h3 class="reference-title"><?php echo($reference['reference_title']); ?></h3>
                                    <div class="reference-date"><?php echo($reference['reference_date']); ?></div>
                                    <div><img src='<?php echo($reference['reference_image']);?>' class="reference-image" />Image</div>
                                    <div class="reference-description"> <?php echo($reference['reference_excerpt']); ?> </div>
                                    <div class="reference-link"><a href="<?php echo($reference['reference_link']); ?>" target="_blank">logo link</a></div>
                                </div>
                            </div>
                            <?php } ?>
                                       
                        </div><!--  bottom left side row double-->
                    </div><!-- left side -->
        </div>
                <?php
                                }
            while(sizeof($references) > 3)
			{
				?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <?php
					for($x = 0; $x < 5; $x++)
					{
						if(sizeof($references) == 0)
							continue;
						$reference = array_shift($references);
						?>
                                                            <div class="col-sm-5 col-md-5">
                                                                <h1>this is the right side</h1>
                                                                <div class="reference">
                                                                    <h3 class="reference-title"><?php echo($reference['reference_title']); ?></h3>
                                                                    <div class="reference-date">
                                                                        <?php echo($reference['reference_date']); ?>
                                                                    </div>
                                                                    <div>
                                                                    <img src='<?php echo($reference['reference_image']);?>' class="reference-image" />Image
                                                                    </div>
                                                                    <div class="reference-description">
                                                                        <?php echo($reference['reference_excerpt']); ?>
                                                                    </div>
                                                                    <div class="reference-link"><a href="<?php echo($reference['reference_link']); ?>" target="_blank">logo link</a></div>
                                                                </div>
                                                            </div>
                                                            <?php
					}
				?>
                                                    </div>
                                                      </div>
                                </div>
                    </div>
                </div>

                                                    <?php
			}
		?>

                                              




