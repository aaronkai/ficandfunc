<?php
include('Includes/birdsHeader.inc.php');
//Define Variables and import functions
$edits=array();
include('Includes/dbFunctions.inc.php');
// establish db connection
$dbc = dbConnect();

//Create associated array to pass info to function
if (!empty($_POST['submitted']))
{
	foreach($edits as $key => $value)
		echo "$key.'=>'.$value";
	echo $_POST['species'];

	if(!empty($_POST['gName']))
		$edits['nameGeneral']= $_POST['gName'];
	if(!empty($_POST['sName']))
		$edits['nameSpecific']= $_POST['sName'];
	if(!empty($_POST['family']))
		$edits['family']= $_POST['family'];
	if(!empty($_POST['species']))
		$edits['species']= $_POST['species'];
	if(!empty($_POST['genus']))
		$edits['genus']= $_POST['genus'];
	if(!empty($_POST['popTrend']) AND $_POST['popTrend'] != "-") 
		$edits['populationTrend']= $_POST['popTrend'];
	if(!empty($_POST['notes']))
		$edits['Notes']= $_POST['notes'];

	if(!empty($edits))
	{
		$result = editBird($_POST['id'], $dbc, $edits);
		if ($result){
			echo "<p>Data updated successfully.</p>";
			echo '<a href="index.php">Return Home</a>';
			die();
		}
		else{
			echo "<p>There was a problem updating the data.</p>";
			echo '<a href="index.php">Return Home</a>';
			die();
		}
	}
}	
else
?>
	<fieldset id="forms">
	<legend>Edit a bird in the database</legend>
	<form method="post" action="editBird.php">
		<p>
		<label for="gName">General Name: </label>
		<input type="text" size="20" id="gName" value="<?php if(isset($_POST['gName'])) echo $_POST['gName']; ?>" name="gName" placeholder="<?php  if(isset($_GET['gName']))echo $_GET['gName']; ?>" />
		</p>
		
		<p>
		<label for="sName">Specific Name: </label>
		<input type="text" size="20" id="sName"  value="<?php if(isset($_POST['sName'])) echo $_POST['sName']; ?>" name="sName"  placeholder="<?php if(isset($_GET['sName']))echo $_GET['sName']; ?>"/>
		</p>
			
		<p>
		<label for="genus">Genus: </label>
		<input type="text" size="20" id="genus" value="<?php if(isset($_POST['genus'])) echo $_POST['genus']; ?>" name="genus" placeholder="<?php if(isset($_GET['genus']))echo $_GET['genus']; ?>" />
		</p>

		<p>
		<label for="species">Species: </label>
		<input type="text" size="20" id="species" value="<?php if(isset($_POST['species'])) echo $_POST['species']; ?>" name="species"  placeholder="<?php if(isset($_GET['species']))echo $_GET['species']; ?>" />
		</p>
		
		<p>
		<label for="family">Family: </label>
		<input type="text" size="20" id="family" value="<?php if(isset($_POST['family'])) echo $_POST['family']; ?>" name="family"  placeholder="<?php if(isset($_GET['family']))echo $_GET['family']; ?>" />
		</p>

		<p>
		<label for="popTrend"> Population Trend: </label>

		<?php                                            //create drop down menu
		if (isset($_GET['popTrend']))
			$selected=$_GET['popTrend'];
		else 
			$selected="";

		$popTrends[]="-";
		$popTrends[]="Increasing";
		$popTrends[]="Decreasing";
		$popTrends[]="Stable";
		
		echo '<select name="popTrend" id="popTrend">';
		foreach ($popTrends as $trend){
			echo '<option value="'.$trend.'"';
			if ($selected==$trend)
				echo 'selected="selected">'.$trend.'</option>';
			else 
				echo '>'.$trend.'</option>';
			}	
		echo "</select>";
		?>

		</p>
		<p>
		<label for="notes">Notes</label>
		<textarea rows="10" cols="50" name="notes" id="notes" placeholder="<?php if (isset($_GET['notes'])) echo $_GET['notes']; ?>"></textarea>
		</p>
		<p>	
		<input type="hidden" name="submitted" value="TRUE" />	
		<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
		</p>
		<p>
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
