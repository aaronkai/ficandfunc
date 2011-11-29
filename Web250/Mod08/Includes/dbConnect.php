<?php

function dbConnect() {  //returns a database connection($dbc)
 
//set database access info
Define ('DB_USER', 'root');
Define ('DB_PASSWORD', '');
Define ('DB_HOST', 'localhost');
Define ('DB_NAME', 'birds_db');

$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connec to MySQL: '.mysqli_connect_error());

return $dbc;
}

?>
