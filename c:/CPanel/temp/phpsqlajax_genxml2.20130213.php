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


// Select all the rows in the markers table
$query = "SELECT * FROM ".$events_table." WHERE 1 and event_dt>now()";
if ($_GET['radius']!='') {
	$query.=' AND sqrt(pow(68.88*(lat-'.$_GET['lat'].'),2)+pow(59.95*(lng-'.$_GET['lon'].'),2))<'.$_GET['radius'];
}
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}


// Start XML file, echo parent node

// Iterate through the rows, printing XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
  echo '<marker ';
  echo 'name="' . parseToXML($row['eventname']) . '" ';
  echo 'address="' . parseToXML($row['event_addr'].', '.$row['event_city'].', '.$row['event_state'].' '.$row['event_zip']) . '" ';
  echo 'lat="' . $row['lat'] . '" ';
  echo 'lng="' . $row['lng'] . '" ';
  echo 'type="Events" ';
  echo 'notes="' . parseToXML($row['event_detail']) . '" ';
  echo 'url="' . parseToXML($row['weblink']) . '" ';
  echo '/>';
}

// End XML file
echo '</markers>';

?>
