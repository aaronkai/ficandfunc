<?php # Script 10.3 - upload_image.php

//include error handler
include('Includes/birdsHeader.inc.php');
include('Includes/dbFunctions.inc.php');

// Check if the form has been submitted:
if (isset($_POST['submitted'])) {

	// Check for an uploaded file:
	if (isset($_FILES['upload'])) {
		
		// Validate the type. Should be JPEG or PNG.
		$allowed = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png');
		if (in_array($_FILES['upload']['type'], $allowed)) {
		
			// Move the file over.
			if (move_uploaded_file ($_FILES['upload']['tmp_name'], "../BirdImages/{$_FILES['upload']['name']}")) {
				echo '<p><em>The file has been uploaded! The database has been updated!</em></p>';

			//Aaron's added code to communicate with SQL
			#echo $_POST['id'];
			$id = $_POST['id']; 
			#echo $_POST['description'];
			$description = strip_tags($_POST['description']);
			#echo $_FILES['upload']['name'];
			$fileLocation = $_FILES['upload']['name'];

			$dbc = dbConnect();
			if(!$dbc)	
				echo "Could not establish dbc";
			
			$query = "INSERT INTO birdImages (birdID, fileLocation, description) VALUES ('$id', '$fileLocation', '$description')";
			$result = mysqli_query($dbc, $query);
			
			/*if($result)
				echo "query ran";
			else
				echo "query didn't run";
			*/
			mysqli_close($dbc);
			//link to bird database after image is uploaded
			echo "<p><a href='index.php'>Go back to Birds Database</a></p>";
			} // End of move... IF.
			
		} else { // Invalid type.
			echo '<p class="error">Please upload a JPEG or PNG image.</p>';
		}

	} // End of isset($_FILES['upload']) IF.
	
	// Check for an error:
	handleUploadErrors();
			
} // End of the submitted conditional.
?>
	
<form enctype="multipart/form-data" action="fileUpload.php" method="post">

	<input type="hidden" name="MAX_FILE_SIZE" value="524288">
	
	<fieldset><legend>Select a JPEG or PNG image of 512KB or smaller to be uploaded:</legend>
	<p><b>File:</b> <input type="file" name="upload" /></p>
	<p><label for="description">Image Description: </label><textarea cols="45" rows="5" id = "description" name="description"></textarea> </p>
	<input type="hidden" name="id" value=<?php if(isset($_GET['id'])) echo $_GET['id']; if(isset($_POST['id'])) echo $_POST['id']; ?> />	
	</fieldset>
	<input type="submit" name="submit" value="Submit" />
	<input type="hidden" name="submitted" value="TRUE" />
</form>
</body>
</html>
<?php include('Includes/birdsFooter.inc.php'); ?>
