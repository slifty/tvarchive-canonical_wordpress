<?php
/*
    Template Name: Debate Project
*/
?>
<?php get_header(); ?>

<div id="download-header" class="row page-header-row guttered-row">
    <div class="col-xs-12 col-sm-6 col-md-6">
        <h1 id="data-header-title" class="section-header">2016 Presidential Debates</h1>
        <p id="data-header-description">Giving the public tools to track and analyze debates</p>
    </div>
</div>

<div id="data-content" class="page-content">
    <div class="row guttered-row" style="padding-bottom: 40px;">
        <div class="col-xs-12 col-md-12">
            <div><?php echo(get_field('project_about')); ?></div>
        </div>
    </div>

    <div class="row debate-header guttered-row">
        <div class="col-xs-12">
            <h2 class="section-header">Download the Data</h2>
        </div>
    </div>

    <div class="row guttered-row" style="padding-top: 40px;padding-bottom: 20px;">
        <div class="col-xs-12">
            <div><?php echo(get_field('about_data')); ?></div>
        </div>
    </div>

    <div class="row guttered-row">
        <div class="col-xs-12">
            <div class="data-download-group-container">
                <h2 class="debate-title">First Debate (Post-debate commentary): September 26, 2016</h2>
                <p class="debate-data-description">Data on debate clips aired immediately after the first presidential debate.</p>
                <div class="row">
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_09_26_first_presidential_late_1476407823_raw.csv" class="btn primary data-download__button" target="_blank">Raw Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_09_26_first_presidential_late_1476407823_timeline.csv" class="btn primary data-download__button" target="_blank">Frequency Timeline</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_09_26_first_presidential_late_1476407823_summarized.csv" class="btn primary data-download__button" target="_blank">Summarized Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row guttered-row" style="padding-bottom: 20px;">
        <div class="col-xs-12"></div>
    </div>
    <div class="row guttered-row">
        <div class="col-xs-12">
            <div class="data-download-group-container">
                <h2 class="debate-title">First Debate (Cable stations): September 26, 2016</h2>
                <p class="debate-data-description">Data on debate clips aired during the 26 hours following the debate, September 26 – 27, 2016.  Including CNN, MSNBC, Fox News and more.</p>
                <div class="row">
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_09_26_first_presidential_full_cable_1476407859_raw.csv" class="btn primary data-download__button" target="_blank">Raw Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_09_26_first_presidential_full_cable_1476407859_timeline.csv" class="btn primary data-download__button" target="_blank">Frequency Timeline</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_09_26_first_presidential_full_cable_1476407859_summarized.csv" class="btn primary data-download__button" target="_blank">Summarized Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row guttered-row" style="padding-bottom: 20px;">
        <div class="col-xs-12"></div>
    </div>
    <div class="row guttered-row">
        <div class="col-xs-12">
            <div class="data-download-group-container">
                <h2 class="debate-title">First Debate (Local stations): September 26, 2016</h2>
                <p class="debate-data-description"><strong>Morning:</strong> Clips aired in early morning local news programs, on ABC, CBS, NBC, and Fox affiliates–in select battleground state markets from 5:00 am to 7:00 am on September 27, 2016.</p>
                <p class="debate-data-description"><strong>Full:</strong> Clips aired over the 26 hours following the debate by local stations in select battleground state markets.</p>
                <div class="row">
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_09_26_first_presidential_morning_local_1476408320_raw.csv.csv" class="btn primary data-download__button" target="_blank">Morning (raw)</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_09_26_first_presidential_full_local_1476408773_raw.csv" class="btn primary data-download__button" target="_blank">Full (raw)</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row guttered-row" style="padding-top: 40px;padding-bottom: 20px;">
        <div class="col-xs-12"></div>
    </div>
    <div class="row guttered-row">
        <div class="col-xs-12">
            <div class="data-download-group-container">
                <h2 class="debate-title">VP Debate (Post-debate commentary): October 4, 2016</h2>
                <p class="debate-data-description">Data on debate clips aired immediately after the vice presidential debate.</p>
                <div class="row">
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/vp_night_raw.csv" class="btn primary data-download__button" target="_blank">Raw Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/vp_night_timeline.csv" class="btn primary data-download__button" target="_blank">Frequency Timeline</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/vp_night_summarized.csv" class="btn primary data-download__button" target="_blank">Summarized Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row guttered-row" style="padding-bottom: 20px;">
        <div class="col-xs-12"></div>
    </div>
    <div class="row guttered-row">
        <div class="col-xs-12">
            <div class="data-download-group-container">
                <h2 class="debate-title">VP Debate (Cable stations): October 4, 2016</h2>
                <p class="debate-data-description">Data on debate clips aired during the 26 hours following the debate, October 4 – 5, 2016.  Including CNN, MSNBC, Fox News and more.</p>
                <div class="row">
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/vp_cable_full_raw.csv" class="btn primary data-download__button" target="_blank">Raw Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/vp_cable_full_timeline.csv" class="btn primary data-download__button" target="_blank">Frequency Timeline</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/vp_cable_full_summarized.csv" class="btn primary data-download__button" target="_blank">Summarized Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row guttered-row" style="padding-bottom: 20px;">
        <div class="col-xs-12"></div>
    </div>
    <div class="row guttered-row">
        <div class="col-xs-12">
            <div class="data-download-group-container">
                <h2 class="debate-title">VP Debate (Local stations): October 4, 2016</h2>
                <p class="debate-data-description"><strong>Morning:</strong> Clips aired in early morning local news programs, on ABC, CBS, NBC, and Fox affiliates–in select battleground state markets from 5:00 am to 7:00 am on October 5, 2016.</p>
                <p class="debate-data-description"><strong>Full:</strong> Clips aired over the 26 hours following the debate by local stations in select battleground state markets.</p>
                <div class="row">
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/vp_local_morning_raw.csv" class="btn primary data-download__button" target="_blank">Morning (raw)</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/vp_local_full_raw.csv" class="btn primary data-download__button" target="_blank">Full (raw)</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row guttered-row" style="padding-top: 40px;padding-bottom: 20px;">
        <div class="col-xs-12"></div>
    </div>
    <div class="row guttered-row">
        <div class="col-xs-12">
            <div class="data-download-group-container">
                <h2 class="debate-title">Second Presidential Debate (Post-debate commentary): October 9, 2016</h2>
                <p class="debate-data-description">Data on debate clips aired immediately after the second presidential debate</p>
                <div class="row">
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_10_09_second_presidential_late_1476112573_raw.csv" class="btn primary data-download__button" target="_blank">Raw Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_10_09_second_presidential_late_1476112573_timeline.csv" class="btn primary data-download__button" target="_blank">Frequency Timeline</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_10_09_second_presidential_late_1476112573_summarized.csv" class="btn primary data-download__button" target="_blank">Summarized Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row guttered-row" style="padding-bottom: 20px;">
        <div class="col-xs-12"></div>
    </div>
    <div class="row guttered-row">
        <div class="col-xs-12">
            <div class="data-download-group-container">
                <h2 class="debate-title">Second Presidential Debate (Cable stations): October 9, 2016</h2>
                <p class="debate-data-description">Data on debate clips aired during the 26 hours following the debate, October 9 – 10, 2016.  Including CNN, MSNBC, Fox News and more</p>
                <div class="row">
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_10_09_second_presidential_full_cable_1476215812_raw.csv" class="btn primary data-download__button" target="_blank">Raw Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_10_09_second_presidential_full_cable_1476215812_timeline.csv" class="btn primary data-download__button" target="_blank">Frequency Timeline</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_10_09_second_presidential_full_cable_1476215812_summarized.csv" class="btn primary data-download__button" target="_blank">Summarized Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row guttered-row" style="padding-bottom: 20px;">
        <div class="col-xs-12"></div>
    </div>
    <div class="row guttered-row">
        <div class="col-xs-12">
            <div class="data-download-group-container">
                <h2 class="debate-title">Second Presidential Debate (Local stations): October 9, 2016</h2>
                <p class="debate-data-description"><strong>Morning:</strong> Clips aired in early morning local news programs, on ABC, CBS, NBC, and Fox affiliates–in select battleground state markets from 5:00 am to 7:00 am on October 10, 2016.</p>
                <p class="debate-data-description"><strong>Full:</strong> Clips aired over the 26 hours following the debate by local stations in select battleground state markets.</p>
                <div class="row">
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_10_09_second_presidential_morning_local_1476116889_raw.csv" class="btn primary data-download__button" target="_blank">Morning (raw)</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_10_09_second_presidential_full_local_1476216430_raw.csv" class="btn primary data-download__button" target="_blank">Full (raw)</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row guttered-row" style="padding-top: 40px;padding-bottom: 20px;">
        <div class="col-xs-12"></div>
    </div>
    <div class="row guttered-row">
        <div class="col-xs-12">
            <div class="data-download-group-container">
                <h2 class="debate-title">Third Presidential Debate (Post-debate commentary): October 19, 2016</h2>
                <p class="debate-data-description">Data on debate clips aired immediately after the third presidential debate</p>
                <div class="row">
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_10_19_third_presidential_late_1476948275_raw.csv" class="btn primary data-download__button" target="_blank">Raw Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_10_19_third_presidential_late_1476948275_timeline.csv" class="btn primary data-download__button" target="_blank">Frequency Timeline</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_10_19_third_presidential_late_1476948275_summarized.csv" class="btn primary data-download__button" target="_blank">Summarized Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row guttered-row" style="padding-bottom: 20px;">
        <div class="col-xs-12"></div>
    </div>
    <div class="row guttered-row">
        <div class="col-xs-12">
            <div class="data-download-group-container">
                <h2 class="debate-title">Third Presidential Debate (Local stations): October 19, 2016</h2>
                <p class="debate-data-description"><strong>Morning:</strong> Clips aired in early morning local news programs, on ABC, CBS, NBC, and Fox affiliates–in select battleground state markets from 5:00 am to 7:00 am on October 20, 2016.</p>
                <p class="debate-data-description"><strong>Full:</strong> Clips aired over the 26 hours following the debate by local stations in select battleground state markets.</p>
                <div class="row">
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/2016_10_19_third_presidential_morning_local_1476984083_raw.csv" class="btn primary data-download__button" target="_blank">Morning (raw)</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="" class="btn primary data-download__button" target="_blank">Full (raw)</a>
                        <small class="data-download__size">Coming Soon</small>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row guttered-row" style="padding-bottom: 20px;">
        <div class="col-xs-12"></div>
    </div>

    <div class="row debate-header guttered-row">
        <div class="col-xs-12">
            <h2 class="section-header">Special Datasets</h2>
        </div>
    </div>


    <div class="row guttered-row" style="padding-bottom: 20px;">
        <div class="col-xs-12"></div>
    </div>

    <div class="row guttered-row">
        <div class="col-xs-12">
            <div class="data-download-group-container">
                <h2 class="debate-title">Trump Tape Coverage: October 7-9, 2016</h2>
                <p class="debate-data-description">Data related to coverage of the Trump Tapes from the breaking news to the beginning of the presidential debate (9:00 EST on Sunday).</p>
                <div class="row">
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/trump_tape_to_debate_1476155228_raw.csv" class="btn primary data-download__button" target="_blank">Raw Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/trump_tape_to_debate_1476155228_timeline.csv" class="btn primary data-download__button" target="_blank">Frequency Timeline</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/trump_tape_to_debate_1476155228_summarized.csv" class="btn primary data-download__button" target="_blank">Summarized Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row guttered-row" style="padding-bottom: 20px;">
        <div class="col-xs-12"></div>
    </div>

    <div class="row guttered-row">
        <div class="col-xs-12">
            <div class="data-download-group-container">
                <h2 class="debate-title">Trump Tape Apology Coverage: October 7-9, 2016</h2>
                <p class="debate-data-description">Data related to coverage of Donald Trump's apology from the breaking news to the beginning of the presidential debate (9:00 EST on Sunday).</p>
                <div class="row">
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/trump_tape_apology_to_debate_1476155266_raw.csv" class="btn primary data-download__button" target="_blank">Raw Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/trump_tape_apology_to_debate_1476155266_timeline.csv" class="btn primary data-download__button" target="_blank">Frequency Timeline</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/trump_tape_apology_to_debate_1476155266_summarized.csv" class="btn primary data-download__button" target="_blank">Summarized Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row guttered-row" style="padding-bottom: 20px;">
        <div class="col-xs-12"></div>
    </div>
</div>

<?php get_footer(); ?>
