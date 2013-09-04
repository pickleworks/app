<?php
header("Content-type: text/xml");
echo '<markers>';
require("include/calvars.inc.php");
$link = mysql_connect($host, $user, $pwd);
if (!$link) die('Not connected : ' . mysql_error());
if (!mysql_select_db($db)) die ('Can\'t use foo : ' . mysql_error());

function parseToXML($htmlStr) 
{ 
$xmlStr=str_replace('<','&lt;',$htmlStr); 
$xmlStr=str_replace('>','&gt;',$xmlStr); 
$xmlStr=str_replace('"','&quot;',$xmlStr); 
$xmlStr=str_replace("'",'&#39;',$xmlStr); 
$xmlStr=str_replace("&",'&amp;',$xmlStr); 
return $xmlStr; 
} 

$searchDate = $_GET['date'];
//session_start(); 
if ($_SESSION['date'] == '') {
	$_SESSION['date'] = $searchDate;
	//$searchDate = '2013-02-28';
} else {
	$searchDate = $_SESSION['date'];
}

// Select all the rows in the markers table
$query = "SELECT * FROM ".$events_table." WHERE";
if ($searchDate!='') {
	$query.=" event_dt = '".$searchDate."' OR (event_dt<= '".$searchDate."' AND event_edate>'".$searchDate."')";
/* newer query from amit.. seems to pull same results as before.  why are we not picking up http://www.sdvisualarts.net/sdvan_new/popdetail.php?id=7641
	$query.=" date(event_dt) = '".$searchDate."' OR (date(event_dt)<= '".$searchDate."' AND date(event_edate)>'".$searchDate."')"; */
// for testing tired now $query.=" event_dt = '".$searchDate."' OR (event_dt<= '".$searchDate."' AND event_edate>'".$searchDate."')";
}
if ($_GET['neighborhood']!='') {
	$query.=' AND neighborhood="'.$_GET['neighborhood'].'"';
}
if ($_GET['radius']!='') {
	$query.=' AND sqrt(pow(68.88*(lat-'.$_GET['lat'].'),2)+pow(59.95*(lng-'.$_GET['lon'].'),2))<'.$_GET['radius'];
}
//echo $query;
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}



// Start XML file, echo parent node
// Iterate through the rows, printing XML nodes for each
while ($row = @mysql_fetch_assoc($result)){

if ( strlen($row['event_detail']) > 89 ) {
	$notes =  substr($row['event_detail'],0,90) . "...";
} else {
	$notes =  $row['event_detail'];
}
$notes=preg_replace("/<img[^>]+\>/i", " ",  $notes);
/* function closetags ( $notes ) {
			#put all opened tags into an array
			preg_match_all ( "#<([a-z]+)( .*)?(?!/)>#iU", $notes, $result );
			$openedtags = $result[1];
			#put all closed tags into an array
			preg_match_all ( "#</([a-z]+)>#iU", $notes, $result );
			$closedtags = $result[1];;
			$len_opened = count ( $openedtags );
			# all tags are closed
			if( count ( $closedtags ) == $len_opened )
			{
			return $notes;
			}
			$openedtags = array_reverse ( $openedtags );
			# close tags
			for( $i = 0; $i < $len_opened; $i++ )
			{
				if ( !in_array ( $openedtags[$i], $closedtags ) )
				{
				$notes .= "</" . $openedtags[$i] . ">";
				}
				else
				{
				unset ( $closedtags[array_search ( $openedtags[$i], $closedtags)] );
				}
			}
			return $notes;
		} */
		// close opened html tags
		//$notes = closetags($notes); 
	

//$notes=preg_replace("/<a href[^>]+\>/i", " ",  $notes);
  // ADD TO XML DOCUMENT NODE
  echo '<marker ';
  echo 'name="' . parseToXML($row['eventname']) . '" ';
  echo 'address="' . parseToXML($row['event_addr'].', '.$row['event_city'].', '.$row['event_state'].' '.$row['event_zip']) . '" ';
  echo 'lat="' . $row['lat'] . '" ';
  echo 'lng="' . $row['lng'] . '" ';
  echo 'event_id="' . parseToXML($row['event_id']) . '" ';  
  echo 'type="Events" ';
  echo 'notes="' . parseToXML($notes) . '" ';
  echo '/>';
}

// End XML file
echo '</markers>';

?>