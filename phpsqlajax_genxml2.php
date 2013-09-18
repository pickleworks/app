<?php
header("Content-Type: application/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8"?><markers>';
require("include/calvars.inc.php");
$link = mysql_connect($host, $user, $pwd);
if (!$link) die('Not connected : ' . mysql_error());
if (!mysql_select_db($db)) die ('Can\'t use foo : ' . mysql_error());

function parseToXML($htmlStr) 
{ 
	$xmlStr=utf8_encode($htmlStr);
	$xmlStr=str_replace('<','&lt;',$xmlStr); 
	$xmlStr=str_replace('>','&gt;',$xmlStr); 
	$xmlStr=str_replace('"','&quot;',$xmlStr); 
	$xmlStr=str_replace("'",'&#39;',$xmlStr); 
	$xmlStr=str_replace("&",'&amp;',$xmlStr); 
			
	return $xmlStr; 
} 

// Select all the rows in the markers table
//$query = "SELECT * FROM ".$events_table." WHERE date(event_dt)=curdate() OR (date(event_dt)<=curdate() AND date(event_edate)>=curdate())";
$query = "SELECT * FROM ".$events_table." WHERE event_dt=curdate() OR (event_dt<=curdate() AND event_edate>=curdate())";
//$query = "SELECT * FROM ".$events_table." WHERE event_dt=curdate() OR (event_dt<=now() AND event_edate>=now())";

if ($_GET['radius']!='') {
	$query.=' AND sqrt(pow(68.88*(lat-'.$_GET['lat'].'),2)+pow(59.95*(lng-'.$_GET['lon'].'),2))<'.$_GET['radius'];
}
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

//echo $query;
// Start XML file, echo parent node
// Iterate through the rows, printing XML nodes for each
while ($row = @mysql_fetch_assoc($result)){

if ( strlen($row['event_detail']) > 89 ) {
	$notes =  parseToXML(substr($row['event_detail'],0,90)) . "...";
} else {
	$notes =  $row['event_detail'];
}
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