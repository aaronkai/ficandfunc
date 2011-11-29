<?php
include('./Includes/birdsHeader.inc.html');
    include('Includes/dbFunctions.inc.php');
    $dbc=dbConnect();
    $member=false;
    if (isset($_POST['submitted'])) //error checking
    {
	$errors= array();

	if(empty($_POST['firstName']))
	    $errors[]='You forgot to enter your first name.';
	else
	    $firstName=trim($_POST['firstName']);

	if(empty($_POST['lastName']))
	    $errors[]='You forgot to enter your last name.';
	else
	    $lastName=trim($_POST['lastName']);
	
	if(empty($_POST['email']))
	    $errors[]='You forgot to enter your email address.';
	else
	{
	    $emailQuerry="SELECT email FROM users";
	    $result=mysqli_query($dbc, $emailQuerry);
	    while ($row= mysqli_fetch_array($result)){ //I see here on p. 248 that this could have been done another way. 
		if ($row['email'] == $_POST['email']){
		    $member=TRUE;
		}
	    }
	    if ($member)
		$errors[]='You are already a member. Please contact us if you need help rememering your username or password. Otherwise, '; 
	    else
		$email=trim($_POST['email']);
	}

	if (empty($_POST['password']) || empty($_POST['confirm']))
	    $errors[]='You did not enter a password.';
	else{
	    if(!empty($_POST['password'])){
		if ($_POST['password'] == $_POST['confirm'])
		    $password=$_POST['password'];
	    else
		$errors[]='Your passwords did not match.';
	    }
	}

    if (empty($errors)){
	//this seems like a stupid way to do this but here we go. Count # of rows before INSERT
	$querryA="select * from users";
	$r= mysqli_query($dbc, $querryA);
	$numBefore=mysqli_num_rows($r);
	//insert user
	$querry="INSERT INTO users (firstName, lastName, email, pass, registrationDate) VALUES ('$firstName', '$lastName', '$email', SHA1('$password'), NOW())";
	$r=mysqli_query ($dbc, $querry);
	//get number of rows after insert
	$r=mysqli_query ($dbc, $querryA);
	$numAfter=mysqli_num_rows($r);
	//check the two against each other.
	if ($numAfter>$numBefore){
	    echo '<div class="message">';
	    echo '<p>Thank You. You have been registered. <br />';
	    echo '<a href="index.php">Go Back</a></p>';
	    echo '</div>';
	    echo '</body>';
	    echo '</html>';
	}
	else
	{
	    echo '<div class="message">';
	    echo ' <h1> System Error</h1> <p>You could not be registered due to a system error. </p>';
	    echo '<p>'.mysqli_error($dbc).'</br> Querry: '.$querry.'</p>';
	    echo '</div>';
	    echo '</body>';
	    echo '</html>';
	}   
	mysqli_close($dbc);
	exit();
    }
    else{
	echo '<div class="message">';
	echo '<h1> Error!</h1>';
	echo '<p> The following errors occured:<br />';
	foreach ($errors as $msg)
	    echo "- $msg<br />\n";
	echo "</p><p>Please try again.</p>";
	echo '</div>';
    }	
}
?>
<!--registration form-->
<form action="registration.php" method="post">
<fieldset>
    <legend>Register Here</legend>
    <p>
    <label for="firstName">First Name:</label>
    <input type="text" placeholder="John" name="firstName" size="15" maxlength="20" value="<?php if(isset($_POST['firstName'])) echo $_POST['firstName']; ?>" id="firstName">
    </p>
    <p>	
    <label for="lastName">Last Name:</label>
    <input placeholder="Doe" type="text" name="lastName" size="15" maxlength="20" value="<?php if(isset($_POST['lastName'])) echo $_POST['lastName']; ?>" id="lastName">
    </p>
    <p>
    <label for="email">Email Address:</label>
    <input placeholder="me@whatever.com" type="text" name="email" size="15" maxlength="80" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" id="email">
    </p>
    <label for="password">Password:</label>
    <input placeholder="secret password" type="password" name="password" size="15" maxlength="20" id="password">
    <p>
    <label for="confirm">Confirm Password:</label>
    <input placeholder="type it again" type="password" name="confirm" size="15" maxlength="20" id="confirm">
    </p>
    <p><input type="submit" name="submit" value="Register"></p>
    <input type="hidden" name="submitted" value="TRUE" />
</fieldset>
</form>
</body>
</div>
</html> 
