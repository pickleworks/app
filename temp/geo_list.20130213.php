<?php 
	if ($_POST['radius']!='') {
		$currentRadius=$_POST['radius'];
	} else {
		$currentRadius=5;
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
        <meta charset="utf-8">
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
        <link rel="shortcut icon" href="img/touch/apple-touch-icon.png">
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
				zoomControl: false
			});
			var infoWindow = new google.maps.InfoWindow;
			downloadUrl("/app/phpsqlajax_genxml2.php?radius="+radius+"&lat="+lat+"&lon="+lon, function(data) {			
				var xml = data.responseXML;
				var markers = xml.documentElement.getElementsByTagName("marker");
				for (var i = 0; i < markers.length; i++) {
					var name = markers[i].getAttribute("name");
					var address = markers[i].getAttribute("address");
					var type = markers[i].getAttribute("type");
					var point = new google.maps.LatLng(
						parseFloat(markers[i].getAttribute("lat")),
						parseFloat(markers[i].getAttribute("lng"))
					);
					var url=markers[i].getAttribute('url');
					var notes=markers[i].getAttribute('notes');
					var html = "<a href='"+parsetoHTML(url)+"' target='_blank' class='infoWinTitleURL'><b>" + parsetoHTML(name) + "</b></a><br/>"+parsetoHTML(notes)+"<br/>" + parsetoHTML(address) +"<br/>Directions: <a href='http://maps.google.com/maps?saddr=&daddr="+address+"'>To here</a> <a href='http://maps.google.com/maps?saddr="+address+"&daddr='>From Here</a>";
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
		}

		function doNothing() {
		}

		$(document).ready(function() {
			load();
		});
	</script>
</head>
    <body>

		<div id="wrapper">
		<div id="header" class="internal">
		<a href="/app"><img src="img/sdvan-header-internal.png" class="header-internal"/></a>
		</div>
		<div id="body" class="internal">
<!--	 <form method='POST'>
		<label for='radius'>Radius:</label>
		<select name='radius'>
<?
	$rad=array( 1, 5, 10, 15, 20, 25, 50, 100);
	foreach ($rad as $i=>$v) {
		echo '<option ';
		if ($v==$currentRadius) echo 'selected ';
		echo 'value='.$v.'>'.$v.'</option>';
	}
?>
		</select>
		<label for='neighborhood'>Neighborhood</label>
		<select name='neighborhood' id='neighborhood'>
<?
	$nbh=array('Current Location','All Neighborhoods','North County Coastal','Central San Diego','East San Diego','South San Diego','Baja Norte' );
	foreach ($nbh as $i=>$v) {
		echo '<option ';
		if ($v==$currentNeighborhood) echo 'selected ';
		echo 'value="'.$v.'">'.$v.'</option>';
	}
?>
		</select>
		<input type='Submit' value='Change'>
	</form>  -->
<div id="map" style="width: 100%; height: 100%;"></div>
<div id="directions"></div>
<?
include('geo_fix.php'); 


echo "<table border=1 style='display:none;' >"; 
echo "<tr>"; 
echo "<td><b>Id</b></td>"; 
echo "<td><b>Name</b></td>"; 
echo "<td><b>Address</b></td>"; 
echo "<td><b>City</b></td>"; 
echo "<td><b>State</b></td>"; 
echo "<td><b>ZipCode</b></td>"; 
echo "<td><b>Status</b></td>"; 
echo "<td><b>EventDate</b></td>"; 
echo "<td><b>Notes</b></td>"; 
echo "<td><b>URL</b></td>"; 
echo "<td><b>Lat</b></td>"; 
echo "<td><b>Long</b></td>"; 
echo "</tr>"; 
$result = mysql_query("SELECT * FROM `events` WHERE event_dt>now()") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<tr>";  
echo "<td valign='top'>" . nl2br( $row['event_id']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['eventname']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['event_addr']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['event_city']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['event_state']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['event_zip']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['event_dt']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['event_detail']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['weblink']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['lat']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['lng']) . "</td>";  
//echo "<td valign='top'><a href=geo_edit.php?id={$row['id']}>Edit</a></td><td><a href=geo_delete.php?id={$row['id']}>Delete</a></td> "; 
echo "</tr>"; 
} 
echo "</table>"; 
?>
		</div>
		<div id="footer" class="internal">
		<p><a href="/app/" data-ajax="false"><img src="img/back.png" class="back" /></a><a href="http://www.sdvisualarts.net" target="_blank">SDVisualArts.net</a></p>
		</div>
		</div>
        <script src="js/vendor/zepto.min.js"></script>
        <script src="js/helper.js"></script>
    </body>
</html>

