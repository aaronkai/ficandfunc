<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php 
ob_start();
session_start(); 
?>

<html lang="en-US" xml:lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo"$page_title"; ?></title>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="js/lightbox.js"></script>

<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />

<link rel="stylesheet" href="Styles/bird.css" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Monofett' rel='stylesheet' type='text/css'>

</head>

<body>
<div id="wrapper">
	<h1><a href="birdsPagination.php">Bird Database</a></h1>
	
<div id='navbar'>
	<?php 
	echo "<a href='index.php'>Home</a>";
	if (isset($_SESSION['firstName'])) 
		echo "<a href='logout.php'>Logout</a>";
		echo "<a href='addBird.php'>Add a Bird</a>";
		echo "<a href='changePassword.php'>Change Password</a>";
	{	echo "<a href=''>Welcome, ".$_SESSION['firstName']."</a>";
	}
	?>
</div> 
