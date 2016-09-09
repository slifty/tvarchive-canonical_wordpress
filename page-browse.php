<?php
/*
    Template Name: Browse
*/
?>

<?php
    // Populate the "autocomplete" values for advanced search
    $candidates = array_map(function($x) { return $x->name; }, PoliticalAdArchiveCandidate::get_candidates());
    $sponsors = array_map(function($x) { return $x->name; }, PoliticalAdArchiveSponsor::get_sponsors());
    $sponsor_types = array_map(function($x) { return PoliticalAdArchiveSponsorType::get_friendly_sponsor_type_name($x->type); }, PoliticalAdArchiveSponsorType::get_sponsor_types());
    $sponsor_types = array_unique($sponsor_types);
    $channels = array_map(function($x) { return $x->channel; }, PoliticalAdArchiveChannel::get_channels());
    $subjects = array_map(function($x) { return $x->subject; }, PoliticalAdArchiveSubject::get_subjects());
    $programs = array_map(function($x) { return $x->program; }, PoliticalAdArchiveProgram::get_programs());
    $ad_types = array_map(function($x) { return $x->type; }, PoliticalAdArchiveAdType::get_ad_types());

    // Sort in alphabetical order
    sort($candidates);
    sort($sponsors);
    sort($sponsor_types);
    sort($channels);
    sort($subjects);
    sort($programs);
    sort($ad_types);

    // Pull down any URL-based search values
    $word_filter = array_key_exists('word_filter',$_GET)?$_GET['word_filter']:"";
    $candidate_filter = array_key_exists('candidate_filter',$_GET)?$_GET['candidate_filter']:"";
    $sponsor_filter = array_key_exists('sponsor_filter',$_GET)?$_GET['sponsor_filter']:"";
    $sponsor_type_filter = array_key_exists('sponsor_type_filter',$_GET)?$_GET['sponsor_type_filter']:"";
    $subject_filter = array_key_exists('subject_filter',$_GET)?$_GET['subject_filter']:"";
    $type_filter = array_key_exists('type_filter',$_GET)?$_GET['type_filter']:"";
    $channel_filter = array_key_exists('channel_filter',$_GET)?$_GET['channel_filter']:"";
    $program_filter = array_key_exists('program_filter',$_GET)?$_GET['program_filter']:"";

    // Should a search be run?
    $run_search_on_load = false;
    $start_with_advanced = false;
    if($word_filter || $candidate_filter || $sponsor_filter
    || $subject_filter || $type_filter || $channel_filter
    || $program_filter)
        $run_search_on_load = true;

    if($candidate_filter || $sponsor_filter
    || $subject_filter || $type_filter || $channel_filter
    || $program_filter)
        $start_with_advanced = true;

?>

<?php get_header(); ?>
<div id="browse-header" class="row page-header-row guttered-row">
    <div class="col-sm-8 col-md-6">
        <h1 id="browse-header-title" class="section-header">Search</h1>
        <p id="browse-header-description">Search and Explore the Political TV Ad Archive</p>
    </div>
    <div id="basic-search" class="col-xs-12 col-sm-12 col-md-12">
        <form id="search-form" action="<?php bloginfo('url'); ?>/browse">
            <input type="text" name="word_filter" id="search-text" value="<?php echo(addslashes($word_filter)); ?>" placeholder="search for a sponsor, candidate or keyword" />
        </form>
    </div>
</div>
<div id="advanced-search" class="row guttered-row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form id="advanced-search-form" action="<?php bloginfo('url'); ?>/browse">
            <div id="advanced-facets">
                <fieldset>
                    <legend>Find Ads with...</legend>
                    <div class="advanced-search-facet row">
                        <label for="word-facet" class="col-md-2 col-sm-12">Any of these words</label>
                        <input type="text" class="col-md-10 col-sm-12" id="word-facet" name="word-facet" placeholder="search for a sponsor, candidate, political party, or keyword" value="<?php echo(addslashes($word_filter)); ?>" />
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Candidates and Sponsors</legend>
                    <div class="advanced-search-facet row">
                        <label for="candidate-facet" class="col-md-2 col-sm-12">Candidate</label>
                        <input type="text" class="col-md-10 col-sm-12" id="candidate-facet" name="candidate-facet" placeholder="search by candidate full, last or first name" value="<?php echo(addslashes($candidate_filter)); ?>" />
                    </div>
                    <div class="advanced-search-facet row">
                        <label for="sponsor-facet" class="col-md-2 col-sm-12">Sponsor</label>
                        <input type="text" class="col-md-10 col-sm-12" id="sponsor-facet" name="sponsor-facet" placeholder="search by full or partial sponsor name" value="<?php echo(addslashes($sponsor_filter)); ?>" />
                    </div>
                    <div class="advanced-search-facet row">
                        <label for="sponsor-type-facet" class="col-md-2 col-sm-12">Sponsor Type</label>
                        <input type="text" class="col-md-10 col-sm-12" id="sponsor-type-facet" name="sponsor-type-facet" placeholder="search by sponsor type (candidate committee, super PAC, etc)" value="<?php echo(addslashes($sponsor_type_filter)); ?>" />
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Ad</legend>
                    <div class="advanced-search-facet row">
                        <label for="subject-facet" class="col-md-2 col-sm-12">Subject</label>
                        <input type="text" class="col-md-10 col-sm-12" id="subject-facet" name="subject-facet" placeholder="search by ad subject (immigration, taxes, etc)" value="<?php echo(addslashes($subject_filter)); ?>" />
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Airing History</legend>
                    <div class="advanced-search-facet row">
                        <label for="channel-facet" class="col-md-2 col-sm-12">Channel</label>
                        <input type="text" class="col-md-10 col-sm-12" id="channel-facet" name="channel-facet" value="<?php echo(addslashes($channel_filter)); ?>" />
                    </div>
                    <div class="advanced-search-facet row">
                        <label for="program-facet" class="col-md-2 col-sm-12">Program</label>
                        <input type="text" class="col-md-10 col-sm-12" id="program-facet" name="program-facet" value="<?php echo(addslashes($program_filter)); ?>" />
                    </div>
                </fieldset>
            </div>
        </form>
    </div>
</div>
<div id="browse-toggle-row" class="row guttered-row">
    <div class="col-xs-12">
        <div id="search-toggle"></div>
    </div>
</div>
<div id="browse-toolbox" class="row guttered-row">
    <div class="col-xs-12">
            <input type="submit" id="search-submit" value="Search" />
    </div>
</div>
<script type="text/javascript">
    var candidate_values = ["<?php echo(implode('","', $candidates)); ?>"];
    var sponsor_values = ["<?php echo(implode('","', $sponsors)); ?>"];
    var sponsor_type_values = ["<?php echo(implode('","', $sponsor_types)); ?>"];
    var channel_values = ["<?php echo(implode('","', $channels)); ?>"];
    var subject_values = ["<?php echo(implode('","', $subjects)); ?>"];
    var program_values = ["<?php echo(implode('","', $programs)); ?>"];
    var ad_type_values = ["<?php echo(implode('","', $ad_types)); ?>"];

    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }

    function preparedAutoComplete( object, list) {
        object
        .bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).autocomplete( "instance" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
            minLength: 0,
            source: function( request, response ) {
              // delegate back to autocomplete, but extract the last term
              response( $.ui.autocomplete.filter(
                list, extractLast( request.term ) ) );
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
                var original = this.value;
                var terms = split( this.value );
                // remove the current input
                terms.pop();
                // add the selected item
                terms.push( ui.item.value );
                // add placeholder to get the comma-and-space at the end
                terms.push( "" );
                this.value = terms.join( ", " );

                // Were any changes made?
                if(original == this.value)
                    return true;

                return false;
            }
        });
    }

    var searchPage = 0;
    var perPage = 20;
    var activeSearch = false;
    function runSearch(reset) {
        if(activeSearch)
            return;
        if(reset === true) {
            $("#search-results").empty();
            searchPage = 0;
            aTag = $("#browse-content");
            $('html,body').animate({scrollTop: aTag.offset().top - 50});
        }
        activeSearch = true;
        $("#no-results").hide();

        // Pull in the search parameters
        var search_params = [];
        if(isBasic) {
            search_params['word_filter'] = $("#search-text").val();
        }
        else {
            search_params['word_filter'] = $("#word-facet").val();
            search_params['candidate_filter'] = $("#candidate-facet").val();
            search_params['sponsor_filter'] = $("#sponsor-facet").val();
            search_params['sponsor_type_filter'] = $("#sponsor-type-facet").val();
            search_params['subject_filter'] = $("#subject-facet").val();
            search_params['channel_filter'] = $("#channel-facet").val();
            search_params['program_filter'] = $("#program-facet").val();
        }

        // Run a search and populate results
        var querystring_parts = [];
        for(param in search_params) {
            if(search_params[param] != "")
                querystring_parts.push(param + "=" + search_params[param]);
        }

        // Update the URL
        var new_url = location.protocol + '//' + location.host + location.pathname;
        var new_querystring = querystring_parts.join("&");
        window.history.pushState(search_params, "", new_url + "?" + new_querystring);

        // Add paging information
        querystring_parts.push("page=" + searchPage)
        querystring_parts.push("per_page=" + perPage)

        $.ajax({
            url: "<?php bloginfo('url'); ?>/api/v1/ads?" + querystring_parts.join("&"),
            type: "get"
        }).success(function(data) {
            $search_results = $("#search-results");
            for(x in data) {
                var ad = data[x];
                var result_html = '<div class="row page-content-row political-ad">';
                    result_html+= '<div class="col-xs-12 col-sm-6 col-lg-3"><div class="embed"><iframe frameborder="0" allowfullscreen src="' + ad['embed_url'] + '&nolinks=1" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe></div></div>';
                    result_html+= '<div class="col-xs-12 col-sm-6 col-lg-9"><div class="row"><div class="col-sm-12"><div class="title"><a href="<?php bloginfo('url'); ?>/ad/' + ad['archive_id'] + '">' + (ad['candidates'].length > 0?ad['candidates']:ad['sponsors']) + '</a></div></div></div>';
                    result_html+= '<div class="row"><div class=" col-sm-12"><div class="sponsors"><span class="browse-label">Ingested: </span>' + ad['date_ingested'] + '</div></div></div>';
                    result_html+= '<div class="row"><div class=" col-sm-12"><div class="sponsors"><span class="browse-label">Sponsors: </span>' + ad['sponsors'] + '</div></div></div>';
                    result_html+= '<div class="row"><div class=" col-sm-12"><div class="sponsors"><span class="browse-label">Sponsor Types: </span>' + ad['sponsor_types'] + '</div></div></div>';
                    if(ad['subjects'].length > 0) {
                        result_html += '<div class="row"><div class=" col-sm-12"><div class="sponsors"><span class="browse-label">Subjects: </span>' + ad['subjects'] + '</div></div></div>';
                    }
                    result_html+= '<div class="row"><div class=" col-sm-12"><div class="sponsors"><span class="browse-label">Air Count: </span>' + ad['air_count'] + '</div></div></div>';
                    result_html+= '</div></div>';
                    $search_results.append($(result_html));
            }
            searchPage +=1;
            activeSearch = false;
            if(data.length == perPage) {
                $("#load-more")
                    .text("Load More")
                    .show();
            }
            if(data.length == 0 && searchPage == 1) {
                $("#no-results")
                    .text("No Results")
                    .show();
            }
        });

        // Update URL to reflect the search

    }

    $('form').each(function() {
        $(this).find('input').keypress(function(e) {
            // Enter pressed?
            if(e.which == 10 || e.which == 13) {
                runSearch(true);
                return false;
            }
        });
    });

    $(function() {
        preparedAutoComplete($("#candidate-facet"), candidate_values);
        preparedAutoComplete($("#sponsor-facet"), sponsor_values);
        preparedAutoComplete($("#sponsor-type-facet"), sponsor_type_values);
        preparedAutoComplete($("#channel-facet"), channel_values);
        preparedAutoComplete($("#subject-facet"), subject_values);
        preparedAutoComplete($("#program-facet"), program_values);

        // AJAX search
        $("#search-submit").click(function() {
            runSearch(true);
            return false;
        });
        $("#advanced-search-form").submit(function() {
            runSearch(true);
            return false;
        });
        $("#search-form").submit(function() {
            runSearch(true);
            return false;
        });

        $("#load-more").click(function() {
            $("#load-more").hide();
            runSearch();
        })
    });

    function renderForm(type, skip_scroll) {
        var searchToggle = $("#search-toggle");
        if(type=="basic") {
            $("#basic-search").slideDown();
            $("#advanced-search").slideUp();
            searchToggle.html("Open Advanced Search &#x25BC;");
            if(!skip_scroll);
                $("html, body").animate({ scrollTop: 0 }, "slow");
        } else if(type=="advanced") {
            $("#advanced-search").slideDown();
            $("#basic-search").slideUp();
            searchToggle.html("Close Advanced Search &#x25B2;");
            if(!skip_scroll);
                $("html, body").animate({ scrollTop: 0 }, "slow");
        }
    }

    var isBasic = true;
    $(function() {
        var searchToggle = $("#browse-toggle-row");
        searchToggle.click(function() {
            if(isBasic) {
                // Basic is currently rendered
                renderForm("advanced");
                isBasic = false;
            } else {
                // Advanced is currently rendered
                renderForm("basic")
                isBasic = true;
            }
        });

        if(<?php echo($start_with_advanced?"true":"false"); ?>) {
            $(function() { renderForm("advanced", true); });
            isBasic = false;
        } else {
            $(function() { renderForm("basic", true); });
            isBasic = true;
        }

        if(<?php echo($run_search_on_load?"true":"false"); ?>) {
            $(function() { runSearch(true) });
        }
    });
</script>
<div id="browse-content" class="page-content">
    <div id="search-results">
    </div>
    <div id="load-more"></div>
    <div id="no-results"></div>
</div>
<?php get_footer(); ?>
