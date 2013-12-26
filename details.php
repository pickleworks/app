<?php session_start();/* echo $_SESSION['date']; echo $_SESSION['neighborhood'];  */ ?>
<?php
//header("Content-type: text/html; charset=iso-8859-1");
require("include/calvars.inc.php");
$link = mysql_connect($host, $user, $pwd);
if (!$link) die('Not connected : ' . mysql_error());
if (!mysql_select_db($db)) die ('Can\'t use foo : ' . mysql_error());

?>
<!DOCTYPE html>
<!--[if IEMobile 7 ]>    <html class="no-js iem7"> <![endif]-->
<!--[if (gt IEMobile 7)|!(IEMobile)]><!--> <html class="no-js"> <!--<![endif]-->
    <head>

	<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> -->
	<META http-equiv="Content-type" content="text/html; charset=iso-8859-1">
<!-- 	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
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
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.1.min.js"></script>
    </head>
    <body>

		<div id="wrapper">
		<div id="header" class="internal">
		<a href="/SDVisualArts"><img src="img/sdvan-header-details.png" class="header-internal"/></a>
		</div>
		<div id="body" class="internal details">
		
		<?php
			$data_query=mysql_query("select * from ".$events_table." where event_id=".$_GET['event_id']);
			$data=mysql_fetch_array($data_query);
			$modtime=$data['event_stime'];
			$hh=$modtime[0].$modtime[1]+0;
			$mmts=$modtime[3].$modtime[4]+0;
			if($hh>12)
			{
				$hh=$hh-12;
				$indr="P.M.";
			}
			else
			{
				if($hh==12 && $mmts>0)
					$indr="P.M.";
				else
					$indr="A.M.";
			}
			$dt=$data['event_dt'];
			$dd=$dt[8].$dt[9]+0;
			$mm=$dt[5].$dt[6]+0;
			$yy=$dt[0].$dt[1].$dt[2].$dt[3]+0;
			$stdate=$yy."-".$mm."-".$dd;
			
			$dt=$data['event_edate'];
			$dd=$dt[8].$dt[9]+0;
			$mm=$dt[5].$dt[6]+0;
			$yy=$dt[0].$dt[1].$dt[2].$dt[3]+0;
			$edate=$yy."-".$mm."-".$dd;
			
			$dt=$data['rec_dt'];
			$dd=$dt[8].$dt[9]+0;
			$mm=$dt[5].$dt[6]+0;
			$yy=$dt[0].$dt[1].$dt[2].$dt[3]+0;
			$rec_dt=$yy."-".$mm."-".$dd;
			
			$t2=$data['open_hrs'];
			$hho=$t2[0].$t2[1]+0;
			$mmo=$t2[3].$t2[4]+0;
			if($hho>12)
			{
				$hho=$hho-12;
				$indro="P.M.";
			}
			else
			{
				if($hho==12 && $mmo>0)
					$indro="P.M.";
				else
					$indro="A.M.";
			}
			
			$open_days=$data['open_days'];
			?>
	<? 
		$event_detail=preg_replace("/<img[^>]+\>/i", " ",  $data['event_detail']);
		 // close opened html tags
		function closetags ( $event_detail )
		{
			#put all opened tags into an array
			preg_match_all ( "#<([a-z]+)( .*)?(?!/)>#iU", $html, $result );
			$openedtags = $result[1];
			#put all closed tags into an array
			preg_match_all ( "#</([a-z]+)>#iU", $html, $result );
			$closedtags = $result[1];;
			$len_opened = count ( $openedtags );
			# all tags are closed
			if( count ( $closedtags ) == $len_opened )
			{
			return $event_detail;
			}
			$openedtags = array_reverse ( $openedtags );
			# close tags
			for( $i = 0; $i < $len_opened; $i++ )
			{
				if ( !in_array ( $openedtags[$i], $closedtags ) )
				{
				$html .= "</" . $openedtags[$i] . ">";
				}
				else
				{
				unset ( $closedtags[array_search ( $openedtags[$i], $closedtags)] );
				}
			}
			return $event_detail;
		}
		// close opened html tags
		$event_detail = closetags($event_detail); 
	?>

	<article>
		<h1><? echo $data['eventname']?></h1>
		<h2><? echo $data['organization']?></h2>
		<p class="event-info">
			<? echo $event_detail; ?>
		</p>
		<p class="event-address">
			<? if ( ($data['town_area'] != 'All') && ($data['town_area'] != '0') ) { echo $data['town_area']; echo '<br />'; } ?>
			<? echo $data['event_addr']?><br />
			<? echo $data['event_city']?>, 
			<? echo $data['event_state']?>&nbsp;&nbsp;<? echo $data['event_zip']?>
		</p>
		<?php $address = $data['event_addr'].', '.$data['event_city'].', '.$data['event_state'].' '.$data['event_zip']; ?>
		<p class="directions-link"><a href='http://maps.google.com/maps?saddr=&daddr="<?php echo $address; ?>"'>DIRECTIONS</a></p>
		<?php $img = preg_match_all( '/<img[^>]+src=[\'"]([^\'"]+)[\'"].*>/i', $data['event_detail'], $matches); 
		if ( $img > 0 ) $image=$matches[1][0]; 
		if ($image != '') : ?>
		<a href="<?php echo $data['weblink']; ?>">
			<img src="<?php echo $image; ?>" class="event-feat-img" />
		</a>
		<?php endif; ?>
		<div class="event-dates">
		<?php if ( ($rec_dt!="0-0-0") && ($rec_dt!="") ) : ?>		
			<h3>Reception Date</h3>
			  <?php echo $rec_dt; ?>
		<?php endif; ?>
          <h3>Dates</h3>
           <? echo "Starts On: ".$stdate."<br />";
				 if(isset($edate)) echo "Ends On: ".$edate."<br>";?>
     <?php if ( ($open_days!="0-0-0") && ($open_days!="") ) : ?>
       <h3>Opening Days</h3>
            <? echo $open_days; ?>
    <?php endif; ?>
    <?php list ($hrs, $min, $secs) = split ('[:.-]', $modtime); ?>
    <?php if ($hrs != '00' ) : ?>
        <h3>Opening Time</h3>
		<? 
			echo "$hrs:$min";
		?>
	<?php endif; ?>
		</div>
		<div class="extra-info">
			<? echo $data['contact_name']?><br />		
			<?php if ($data['telno'] != '') : ?>
				<? echo $data['telno']?><br />
			<?php endif; ?>
			<a href="<? echo $data['weblink']?>">
				<? echo $data['weblink']?>
			</a><br />
			<? echo $data['fee']?>
		</div>
		<?php if ($_SERVER['HTTP_REFERER'] != '') : ?><a href="<?php echo $_SERVER['HTTP_REFERER'] ?>"><img src="img/back-arrow-gray.png" class="backarrow" /><?php else: ?><img src="img/spacer.png" class="backarrow" /></a><?php endif; ?>
	</article>
</div>
<div id="footer" class="internal">
		<table id="tableFooter" ><tr><td width="53%" align="right">
		<p><?php if ($_SERVER['HTTP_REFERER'] != '') : ?><a href="<?php echo $_SERVER['HTTP_REFERER'] ?>" data-ajax="false">
		<img src="img/back.png" class="back" /></a><?php endif; ?>
		<a href="http://www.sdvisualarts.net" target="_blank">SDVisualArts.net</a></p>
		
		</td>
		<td width="47%" align="right"><p class="info">
		<a href="http://sdvan.weebly.com/helpfaq.html" target="_blank"><img align="right" src="img/help_black.png" height="25" width="25"/></a></p></td></tr></table>
			
</div>
        <script src="js/vendor/zepto.min.js"></script>
        <script src="js/helper.js"></script>
    </body>
</html>
