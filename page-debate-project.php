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
                <h2 class="debate-title">First Debate: September 26, 2016</h2>
                <div class="row">
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/20160927_2_30_raw.csv" class="btn primary data-download__button" target="_blank">Raw Matches</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/20160927_2_30_timeline.csv" class="btn primary data-download__button" target="_blank">Frequency Timeline</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download col-xs-12 col-sm-4">
                        <a href="<?php echo(get_stylesheet_directory_uri());?>/data/20160927_2_30_summarized.csv" class="btn primary data-download__button" target="_blank">Summarized Matches</a>
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
                <p class="debate-data-description">Data on debate clips aired immediately after the vice presidential debate</p>
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
                <p class="debate-data-description">Data on debate clips aired during the 26 hours following the debate, October 4 – 5, 2016.  Including CNN, MSNBC, Fox News and more</p>
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
                <p class="debate-data-description"><strong>Raw:</strong> Clips aired over the 26 hours following the debate by local stations in select battleground state markets.</p>
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
    <!--    End Main Page Content-->

</div>

<?php get_footer(); ?>