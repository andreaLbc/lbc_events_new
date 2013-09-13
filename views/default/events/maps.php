<?php
	elgg_load_js('elgg:gmaps');
	$zoom = $vars['zoom'];
	$location = $vars['location'];
	if(!isset($zoom)){
		$zoom = GMAP_DEFAULT_ZOOM;
	} 
	if(!isset($location)){
		$location = GMAP_DEFAULT_LOCATION;
	}  
?>
<div id="map_canvas" style="overflow:hidden; width:100%; height:250px; margin-top:10px"></div>
<script type='text/javascript'>
	// Delayed load is required, or elgg page continually reloads
    $(document).ready(function () { initialize();  });
	var geocoder = new google.maps.Geocoder();
    function getAddress(address, callback) {
		geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				callback(results[0].geometry.location);
			} 
		});
	}	
	function initialize() {
		getAddress("<?php echo $location;?>", function(defaultLocation) {
			var map = new google.maps.Map(document.getElementById("map_canvas"),{ 
					center: defaultLocation,
					zoom: <?php echo $zoom;?>, 
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					});
			var markerOptions = {
					map:map, 
					position:defaultLocation,
			};
			var marker = new google.maps.Marker(markerOptions);
		});
	};
</script>