<div class="row">
    <div class="market-map-container">
        <ul class="nav nav-pills" id="homepage-market-map-pills" role="tablist">
            <li id="market-all-pill" role="presentation" class="active">
                <a href="#" aria-controls="All Ads" role="tab" data-toggle="pill">All Ads</a>
            </li>
            <li id="market-before-pill" role="presentation">
                <a href="#" aria-controls="Ads before July 1" role="tab" data-toggle="pill">Ads before July 1</a>
            </li>
            <li id="market-after-pill" role="presentation">
                <a href="#" aria-controls="Ads since July 1" role="tab" data-toggle="pill">Ads since July 1</a>
            </li>
        </ul>
        <div id="homepage-market-map"></div>
    </div>
</div>
<script type="text/javascript">

    var marketData = [];
    var is_home = <?php echo(is_home()?"true":"false");?>;
    var market = '';
    var current_page = 0;
    var commas = d3.format(',d');
    var bubblesData = [
        {
           city: 'Boston, MA /Manchester',
           state: 'NH',
           fillKey: 'bubble',
           latitude: 42.4,
           longitude:-71,
           market: 'BOS'
        },
        {
           city: 'Des Moines-Ames',
           state: 'IA',
           fillKey: 'bubble',
           latitude: 41.7,
           longitude:-93.6,
           market: 'DSM'
        },
        {
           city: 'Ceder Rapids-Waterloo-Iowa City-Dublin',
           state: 'IA',
           fillKey: 'bubble',
           latitude: 42,
           longitude:-91.7,
           market: 'CID'
         },
         {
           city: 'Sioux City',
           state: 'IA',
           fillKey: 'bubble',
           latitude: 42.5,
           longitude:-96.4,
           market: 'SUX'
         },
         {
           city: 'Philadelphia',
           state: 'PA',
           fillKey: 'bubble',
           latitude: 40,
           longitude:-75.1,
           market: 'PHL'
         },
         {
           city: 'San Francisco-Oakland-San Jose',
           state: 'CA',
           fillKey: 'bubble',
           latitude: 37.8,
           longitude:-122.7,
           market: 'SF'
         },
         {
           city: 'Washington, DC/Hagerstown',
           state: 'DC',
           fillKey: 'bubble',
           latitude: 38.6,
           longitude:-77.3,
           market: 'VA'
         },
         {
           city: 'Columbia',
           state: 'SC',
           fillKey: 'bubble',
           latitude: 34,
           longitude:-81,
           market: 'CAE'
         },
         {
           city: 'Greenville-Spartanburg, SC / Asheville-Anderson',
           state: 'NC',
           fillKey: 'bubble',
           latitude: 34.8,
           longitude:-82.4,
           market: 'GSP'
         },
         {
           city: 'Las Vegas',
           state: 'NV',
           fillKey: 'bubble',
           latitude: 36.2,
           longitude:-115.1,
           market: 'LAS'
         },
         {
           city: 'Reno',
           state: 'NV',
           fillKey: 'bubble',
           latitude: 39.7,
           longitude:-119.7,
           market: 'RNO'
         },
         {
           city: 'Cleveland',
           state: 'OH',
           fillKey: 'bubble',
           latitude: 41.5,
           longitude:-81.6,
           market: 'CLE'
         },
         {
           city: 'Orlando-Daytona Beach-Melbourne',
           state: 'FL',
           fillKey: 'bubble',
           latitude: 28.5,
           longitude:-81.4,
           market: 'MCO'
         },
         {
           city: 'Tampa-St. Petersburg',
           state: 'FL',
           fillKey: 'bubble',
           latitude: 28,
           longitude:-82.6,
           market: 'TPA'
         },
         {
           city: 'Cincinnati',
           state: 'OH',
           fillKey: 'bubble',
           latitude: 39.2,
           longitude:-84.5,
           market: 'CVG'
         },
         {
           city: 'Denver',
           state: 'CO',
           fillKey: 'bubble',
           latitude: 39.7,
           longitude:-104.9,
           market: 'DEN'
         },
         {
           city: 'Raleigh-Durham-Fayetteville',
           state: 'NC',
           fillKey: 'bubble',
           latitude: 35.8,
           longitude:-78.6,
           market: 'RDU'
         },
         {
           city: 'Charlotte',
           state: 'NC',
           fillKey: 'bubble',
           latitude: 35.3,
           longitude:-80.8,
           market: 'CLT'
         },
         {
           city: 'Miami-Fort Lauderdale',
           state: 'FL',
           fillKey: 'bubble',
           latitude: 25.8,
           longitude:-80.2,
           market: 'MIA'
         },
         {
           city: 'New York City',
           state: 'NY',
           fillKey: 'bubble',
           latitude: 40.8,
           longitude:-74,
           market: 'NYC'
         },
         {
           city: 'Colorado Springs-Pueblo',
           state: 'CO',
           fillKey: 'bubble',
           latitude: 38.9,
           longitude:-104.9,
           market: 'COS'
         },
         {
           city: 'Norfolk-Portsmouth-Newport News',
           state: 'VA',
           fillKey: 'bubble',
           latitude: 36.9,
           longitude:-76.2,
           market: 'ORF'
         },
         {
           city: 'Milwaukee',
           state: 'WI',
           fillKey: 'bubble',
           latitude: 43.04,
           longitude: -87.91,
           market: 'MKE'
         },
         {
           city: 'Phoenix-Prescott',
           state: 'AZ',
           fillKey: 'bubble',
           latitude: 33.44,
           longitude: -112.07,
           market: 'PHX'
         }
    ];

    var current_start_time = null;
    var current_end_time = null;
    var current_market = null;
    function renderGraph(start_time, end_time) {
        current_start_time = start_time;
        current_end_time = end_time;

        // Step 1: Load the data
        var conditions = [];
        if(start_time)
            conditions.push("start_time=" + start_time);
        if(end_time)
            conditions.push("end_time=" + end_time);
        var url = '<?php bloginfo('url'); ?>/api/v1/market_counts'+(conditions.length>0?'?'+conditions.join('&'):'');
        $.get(url, function(data){
            marketData = data.data;
        }).done(function(){
            // Step 2: Calculate values
            var adCountTotal = d3.sum(marketData, function(d){return d.ad_count}) | 0;
            var adCountMax = d3.max(marketData, function(d){return +d.ad_count}) | 0;
            var adCountMin = d3.min(marketData, function(d){return +d.ad_count}) | 0;
            var scale = d3.scale.linear();
            scale.domain([0, adCountMax]).range([5,40]);

            $('.total-airing-count').html(commas(adCountTotal)+' times');
            $('.total-market-count').html(commas(marketData.length)+' markets');

            var bubblesIndex;
            var marketDataIndex;

            // Clear out the bubble data
            for(var j=0;j<bubblesData.length;j++) {
                bubblesData[j].num = 0;
                bubblesData[j].radius = scale(0);
            }

            for(var i=0;i<marketData.length;i++){
                for(var j=0;j<bubblesData.length;j++) {
                    if (marketData[i].market_code == bubblesData[j].market){
                        bubblesData[j].num = commas(marketData[i].ad_count);
                        bubblesData[j].radius = scale(marketData[i].ad_count);
                    }
                }
            }

            // Remove any bubbles

            var colors = d3.scale.category10();
            $("#homepage-market-map").empty();
            var map = new Datamap(
            {
                element: document.getElementById('homepage-market-map'),
                scope:'usa',
                responsive:true,
                geographyConfig: {
                    popupOnHover: false,
                    highlightOnHover: false
                },
                bubblesConfig: {
                    borderWidth: 1,
                    highlightOnHover: true,
                    highlightFillColor: '#e85646',
                    highlightFillOpacity: 1,
                    highlightBorderColor: '#ffffff',
                    highlightBorderWidth: 1,
                    highlightBorderOpacity: 1
                },
                fills: {
                    defaultFill: '#d8d8d8',
                    bubble: '#0094AF'
                },
                done: function(datamap){

                    $(window).on('resize  orientationchange', function(){
                       datamap.resize();
                    });

                    // Filter out bubbles with no airings
                    var finalData = [];
                    for(var x in bubblesData) {
                        if(bubblesData[x].num != 0)
                            finalData.push(bubblesData[x]);
                    }

                    datamap.bubbles(finalData, {
                        popupTemplate: function(geo, data) {
                            return '<div class="hoverinfo"><b>'+data.num+'</b> ads found in <b>'+data.city+', '+data.state+'</b> market'+'<br/><i><small>click for just this market</small</i>'+'</div>';
                        }
                    });

                    $(datamap.svg[0][0]).on('click', '.bubbles', function(evt) {
                        var market_code = $(evt.target).attr('data-market');
                        window.location.hash = '#' + market_code;
                        selectMarket(market_code);
                    });

                    if(!is_home){
                        $('.bubbles .datamaps-bubble[data-market="'+window.location.hash.substr(1)+'"]').attr('data-state', 'active');
                    }
                }
            });
        });
    }

    function selectMarket(market_code) {
        current_market = market_code;

        if(is_home) {
            if(market_code == null)
                return;
            window.location.href = '<?php bloginfo('url'); ?>/market-map/#' + market_code;
            return;
        }

        if(market_code == "") {
            $("#market-map-show-all").hide();
        } else {
            $("#market-map-show-all").show();
        }

        $('.bubbles .datamaps-bubble').each(function(){
            $(this).attr('data-state', 'default');
        });

        $('.bubbles .datamaps-bubble[data-market="'+market_code+'"]').attr('data-state', 'active');

        for (var j=0;j<bubblesData.length;j++){
            if (bubblesData[j].market == market_code){
                market = bubblesData[j].city+', '+bubblesData[j].state;
            }
        };

        if(market_code.length>0){
            $('span.market-location').html(market);
        } else {
            $('span.market-location').html('All Markets');
        }

        current_page = 0;
        $('#most-aired-ads').empty();
        renderAds(current_page, market_code);
        current_page++;
    };

    function renderAds(page, market_code) {
        var per_page = 50;
        var url = '<?php bloginfo('url'); ?>/api/v1/ads?sort=air_count&market_filter='+market_code;

        if(current_start_time)
            url += "&start_time=" + current_start_time;
        if(current_end_time)
            url += "&end_time=" + current_end_time;
        url += "&page=" + page;
        url += "&per_page=" + per_page;

        $.get(url, function(data){
            var adData = data.data;
            var total_results = data.total_results;

            if(total_results == 0) {
                $("#no-ads").show();
            } else {
                $("#no-ads").hide();
                for (i = 0; i < adData.length; i++ ) {
                var html = '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">';
                    html+= '<div class="most-aired-ad-container">';
                    html+= '<div class="video-container">';
                    html+= '<a href="<?php bloginfo('url'); ?>/ad/'+adData[i].archive_id+'/"><img src="https://archive.org/serve/'+adData[i].archive_id+'/format=Thumbnail" /></a>';
                    html+= '</div>';
                    html+= '<div class="details-container '+(adData[i].wp_identifier == 1396 ? 'expanded' : '')+'">';
                    html+= '<h3><a href="<?php bloginfo('url'); ?>/ad/'+adData[i].archive_id+'/"><span class="air-count">'+commas(adData[i].air_count)+'</span> Broadcasts</a></h3>';
                    html+= '<p>Sponsor Type: <span class="sponsor-type">'+adData[i].sponsor_types+'<span></p>';
                    html+= '<p>Candidates: <span class="candidates">'+adData[i].candidates+'</span></p>';
                    html+= '<div class="reference-container">';
                    html+= (adData[i].wp_identifier == 1396 ? '<p class="reference-citation">From Politifact:</p><p>Celery quandong swiss chard chicory earthnut pea potato. Salsify taro catsear garlic gram celery bitterleaf wattle seed collard greens nori. Grape wattle seed kombu beetroot horseradish carrot squash brussels sprout chard.</p></div><div class="read-more-cta"><a href="'+url+'/ad/'+adData[i].archive_id+'/">Read More About this Ad</a></div>' : '');
                    html+= '</div></div></div></div>';
                    $('#most-aired-ads').append(html);
                }
                if((page + 1) * per_page < total_results) {
                    $("#load-more").show();
                }
            }
        })
    }

    $(function() {
        if(!is_home) {
            selectMarket(window.location.hash.substr(1));
        }

        $('#market-map-show-all').click(function(){
            selectMarket('');
        });

        $('#load-more').hide();
        $('#load-more').click(function () {
            $('#load-more').hide();
            renderAds(current_page, current_market);
            current_page++;
        });

        $('#market-all-pill').click(function() { renderGraph(null,null); selectMarket(current_market); });
        $('#market-after-pill').click(function() { renderGraph('7/1/2016 00:00:00', null); selectMarket(current_market); });
        $('#market-before-pill').click(function() { renderGraph(null, '6/30/2016 23:23:59'); selectMarket(current_market); });
        renderGraph(null, null);
    });
</script>
