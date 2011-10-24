<?php #Script displayBirds.php
$page_title="displayBirds.php";

include('./Includes/mysqli_connect.inc.php');
include('./Includes/birdsHeader.inc.html');


$querry = "SELECT nameGeneral, nameSpecific, populationTrend FROM birds";
$result = mysqli_query ($dbc, $querry);  //runs querry

echo "
	<fieldset><legend>birds</legend>
	<table align='center' cellspacing='3px' cellpadding='3px' width='40%'>
	<tr><th>General Name</th><th>Specific Name</th><th>Population Trend</th></tr>";

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '<tr><td>'.$row['nameGeneral'].'</td><td>'.$row['nameSpecific'].'</td><td>'.$row['populationTrend'].'</td>';	
	
	}
echo "</table></fieldset></body></html>";

include ('./Includes/birdsFooter.inc.html');

?>
