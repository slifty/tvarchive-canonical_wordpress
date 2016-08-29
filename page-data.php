<?php
/*
    Template Name: Data
*/
?>
<?php get_header(); ?>

<div id="download-header" class="row page-header-row guttered-row">
    <div class="col-xs-12 col-sm-6 col-md-6">
        <h1 id="download-header-title" class="section-header">Data Download</h1>
        <p id="download-header-description">Put the Archive to Work</p>
    </div>
</div>

<div id="data-content" class="page-content">
    <div id="download-content" class="">
        <div class="row page-content-row">
            <div class="col-xs-12 col-md-12">
                <h2>About the Dataset</h2>
                <div><?php echo(get_field('dataset_about')); ?></div>
            </div>
        </div>
        <div class="row page-content-row">
            <div class="col-xs-12 col-md-6">
                <div class="data-download-group-container">
                    <h2>Download Details of Airings on TV</h2>
                    <p>These datasets provide details about airings of ads on TV, giving information about when and where they aired. Divided datasets by quarter are also available for download.</p>
                    <div class="data-download">
                        <a href="<?php bloginfo('url'); ?>/api/v1/ad_instances?end_time=12/31/2015%2023:59:59&output=csv" class="btn primary data-download__button" target="_blank">Sept - Dec 2015</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download">
                        <a href="<?php bloginfo('url'); ?>/api/v1/ad_instances?start_time=1/1/2016%2000:00:00&end_time=4/30/2016%2023:59:59&output=csv" class="btn primary data-download__button" target="_blank">Jan - April 2016</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download">
                        <a href="<?php bloginfo('url'); ?>/api/v1/ad_instances?start_time=5/1/2016%2000:00:00output=csv" class="btn primary data-download__button" target="_blank">May - <?php echo(date('F Y')); ?></a>
                        <small class="data-download__size">CSV</small>
                    </div>
                    <div class="data-download">
                        <a href="<?php bloginfo('url'); ?>/api/v1/ad_instances?output=csv" class="btn primary data-download__button" target="_blank">Entire Dataset</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="data-download-group-container">
                    <h2>Download a List of Unique Ads Aired</h2>
                    <p>This dataset provides information on every ad archived by the project, whether or not that ad has been captured as airing on television.</p>
                    <div class="data-download">
                        <a href="<?php bloginfo('url'); ?>/api/v1/ads?output=csv" class="btn primary data-download__button" target="_blank">Entire Dataset</a>
                        <small class="data-download__size">CSV</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row page-content-row">
            <div class="col-xs-12 col-md-12">
                <h2>TV Recording</h2>
                <div><?php echo(get_field('dataset_tv_recording_description')); ?></div>
                    <button class="collapse-toggle metadata-table-collapse-toggle" type="button" data-toggle="collapse" data-target="#channelRecordingDetails" aria-expanded="false" aria-controls="channelRecordingDetails" data-description="Details of which channels are collected, when collection was started, and when it stopped (if appropriate).">Show Channel Recording Details</button>
                <div class="metadata-table-container collapse" id="channelRecordingDetails">
                    <table>
                        <thead>
                            <tr>
                                <th>Started</th>
                                <th>Stopped</th>
                                <th>Location</th>
                                <th>Station Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $rows = get_field('dataset_collected_channel');
                                if(is_array($rows)) {
                                    foreach($rows as $row) {
                                        ?>
                                        <tr>
                                            <td><?php echo($row['date_started']); ?></td>
                                            <td><?php echo($row['date_ended']); ?></td>
                                            <td><?php echo($row['location']); ?></td>
                                            <td><?php echo($row['station_name']); ?></td>
                                        </tr>
                                        <?php
                                    }
                                }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row page-content-row">
            <div class="col-xs-12 col-md-12">
                <h2>Audio Fingerprinting</h2>
                <div><?php echo(get_field('dataset_audio_fingerprinting_description')); ?></div>
            </div>
        </div>
        <div class="row page-content-row">
            <div class="col-xs-12 col-md-12">
                <h2>Metadata</h2>
                <div><?php echo(get_field('dataset_airings_metadata_description')); ?></div>
                    <button class="collapse-toggle metadata-table-collapse-toggle" type="button" data-toggle="collapse" data-target="#airingsMetadataDetails" aria-expanded="false" aria-controls="channelRecordingDetails" data-description="Details of which channels are collected, when collection was started, and when it stopped (if appropriate).">Show Channel Recording Details</button>
                <div class="metadata-table-container collapse" id="airingsMetadataDetails">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $rows = get_field('dataset_airings_metadata_entry');
                                if(is_array($rows)) {
                                    foreach($rows as $row) {
                                        ?>
                                        <tr>
                                            <td><?php echo($row['airings_metadata_name']); ?></td>
                                            <td><?php echo($row['airings_metadata_type']); ?></td>
                                            <td><?php echo($row['airings_metadata_description']); ?></td>
                                        </tr>
                                        <?php
                                    }
                                }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row page-content-row">
            <div class="col-xs-12 col-md-12">
                <h2>Unique Ads Archived Metadata</h2>
                <div><?php echo(get_field('dataset_unique_metadata_description')); ?></div>
                    <button class="collapse-toggle metadata-table-collapse-toggle" type="button" data-toggle="collapse" data-target="#uniqueAdsMetadataDetails" aria-expanded="false" aria-controls="channelRecordingDetails" data-description="Details of which channels are collected, when collection was started, and when it stopped (if appropriate).">Show Channel Recording Details</button>
                <div class="metadata-table-container collapse" id="uniqueAdsMetadataDetails">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $rows = get_field('dataset_unique_ads_metadata_table_entry');
                                if(is_array($rows)) {
                                    foreach($rows as $row) {
                                        ?>
                                        <tr>
                                            <td><?php echo($row['unique_ads_name']); ?></td>
                                            <td><?php echo($row['unique_ads_type']); ?></td>
                                            <td><?php echo($row['unique_ads_description']); ?></td>
                                        </tr>
                                        <?php
                                    }
                                }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--    End Main Page Content-->

</div>

<?php get_footer(); ?>
