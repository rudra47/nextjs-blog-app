
@extends('customer.layouts.app')

@section('content')
<div class="container" style="width: 80%;">
	
	
	<div class="col-sm-2" style="width: 23%; float: left; padding-right: 5px;">
		<select class="form-control" id="zone_profile_id" name="zone_profile_id" onchange="getRoute(this.value)">
			<option value="">Select Area</option>
			
		</select>
	</div>
	
	<div class="col-sm-3" style="width: 5%; float: left; padding: 0px;">
		<a onclick="filter()" class="button" style="padding: 4px 15px;">Search</a>
	</div>
	
</div>

@php
    if(auth()->check()){
        $defaultLat = auth()->user()->latitude;
		$defaultLong = auth()->user()->longitude;
    }else{
        $defaultLat = 23.7283894;
		$defaultLong = 90.4206081;
    }
@endphp

@endsection

@push('scripts')
<script type="text/javascript">

    var map;

    var markersArray_free = [];
    var markersArray_free_prev = [];
    var markersArray_anj = [];
    var markersArray_anj_prev = [];
    var markersArray_car = [];
    var markersArray_route = [];

    var infos_free = [];
    var infos_anj = [];
    var infos_car = [];
    var infos_route = [];

    var initMapView = false;

	var saloons = {!! json_encode($saloons) !!};
	var markerIcon = '{{ asset('/') }}marker.png';
	var marks = [];
	var pos = [];

	var defaultLat = {{ $defaultLat }};
	var defaultLong = {{ $defaultLong }};

	//console.log({{$saloons}});

    function initMap() {

        var mapOptions = {
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            center: new google.maps.LatLng(defaultLat, defaultLong)
        };

        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        //addMarker_saloon();
		//addMarker_cars();
		
        //addMarker_anjuman();
        //addMarker_route_spot();

		var bounds = new google.maps.LatLngBounds();

		for(var i = 0; i < saloons.length; i++){
			var position;
			position = addMarker(saloons[i]);
			bounds.extend(position);
        }

		if(saloons.length>0){
			if(initMapView != true) {
				map.fitBounds(bounds);
				initMapView = true;
			}
		}else{
			var position = new google.maps.LatLng(parseFloat(defaultLat),parseFloat(defaultLong));
			bounds.extend(position);
			if(initMapView != true) {
				map.fitBounds(bounds);
				initMapView = true;
			}
		}
		
    }

	function addMarker(saloon){
        var name = saloon.name;
		var email = saloon.email;
		var phone = saloon.phone;
		var address = saloon.address;
        var latitude = saloon.latitude;
        var longitude = saloon.longitude;

		var confirm = "Are you sure?";

        var html = "<h3>" + name + "</h3>" + email +"<br/>"+phone+"<br/>"+address+"<br/>";
		html += '<p style="font-size: 18px; font-weight: bold; margin-top: 10px">Available schedules:</p>';
		// html += '<div><table class="table table-responsive table-bordered"><thead><tr><th>Schedule</th><th>Book</th></tr></thead>';
		// html += '<tbody>';
		// html += '<tr><td>12:30pm - 2:00pm</td><td><button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Book Now</button></td></tr>';
		// html += '</tr>';
		// html += '</table></div>';

		html += '<div><form method="post" action="{{ route('saloon.book') }}">';
		html += 	'@csrf';
		html += 	'<span><b>Time:</b> 12:30pm - 2:00pm</span><br/>';
		html += 	'<input type="hidden" name="schedule" value="1">';
		html += 	'<span><b>Select Service: </b>';
		html += 		'<select name="service" style="margin-top: 5px;">';
		html += 			'<option value="0">Hair cut</option>';
		html += 			'<option value="0">Head massage</option>';
		html += 			'<option value="0">Hair color</option>';
		html +=			'</select>';
		html +=		'</span><br/>';
		html += 	'<button type="submit" class="btn btn-xs btn-primary" style="margin-top: 5px;" onclick="return confirm('+confirm+');">Book Now</button>';
		html += '</form></div>';

		html += '<hr style="margin-bottom: 10px;">';

		html += '<div><form method="post" action="{{ route('saloon.book') }}">';
		html += 	'@csrf';
		html += 	'<span><b>Time:</b> 12:30pm - 2:00pm</span><br/>';
		html += 	'<input type="hidden" name="schedule" value="1">';
		html += 	'<span><b>Select Service: </b>';
		html += 		'<select name="service" style="margin-top: 5px;">';
		html += 			'<option value="0">Hair cut</option>';
		html += 			'<option value="0">Head massage</option>';
		html += 			'<option value="0">Hair color</option>';
		html +=			'</select>';
		html +=		'</span><br/>';
		html += 	'<button type="submit" class="btn btn-xs btn-primary" style="margin-top: 5px;" onclick="return confirm('+confirm+');">Book Now</button>';
		html += '</form></div>';

		// html += '<div class="modal" id="exampleModal" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
		// html += 	'<div class="modal-dialog" role="document">';
		// html += 		'<div class="modal-content">';
		// html += 			'<div class="modal-header">';
		// html += 				'<h5 class="modal-title" id="exampleModalLabel">New message</h5>';
		// html += 				'<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
		// html += 					'<span aria-hidden="true">&times;</span>';
		// html += 				'</button>';
		// html += 			'</div>';
		// html += 			'<div class="modal-body">';
		// html += 				'<form>';
		// html += 					'<div class="form-group">';
		// html += 						'<label for="recipient-name" class="col-form-label">Recipient:</label>';
		// html += 						'<input type="text" class="form-control" id="recipient-name">';
		// html += 					'</div>';
		// html += 					'<div class="form-group">';
		// html += 						'<label for="message-text" class="col-form-label">Message:</label>';
		// html += 						'<textarea class="form-control" id="message-text"></textarea>';
		// html += 					'</div>';
		// html += 				'</form>';
		// html += 			'</div>';
		// html += 			'<div class="modal-footer">';
		// html += 				'<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
		// html += 				'<button type="button" class="btn btn-primary">Send message</button>';
		// html += 			'</div>';
		// html += 		'</div>';
		// html += 	'</div>';
		// html += '</div>';


        var markerLatlng = new google.maps.LatLng(parseFloat(latitude),parseFloat(longitude));


        var mark = new google.maps.Marker({
            map: map,
            position: markerLatlng,
            icon: markerIcon
        });

        var infoWindow = new google.maps.InfoWindow;
        google.maps.event.addListener(mark, 'click', function(){
            infoWindow.setContent(html);
            infoWindow.open(map, mark);
        });

        return markerLatlng;
    }

	function addMarker_saloon() {
		
		//map.clearOverlays();

		//Initialize a variable that the auto-size the map to whatever you are plotting
		var bounds = new google.maps.LatLngBounds();
		//Initialize the encoded string
		//var encodedString;
		//Initialize the array that will hold the contents of the split string
		var stringArray = ['Saloon1', 'Saloon2', 'Saloon3', 'Saloon4'];
		//Get the value of the encoded string from the hidden input
		//encodedString = document.getElementById("encodedString").value;
		//Split the encoded string into an array the separates each location
		//stringArray = result.split("****");
		var lats = ['23.7507983', '23.7519229', '23.7517265', '23.7570539'];
		var longs = ['90.4219536', '90.4048733', '90.4106669', '90.4120373'];

		var x;
		for (x = 0; x < stringArray.length; x = x + 1) {
			var marker;
			//Separate each field
			//Load the lat, long data
			var pos = new google.maps.LatLng(parseFloat(lats[x]), parseFloat(longs[x]));
			//Create a new marker and info window

			var markerIcon = '{{ asset('/') }}marker.png';
			//alert(markerIcon[3]);
			marker = new google.maps.Marker({
				map: map,
				position: pos,
				icon: markerIcon,
				//Content is what will show up in the info window
				content: stringArray[x]
			});
			//Pushing the markers into an array so that it's easier to manage them
			//markersArray_free.push(marker);
			google.maps.event.addListener( marker, 'click', function () {
				//closeInfos_free();
				var info = new google.maps.InfoWindow({content: this.content});
				//On click the map will load the info window
				info.open(map,this);
				//infos_free[0]=info;
			});
			//Extends the boundaries of the map to include this new location
			bounds.extend(pos);
		}
		
		//Takes all the lat, longs in the bounds variable and autosizes the map
		if(initMapView != true) {
			map.fitBounds(bounds);
			initMapView = true;
		}
	}


    //Manages the info windows
    function closeInfos_free(){
        if(infos_free.length > 0){
            infos_free[0].set("marker",null);
            infos_free[0].close();
            infos_free.length = 0;
        }
    }
    function closeInfos_anj(){
        if(infos_anj.length > 0){
            infos_anj[0].set("marker",null);
            infos_anj[0].close();
            infos_anj.length = 0;
        }
    }
    function closeInfos_car(){
        if(infos_car.length > 0){
            infos_car[0].set("marker",null);
            infos_car[0].close();
            infos_car.length = 0;
        }
    }
    function closeInfos_route(){
        if(infos_route.length > 0){
            infos_route[0].set("marker",null);
            infos_route[0].close();
            infos_route.length = 0;
        }
    }

    // clearing markers
    function clearmarkers_free_leather(){
//        markersArray_free_prev = markersArray_free;
        for (var i = 0; i < markersArray_free.length; i++ ) {
            markersArray_free[i].setMap(null);
        }
        markersArray_free.length = 0;
    }
    function clearmarkers_anj(){
        for (var i = 0; i < markersArray_anj.length; i++ ) {
            markersArray_anj[i].setMap(null);
        }
        markersArray_anj.length = 0;
    }
    function clearmarkers_route(){
        for (var i = 0; i < markersArray_route.length; i++ ) {
            markersArray_route[i].setMap(null);
        }
        markersArray_route.length = 0;
    }

    // update from MAP
    function updateMarker(obj) {

        var frm = $(obj).closest("form");
		
        $.ajax({
            type: "POST",
            url: "index.php?page=map_controller",
            data: frm.serialize(),
            cache: false,
            success: function(result){
				if(result==1){
					// clearing and refrashing markers
                    clearmarkers_free_leather();
                    //clearmarkers_anj();
					addMarker_free_leather();
                    //addMarker_anjuman();
					return false;
                } else{
                    alertify.error("FAILED!");
                    return false;
                }
            }
        });
    }

    function syncCarPosition(){

        $.get('index.php?page=map_controller&action=3', function(result){
            var stringArray = [];
            stringArray = result.split("****");
            var x;
            var markersArray_car_new = [];

            for (x = 0; x < stringArray.length; x = x + 1) {
                var posData = [];
                var marker;
                posData = stringArray[x].split("&&&");

                var sOldPos = markersArray_car[x].position.toString().replace('(','').replace(')','').replace(' ','');
                var temppos = new google.maps.LatLng(posData[1], posData[2]);
                var sNewPos = temppos.toString().replace('(','').replace(')','').replace(' ','');

                if (sOldPos != sNewPos) {

                    //alert(sOldPos+"\n"+sNewPos)
                    //alert(x + " changed");

                    markersArray_car[x].setMap(null);
                    //Load the lat, long data
                    var pos = new google.maps.LatLng(posData[1], posData[2]);
                    //Create a new marker and info window
                    var markerIcon = 'assets/img/' + posData[3] + '.png';

                    marker = new google.maps.Marker({
                        map: map,
                        position: pos,
                        icon: markerIcon,
                        content: posData[0]
                    });
                    google.maps.event.addListener(marker, 'click', function () {
                        closeInfos_car();
                        var info = new google.maps.InfoWindow({content: this.content});
                        //On click the map will load the info window
                        info.open(map, this);
                        infos_car[0] = info;
                    });

                    markersArray_car[x] = marker;
                } else{
                    //alert(x + " no change");
                }
            }
        });

        /*for (var i = 0; i < markersArray_car.length; i++ ) {
         //alert(markersArray_car[i].position);
         var oldpost = markersArray_car[i].position.toString().replace('(','').replace(')','').replace(' ','').split(',');
         //alert(oldpost[0]);
         var pos = new google.maps.LatLng(parseFloat(oldpost[0])+0.0005, parseFloat(oldpost[1])+0.0005)
         //alert(pos + oldpost);
         //markersArray_car[i].position = pos;
         if (markersArray_car[i] != null) {
         markersArray_car[i].setMap(null);
         }
         markersArray_car[i] = new google.maps.Marker({
         position: pos,
         map: map,
         title: "jgjg"
         });
         }*/
    }

    function updateRoutSpot(obj) {

        var frm = $(obj).closest("form");

        $.ajax({
            type: "POST",
            url: "class/map.manager.php",
            data: frm.serialize(),
            cache: false,
            success: function(result){

                if(result==1){

                    // clearing and refrashing markers
                    clearmarkers_route();
                    addMarker_route_spot();

                    return true;
                } else{
                    alertify.error("FAILED!");
                    return false;
                }
            }
        });
    }
	function filter() {
	
		url = 'index.php?page=map';
		
		var zone_profile_id = $('select[name=\'zone_profile_id\']').attr('value');
		if (zone_profile_id) {
			url += '&zone_profile_id=' + encodeURIComponent(zone_profile_id);
		}
		
		var route_profile_id = $('select[name=\'route_profile_id\']').attr('value');
		if (route_profile_id) {
			url += '&route_profile_id=' + encodeURIComponent(route_profile_id);
		}
		
		var area_id = $('select[name=\'area_id\']').attr('value');
		if (area_id>0) {
			url += '&route_area_id=' + encodeURIComponent(area_id);
		}
		
		var collector = $('select[name=\'collector\']').attr('value');
		if (collector) {
			url += '&collector=' + encodeURIComponent(collector);
		}
		
		var leather_type = $('select[name=\'leather_type\']').attr('value');
		if (leather_type) {
			url += '&leather_type=' + encodeURIComponent(leather_type);
		}
		
		var reference_id = $('input[name=\'reference_id\']').attr('value');
		if (reference_id) {
			url += '&reference_id=' + encodeURIComponent(reference_id);
		}
		
		location = url;	
	}

	function getRoute(zone_profile_id) {
		$.ajax({
			url: 'index.php?page=leather_controller&zone_profile_id=' +  zone_profile_id,
			dataType: 'json',			
			success: function(json) {
				var html = '<option value="">রুট সিলেক্ট করুন</option>';
				for (i = 0; i < json.length; i++) {
					html += '<option value="' + json[i]['profile_id'] + '"';
					html += '>' + json[i]['name'] + '</option>';
				}
				$('select[name=\'route_profile_id\']').html(html);
			}
		});
	}
	
	function getArea(route_profile_id) {
		$.ajax({
			url: 'index.php?page=leather_controller&area_route_profile_id=' +  route_profile_id,
			dataType: 'json',			
			success: function(json) {
				var html = '<option value="">স্পট/এলাকা সিলেক্ট করুন</option>';
				for (i = 0; i < json.length; i++) {
					html += '<option value="' + json[i]['area_id'] + '"';
					html += '>' + json[i]['area_name'] + '</option>';
				}
				$('select[name=\'area_id\']').html(html);
			}
		});
	}
	
</script>
<div class="jumbotron">
<div id="map-canvas"></div>
</div>
<script>
    $(document).ready(function(){
        initMap();
        setInterval(function mapload(){
            //clearmarkers_free_leather();
            //addMarker_free_leather();
            //clearmarkers_route();
            //addMarker_route_spot();
        },300000);  // 5 min

        setInterval(function mapload(){
            //syncCarPosition();
        },10000);  // 10 sec
    });
</script>
@endpush