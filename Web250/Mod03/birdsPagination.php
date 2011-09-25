<?php #Script birdsPagination.php
$page_title="birdsPagination.php";

include('./Includes/birdsHeader.inc.html');
include('./Includes/dbFunctions.inc.php');

$dbc = dbConnect();
$display = 10;

//determine how many pages there are or need to be
if(isset($_GET['p']) && is_numeric($_GET['p'])){
	$pages=$_GET['p'];
}
else{
	//count number of records and calculate number of pages
	$pages= numberOfPages('birds', $dbc, $display);

}

//at this point the pages have been determined*************************

//Now determine where in database to start returning results
if (isset($_GET['s']) && is_numeric($_GET['s']))
	$start=$_GET['s'];
else
	$start=0;

//Make the querry
$q="SELECT nameGeneral, nameSpecific, populationTrend FROM birds LIMIT $start, $display";
$r=mysqli_query($dbc,$q);

//table headings
echo"
	<table align='center' cellspacing='3px' cellpadding='3px' width='40%'>
	<tr><th>General Name</th><th>Specific Name</th><th>Population Trend</th></tr>";

//fetch and print records;
$bg='#dddddd'; //set initial background color
while ($row=mysqli_fetch_array($r, MYSQLI_ASSOC))
{
	$bg = ($bg == '#dddddd' ? '#ffffff' : '#dddddd'); //switch color;
	echo '<tr bgcolor="'.$bg.'"><td>'.$row['nameGeneral'].'</td><td>'.$row['nameSpecific'].'</td><td>'.$row['populationTrend'].'</td>';
}

echo '</table>';
mysqli_free_result($r);
mysqli_close($dbc);

//make links to other pages, if necessary
if($pages >1){
	echo '<br/><p>';
	//determine what page script is on
	$current_page=($start/$display) + 1;
	//if not first page make previous button
	echo previousButton($current_page, $start, $display, $pages);
	
	
	//make the numbered page links
	$pageNumbers=makePageNumberLinks($current_page, $display, $pages);
	foreach ($pageNumbers as $value)
		echo "$value";
	
	//if it is not the last page, make the next button
	echo nextButton($current_page, $start, $display, $pages);
	
	echo '</p'; //close paragraph
} //end of links section

echo '</br>';
include ('./Includes/birdsFooter.inc.html');

?>
