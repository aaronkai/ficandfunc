<?php
include ($_SERVER['NFSN_SITE_ROOT'].'protected/Includes/dbConnect.inc.php');

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
		return('<a href="birdsPagination.php?s='.($start-$display).'&amp;p=' .$pages.'">Previous</a>');}
}

function nextButton($current_page, $start, $display, $pages){
	if($current_page !=$pages){
	return('<a href="birdsPagination.php?s='.($start+$display).'&amp;p=' .$pages.'">Next</a>');}
}

function makePageNumberLinks($current_page, $display, $pages){
	$array[]='';
	for($i = 1; $i <= $pages; $i++) {
		if ($i != $current_page){
			$array[]='<a href="birdsPagination.php?s='.(($display * ($i-1))).'&amp;p='.$pages.'">'.$i.'</a>';
			}
		else
			$array[]="<p>$i</p>";
	}//end for loop
	return ($array);
}

function addToDatabase($array, $dbc, $dbName){

	$columnNames="";
	if (!$dbc)
		echo "<p>Could  not connect. Check dbc";
	$result=mysqli_query($dbc, "select * from $dbName");
	if (!$result)
		echo "Query Failed.";

	//Generate column names for MySQL query
	while ($meta = mysqli_fetch_field($result)){
			$columnNames=$columnNames.$meta->name.", ";
		}
	$columnNames=substr($columnNames,8,-2);
	$columnNames="(".$columnNames.")";

	//Generate inserts for MySQL query
	$firstPart="";
	foreach ($_POST as $inserts)
		$firstPart=$firstPart."'".$inserts."', ";	
	$firstPart=substr($firstPart, 0, -10);
	$firstPart="(".$firstPart.")";

	//Run Query
	$query="INSERT INTO $dbName $columnNames VALUES $firstPart";
	$result=mysqli_query($dbc, $query);
	if (!$result)
		return FALSE;
	else
		return TRUE;
}

function deleteBird($recordID, $dbc){
	$query="DELETE FROM birds WHERE birdID=".$recordID;
	$result=mysqli_query($dbc, $query);
	return $result;
}

function editBird($recordID, $dbc, $array){
	$query="UPDATE birds SET ";
	foreach($array as $column=>$value){
		$query=$query.$column."= '".$value."', ";
	}
	$query=substr($query, 0, -2);
	$query=$query." WHERE birdID=".$recordID;
	$result=mysqli_query($dbc, $query);
	if ($result)
		return TRUE;
	if (!$result)
		return FALSE;
}
?>

