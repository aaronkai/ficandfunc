<?php #Script birdsPagination.php
$page_title="birdsPagination.php";

include('./Includes/birdsHeader.inc.html');
include ('Includes/dbFunctions.inc.php');

$dbc = dbConnect();
$display = 10;
if (!isset($_GET['dir']))
$dir = "";
else
	$dir= $_GET['dir'];

	
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

//define sort variable
$sort=(isset($_GET['sort'])) ? $_GET['sort'] : 'generalName';

//determine sorting order
switch ($sort) {
		case 'generalName':
			$order_by = 'nameGeneral ';
			break;
		case 'specificName':
			$order_by = 'nameSpecific ';
			break;
		case 'populationTrend':
			$order_by = 'populationTrend ';
			break;
		case 'notes':
			$order_by = 'notes ';
			break;
		default:
			$order_by = 'nameGeneral ';
			//$sort = 'generalName';
			break;
	}
	
//Make the querry
$q="SELECT birdID, nameGeneral, nameSpecific, genus, family, species, populationTrend, notes FROM birds ORDER BY $order_by $dir LIMIT $start, $display";
$r=mysqli_query($dbc,$q);

if (!$r) {
echo "<h1>problem with query</h1>";
} else {

$current_page=($start/$display) + 1;

//set $dir to proper value before making table
if ($dir=="")
	$dir= "ASC";
else
$dir=$_GET['dir'];


	
echo "<div id='main'>";
echo "<div id='table'>";

//display arrows based on value of $dir
if ($dir=='DESC')
	echo '<img src="Images/downArrow.png" alt="a down arrow" class="arrow" />';
if ($dir=='ASC')
	echo '<img src="Images/upArrow.png" alt="a up arrow" class="arrow" />';

//anchor to add an image
echo "<p><a href='fileUpload.php'>Add an Image</a></p>";
	
//table headings and create variables: sort, s, and p, and dir. Also toggle sort order
echo"<table><tr>
		<th></th>
		<th><a href='birdsPagination.php?sort=generalName&amp;dir=".(($sort != 'generalName')? 'ASC' : (($dir=='ASC')? 'DESC' : 'ASC'))."'>General Name</a></th>
		<th><a href='birdsPagination.php?sort=specificName&amp;dir=".(($sort != 'specificName')? 'ASC' : (($dir=='ASC')? 'DESC' : 'ASC'))."'>Specific Name</a></th>
		<th><a href='birdsPagination.php?sort=populationTrend&amp;dir=".(($sort != 'populationTrend')? 'ASC' : (($dir=='ASC')? 'DESC' : 'ASC'))."'>Population Trend</a></th>
		<th><a href='birdsPagination.php?sort=notes&amp;dir=".(($sort != 'notes')? 'ASC' : (($dir=='ASC')? 'DESC' : 'ASC'))."'>Notes</a></th>
		<th>Upload a Photo</th>
		<th>View Bird Photos</th></tr>";
}

	
//fetch and print records;
$bg='#dddddd'; //set initial background color
while ($row=mysqli_fetch_array($r, MYSQLI_ASSOC))
{
	$bg = ($bg == '#dddddd' ? '#ffffff' : '#dddddd'); //switch color;
	echo '<tr bgcolor="'.$bg.'">	<td> 	<a href="editBird.php?id='.$row['birdID'].'  
							&amp;gName='.$row['nameGeneral'].'
							&amp;sName='.$row['nameSpecific'].'
							&amp;popTrend='.$row['populationTrend'].'
							&amp;notes='.$row['notes'].'
							&amp;genus='.$row['genus'].'
							&amp;species='.$row['species'].'
							&amp;family='.$row['family'].'">Edit</a>
							
						<a href="deleteBird.php?id='.$row['birdID'].'
							&amp;gName='.$row['nameGeneral'].'
							&amp;sName='.$row['nameSpecific'].'
							&amp;popTrend='.$row['populationTrend'].'
							&amp;notes='.$row['notes'].'">Delete</a></td>
					<td>'.$row['nameGeneral'].'</td>
					<td>'.$row['nameSpecific'].'</td>
					<td>'.$row['populationTrend'].'</td>
					<td>'.$row['notes'].'</td>
					<td><a href="fileUpload.php?id='.$row['birdID'].'">Upload a Photo</a></td>
					<td><a href="">View Photos</a></td></tr>';
}

echo '</table>';
echo '</div>'; //end table
mysqli_free_result($r);
mysqli_close($dbc);

echo '<div id="links">';
echo '<div id="linksInner">';
echo '<h3>Page Navigigation</h3>';
//make links to other pages, if necessary
if($pages >1){
	//determine what page script is on
	$current_page=($start/$display) + 1;
	//if not first page make previous button 

	echo previousButton($current_page, $start, $display, $pages, $sort, $dir);
	
	
	//make the numbered page links
	
	$pageNumbers=makePageNumberLinks($current_page, $display, $pages, $sort, $dir);
	foreach ($pageNumbers as $value)
		echo "$value";
	
	//if it is not the last page, make the next button
	echo nextButton($current_page, $start, $display, $pages, $sort, $dir);
	
}
echo "</div>"; //end linksInner;
echo '<img src="Images/bird.png" id="bird" alt="birds in profile"/>';
echo "</div>"; //end links


echo '</div>'; //end main
echo '<br />';

include ('./Includes/birdsFooter.inc.html');

?>
