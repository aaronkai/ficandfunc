<?php
include('./Includes/birdsHeader.inc.php');
include('./Includes/dbFunctions.inc.php');

if (isset($_SESSION['userID']))
{
	$_SESSION = array();
	session_destroy();
	setcookie('PHPSESSID', '', time()-3600, '/', '', 0, 0);
	$url=absolute_url('logout.php');
	header("Location: $url"); 
}
?>
<p>You have been logged out.</p>
