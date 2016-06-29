<div class="row">
    <div class="market-map-container">
        <div id="homepage-market-map"></div>
    </div>
</div>
<script type="text/javascript">

 $(function(){
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

       datamap.bubbles([
                  {
           radius: 39,
           num: '24,161',
           city: 'Boston',
           state: 'MA',
           fillKey: 'bubble',
           latitude: 42.4,
           longitude:-71,
         },
                  {
           radius: 38,
           num: '18,481',
           city: 'Des Moines',
           state: 'IA',
           fillKey: 'bubble',
           latitude: 41.7,
           longitude:-93.6,
         },
                  {
           radius: 38,
           num: '18,329',
           city: 'Cedar Rapids',
           state: 'IA',
           fillKey: 'bubble',
           latitude: 42,
           longitude:-91.7,
         },
                  {
           radius: 37,
           num: '14,188',
           city: 'Sioux City',
           state: 'IA',
           fillKey: 'bubble',
           latitude: 42.5,
           longitude:-96.4,
         },
                  {
           radius: 36,
           num: '12,352',
           city: 'Philadelphia',
           state: 'PA',
           fillKey: 'bubble',
           latitude: 40,
           longitude:-75.1,
         },
                  {
           radius: 36,
           num: '12,094',
           city: 'San Francisco',
           state: 'CA',
           fillKey: 'bubble',
           latitude: 37.8,
           longitude:-122.7,
         },
                  {
           radius: 36,
           num: '11,520',
           city: 'Woodbridge',
           state: 'VA',
           fillKey: 'bubble',
           latitude: 38.6,
           longitude:-77.3,
         },
                  {
           radius: 36,
           num: '11,100',
           city: 'Columbia',
           state: 'SC',
           fillKey: 'bubble',
           latitude: 34,
           longitude:-81,
         },
                  {
           radius: 35,
           num: '8,838',
           city: 'Greenville',
           state: 'SC',
           fillKey: 'bubble',
           latitude: 34.8,
           longitude:-82.4,
         },
                  {
           radius: 34,
           num: '6,989',
           city: 'Las Vegas',
           state: 'NV',
           fillKey: 'bubble',
           latitude: 36.2,
           longitude:-115.1,
         },
                  {
           radius: 34,
           num: '6,068',
           city: 'Reno',
           state: 'NV',
           fillKey: 'bubble',
           latitude: 39.7,
           longitude:-119.7,
         },
                  {
           radius: 34,
           num: '6,011',
           city: 'Cleveland',
           state: 'OH',
           fillKey: 'bubble',
           latitude: 41.5,
           longitude:-81.6,
         },
                  {
           radius: 33,
           num: '5,064',
           city: 'Orlando',
           state: 'FL',
           fillKey: 'bubble',
           latitude: 28.5,
           longitude:-81.4,
         },
                  {
           radius: 33,
           num: '4,315',
           city: 'Tampa',
           state: 'FL',
           fillKey: 'bubble',
           latitude: 28,
           longitude:-82.6,
         },
                  {
           radius: 33,
           num: '4,221',
           city: 'Cincinnati',
           state: 'OH',
           fillKey: 'bubble',
           latitude: 39.2,
           longitude:-84.5,
         },
                  {
           radius: 31,
           num: '3,005',
           city: 'Denver',
           state: 'CO',
           fillKey: 'bubble',
           latitude: 39.7,
           longitude:-104.9,
         },
                  {
           radius: 31,
           num: '2,863',
           city: 'Raleigh',
           state: 'NC',
           fillKey: 'bubble',
           latitude: 35.8,
           longitude:-78.6,
         },
                  {
           radius: 31,
           num: '2,627',
           city: 'Charlotte',
           state: 'NC',
           fillKey: 'bubble',
           latitude: 35.3,
           longitude:-80.8,
         },
                  {
           radius: 31,
           num: '2,623',
           city: 'Miami',
           state: 'FL',
           fillKey: 'bubble',
           latitude: 25.8,
           longitude:-80.2,
         },
                  {
           radius: 30,
           num: '2,273',
           city: 'New York',
           state: 'NY',
           fillKey: 'bubble',
           latitude: 40.8,
           longitude:-74,
         },
                  {
           radius: 29,
           num: '1,535',
           city: 'Colorado Springs',
           state: 'CO',
           fillKey: 'bubble',
           latitude: 38.9,
           longitude:-104.9,
         },
                  {
           radius: 29,
           num: '1,534',
           city: 'Norfolk',
           state: 'VA',
           fillKey: 'bubble',
           latitude: 36.9,
           longitude:-76.2,
         },
                  {
           radius: 27,
           num: '983',
           city: 'Roanoke',
           state: 'VA',
           fillKey: 'bubble',
           latitude: 37.3,
           longitude:-80,
         },
                  {}], {
         popupTemplate: function(geo, data) {
           return '<div class="hoverinfo"><b>'+data.num+'</b> ads found in <b>'+data.city+'</b>, '+data.state+' market'+
                      '<br/><i><small>click for just this market</small</i>'+
                      '</div>';
         }
       });
              $(datamap.svg[0][0]).on('click', '.bubbles', function(evt) {
         var TVC = JSON.parse($(evt.target).attr('data-info')).fillKey;
         location.href = location.href + '&TVC=' + TVC;
       });
                   }})});
</script>
