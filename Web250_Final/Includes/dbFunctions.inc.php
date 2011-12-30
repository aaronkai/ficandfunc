<?php

# select dbConnect version based on localhost or WebServer
#include ($_SERVER['NFSN_SITE_ROOT'].'protected/Includes/dbConnect.inc.php');
include ('dbConnect.php');

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

//i am contemplating how to introduce a prepared statemtent into this function. Because the function uses and array to create the query, and the length of the array is unknown until the user submits data, it is difficult to write a prepared statement. I am not saying that it cannot be done, but I'm tired and I don't feel reinventing this function. In fact, part of the reason this is hard is because i wrote the function to be generic. I am going to use mysqli_real_escape_string instead for this and the edit function below, as I will demonstrate, (uselessly it would seem to me) that I can write a prepared statement in the delete funcition below. 
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
	{
	$inserts = mysqli_real_escape_string($dbc, $inserts);
		$firstPart=$firstPart."'".strip_tags($inserts)."', ";	
	}	
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
	$query="DELETE FROM birds WHERE birdID=?";
	$stmt = mysqli_prepare($dbc, $query);
	mysqli_stmt_bind_param($stmt, 'i', $recordID);
	mysqli_stmt_execute($stmt);
	if (mysqli_stmt_affected_rows($stmt) == 1)
		$result= true;
	else
		$result=false;
	mysqli_stmt_close($stmt);
	return $result;
}

function editBird($recordID, $dbc, $array){
	$query="UPDATE birds SET ";
	foreach($array as $column=>$value){
		$value= mysqli_real_escape_string($dbc, $value);
		$query=$query.$column."= '".strip_tags($value)."', ";
	}
	$query=substr($query, 0, -2);
	$query=$query." WHERE birdID=".$recordID;
	$result=mysqli_query($dbc, $query);
	if ($result)
		return TRUE;
	if (!$result)
		return FALSE;
}

function handleUploadErrors(){
	//check $_FILES superglobal for errors
	
	if ($_FILES['upload']['error'] > 0) {
		echo '<p class="error">The file could not be uploaded because: <strong>';
	
		// Print a message based upon the error.
		switch ($_FILES['upload']['error']) {
			case 1:
				print 'The file exceeds the upload_max_filesize setting in php.ini.';
				break;
			case 2:
				print 'The file exceeds the MAX_FILE_SIZE setting in the HTML form.';
				break;
			case 3:
				print 'The file was only partially uploaded.';
				break;
			case 4:
				print 'No file was uploaded.';
				break;
			case 6:
				print 'No temporary folder was available.';
				break;
			case 7:
				print 'Unable to write to the disk.';
				break;
			case 8:
				print 'File upload stopped.';
				break;
			default:
				print 'A system error occurred.';
				break;
		} // End of switch.
		
		print '</strong></p>';
		
	} // End of error IF.
	
	// Delete the file if it still exists:
	if (file_exists ($_FILES['upload']['tmp_name']) && is_file($_FILES['upload']['tmp_name']) ) {
		unlink ($_FILES['upload']['tmp_name']);
	}
}

function lightbox($dbc, $birdID){
	$query= "SELECT * FROM birdImages WHERE birdID=".$birdID;
	$result = mysqli_query($dbc, $query);
	/*if($result)
		echo "query ran";
	else 
		echo "query didnt run";*/
	$anchor="";
	$i=0;
	while ($row = mysqli_fetch_array($result)){
		$i+=1;
		$anchor=$anchor.'<a href="../BirdImages/'.$row['fileLocation'].'" rel="lightbox[birdID'.$row['birdID'].']" title="'.$row['description'].'">View Image #'.$i.'</a><br />';
	}
	return $anchor;
}

function absolute_url ($page = 'index.php') {


	// Start defining the URL...
	// URL is http:// plus the host name plus the current directory:
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	
	// Remove any trailing slashes:
	$url = rtrim($url, '/\\');
	
	// Add the page:
	$url .= '/' . $page;
	
	// Return the URL:
	return $url;
}

function check_login($dbc, $email = '', $pass = '') {

	$errors = array(); // Initialize error array.
	
	// Validate the email address:
	if (empty($email)) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($email));
	}
	
	// Validate the password:
	if (empty($pass)) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($pass));
	}

	if (empty($errors)) { // If everything's OK.

		// Retrieve the user_id and first_name for that email/password combination:
		$q = "SELECT userID, firstName FROM users WHERE email='$e' AND pass=SHA1('$p')";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		
		// Check the result:
		if (mysqli_num_rows($r) == 1) {
		
			// Fetch the record:
			$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
			
			// Return true and the record:
			return array(true, $row);
			
		} else { // Not a match!
			$errors[] = 'The email address and password entered do not match those on file.';
		}
		
	} // End of empty($errors) IF.
	
	// Return false and the errors:
	return array(false, $errors);

} // End of check_login() function.
?>

