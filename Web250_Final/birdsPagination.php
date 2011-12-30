<?php #Script birdsPagination.php
$page_title="Bird Database";

include('./Includes/birdsHeader.inc.php');
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
if (empty($_POST['search']))
	$q="SELECT birdID, nameGeneral, nameSpecific, genus, family, species, populationTrend, notes FROM birds ORDER BY $order_by $dir LIMIT $start, $display";
else
	//run search query if post_search is not empty
	$q="SELECT birdID, nameGeneral, nameSpecific, genus, family, species, populationTrend, notes FROM birds WHERE nameGeneral LIKE '".$_POST['search']."%' ORDER BY $order_by $dir LIMIT $start, $display";

$r=mysqli_query($dbc,$q);

if (!$r) {
echo "<h1>problem with query</h1>";
} 

else {

$current_page=($start/$display) + 1;

//set $dir to proper value before making table
if ($dir=="")
	$dir= "ASC";
else
$dir=$_GET['dir'];

echo "<div id='main'>";
//start building web page ********************************************

//right column------------------------------------------------
echo '<div id="column_right">';

//include search function
include('Includes/search.inc.php');

//include admin contact via email
echo "<p><a href='email.php' id='emailAnchor'>Send an email to the site administrator</a></p>";

//if user is not logged in, display login area
if (empty($_SESSION['userID']))
{
	include('./Includes/login.inc.html');
}

echo '</div>'; //end column_right----------------------------------

//create session data
if(!empty($_POST['login']))
{
	list($check, $data) = check_login($dbc, $_POST['email'], $_POST['password']);
	if ($check)
	{
		$_SESSION['userID'] = $data['userID'];
		$_SESSION['firstName'] = strip_tags($data['firstName']);
		$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
		$url = absolute_url('index.php');
		header("Location: $url");
		exit();
	}
	else
	{
		foreach ($data as $error)
			echo "<p>$error</p>";
	}
}


//left column-----------------------------------------------------
echo '<div id="column_left">';

//if user is not logged in, display generic table
if (empty($_SESSION['userID']))
{
	include('./Includes/genericTable.inc.php');
}

//otherwise display member table
else{
	//check for session session hijacking
	if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT']) ))
	{
		echo "<p>Whoa! Whats going on here. Lets <a href='index.php'>Start Over</a></p>";
	}
	else
	{
		include ('./Includes/memberTable.inc.php');
	}
}

echo '<div id="links">';
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
echo "</div>"; //end links
echo '</div>'; //end column_left----------------------------------
echo '</div>'; //end main

include ('./Includes/birdsFooter.inc.php');
}
?>
