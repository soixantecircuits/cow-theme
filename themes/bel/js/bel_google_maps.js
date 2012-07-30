var map;
var currentInfoWindow = null;
var greenMarker = new google.maps.MarkerImage

function maps_add_marker(lat, lng, title, link, excerpt, type) {
	var titlelink = "<a href='" + link + "'>" + title + "</a>" + "<br />" + excerpt;
	var marker = new google.maps.Marker({
		position: new google.maps.LatLng(lat, lng),
		map: window.map
	});
	if (type == 'dropdown_num_3')
		marker.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png') 

	var infoWindow = new google.maps.InfoWindow({
		content: titlelink
	});
	
	google.maps.event.addListener(marker, 'click', function() {
		if (window.currentInfoWindow !== null)
			window.currentInfoWindow.close();
		infoWindow.open(window.map, marker);

		window.currentInfoWindow = infoWindow;
	});

	google.maps.event.addListener(map, 'click', function() {
		if (window.currentInfoWindow !== null)
		{
			window.currentInfoWindow.close();
			window.currentInfoWindow = null;
		}
	});

}

function maps_initialize() {
	var myOptions = {
		center: new google.maps.LatLng(36.879621,-10.400394),
		zoom: 2,
		mapTypeId: google.maps.MapTypeId.HYBRID
	};
	window.map = new google.maps.Map(document.getElementById("map_canvas"),
		myOptions);

	for (var i = 0; i < Object.keys(marker_array).length; i++)
	{
		if (marker_array[i].lat != "" && marker_array[i].lng != "")
		{
			maps_add_marker(marker_array[i].lat, marker_array[i].lng, marker_array[i].title, marker_array[i].link, marker_array[i].excerpt, marker_array[i].type);
		}
	}
}

maps_initialize();
