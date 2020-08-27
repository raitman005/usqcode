$(function() {
    var osmUrl = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
    osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    osm = L.tileLayer(osmUrl, {
      maxZoom: 20,
      attribution: osmAttrib
    });

    if (latitude && longitude) {
        map = L.map('map').setView([latitude, longitude], 12).addLayer(osm);
    } else {
        map = L.map('map').setView([40.758896, -73.985130], 12).addLayer(osm);
    }

    map.on('click', addMarker);
    $('#address').on("focusout", addSearch);
    layerGroup = L.layerGroup().addTo(map);

    if (latitude && longitude) {
        layerGroup.clearLayers();
        new L.marker([latitude, longitude]).addTo(layerGroup);
    }

    function addMarker(e){
        // Add marker to map at click location; add popup window
        $('#map-latitude').val(e.latlng.lat);
        $('#map-longitude').val(e.latlng.lng);
        
        layerGroup.clearLayers();
        var newMarker = new L.marker(e.latlng).addTo(layerGroup);
    }

    function addSearch(){
        // var geocoder = new google.maps.Geocoder();
        var street = $('#address').val();
        var address = street +", New York";
        var bingGeocoder = new GeocoderJS.createGeocoder({provider: 'bing', apiKey: 'As11PsBXYvAoGEXmz59ZWl93T8_OACdXi2QnRKWMRIUK6hzOXgN3BcZHnbKyPZYo'});
          bingGeocoder.geocode(address, function(result) {
            var firstres = result[0];
         var js = JSON.parse(JSON.stringify(firstres));
         $('#map-latitude').val(js.latitude);
         $('#map-longitude').val(js.longitude);
         console.log(js.latitude+":"+js.longitude);
         layerGroup.clearLayers();
         var newMarker = new L.marker([js.latitude, js.longitude]).addTo(layerGroup);
         // document.getElementById('latitude').innerHTML = js.latitude;
         // document.getElementById('longitude').innerHTML = js.longitude;
          });
    }


    $('#collapse-map').on('shown.bs.collapse', function (e) {
        map.invalidateSize(true);
    })
});