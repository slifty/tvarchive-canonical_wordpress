<div class="row">
    <div class="market-map-container">
        <ul class="nav nav-pills" id="homepage-market-map-pills" role="tablist">
            <li role="presentation" class="active">
                <a href="#" aria-controls="All Ads" role="tab" data-toggle="pill">All Ads</a>
            </li>
            <li role="presentation">
                <a href="#" aria-controls="Ads before July 1" role="tab" data-toggle="pill">Ads before July 1</a>
            </li>
            <li role="presentation">
                <a href="#" aria-controls="Ads since July 1" role="tab" data-toggle="pill">Ads since July 1</a>
            </li>
        </ul>
        <div id="homepage-market-map"></div>
    </div>
</div>
<script type="text/javascript">

var marketData = [];
    var is_home = <?php echo(is_home()?"true":"false");?>;
    var bubblesData = [
        {
           radius: 39,
           num: '24,161',
           city: 'Boston',
           state: 'MA',
           fillKey: 'bubble',
           latitude: 42.4,
           longitude:-71,
           market: 'BOS'
         },
                  {
           radius: 38,
           num: '18,481',
           city: 'Des Moines',
           state: 'IA',
           fillKey: 'bubble',
           latitude: 41.7,
           longitude:-93.6,
           market: 'DSM'
         },
                  {
           city: 'Cedar Rapids',
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
           radius: 36,
           num: '12,352',
           city: 'Philadelphia',
           state: 'PA',
           fillKey: 'bubble',
           latitude: 40,
           longitude:-75.1,
           market: 'PHL'
         },
                  {
           radius: 36,
           num: '12,094',
           city: 'San Francisco',
           state: 'CA',
           fillKey: 'bubble',
           latitude: 37.8,
           longitude:-122.7,
           market: 'SF'
         },
                  {
           radius: 36,
           num: '11,520',
           city: 'Washington',
           state: 'DC',
           fillKey: 'bubble',
           latitude: 38.6,
           longitude:-77.3,
           market: 'VA'
         },
                  {
           radius: 36,
           num: '11,100',
           city: 'Columbia',
           state: 'SC',
           fillKey: 'bubble',
           latitude: 34,
           longitude:-81,
           market: 'CAE'
         },
                  {
           radius: 35,
           num: '8,838',
           city: 'Greenville',
           state: 'SC',
           fillKey: 'bubble',
           latitude: 34.8,
           longitude:-82.4,
           market: 'GSP'
         },
                  {
           radius: 34,
           num: '6,989',
           city: 'Las Vegas',
           state: 'NV',
           fillKey: 'bubble',
           latitude: 36.2,
           longitude:-115.1,
           market: 'LAS'
         },
                  {
           radius: 34,
           num: '6,068',
           city: 'Reno',
           state: 'NV',
           fillKey: 'bubble',
           latitude: 39.7,
           longitude:-119.7,
           market: 'RNO'
         },
                  {
           radius: 34,
           num: '6,011',
           city: 'Cleveland',
           state: 'OH',
           fillKey: 'bubble',
           latitude: 41.5,
           longitude:-81.6,
           market: 'CLE'
         },
                  {
           radius: 33,
           num: '5,064',
           city: 'Orlando',
           state: 'FL',
           fillKey: 'bubble',
           latitude: 28.5,
           longitude:-81.4,
           market: 'MCO'
         },
                  {
           radius: 33,
           num: '4,315',
           city: 'Tampa',
           state: 'FL',
           fillKey: 'bubble',
           latitude: 28,
           longitude:-82.6,
           market: 'TPA'
         },
                  {
           radius: 33,
           num: '4,221',
           city: 'Cincinnati',
           state: 'OH',
           fillKey: 'bubble',
           latitude: 39.2,
           longitude:-84.5,
           market: 'CVG'
         },
                  {
           radius: 31,
           num: '3,005',
           city: 'Denver',
           state: 'CO',
           fillKey: 'bubble',
           latitude: 39.7,
           longitude:-104.9,
           market: 'DEN'
         },
                  {
           radius: 31,
           num: '2,863',
           city: 'Raleigh',
           state: 'NC',
           fillKey: 'bubble',
           latitude: 35.8,
           longitude:-78.6,
           market: 'RDU'
         },
                  {
           radius: 31,
           num: '2,627',
           city: 'Charlotte',
           state: 'NC',
           fillKey: 'bubble',
           latitude: 35.3,
           longitude:-80.8,
           market: 'CLT'
         },
                  {
           radius: 31,
           num: '2,623',
           city: 'Miami',
           state: 'FL',
           fillKey: 'bubble',
           latitude: 25.8,
           longitude:-80.2,
           market: 'MIA'
         },
                  {
           radius: 30,
           num: '2,273',
           city: 'New York',
           state: 'NY',
           fillKey: 'bubble',
           latitude: 40.8,
           longitude:-74,
           market: 'NYC'
         },
                  {
           radius: 29,
           num: '1,535',
           city: 'Colorado Springs',
           state: 'CO',
           fillKey: 'bubble',
           latitude: 38.9,
           longitude:-104.9,
           market: 'COS'
         },
                  {
           radius: 29,
           num: '1,534',
           city: 'Norfolk',
           state: 'VA',
           fillKey: 'bubble',
           latitude: 36.9,
           longitude:-76.2,
           market: 'ORF'
         },
                  {
           radius: 27,
           num: '983',
           city: 'Roanoke',
           state: 'VA',
           fillKey: 'bubble',
           latitude: 37.3,
           longitude:-80,
           market: 'ROA'
         }
    ]

$.get('<?php bloginfo('url'); ?>/api/v1/market_counts/', function(data){
    marketData = data;
}).done(function(){

    var commas = d3.format(',d');

    var adCountTotal = d3.sum(marketData, function(d){return d.ad_count});
    var adCountMax = d3.max(marketData, function(d){return +d.ad_count});
    var adCountMin = d3.min(marketData, function(d){return +d.ad_count});

    var scale = d3.scale.linear();
    scale.domain([adCountMin, adCountMax]).range([15,40]);

    $('.total-airing-count').html(commas(adCountTotal)+' times');
    $('.total-market-count').html(commas(marketData.length)+' markets');

    var bubblesIndex;
    var marketDataIndex;

    for(var i=0;i<marketData.length;i++){
        for(var j=0;j<bubblesData.length;j++){
            if (marketData[i].market_code == bubblesData[j].market){
                bubblesData[j].num = commas(marketData[i].ad_count);
                bubblesData[j].radius = scale(marketData[i].ad_count);
            }
        }
    }


   var colors = d3.scale.category10();
   var map = new Datamap({
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

        datamap.bubbles(bubblesData, {
            popupTemplate: function(geo, data) {
                return '<div class="hoverinfo"><b>'+data.num+'</b> ads found in <b>'+data.city+', '+data.state+'</b> market'+'<br/><i><small>click for just this market</small</i>'+'</div>';
            }
        });

        $(datamap.svg[0][0]).on('click', '.bubbles', function(evt) {
            var market_code = $(evt.target).attr('data-market');
            window.location.hash = '#' + market_code;
            selectMarket(market_code);
        });
    }});

    var adData = [];
    var url = '<?php bloginfo('url'); ?>';
    var location = '';

    function selectMarket(market_code) {

        if(is_home) {
            window.location.href = '<?php bloginfo('url'); ?>/market-map/#' + market_code;
            return;
        }

        $('.bubbles .datamaps-bubble').each(function(){
            $(this).attr('data-state', 'default');
        });
        $('.bubbles .datamaps-bubble[data-market="'+market_code+'"]').attr('data-state', 'active');

        for (var j=0;j<bubblesData.length;j++){
            if (bubblesData[j].market == market_code){
                location = bubblesData[j].city+', '+bubblesData[j].state;
            }
        };

        $.get('<?php bloginfo('url'); ?>/api/v1/ads?market_filter='+market_code, function(data){
            adData = data;
        }).done(function(){

            if (market_code.length>0){
                $('span.market-location').html(location);
            } else {
                $('span.market-location').html('All Markets');
            }


            $('#most-aired-ads').empty();
            for (var i=0;i<adData.length;i++){
                $('#most-aired-ads').append('<div class="col-xs-12 col-md-6 col-lg-3"><div class="most-aired-ad-container"><div class="video-container"><iframe src="'+adData[i].embed_url+'" frameborder="0" webkitallowfullscreen="true" mozallowfullscreen="true" allowfullscreen=""></iframe></div><div class="details-container '+(adData[i].wp_identifier == 1396 ? 'expanded' : '')+'"><h3><a href="'+url+'/ad/'+adData[i].archive_id+'/"><span class="air-count">'+commas(adData[i].air_count)+'</span> Broadcasts</a></h3><p>Sponsor Type: <span class="sponsor-type">'+adData[i].sponsor_types+'<span></p><p>Candidates: <span class="candidates">'+adData[i].candidates+'</span></p><div class="reference-container">'+(adData[i].wp_identifier == 1396 ? '<p class="reference-citation">From Politifact:</p><p>Celery quandong swiss chard chicory earthnut pea potato. Salsify taro catsear garlic gram celery bitterleaf wattle seed collard greens nori. Grape wattle seed kombu beetroot horseradish carrot squash brussels sprout chard.</p></div><div class="read-more-cta"><a href="'+url+'/ad/'+adData[i].archive_id+'/">Read More About this Ad</a></div>' : '')+'</div></div></div></div>');
            }
        });
    };

    if(!is_home) {
        selectMarket(window.location.hash.substr(1));
    }

    $('.market-map-show-all').click(function(){
        selectMarket('');
    });
});
</script>
