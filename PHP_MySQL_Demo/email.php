<?php
include("Includes/birdsHeader.inc.php");

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
/*
Name: is_valid_email_address
Desc: This function is from the PHP Cookbook
*/
function is_valid_email_address($email){
		$qtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
		$dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
		$atom = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c'.
			'\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
		$quoted_pair = '\\x5c[\\x00-\\x7f]';
		$domain_literal = "\\x5b($dtext|$quoted_pair)*\\x5d";
		$quoted_string = "\\x22($qtext|$quoted_pair)*\\x22";
		$domain_ref = $atom;
		$sub_domain = "($domain_ref|$domain_literal)";
		$word = "($atom|$quoted_string)";
		$domain = "$sub_domain(\\x2e$sub_domain)*";
		$local_part = "$word(\\x2e$word)*";
		$addr_spec = "$local_part\\x40$domain";
		return preg_match("!^$addr_spec$!", $email) ? 1 : 0;
}

if (is_valid_email_address('cal@example.com')) {
   print 'cal@example.com is a valid e-mail address';
} else {
   print 'cal@example.com is not a valid e-mail address';
}


/* The function takes one argument: a string.
* The function returns a clean version of the string.
* The clean version may be either an empty string or
* just the removal of all newline characters.
*/
function spam_scrubber($value) {

	// List of very bad values:
	$very_bad = array('to:', 'cc:', 'bcc:', 'content-type:', 'mime-version:', 'multipart-mixed:', 'content-transfer-encoding:');
	
	// If any of the very bad strings are in 
	// the submitted value, return an empty string:
	foreach ($very_bad as $v) {
		if (stripos($value, $v) !== false) return '';
	}
	
	// Replace any newline characters with spaces:
	$value = str_replace(array( "\r", "\n", "%0a", "%0d"), ' ', $value);
	
	// Return the value:
	return trim($value);

} // End of spam_scrubber() function.

	// Clean the form data:
	$scrubbed = array_map('spam_scrubber', $_POST);

// End of Functions
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(isset($_POST['submitted'])) {

// minimal form validation
if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['comments'])) {
	// create the body
	$body = "Name: {$scrubbed['name']}\n\nComments:{$scrubbed['comments']}";
	// no longer than 70 chars
	$body = wordwrap($body, 70);
	// Send it
	mail('abhorrentaaron@gmail.com','Contact form submission', $body, "From: {$scrubbed['email']}");
	echo "<p>Thanks. Your email has been sent</p>";
	// make it so the form is not sticky
	$scrubbed[] = array();
}	else	{
			echo "<p>Please fill out the form completely</p>";
	}
} // end of main isset

// create HTML	
?>

<p>Please fill out this form to contact me.</p>
<form action="email.php" method="post">
<p>Name: <input type="text" name="name" size="30" maxlength="60" 
				value="<?php if(isset($_POST['name'])) echo $_POST['name'];?>"/></p>
				
<p>Email: <input type="text" name="email" size="30" maxlength="60" 
				value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>"/></p>
				
<p>Comments:	<textarea name="comments" rows="5" cols="30">
				<?php if(isset($_POST['comments'])) echo $_POST['comments'];?></textarea></p>
<p>
<input type="submit" name="submit" value="Send" />
</p>
<input type="hidden" name="submitted" value="TRUE" />
</form>
<?php include("Includes/birdsFooter.inc.php"); ?>
