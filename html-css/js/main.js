


var defaultZoom = 6;
var geocoder;
var map;
var markersArray = [];
var image;

function initializeMap() {
  geocoder = new google.maps.Geocoder();
  var mapOptions = {
    zoom: defaultZoom,
		center: moveToPoint(),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
	map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	image = 'http://quakehousing.com/images/house-icon.png';
	loadHousing();
}

function loadHousing() {
	$.getJSON("getHousing.php?"+$("#filter-form").serialize(), function(data) {
		$.each(data, function(key, val) {
			var marker = new google.maps.Marker({
					position: new google.maps.LatLng(val['lat'], val['long']),
					map: map,
					icon: image
			});
			markersArray.push(marker);

			google.maps.event.addListener(marker, 'click', function() {
				map.setCenter(new google.maps.LatLng(val['lat'], val['long']));
				map.setZoom(15);
				$.ajax({
					type: "POST",
					url: 'housingAjax.php?houseID='+val['id']+'&'+$("#filter-form").serialize(),
					beforeSend : function(){
						$(".list-item").css('opacity','0.5');
						$("#loading").show();
					},
					success: function(data) {
						if (data != "") {
							$("#list-view").html(data);	
						}
					},
					complete: function() {
						$(".list-item").css('opacity','1.0');
						$("#loading").hide();
					}
				});			
				
			});
		});
	}); 
}
function clearHousing() {
 if (markersArray) {
    for (i in markersArray) {
      markersArray[i].setMap(null);
    }
    markersArray.length = 0;
  }
}
function moveToPoint() {
	var address = $("#location").val();
	geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			map.setCenter(results[0].geometry.location);
			map.setZoom(defaultZoom);
		}
	});
}
	
function buildQueryUrl() {
	$.ajax({
		type: "POST",
		url: 'housingAjax.php?'+$("#filter-form").serialize(),
		beforeSend : function(){
			$(".list-item").css('opacity','0.5');
			$("#loading").show();
		},
		success: function(data) {
			if (data != "") {
				$("#list-view").html(data);	
			}
		},
		complete: function() {
			$(".list-item").css('opacity','1.0');
			$("#loading").hide();
		}
	});			
}



