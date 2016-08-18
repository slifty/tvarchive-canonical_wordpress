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

        $(document).ready(function(){

            var candidatesData=[];
            var candidatesByRace = [
                    {
                        race: 'Presidental',
                        adCountMax: 0,
                        affiliations: [
                            {
                                name: 'Democratic',
                                candidates: []
                            },{
                                name: 'Republican',
                                candidates: []
                            },{
                                name: 'Other',
                                candidates: []
                            }
                        ]
                    },
                    {
                        race: 'Senate',
                        adCountMax: 0,
                        affiliations: [
                            {
                                name: 'Democratic',
                                candidates: []
                            },{
                                name: 'Republican',
                                candidates: []
                            },{
                                name: 'Other',
                                candidates: []
                            }
                        ]
                    },
                    {
                        race: 'House',
                        adCountMax: 0,
                        affiliations: [
                            {
                                name: 'Democratic',
                                candidates: []
                            },{
                                name: 'Republican',
                                candidates: []
                            },{
                                name: 'Other',
                                candidates: []
                            }
                        ]
                    }
                ];

            $.get('<?php bloginfo('url'); ?>/api/v1/ad_candidates/', function(data){
                candidatesData = data;
            }).done(function(){

                for(var i=0;i<candidatesData.length;i++){

                    var affiliationIndex = 0;
                    var raceIndex = 0;

                    if (candidatesData[i].affiliation == 'D'){
                        affiliationIndex = 0;
                    } else if (candidatesData[i].affiliation == 'R') {
                        affiliationIndex = 1;
                    } else {
                        affiliationIndex = 2;
                    }

                    switch(candidatesData[i].race.indexOf('S')){
                        case 3:
                            raceIndex = 0;
                            break;
                        case 2:
                            raceIndex = 1;
                            break;
                        default:
                            raceIndex = 2;
                    }

                    if(+candidatesData[i].ad_count > +candidatesByRace[raceIndex].adCountMax){
                        candidatesByRace[raceIndex].adCountMax = +candidatesData[i].ad_count;
                        console.log(candidatesByRace[raceIndex].adCountMax);
                    }
                    candidatesByRace[raceIndex].affiliations[affiliationIndex].candidates.push(candidatesData[i]);

                }

                console.log(candidatesByRace);

                for(var j=0;j<candidatesByRace.length;j++){
                    $('#candidate-race-pills').append('<li role="presentation" '+(j==0 ? 'class="active"' : '')+'><a href="#'+candidatesByRace[j].race+'" aria-controls="'+candidatesByRace[j].race+'" role="tab" data-toggle="pill">'+candidatesByRace[j].race+'</a></li>');
                    $('#explore-candidates-tab-content').append('<div role="tabpanel" class="tab-pane '+(j==0 ? 'active' : '')+'" id="'+candidatesByRace[j].race+'"></div>');

                    for(var k=0;k<candidatesByRace[j].affiliations.length;k++){

                        if (candidatesByRace[j].affiliations[k].candidates.length > 0){
                            $('#'+candidatesByRace[j].race).append('<div class="candidate-affiliation-group" id="'+candidatesByRace[j].race+candidatesByRace[j].affiliations[k].name+'"><h3>'+candidatesByRace[j].affiliations[k].name+' '+candidatesByRace[j].race+' Candidates</h3><ol class="explore-list main"></ol><div class="collapse" id="seeMoreCandidates'+candidatesByRace[j].race+candidatesByRace[j].affiliations[k].name+'"><ol class="explore-list extra"></ol></div>'+(candidatesByRace[j].affiliations[k].candidates.length > 4 ? '<button class="btn explore-show-more" role="button" data-toggle="collapse" data-target="#seeMoreCandidates'+candidatesByRace[j].race+candidatesByRace[j].affiliations[k].name+'" aria-expanded="false" aria-controls="seeMoreCandidates">Show / Hide '+(candidatesByRace[j].affiliations[k].candidates.length-4)+' More Candidates</button>':'')+'</div></div>');
                        }

                        for(var l=0;l<candidatesByRace[j].affiliations[k].candidates.length;l++){

                            if (l<4){
                                $('#'+candidatesByRace[j].race+candidatesByRace[j].affiliations[k].name+' .explore-list.main').append('<li class="explore-item item"><div class="explore-label"><p>'+candidatesByRace[j].affiliations[k].candidates[l].name+'</p><small><a href="<?php bloginfo('url'); ?>/browse/?q='+encodeURI(candidatesByRace[j].affiliations[k].candidates[l].name)+'">View Ads</a></small></div><div class="explore-bar-container" data-count="'+candidatesByRace[j].affiliations[k].candidates[l].ad_count+' Ads"><div class="explore-bar" style="width:'+(((+candidatesByRace[j].affiliations[k].candidates[l].ad_count)/(+candidatesByRace[j].adCountMax))*100)+'%;"><div class="explore-count">'+candidatesByRace[j].affiliations[k].candidates[l].ad_count+' Ads</div></div></div></li>');
                            } else {
                                $('#'+candidatesByRace[j].race+candidatesByRace[j].affiliations[k].name+' .explore-list.extra').append('<li class="explore-item item"><div class="explore-label"><p>'+candidatesByRace[j].affiliations[k].candidates[l].name+'</p><small><a href="<?php bloginfo('url'); ?>/browse/?q='+encodeURI(candidatesByRace[j].affiliations[k].candidates[l].name)+'">View Ads</a></small></div><div class="explore-bar-container" data-count="'+candidatesByRace[j].affiliations[k].candidates[l].ad_count+' Ads"><div class="explore-bar" style="width:'+(((+candidatesByRace[j].affiliations[k].candidates[l].ad_count)/(+candidatesByRace[j].adCountMax))*100)+'%;"><div class="explore-count">'+candidatesByRace[j].affiliations[k].candidates[l].ad_count+' Ads</div></div></div></li>');
                            }

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
