<?php
//Define Variables and import functions
include('Includes/birdsHeader.inc.php');
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
			echo "<p>Selection has been Deleted.<br /><a href='index.php'>Return Home</a></p>";
			die();
		}
		if (!$result){
			echo "There was a problem completing your request. <br /> <a href='index.php'>Return Home</a></p>";	
			die();
		}
	}
	else	
	{
		echo '<p>Deletion was canceled.</p><a href="index.php">Return Home</a>';
		die();
	}
}	
?>
	<fieldset id="forms">
	<legend>Delete a bird in the database</legend>
	<form method="post" action="deleteBird.php">
		<p>Are you sure you want to delete 
			<?php 	print($_GET['sName']." ");
				print( $_GET['gName']);
			 ?>

		?
		<br />
		<input type="radio" name="confirm" value="TRUE" id="yes"/><label for="yes">Yes</label>
		<input type="radio" name="confirm" value="FALSE" id="no"/><label for="no">No</label>
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
<?php
include('Includes/birdsFooter.inc.php');
?>
