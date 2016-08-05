<script type="text/javascript">
    var adData = [];
    var commas = d3.format(',d');
    var hash = location.hash;

    $.get('<?php bloginfo('url'); ?>/api/v1/ads?market_filter='+hash, function(data){
        adData = data;
    }).done(function(){
        console.log(adData);
        for (var i=0;i<adData.length;i++){
            $('#most-aired-ads').append('<div class="col-xs-12 col-md-6 col-lg-3"><div class="video-container"><iframe src="'+adData[i].embed_url+'" frameborder="0" webkitallowfullscreen="true" mozallowfullscreen="true" allowfullscreen=""></iframe></div><div class="details-container '+(adData[i].reference_count ? 'expanded' : '')+'"><h3><span class="air-count">'+commas(adData[i].air_count)+'</span> Broadcasts</h3><p>Sponsor Type: <span class="sponsor-type">'+adData[i].sponsor_types+'<span></p><p>Candidates: <span class="candidates">'+adData[i].candidates+'</span></p><div class="reference-container">'+(adData[i].reference_count ? '<p class="reference-citation">From Politifact:</p><p>Celery quandong swiss chard chicory earthnut pea potato. Salsify taro catsear garlic gram celery bitterleaf wattle seed collard greens nori. Grape wattle seed kombu beetroot horseradish carrot squash brussels sprout chard.</p></div><div class="read-more-cta"><a href="#">Read More About this Ad</a></div>' : '')+'</div></div></div>');
        }
    });
</script>
<div id="most-aired-ads-subheader" class="row header-row">
    <div class="col-sm-12">
        <h1>Most Aired Ads Found in <span class="market-location">All Markets</span></h1>
    </div>
</div>
<div id="most-aired-ads" class="row">
    <!-- <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="most-aired-ad-container">
            <div class="video-container">
                <iframe src="https://archive.org/embed/PolitAdArchiveVideo" frameborder="0" webkitallowfullscreen="true" mozallowfullscreen="true" allowfullscreen=""></iframe>
            </div>
            <div class="details-container expanded">
                <h3><span class="air-count">3,583</span> Broadcasts</h3>
                <p>Sponsor Type: <span class="sponsor-type">Super PAC<span></p>
                <p>Candidates: <span class="candidates">Hillary Clinton</span></p>
                <div class="reference-container">
                    <p class="reference-citation">From Politifact:</p>
                    <p>Celery quandong swiss chard chicory earthnut pea potato. Salsify taro catsear garlic gram celery bitterleaf wattle seed collard greens nori. Grape wattle seed kombu beetroot horseradish carrot squash brussels sprout chard.</p>
                </div>
                <div class="read-more-cta">
                    <a href="#">
                        Read More About this Ad
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="most-aired-ad-container">
            <div class="video-container">
                <iframe src="https://archive.org/embed/PolitAdArchiveVideo" frameborder="0" webkitallowfullscreen="true" mozallowfullscreen="true" allowfullscreen=""></iframe>
            </div>
            <div class="details-container">
                <h3><span class="air-count">3,583</span> Broadcasts</h3>
                <p>Sponsor Type: <span class="sponsor-type">Super PAC<span></p>
                <p>Candidates: <span class="candidates">Hillary Clinton</span></p>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="most-aired-ad-container">
            <div class="video-container">
                <iframe src="https://archive.org/embed/PolitAdArchiveVideo" frameborder="0" webkitallowfullscreen="true" mozallowfullscreen="true" allowfullscreen=""></iframe>
            </div>
            <div class="details-container">
                <h3><span class="air-count">3,583</span> Broadcasts</h3>
                <p>Sponsor Type: <span class="sponsor-type">Super PAC<span></p>
                <p>Candidates: <span class="candidates">Hillary Clinton</span></p>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="most-aired-ad-container">
            <div class="video-container">
                <iframe src="https://archive.org/embed/PolitAdArchiveVideo" frameborder="0" webkitallowfullscreen="true" mozallowfullscreen="true" allowfullscreen=""></iframe>
            </div>
            <div class="details-container">
                <h3><span class="air-count">3,583</span> Broadcasts</h3>
                <p>Sponsor Type: <span class="sponsor-type">Super PAC<span></p>
                <p>Candidates: <span class="candidates">Hillary Clinton</span></p>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="most-aired-ad-container">
            <div class="video-container">
                <iframe src="https://archive.org/embed/PolitAdArchiveVideo" frameborder="0" webkitallowfullscreen="true" mozallowfullscreen="true" allowfullscreen=""></iframe>
            </div>
            <div class="details-container">
                <h3><span class="air-count">3,583</span> Broadcasts</h3>
                <p>Sponsor Type: <span class="sponsor-type">Super PAC<span></p>
                <p>Candidates: <span class="candidates">Hillary Clinton</span></p>
            </div>
        </div>
    </div> -->
</div>
