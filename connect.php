<?php
// Connecting, selecting database
$dbconn = pg_connect("host=localhost dbname=AlbumyDB user=postgres password=root")
or die('Could not connect: ' . pg_last_error());
// Closing connection
pg_close($dbconn);
?>

