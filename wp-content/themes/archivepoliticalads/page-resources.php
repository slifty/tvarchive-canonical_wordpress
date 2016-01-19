<?php
/*
    Template Name: Resources
*/
?>
<?php get_header(); ?>

<div id="resources-header" class="row page-header-row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
        <h1 id="resources-header-title">Resources</h1>
        <p id="resources-header-description">Our partners and additional resources</p>
    </div>
</div>

<div id="partners-content" class="page-content">
    <div id="partner-logos" class="row page-content-row">
        <div class="">
            <ul>
                <?php
                    $partners = get_field('partners');
                    if(is_array($partners)) {
                        foreach($partners as $partner)
                        {
                            ?>
                            <li><img src='<?php echo($partner['partner_logo']['url']);?>' class="logo" /></li>
                            <?php
                        }
                    }
                ?>
            </ul>
        </div>
    </div>
    <div id="partner-description" class="row page-content-row">
        <div class="col-lg-12">
            <h2>Our Partners</h2>
            <div><?php the_field('partners_description'); ?></div>
        </div>
    </div>
</div>

<div id="resources-subheader" class="row page-subheader-row">
    <div class="col-lg-6">
        <h2>Resources</h2>
    </div>
</div>
<div id="resources-content" class="row">
    <div coass="col-lg-12">
        <?php
            $wide_resources = get_field('wide_resources');
            $narrow_resources = get_field('narrow_resources');
            if(is_array($wide_resources)) {
                foreach($wide_resources as $resource) {
                    ?>
                    <div id="featured-resource" class="row resource-row page-content-row">
                        <div class="col-lg-12">
                            <div class="resource">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <a href="<?php echo($resource['resource_link']); ?>" target="_blank"><h3 class="resource-name"><?php echo($resource['resource_name']); ?></h3></a>
                                        <div class="resource-description"><?php echo($resource['resource_description']); ?></div>
                                        <div class="resource-link"><a href="<?php echo($resource['resource_link']); ?>" target="_blank">Visit</a></div>
                                    </div>
                                    <div class="col-sm-4">
                                        <a href="<?php echo($resource['resource_link']); ?>" target="_blank"><img src='<?php echo($resource['resource_image']['url']);?>' class="resource-image"/></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            if(is_array($narrow_resources)) {
                $cleanup = "";
                foreach($narrow_resources as $index => $resource) {

                    if($index % 3 == 0) {
                        ?>
                        <div class="row resource-row page-content-row">
                        <?php
                        $cleanup = "</div>";
                    }
                    ?>
                    <div class="col-sm-4 col-lg-4">
                        <div class="resource">
                            <a href="<?php echo($resource['resource_link']); ?>" target="_blank"><h3 class="resource-name"><?php echo($resource['resource_name']); ?></h3></a>
                            <a href="<?php echo($resource['resource_link']); ?>" target="_blank"><img src='<?php echo($resource['resource_image']['url']);?>' class="resource-image"/></a>
                            <div class="resource-description"><?php echo($resource['resource_description']); ?></div>
                            <div class="resource-link"><a href="<?php echo($resource['resource_link']); ?>" target="_blank">Visit</a></div>
                        </div>
                    </div>
                    <?php
                    if($index % 3 == 2) {
                        ?>
                        </div>
                        <?php
                        $cleanup = "";
                    }
                }
                echo($cleanup);
            }
        ?>
    </div>
</div>

<?php get_footer(); ?>
