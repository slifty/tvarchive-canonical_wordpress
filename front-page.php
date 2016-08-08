<?php get_header(); ?>
    <div id="home-header-section" class="row">
        <div id="home-header-content">
            <div id="home-header-introduction">
                <div id="home-header-title" class="col-sm-12 col-md-4">
                    <h1>Political ads broadcast <span class="total-airing-count">175,515 times</span> over <span class="total-market-count">23 markets</span></h1>
                </div>
                <div id="home-header-explanation" class="col-sm-12 col-md-8">
                    <?php the_field('home_description', 'option'); ?>
                </div>
            </div>
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


    <div  id="home-feature-section" class="row">
        <div  class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
            <?php get_template_part('content', 'home_blog_posts'); ?>
        </div>
        <div id="ad-embed_home" class="hidden-xs hidden-sm hidden-md col-lg-8">
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
                                name: 'Democrat',
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
                                name: 'Democrat',
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
                                name: 'Democrat',
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
                            $('#'+candidatesByRace[j].race).append('<div class="candidate-affiliation-group" id="'+candidatesByRace[j].race+candidatesByRace[j].affiliations[k].name+'"><h3>'+candidatesByRace[j].race+' '+candidatesByRace[j].affiliations[k].name+' Candidates</h3><ol class="explore-list main"></ol><div class="collapse" id="seeMoreCandidates'+candidatesByRace[j].race+candidatesByRace[j].affiliations[k].name+'"><ol class="explore-list extra"></ol></div>'+(candidatesByRace[j].affiliations[k].candidates.length > 4 ? '<button class="btn explore-show-more" role="button" data-toggle="collapse" data-target="#seeMoreCandidates'+candidatesByRace[j].race+candidatesByRace[j].affiliations[k].name+'" aria-expanded="false" aria-controls="seeMoreCandidates">Show / Hide '+(candidatesByRace[j].affiliations[k].candidates.length-4)+' More Candidates</button>':'')+'</div></div>');
                        }

                        for(var l=0;l<candidatesByRace[j].affiliations[k].candidates.length;l++){

                            if (l<4){
                                $('#'+candidatesByRace[j].race+candidatesByRace[j].affiliations[k].name+' .explore-list.main').append('<li class="explore-item item"><div class="explore-label"><p>'+candidatesByRace[j].affiliations[k].candidates[l].name+'</p><small><a href="<?php bloginfo('url'); ?>/browse/?q='+encodeURI(candidatesByRace[j].affiliations[k].candidates[l].name)+'">View Ads</a></small></div><div class="explore-bar-container"><div class="explore-bar" style="width:'+(((+candidatesByRace[j].affiliations[k].candidates[l].ad_count)/(+candidatesByRace[j].adCountMax))*100)+'%;"></div><div class="explore-count">'+candidatesByRace[j].affiliations[k].candidates[l].ad_count+' Ads</div></div></li>');
                            } else {
                                $('#'+candidatesByRace[j].race+candidatesByRace[j].affiliations[k].name+' .explore-list.extra').append('<li class="explore-item item"><div class="explore-label"><p>'+candidatesByRace[j].affiliations[k].candidates[l].name+'</p><small><a href="<?php bloginfo('url'); ?>/browse/?q='+encodeURI(candidatesByRace[j].affiliations[k].candidates[l].name)+'">View Ads</a></small></div><div class="explore-bar-container"><div class="explore-bar" style="width:'+(((+candidatesByRace[j].affiliations[k].candidates[l].ad_count)/(+candidatesByRace[j].adCountMax))*100)+'%;"></div><div class="explore-count">'+candidatesByRace[j].affiliations[k].candidates[l].ad_count+' Ads</div></div></li>');
                            }

                        }
                    }
                }

            });


            var sponsorsData=[];
            var sponsorsByType=[];

            $.get('<?php bloginfo('url'); ?>/api/v1/ad_sponsors/', function(data){
                sponsorsData = data;
            }).done(function(){
                console.log(sponsorsData);
            });

            for(var i=0;i<sponsorsData.length;i++){

            }


        });

    </script>
    <div id="home-explore-header" class="row header-row">
        <div class="col-xs-12 col-md-12">
            <h1>Explore the Collection</h1>
        </div>
    </div>
    <div id="home-explore-tabs" class="row explore-tab-row">
      <div class="col-xs-12 col-md-12">
        <ul class="nav nav-tabs" id="explore-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#candidates" aria-controls="candidates" role="tab" data-toggle="tab">By Candidate</a></li>
          <li role="presentation"><a href="#sponsors" aria-controls="sponsors" role="tab" data-toggle="tab">By Sponsor</a></li>
          <li role="presentation"><a href="#sponsorTypes" aria-controls="sponsorTypes" role="tab" data-toggle="tab">By Sponsor Type</a></li>
        </ul>
      </div>
    </div>
    <div id="home-explore-section" class="row">
      <div class="col-xs-12 col-md-12">
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="candidates">
            <?php get_template_part('content', 'explore_candidates'); ?>
          </div>
          <div role="tabpanel" class="tab-pane" id="sponsors">

          </div>
          <div role="tabpanel" class="tab-pane" id="sponsorTypes">

          </div>
        </div>
      </div>
    </div>
    <?php get_footer(); ?>
