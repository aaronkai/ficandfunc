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

function numberOfPages($dbname, $dbc, $display) {

	//count number of records
	$q="SELECT COUNT(birdID) from ".$dbname;
	$r=mysqli_query($dbc, $q);
	$row=mysqli_fetch_array($r, MYSQLI_NUM);
	$records = $row[0];

	//calculate the number of pages
	if ($records > $display)
		$pages=ceil($records/$display);
	else
		$pages=1;

	return ($pages);
}

function previousButton($current_page, $start, $display, $pages){
	if($current_page !=1){
		return('<a href="birdsPagination.php?s='.($start-$display).' &p=' .$pages.'">Previous</a>');}
}

function nextButton($current_page, $start, $display, $pages){
	if($current_page !=$pages){
	return('<a href="birdsPagination.php?s='.($start+$display).' &p=' .$pages.'">Next</a>');}
}

function makePageNumberLinks($current_page, $display, $pages){
	$array[]='';
	for($i = 1; $i <= $pages; $i++) {
		if ($i != $current_page){
			$array[]='<a href="birdsPagination.php?s='.(($display * ($i-1))).'&p='.$pages.'">'.$i.'</a>';
			}
		else
			$array[]="<p>$i</p>";
	}//end for loop
	return ($array);
}

function addToDatabase($array, $dbc){
	if (!$dbc)
		echo "<p>Could  not connect. Check dbc";
	mysqli_select_db('birds_db');
	$result=mysqli_query('select * from birds');
	if (!$result)
		echo "Query Failed.";
	$i=0;	
	while ($i < mysqli_num_fields($result)){
		$meta=mysqli_fetch_fields($result);
		$i++;
	}
		return ($meta);
}

?>

