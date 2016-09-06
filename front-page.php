<?php get_header(); ?>
    <div id="home-header-section" class="row guttered-row">
        <div id="home-header-content">
            <div id="home-header-introduction">
                <div class="col-md-12 col-lg-4">
                    <h1 id="home-header-title">Political ads broadcast <span class="total-airing-count">175,515 times</span> over <span class="total-market-count">23 markets</span></h1>
                </div>
                <div id="home-header-explanation" class="col-md-12 col-lg-8">
                    <?php the_field('home_description', 'option'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row guttered-row">
        <div class="col-xs-12">
            <hr />
        </div>
    </div>

    <div class="row">
        <div id="home-market-map-section">
            <div class="col-xs-12">
                <?php get_template_part('content', 'home_market_map'); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="home-header-search">
            <div class="col-xs-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 home-header-search-formfield">
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>


    <div id="home-feature-section" class="row guttered-row">
        <div class="col-xs-12 col-sm-12 col-md-4">
            <?php get_template_part('content', 'home_blog_posts'); ?>
        </div>
        <div id="ad-embed_home" class="col-md-8 col-sm-12">
            <?php get_template_part('content', 'home_canonical_ad'); ?>
        </div>
    </div>
    <script type="text/javascript">

        $(function(){

            var candidates_by_race = {
                'presidential': {
                    air_count_max: 1,
                    candidates: []
                },
                'senate': {
                    air_count_max: 1,
                    states: {}
                }
            }

            $.get('<?php bloginfo('url'); ?>/api/v1/ad_candidates/')
            .done(function(data){
                for(var x in data) {
                    var candidate = data[x];

                    // is this a presidential candidate?
                    if(candidate.race == "PRES") {
                        candidates_by_race.presidential.candidates.push(candidate);
                        candidates_by_race.presidential.air_count_max = Math.max(candidate.air_count, candidates_by_race.presidential.air_count_max);
                    }
                    else {
                        // The race code is of form XXS# or XX##
                        // where
                        // - XX is the state code
                        // - ## is the house seat
                        // - S# is a senate race
                        var state = candidate.race.substring(0,2);
                        var seat = candidate.race.substring(2,4);

                        // We aren't tracking house races
                        if(!/S\d/.test(seat))
                            continue;
                        if(!candidates_by_race.senate.states.hasOwnProperty(state)) {
                            candidates_by_race.senate.states[state] = [];
                        }
                        candidates_by_race.senate.states[state].push(candidate);
                        candidates_by_race.senate.air_count_max = Math.max(candidate.air_count, candidates_by_race.presidential.air_count_max);
                    }
                }

                // Render the presidential candidates section
                if(candidates_by_race.presidential.candidates.length > 0) {

                    // Sort the presidential candidates by air count
                    candidates_by_race.presidential.candidates.sort(function(a,b) { return parseInt(a.air_count)<parseInt(b.air_count)?1:-1 });

                    // Render the section holder
                    var html = '';
                    html += '<div class="candidate-affiliation-group" id="presidential-data">';
                    html += ' <h3>Presidential Candidates</h3>';
                    html += ' <ol class="explore-list main"></ol>';
                    html += ' <div class="collapse" id="seeMoreCandidatesPresidential">';
                    html += '  <ol class="explore-list extra"></ol>';
                    html += ' </div>';
                    if(candidates_by_race.presidential.candidates.length > 4) {
                        html += '<div>';
                        html += ' <button class="btn explore-show-more" role="button" data-toggle="collapse" data-target="#seeMoreCandidatesPresidential" aria-expanded="false" aria-controls="seeMoreCandidates">Show / Hide '+(candidates_by_race.presidential.candidates.length-4)+' More Candidates</button>';
                        html += '</div>';
                    }
                    html += '</div>';
                    $('#presidential').append(html);

                    // Render the actual bars
                    for(var x in candidates_by_race.presidential.candidates) {
                        var candidate = candidates_by_race.presidential.candidates[x];
                        var html = '';
                        html += '<li class="explore-item item">';
                        html += ' <div class="explore-label">';
                        html += '  <p>'+candidate.name+' ('+candidate.affiliation+')</p>';
                        html += '  <small><a href="<?php bloginfo('url'); ?>/browse/?candidate_filter='+encodeURI(candidate.name)+'">View Ads</a></small></div>';
                        html += '  <div class="explore-bar-container" data-count="'+candidate.air_count+' Airings">';
                        html += '   <div class="explore-bar affiliation-'+candidate.affiliation+'" style="width:'+(((+candidate.air_count)/(candidates_by_race.presidential.air_count_max))*100)+'%;">';
                        html += '    <div class="explore-count">'+candidate.air_count+' Airings</div>';
                        html += '   </div>';
                        html += '  </div>';
                        html += ' </div>';
                        html += '</li>';

                        if(x < 4) {
                            $('#presidential-data .explore-list.main').append(html);
                        } else {
                            $('#presidential-data .explore-list.extra').append(html);
                        }
                    }
                }

                // Render the presidential candidates section
                if(Object.keys(candidates_by_race.senate.states).length > 0) {

                    // Sort the states in alphabetical order
                    var state_keys = Object.keys(candidates_by_race.senate.states);
                    state_keys.sort();

                    for(var x in state_keys) {
                        var state = state_keys[x];
                        // Render each state as a section
                        // Render the section holder
                        var html = '';
                        html += '<div class="candidate-affiliation-group" id="senate-data-'+state+'">';
                        html += ' <h3>'+state+' Candidates</h3>';
                        html += ' <ol class="explore-list main"></ol>';
                        html += '</div>';
                        $('#senate').append(html);

                        // Render the actual bars
                        for(var x in candidates_by_race.senate.states[state]) {
                            var candidate = candidates_by_race.senate.states[state][x];
                            console.log(candidate);
                            var html = '';
                            html += '<li class="explore-item item">';
                            html += ' <div class="explore-label">';
                            html += '  <p>'+candidate.name+' ('+candidate.affiliation+')</p>';
                            html += '  <small><a href="<?php bloginfo('url'); ?>/browse/?candidate_filter='+encodeURI(candidate.name)+'">View Ads</a></small></div>';
                            html += '  <div class="explore-bar-container" data-count="'+candidate.air_count+' Airings">';
                            html += '   <div class="explore-bar affiliation-'+candidate.affiliation+'" style="width:'+(((+candidate.air_count)/(candidates_by_race.presidential.air_count_max))*100)+'%;">';
                            html += '    <div class="explore-count">'+candidate.air_count+' Airings</div>';
                            html += '   </div>';
                            html += '  </div>';
                            html += ' </div>';
                            html += '</li>';
                            $('#senate-data-'+state+' .explore-list.main').append(html);
                        }
                    }
                }
            });

            var sponsorsData=[];
            var sponsorsByType=[
                {
                    name: 'SuperPAC',
                    ad_count: 0
                }
            ];

            $.get('<?php bloginfo('url'); ?>/api/v1/ad_sponsors/', function(data){
                sponsorsData = data;
            }).done(function(){

                var sponsorAdCountMax = d3.max(sponsorsData, function(d){return +d.ad_count});
                $('#explore-sponsors-content').append('<ol class="explore-list main"></ol><div class="collapse" id="seeMoreSponsors"><ol class="explore-list extra"></ol></div>'+(sponsorsData.length > 4 ? '<button class="btn explore-show-more" role="button" data-toggle="collapse" data-target="#seeMoreSponsors" aria-expanded="false" aria-controls="seeMoreSponsors">Show / Hide '+(sponsorsData.length-4)+' More Sponsors</button>':''));

                for(var i=0;i<sponsorsData.length;i++){
                    if (i<4){
                        $('#explore-sponsors-content .explore-list.main').append('<li class="explore-item item"><div class="explore-label"><p>'+sponsorsData[i].name+'</p><small><a href="<?php bloginfo('url'); ?>/browse/?q='+encodeURI(sponsorsData[i].name)+'">View Ads</a></small></div><div class="explore-bar-container" data-count="'+sponsorsData[i].ad_count+' Ads"><div class="explore-bar" style="width:'+(((+sponsorsData[i].ad_count)/(+sponsorAdCountMax))*100)+'%;"><div class="explore-count">'+sponsorsData[i].ad_count+' Ads</div></div></div></li>');
                    } else {
                        $('#explore-sponsors-content .explore-list.extra').append('<li class="explore-item item"><div class="explore-label"><p>'+sponsorsData[i].name+'</p><small><a href="<?php bloginfo('url'); ?>/browse/?q='+encodeURI(sponsorsData[i].name)+'">View Ads</a></small></div><div class="explore-bar-container" data-count="'+sponsorsData[i].ad_count+' Ads"><div class="explore-bar" style="width:'+(((+sponsorsData[i].ad_count)/(+sponsorAdCountMax))*100)+'%;"><div class="explore-count">'+sponsorsData[i].ad_count+' Ads</div></div></div></li>');
                    }
                }

                var flags=[], sponsorsByType=[];

                for(var j=0;j<sponsorsData.length;j++){
                    if( flags[sponsorsData[j].type]) continue;
                    flags[sponsorsData[j].type] = true;
                    sponsorsByType.push({name: sponsorsData[j].type,ad_count:0});
                }

                for(var k=0;k<sponsorsData.length;k++){
                    for(var l=0;l<sponsorsByType.length;l++){
                        if(sponsorsData[k].type == sponsorsByType[l].name){
                            sponsorsByType[l].ad_count += +(sponsorsData[k].ad_count);
                        }
                    }

                }

                sponsorsByType.sort(function(a,b){
                    return d3.descending(a.ad_count, b.ad_count);
                });

                var sponsorTypeAdCountMax = d3.max(sponsorsByType, function(d){return +d.ad_count});

                $('#explore-sponsor_types-content').append('<ol class="explore-list main"></ol><div class="collapse" id="seeMoreSponsorTypes"><ol class="explore-list extra"></ol></div>'+(sponsorsByType.length > 4 ? '<button class="btn explore-show-more" role="button" data-toggle="collapse" data-target="#seeMoreSponsorTypes" aria-expanded="false" aria-controls="seeMoreSponsorTypes">Show / Hide '+(sponsorsByType.length-4)+' More Sponsor Types</button>':''));

                for(var i=0;i<sponsorsByType.length;i++){
                    if (i<4){
                        $('#explore-sponsor_types-content .explore-list.main').append('<li class="explore-item item"><div class="explore-label"><p>'+sponsorsByType[i].name+'</p><small><a href="<?php bloginfo('url'); ?>/browse/?q='+encodeURI(sponsorsByType[i].name)+'">View Ads</a></small></div><div class="explore-bar-container" data-count="'+sponsorsByType[i].ad_count+' Ads"><div class="explore-bar" style="width:'+(((+sponsorsByType[i].ad_count)/(+sponsorTypeAdCountMax))*100)+'%;"><div class="explore-count">'+sponsorsByType[i].ad_count+' Ads</div></div></div></li>');
                    } else {
                        $('#explore-sponsor_types-content .explore-list.extra').append('<li class="explore-item item"><div class="explore-label"><p>'+sponsorsByType[i].name+'</p><small><a href="<?php bloginfo('url'); ?>/browse/?q='+encodeURI(sponsorsByType[i].name)+'">View Ads</a></small></div><div class="explore-bar-container" data-count="'+sponsorsByType[i].ad_count+' Ads"><div class="explore-bar" style="width:'+(((+sponsorsByType[i].ad_count)/(+sponsorTypeAdCountMax))*100)+'%;"><div class="explore-count">'+sponsorsByType[i].ad_count+' Ads</div></div></div></li>');
                    }
                }
            });
        });

    </script>
    <div id="home-explore-header" class="row guttered-row">
        <div class="col-xs-12 col-md-12">
            <h2 class="section-header">Explore the Collection</h2>
        </div>
    </div>
    <div id="home-explore-tabs" class="row explore-tab-row">
      <div class="col-xs-12 col-md-12">
        <ul class="nav nav-tabs" id="explore-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#candidates" aria-controls="candidates" role="tab" data-toggle="tab"><span class="hidden-md hidden-sm hidden-xs">By </span>Candidate<span class="hidden-lg">s</span></a></li>
          <li role="presentation"><a href="#sponsors" aria-controls="sponsors" role="tab" data-toggle="tab"><span class="hidden-md hidden-sm hidden-xs">By </span>Sponsor<span class="hidden-lg">s</span></a></li>
          <li role="presentation"><a href="#sponsor-types" aria-controls="sponsor-types" role="tab" data-toggle="tab"><span class="hidden-md hidden-sm hidden-xs">By </span>Sponsor Type<span class="hidden-lg">s</span></a></li>
        </ul>
      </div>
    </div>
    <div id="home-explore-section" class="row guttered-row">
      <div class="col-xs-12 col-md-12">
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="candidates">
            <?php get_template_part('content', 'explore_candidates'); ?>
          </div>
          <div role="tabpanel" class="tab-pane" id="sponsors">
            <?php get_template_part('content', 'explore_sponsors'); ?>
          </div>
          <div role="tabpanel" class="tab-pane" id="sponsor-types">
            <?php get_template_part('content', 'explore_sponsor_types'); ?>
          </div>
        </div>
      </div>
    </div>
    <div id="home-explore-facts-section" class="row guttered-row">
      <div class="col-xs-12 col-md-12">
        <?php get_template_part('content', 'explore_factchecks'); ?>
      </div>
    </div>
    <?php get_footer(); ?>
