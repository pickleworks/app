<?php
require("include/calvars.inc.php");
$link = mysql_connect($host, $user, $pwd);
if (!$link) die('Not connected : ' . mysql_error());
if (!mysql_select_db($db)) die ('Can\'t use foo : ' . mysql_error());

/*
// need to loop over all records where lat/lng is 0/0 and update with correct values
$result = mysql_query("SELECT event_id, event_addr, event_city, event_state, event_zip FROM ".$events_table." where lat=0 or lng=0") or trigger_error(mysql_error());
while($row = mysql_fetch_array($result)){
        foreach($row AS $key => $value) { $row[$key] = stripslashes($value); }
        $add=urlencode($row['event_addr'].','.$row['event_city'].','.$row['event_state'].' '.$row['event_zip']);
        $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$add.'&sensor=false');
//print $geocode;
        $output= json_decode($geocode);
        $row['lat'] = $output->results[0]->geometry->location->lat;
        $row['lng'] = $output->results[0]->geometry->location->lng;
        foreach($row AS $key => $value) { $row[$key] = mysql_real_escape_string($value); }
        if ($row['lat'] != '') {
                $sql = "UPDATE ".$events_table." SET `lat` =  '{$row['lat']}' ,  `lng` =  '{$row['lng']}' WHERE `event_id` = '{$row['event_id']}'";
                mysql_query($sql) or die(mysql_error());
                echo $row['event_id'];
                echo (mysql_affected_rows()) ? " Edited row.<br />" : " Nothing changed. <br />";
        }
}
*/
?>
