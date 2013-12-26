<?php 
	if ($_POST['radius']!='') {
		$currentRadius=$_POST['radius'];
	} else {
		$currentRadius=500;
	}
	if ($_POST['neighborhood']!='') {
		$currentNeighborhood=$_POST['neighborhood'];
	} else {
		$currentNeighborhood='';
	}
?>
<!DOCTYPE html>
<!--[if IEMobile 7 ]>    <html class="no-js iem7"> <![endif]-->
<!--[if (gt IEMobile 7)|!(IEMobile)]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
	<META http-equiv="Content-type" content="text/html; charset=iso-8859-1">
        <title>SD View Art Now | Results</title>
        <meta name="description" content="">
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="viewport" content="width=device-width">
        <meta http-equiv="cleartype" content="on">

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/touch/apple-touch-icon-144x144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/touch/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/touch/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="img/touch/apple-touch-icon-57x57-precomposed.png">
        <link rel="shortcut icon" href="favicon.ico?v=2" />
		
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

		<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/normalize.css">
        <script src="js/vendor/modernizr-2.6.1.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
        <link rel="stylesheet" href="css/main.css">	
	<script type='text/javascript'>
<?php
		echo 'var radius='.$currentRadius.';';
//		echo 'var curneighb='.$currentNeighborhood.';';
//		echo 'alert(curneighb)';
		switch ($currentNeighborhood) {
			case 'North County Coastal':
				echo 'var nbhSet=1;';
				echo 'var nbhLat=32.9450850;';
				echo 'var nbhLon=-117.241620;';
				break;
			case 'Central San Diego':
				echo 'var nbhSet=1;';
				echo 'var nbhLat=32.71131630;';
				echo 'var nbhLon=-117.15999880;';
				break;
			case 'East San Diego':
				echo 'var nbhSet=1;';
				echo 'var nbhLat=32.78093060;';
				echo 'var nbhLon=-116.98336220;';
				break;
			case 'South San Diego':
				echo 'var nbhSet=1;';
				echo 'var nbhLat=32.60409120;';
				echo 'var nbhLon=-117.08836990;';
				break;
			case 'Baja Norte':
				echo 'var nbhSet=1;';
				echo 'var nbhLat=32.5334890;';
				echo 'var nbhLon=-117.0182040;';
				break;
			case 'All Neighborhoods':
			case 'Current Location':
			default:
				echo 'var nbhSet=0;';
		}
//		echo 'alert(nbhSet);';
?>
	</script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script src="geo.js" type="text/javascript" ></script>
	<script type='text/javascript'>
		var lat=0;
		var lon=0;
		var mobile = (/iphone|ipod|android|blackberry|phone|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));
		if (!mobile) {
		//	document.location='/app/index.php';
		}
		//determine if the handset has client side geo location capabilities
		function load() {
			if(geo_position_js.init()){
				geo_position_js.getCurrentPosition(success_callback,error_callback);
			} else {
				// no coordinate capability on device
				display();
			}
		}
		function success_callback(p) {
			// we have coordinates of device
			lat=p.coords.latitude;
			lon=p.coords.longitude;
			display();
		}
		function error_callback(p) {
			// alert('error='+p.code);
			// if we can't get coordinates do we direct back to non-mobile or use local or some other behavior
			display();
		}
		var customIcons = {
			Events: {
				icon: 'img/eye-marker.png',
				shadow: ''
			},
			bar: {
				icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
				shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
			}
		};

		function parsetoHTML(xmlStr) { 
			htmlStr=xmlStr.replace(/&lt;/g,'<');
			htmlStr=htmlStr.replace(/&gt;/g,'>');
			htmlStr=htmlStr.replace(/&quot;/g,'"');
			htmlStr=htmlStr.replace(/&#39;/g,"'");
			htmlStr=htmlStr.replace(/&amp;/g,'&');
			return htmlStr; 
		}
 
		function downloadUrl(url,callback) {
			var request = window.ActiveXObject ?  new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;
			request.onreadystatechange = function() {
				if (request.readyState == 4) {
					request.onreadystatechange = doNothing;
					callback(request, request.status);
				}
			};
			request.open('GET', url, true);
			request.send(null);
		}

		function display() {
			if (
				(lat>42.009305)||
				(lat<32.519952)||
				(lon<-124.431152)||
				(lon>-114.082031)
			) {
				//console.log("Toto, we're not in California anymore");
				lat=0;
			}
			if (lat==0) {
				// need to remove option from form for "Current Location"
				$('#neighborhood option[value="Current Location"]').remove();
				lat=32.7153;
				lon=-117.1564;
			}
			if (nbhSet==1) {
				// need to set neighborhood's lat/lon
				lat=nbhLat;
				lon=nbhLon;
			}
			
						
			
			var map = new google.maps.Map(document.getElementById("map"), {
				center: new google.maps.LatLng(lat, lon),
				zoom: 13,
				mapTypeId: 'roadmap',
				bounds: true,
				zoomControl: true,
				zoomControlOptions: {style:google.maps.ZoomControlStyle.SMALL}
			});
// 			geocoder = new google.maps.Geocoder();	
// 		    var address = "1690 Wandering Road, Encinitas, CA  92024";
// 		    geocoder.geocode( { 'address': address}, function(results, status) {
// 		      if (status == google.maps.GeocoderStatus.OK) {
// 		        map.setCenter(results[0].geometry.location);
		        
// 		      } else {
// 		        alert("Geocode was not successful for the following reason: " + status);
// 		      }
// 		    });
			  
			//alert(lat+','+lon);
			// my house = 32.7449017,-117.1470023;
			var infoWindow = new google.maps.InfoWindow({
			//disableAutoPan: true
				
			});
			downloadUrl("/app/phpsqlajax_genxml2.php?radius="+radius+"&lat="+lat+"&lon="+lon, function(data) {			
				var xml = data.responseXML;
				var markers = xml.documentElement.getElementsByTagName("marker");
				for (var i = 0; i < markers.length; i++) {
					var name = markers[i].getAttribute("name");
					var address = markers[i].getAttribute("address");					
					var type = markers[i].getAttribute("type");
					var event_id = markers[i].getAttribute("event_id");					
					var point = new google.maps.LatLng(
						parseFloat(markers[i].getAttribute("lat")),
						parseFloat(markers[i].getAttribute("lng"))
					);
					var notes=markers[i].getAttribute('notes');					
					var html = "<div class='infowin'><a href='details.php?event_id="+parsetoHTML(event_id)+"' class='infoWinTitleURL'>" + parsetoHTML(name) + "</a><br/>"+parsetoHTML(notes)+"<p class='addy'>" + parsetoHTML(address) +"</p><p class='dirread'><a href='details.php?event_id="+parsetoHTML(event_id)+"'>READ MORE</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='http://maps.google.com/maps?saddr=&daddr="+address+"'>DIRECTIONS</a></p></div>";
					var icon = customIcons[type] || {};
					var marker = new google.maps.Marker({
						map: map,
						position: point,
						icon: icon.icon,
						shadow: icon.shadow
					});
					bindInfoWindow(marker, map, infoWindow, html);
				}
			});
		}

		function bindInfoWindow(marker, map, infoWindow, html) {
			google.maps.event.addListener(marker, 'click', function() {
				infoWindow.setContent(html);
				infoWindow.open(map, marker);
			});
			
			google.maps.event.addListener(marker, 'mouseover', function() {
				infoWindow.setContent(html);
				infoWindow.open(map, marker);
			});
			
			
		}

		function doNothing() {
		}

		$(document).ready(function() {
			load();
		});
	</script>
</head>
    <body id="listingDetails">
		<div id="wrapper">
		<div id="header" class="internal">
		<a href="/app/"><img src="img/sdvan-header-internal.png" class="header-internal"/></a>
		<p class="date">Art Events on <?php echo date("F j, Y"); ?></p>
		</div>
		<div id="body" class="internal">
			<div id="map" style="width: 100%; height: 100%;"></div>
				<div id="directions"></div>
				<?
				//include('geo_fix.php'); 
				?>
		</div>
		
		
		<div id="footer" class="internal">
		<table id="tableFooter" ><tr><td width="53%" align="right"><p><a href="/app/" data-ajax="false"><img src="img/back.png" class="back" /></a><a href="http://www.sdvisualarts.net" target="_blank">SDVisualArts.net</a></p></td><td width="47%" align="right"><p class="info"><a href="http://sdvan.weebly.com/helpfaq.html" target="_blank"><img align="right" src="img/help_black.png" height="25" width="25"/></a></p></td></tr></table>
		</div>
		</div>
		<script src="js/vendor/zepto.min.js"></script>
		<script src="js/helper.js"></script>
    </body>
</html>

