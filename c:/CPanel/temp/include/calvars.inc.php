<?
if(!isset($ADMIN))
   $ADMIN = 0;
/*if(!isset($_SESSION['ADMIN']))
   $_SESSION['ADMIN'] = 0;*/
//*********************************************/
// COnfigure these for your database connection
//*********************************************/
$host = "localhost";            // 'localhost' or 'www.yoursiteurl.com' if on a remote site
$user = "visual";           // username
$pwd = "arts";               // password
$db = "visual_sdvisual";               // the name of your database
$events_table = "events";        // the name of your events table (the default is "sched")
$locations_table = "resources"; // the name of your locations table (the default is "resources")
$admin_table = "sd_user";         // the name of the table to store admin users
$admin_main="sd_admin";
?>
