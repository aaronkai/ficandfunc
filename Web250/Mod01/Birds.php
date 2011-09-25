<?php 
	include ('./Includes/header.inc.html');
	include ('./Includes/myFunctions.inc.php');
?>

<!--
File: Birds.php
Author: Aaron Hubbard
Date: 8/21/2011
Description: Chapter 1 assignment
-->

<?php
	if (!isset($_POST['submitted'])){
		$birds=getbirds();
		sort($birds);
		if (!is_array($birds))
			echo $birds;
		else{
		echo '<form action="Birds.php" method="post">'; 
		echo'<p><select name="bird">';
		foreach ($birds as $value)
			echo "<option value=\"$value\">$value</option>";
		echo '</select></p>';
		echo '<p><input type="hidden" name="submitted" value="TRUE" /></p>';
		echo '<p><input type="submit" value="Submit" /></p>';
		echo '</form>';
		}
	}
	else
		{
		$userSelection=$_POST['bird'];
		print $userSelection;
	}
?>

</body>
</html> 
