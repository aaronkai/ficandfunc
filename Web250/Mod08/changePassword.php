<?php
include('./Includes/birdsHeader.inc.php');
include('./Includes/dbFunctions.inc.php');

if (!empty($_POST['submitted']))
{
	$dbc=dbConnect();
	$query = "Select pass from users where userID=".$_SESSION['userID'];
	$result = mysqli_query($dbc, $query);
	if (!$result)
		echo "problem with the query, bro";
	else
	{
		$row=mysqli_fetch_array($result);
		$password=$row['pass'];
		if ($password != SHA1($_POST['current']))
			$errors[]="ERROR: The original passwords did not match";
		else
		{
			if($_POST['pass1'] != $_POST['pass2'])
				$errors[]="ERROR: The new passwords must match";
			else
			{
				$newPassword=$_POST['pass1'];
				$uid=$_SESSION['userID'];
				$query="UPDATE users SET pass=SHA1('$newPassword')  WHERE userID=$uid LIMIT 1";
				$r = mysqli_query($dbc, $query);
				if ($r)
					echo "<p>Your password has been changed.</p>";
				else
					echo "problem with query, bro";

			}	
		}
	}
}
if (!empty($errors))
{
	foreach ($errors as $error);
		echo $error;
}
?>

<fieldset id ="forms">
	<legend>Change Password</legend>
	<form action="changePassword.php" method="post">
		<p><label for="current">Current Password: </label> <input type="password" size="15" name="current" id="current"/></p>
		<p><label for="pass1">New Password: </label> <input type="password" size="15" name="pass1" id="pass1"/></p>
		<p><label for="pass2">Retype New Password: </label> <input type="password" size="15" name="pass2" id="pass2"/></p>
		<input type="hidden" name="submitted" value="true" />
		<input type="submit" value="Change Password" />		
	</form>
</fieldset>


<?php
include('./Includes/birdsFooter.inc.php');
?>
