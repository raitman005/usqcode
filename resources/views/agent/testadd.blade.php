<!DOCTYPE html>
<head><title>Convert Address to Coordinates</title></head>
<body>
<div><input type="text" onfocusout="search()" id="address" /><span class="btn" onclick="search()">Search</span></div>
<div id="coordinates">
	Latitude : <span id="latitude"></span><br />
	Longitude : <span id="longitude"></span>
</div>
<script type="text/javascript" src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/geocoder.js') }}"></script>
<script type="text/javascript">
function search(){
	// var geocoder = new google.maps.Geocoder();
	var street = $('#address').val();
	var address = street +", New York";
	var bingGeocoder = new GeocoderJS.createGeocoder({provider: 'bing', apiKey: 'As11PsBXYvAoGEXmz59ZWl93T8_OACdXi2QnRKWMRIUK6hzOXgN3BcZHnbKyPZYo'});
      bingGeocoder.geocode(address, function(result) {
      	var firstres = result[0];
     var js = JSON.parse(JSON.stringify(firstres));
     document.getElementById('latitude').innerHTML = js.latitude;
     document.getElementById('longitude').innerHTML = js.longitude;
      });
}
</script>
</body>
</html>
