    <?php get_header(); ?>

        <div id="download-header" class="row page-header-row">
            <div class="col-xs-12 col-sm-6 col-md-6">
                <h1 id="download-header-title" class="section-header">Data Download</h1>
                <p id="download-header-description">PUT THE LIBRARY TO WORK</p>
            </div>
        </div>
        <!--- end Header -->

        <div class="row page-content">
            <div id="download-content" class="">
                <div class="row page-content-row">
                    <div class="col-xs-12 col-md-12">
                        <h2><?php echo(get_field('data_header')); ?></h2>
                        <p>
                            <?php echo(get_field('data_header_content')); ?>
                        </p>
                    </div>
                </div>
                <!-- end row about dataset-->
                <div class="row page-content-row">
                    <div class="col-xs-12 col-md-12">
                        <h2>BUILD YOUR OWN DATASET</h2>
                        <div class="cell-multiline-value">Choose the fields you would like included below:</div>
                    </div>
                </div>

                <div class="row page-content-row">
                    <div class="col-xs-12 col-lg-12">
                        <h2><?php echo(get_field('data_subheader_1')); ?></h2>
                        <p>
                            <?php echo(get_field('data_subheader_1_content')); ?>
                        </p>
                    </div>
                </div>
                <!-- end row data_subheader_1-->
                <div class="row page-content-row">
                    <div class="col-xs-12 col-md-12">
                        <h2 class="page-content-row"> <?php echo(get_field('data_subheader_2')); ?></h2>
                        <p>
                            <?php echo(get_field('data_subheader_2_content')); ?>
                        </p>
                    </div>
                </div>
                <!-- end row data_subheader_2-->

                <div class="row page-content-row">
                    <div class="col-xs-12 col-md-12">
                        <h2><?php echo(get_field('data_subheader_3')); ?></h2>
                        <p>
                            <?php echo(get_field('data_subheader_3_content')); ?>
                        </p>
                    </div>
                </div>
                <!-- end row data_subheader_3-->

            </div>
            <!--    End Main Page Content-->

        </div>
        <!--    End Row-->


        <!--- End Container -->










        <?php get_footer(); ?>
