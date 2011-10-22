<!--
File: addBird.php
Author: Aaron Hubbard
Date: 10/22/2011
Description: form to add a bird
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html lang="en-US" xml:lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Template</title>
</head>

<body>
<?php
//Define Variables
$errors=array();

//Check for empty fields

if (!empty($_POST['submitted']))
{
	if(empty($_POST['gName']))
		$errors[]= "<p>You must enter a General Name</p>";
	if(empty($_POST['family']))
		$errors[]="<p>You must enter a Family</p>";
	if(!isset($_POST['species']))
		$errors[]="<p>You must enter a Species</p>";
	if(!isset($_POST['genus']))
		$errors[]="<p>You must enter a Genus</p>";
	if(empty($_POST['popTrend']) OR $_POST['popTrend'] == "-")
		$errors[]="<p>You must enter a Population Trend</p>";
	
	if(!empty($errors))
	{
	echo '<div class="message">';
	echo '<h1> Error!</h1>';
	echo '<p> The following errors occured:</p>';
	foreach ($errors as $msg)
	    echo "$msg";
	echo "<p>Please try again.</p>";
	echo '</div>';
	}
}
else{
	//submit data to function
}

?>
	<h1> Bird Database</h1>
	<fieldset>
	<legend>Enter a bird into the database</legend>
	<form method="post" action="addBird.php">
		<p>
		<label for="gName">General Name: </label>
		<input type="text" size="20" id="gName" value="<?php if(isset($_POST['gName'])) echo $_POST['gName']; ?>" name="gName"/>*
		</p>
		
		<p>
		<label for="sName">Specific Name: </label>
		<input type="text" size="20" id="sName"  value="<?php if(isset($_POST['sName'])) echo $_POST['sName']; ?>" name="sName" />
		</p>
			
		<p>
		<label for="genus">Genus: </label>
		<input type="text" size="20" id="genus" value="<?php if(isset($_POST['genus'])) echo $_POST['genus']; ?>" name="genus" />*
		</p>

		<p>
		<label for="species">Species: </label>
		<input type="text" size="20" id="species" value="<?php if(isset($_POST['species'])) echo $_POST['species']; ?>" name="species" />*
		</p>
		
		<p>
		<label for="family">Family: </label>
		<input type="text" size="20" id="family" value="<?php if(isset($_POST['family'])) echo $_POST['family']; ?>" name="family" />*
		</p>

		<p>
		<label for="popTrend"> Population Trend: </label>

		<?php
		if (isset($_POST['popTrend']))
			$selected=$_POST['popTrend'];
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
		<textarea rows="10" cols="50" name="notes" id="notes" ><?php if(isset($_POST['notes'])) echo $_POST['notes']; ?></textarea>
		</p>
		<p>	
		<input type="hidden" name="submitted" value="TRUE" />	
		</p>
		<p>
		<input type="submit" value="Submit" />
		<input type="reset" value="Reset" />
		</p>
		<p>(Asterisk indicated a required field) </p>
	</form>
	</fieldset>
</body>

</html> 
