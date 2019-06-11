
<!DOCTYPE html>
<html>
    <head>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.6/proj4.js"></script>
		<script src="https://code.highcharts.com/maps/highmaps.js"></script>
		<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/maps/modules/offline-exporting.js"></script>
		<script src="https://code.highcharts.com/mapdata/countries/fr/fr-all.js"></script>
		
		<?php require_once 'navbar.php' ?>
        <title>Location</title>
    </head>
    <center><body>
		<center><h1 class="title is-1">Location</h1></center><br>
        
        <div id="container"></div>
        
       
        
        
        <script type='text/javascript'>
			
			
            /*function loadMapScenario() {
                var map = new Microsoft.Maps.Map(document.getElementById('myMap'), {});
                var center = map.getCenter();
				]; 	      
            }*/
            
            
// Initiate the chart
Highcharts.mapChart('container', {

    chart: {
        map: 'countries/fr/fr-all'
    },

    title: {
        text: 'Bins Locations'
    },

    mapNavigation: {
        enabled: true
    },

    tooltip: {
        headerFormat: '',
        pointFormat: '<b>{point.name}</b><br>Lat: {point.lat}, Lon: {point.lon}'
    },

    series: [{
        // Use the gb-all map with no data as a basemap
        name: 'Basemap',
        borderColor: '#A0A0A0',
        nullColor: 'rgba(200, 200, 200, 0.3)',
        showInLegend: false
    }, {
        name: 'Separators',
        type: 'mapline',
        nullColor: '#707070',
        showInLegend: false,
        enableMouseTracking: false
    }, {
        // Specify points using lat/lon
        type: 'mappoint',
        name: 'Bins locations',
        color: Highcharts.getOptions().colors[1],
        data: [{
            name: 'Amiens',
            lat: 50.000,
            lon: 2.000,
            dataLabels: {
                align: 'left',
                x: 5,
                verticalAlign: 'middle'
            }
        }]
    }]
});


        </script>
        <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?key=Ag-_6ORflNDPNlsCj6SnR203I1L3lqsC9vephb--jp49KLN_f01wx6CHaDhec0y8&callback=loadMapScenario' async defer></script>
   
					
    </body></center>
    <?php require_once 'footer.php' ?>
</html>

