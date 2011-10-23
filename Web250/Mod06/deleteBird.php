<!--
File: deleteBird.php
Author: Aaron Hubbard
Date: 10/22/2011
Description: form to delete a bird
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html lang="en-US" xml:lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Template</title>
</head>

<body>
<?php
//Define Variables and import functions
$errors=array();
include('Includes/dbFunctions.inc.php');
// establish db connection
$dbc = dbConnect();

//Check for empty fields
if (!empty($_POST['submitted']))
{
	if($_POST['confirm']=="TRUE"){
		$result = deleteBird($_POST['recordID'], $dbc);
		if ($result){
			echo "<p>Selection has been Deleted.<br /><a href='birdsPagination.php'>Return Home</a></p>";
			die();
		}
		if (!$result){
			echo "There was a problem completing your request. <br /> <a href='birdsPagination.php'>Return Home</a></p>";	
			die();
		}
	}
	else	
	{
		echo '<p>Deletion was canceled.</p><a href="birdsPagination.php">Return Home</a>';
		die();
	}
}	
?>
	<h1> Bird Database</h1>
	<fieldset>
	<legend>Delete a bird in the database</legend>
	<form method="post" action="deleteBird.php">
		<p>Are you sure you want to delete 
			<?php 	print($_GET['sName']." ");
				print( $_GET['gName']);
			 ?>

		?
		<br />
		<input type="radio" name="confirm" value="TRUE"/>Yes
		<input type="radio" name="confirm" value="FALSE" />No
		</p>	
		<p>
		<input type="hidden" name="submitted" value="TRUE" />	
		<input type="hidden" name="recordID" value="<?php echo $_GET['id']; ?>">
		<input type="submit" value="Submit" />
		<input type="reset" value="Reset" />
		</p>
	</form>
	</fieldset>
</body>

</html> 
