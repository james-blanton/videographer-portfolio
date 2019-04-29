<?php
/*-------------------------------------------
FILE PURPOSE

This file includes error checking for the fields, but my html forms have 'required' at the end as the first error check.
I can't figure out how to the html form from processing before checking if the file is of the appropriate size or not, so
for now I am just providing a warning message to the user in video_upload.php if the file size is too large.

This file won't allow an image uploade larger than 4.60 MB (4,827,360 bytes).

My php.ini configuration file is limiting the max file size upload to ~1GB.

/*------------------------------------------*/

// database connection file
include("connect.php");

// Function to ensure that the user is logged in as an admin. This function can be found in header.php.
loginCheck();
		
?>

<?php 
// initialize the variable for displaying errors on video_upload to the user
$user_messages = '';

// IF block 1
// check if the form from video_upload has been submitted or not
if(isset($_POST['submit'])) {
	// initialize the variable for displaying errors on video_upload to the user
	$user_messages = '';

	// database connection file
	include("connect.php");

	// don't allow files over 4.60 MB (4,827,360 bytes) to be uploaded
	if($_FILES['file']['size'] > 4827360){

	$user_messages = '<br/>File too large.';

	// FILE SIZE ELSE
	} else {

		// place data obtained from the form in to more usable variables
		$title = mysqli_real_escape_string($dbcon, $_POST['title']);
		$category = mysqli_real_escape_string($dbcon, $_POST['category']);
		$photoset_ID = mysqli_real_escape_string($dbcon, $_POST['photoset']);
		$date = date("Y-m-d");
		$display = mysqli_real_escape_string($dbcon, $_POST['display']);

		// if no photoset is selected in the form, then set the photoset_ID variable row to NULL
		if($_POST['photoset'] == "NULL"){$photoset_ID = NULL;}

		// $_FILES is an associative array of items  that contains several pieces of 
		$name= $_FILES['file']['name'];

		// get the file type extension 
		$position= strpos($name, "."); 
		$fileextension= substr($name, $position + 1);
		$fileextension= strtolower($fileextension);
		$tmp_name= $_FILES['file']['tmp_name'];

		// IF block 2
		// error check to make sure that the title and category field have been filled in
		if (($_POST['title'] !== '') && ($_POST['category'] !== '')){

			// check if the file has been selected for upload with the html form
			if (isset($name)) {

				// set the path for what directory the photo file will be stored in after upload
				$path= '../photo/';

				// check the file extension and exit the file if the file type is not appropriate
				if (($fileextension !== "jpeg") && ($fileextension !== "jpg") && ($fileextension !== "png"))
				{
					$user_messages = "The file extension must be .jpeg .jpg, or .png in order to be uploaded";
					exit();
				}

				// IF block 4
				// else if ... the file type MUST be appropriate at this point, but this is a good secondary security check
				else if (($fileextension == "jpeg") || ($fileextension == "jpg") || ($fileextension == "png"))
				{
					// IF block 5
					// check if the file was successfully uploaded or not & if it has been, then insert the information on the file in to the database
					// if the upload fails for some reason, then display an error to the user
					if (move_uploaded_file($tmp_name, $path.$name)) 
					{
						$user_messages = '<br/>Uploaded!<br/>';
						// Query statement to insert all of the data for the submitted photo file in to the 'photo' database table
						$sql = "INSERT INTO photo (name, title, category, filedate, photoset_ID, display_hide) VALUES (?,?,?,?,?,?);";
						// initializes a statement and returns an object for use with mysqli_stmt_prepare
						$stmt  = mysqli_stmt_init($dbcon);

						// procedural style prepare statement
						// prepare an sql statement for execution
						// The query used here must be a string. It must consist of a single SQL statement.
						// mysqli_statement_prepare returns TRUE or FALSE
						if(!mysqli_stmt_prepare($stmt, $sql)){

							$user_messages = "ERROR: Could not able to execute sql. " . mysqli_error($dbcon);

						} else {
							// binds variables to a prepared statement as parameters
							// s = corresponding variable has type string
							// i = 	corresponding variable has type integer
							mysqli_stmt_bind_param($stmt, "ssssii", $name, $title, $category, $date, $photoset_ID, $display);

							// executes a prepared query (returns a TRUE or FALSE)
							mysqli_stmt_execute($stmt);

							$user_messages = "<br/>Photo uploaded and data sent.<br/>";

						}

					// IF block 5 close
					} else $user_messages = '<br/>File upload failed.<br/>';

				// IF block 4 close
				}

			// IF block 3 close
			}

		// IF block 2 close
		} else $user_messages= '<br/>Please enter photo data.<br/>';
	// END FILE SIZE ELSE
	}
// IF block 1 close	
} else { 
	$user_messages = '<br/>Select a file to upload. Title and category are required.<br/>';
}
?>
