<!DOCTYPE html>
<!--[if IEMobile 7 ]>    <html class="no-js iem7"> <![endif]-->
<!--[if (gt IEMobile 7)|!(IEMobile)]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>SD View Art Now | Art Event Details</title>
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
			<link rel="stylesheet" href="external/jquery.mobile-1.0.min.css" />
        <link rel="stylesheet" href="css/main.css">			
	<link href="demo/shCoreDefault.css" rel="stylesheet" type="text/css" />
	<link href="demo/shThemeDefault.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="demo/shCore.js"></script>
	<script type="text/javascript" src="demo/shBrushJScript.js"></script>
	<script type="text/javascript" src="demo/shBrushXml.js"></script>
	<script type="text/javascript" src="external/modernizr.custom.min.js"></script>
	<script type="text/javascript" src="external/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="external/jquery.mobile-1.0.min.js"></script>
	<script type="text/javascript">
		// Load mobile datepicker if necessary
		// from http://css-tricks.com/8678-progressively-enhancing-html5-forms/
		yepnope({
			test: Modernizr.inputtypes.text,
			nope: [
				"external/xdate.js", 
				"external/xdate.i18n.js", 
				"js/mobipick.js", 
				"demo/mobipick-custom.js",
				"css/mobipick.css"
			]
		});
		$( "#body" ).live( "pagecreate", function() {
			SyntaxHighlighter.all();
		});		
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".date").click(function() {
				$('.select_region').attr('disabled', 'disabled');
			});
			$(".date").change(function() {
				$('.select_region').attr('disabled', false);
			});	
		});
	</script>
    </head>
    <body>
		<div id="wrapper">
			<div id="header" class="internal">
				<a href="/app/" data-ajax="false"><img src="img/sdvan-header-by-date.png" class="header-internal"/></a>
			</div>
			<div id="body" class="internal details">
				<article>
					<form method="POST" action="date_region_list.php" data-ajax="false">
						<h1>Select Date</h1>
						<div class="dateselect">
							<input class="mobipick-demo-basic date" type="date" name="date" />
						</div>
						<div>
							<h1 class="secondary">Select Region</h1>
							<select name="neighborhood" class="select_region">
							  <option></option>
							  <option value="Current Location">Current Location</option>
							  <option value="All Neighborhoods">All Neighborhoods</option>
							  <option value="North County Coastal">North County Coastal</option>
							  <option value="North County Inland">North County Inland</option>							  
							  <option value="Central San Diego">Central San Diego</option>
							  <option value="East San Diego">East San Diego</option>
							  <option value="South San Diego">South San Diego</option>
							  <option value="Baja Norte">Baja Norte</option>
							</select>
						</div>
						<div><input type="submit" class="map" value="" /></div>
					</form>
				</article>
			</div>
			<div id="footer" class="internal details">
			
			<table id="tableFooter" ><tr><td width="53%" align="right"><p><a href="/app/" data-ajax="false"><img src="img/back.png" class="back" /></a><a href="http://www.sdvisualarts.net" target="_blank">SDVisualArts.net</a></p></td><td width="47%" align="right"><p class="info"><a href="http://sdvan.weebly.com/helpfaq.html" target="_blank"><img align="right" src="img/help_black.png" height="25" width="25"/></a></p></td></tr></table>
				
			
			
			</div>
		</div>
        <script src="js/vendor/zepto.min.js"></script>
        <script src="js/helper.js"></script>
    </body>
</html>
