<?php
/*-------------------------------------------
FILE PURPOSE

This file processes data for new photosets uploaded via the new_photoset.php file.

The file includes error checking for the html form  fields in new_photoset.php, but my html forms have 'required' at the end as the first error check.

I can't figure out how to the html form from processing the file before checking if the file is of the appropriate size or not, so
for now I am just providing a warning message to the user in video_upload.php if the file size is too large.

This file won't allow an image upload larger than 4.60 MB (4,827,360 bytes). My php.ini configuration file is also limiting the max file size upload to ~1GB.

This file gets kind of confusing, so here's a full breakdown of whats happening:

Prepare to enter a new row in to the PHOTO_SETS table.
(a) Checks if the cover photo file is under 4.60 MB.
(b) If the file is under 4.6 MB, then begin the process of entering a new row in to the 'photoset' database table:
(c) Gather the POST data from the form and store them in variables: 
	The category for the photo set will be used in both the 'photo_sets' table and the 'photo' table. 
	There's a separate field for the title of the photoset and the title of the cover image.
(d) Create sql query statement with placeholders for the values that will be inserted in to the new 'photo_sets' table row.
(e) Initializes a database connection statement - returns an object for use with mysqli_stmt_prepare.
(f) Prepare the sql query statement for execution.
(g) Bind POST variables to the prepared statement as parameters.
(h) Execute the query to insert new row in to the 'photo_sets' database table.
(i) Set the the variable that provides feedback to the user. Assign the $last_photoset_id variable the ID (primary key) of the row that was just inserted in to the database.

....

Prepare to enter a new row in to the PHOTO table.
(j) Determine the file name and extension for the photograph; the category will be the same category that was used when inserting the new row in to the 'photo_sets' table.
(h) The photoset to which this new image belongs will be assigned using the $last_photoset_id variable. Set the 'photoset_ID' column for this new image equal to this value. 
(i) Execute error checking to ensure that the image is of the proper file type.
(j) Insert a new row in to the 'photo' table using a prepared statement. 

/*------------------------------------------*/

// database connection file
include("connect.php");

// if the user is not logged in, then redirect the user away to the login page before executing any more of this file
if(!isset($_SESSION['username'])) {
	header("location: login");
	exit();
}
		
?>

<?php 
// initialize the variable for displaying errors on video_upload to the user
$user_messages = '';

// IF block 1
// check if the form from new_photoset.php has been submitted or not
if(isset($_POST['submit'])) {
	// database connection file
	include("connect.php");

	// don't allow files over 4.60 MB (4,827,360 bytes) to be uploaded for the cover photo of a photo set
	if($_FILES['file']['size'] > 4827360){

		$user_messages = '<br/>File too large.';

	// FILE SIZE ELSE
	} else {
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//// EVERYTHING BELOW HERE DEALS CREATING A NEW ENTRY FOR A PHOTOSET IN THE 'photo_sets' TABLE, BUT IT DOES NOT PROCESS THE COVER PHOTO ITSELF  ////
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		// CREATE THE PHOTOSET TABLE ENTRY
		$photoset_title = mysqli_real_escape_string($dbcon, $_POST['photoset_title']);
		$photoset_category = mysqli_real_escape_string($dbcon, $_POST['category']);
		$photoset_display = mysqli_real_escape_string($dbcon, $_POST['display']);
		$photoset_description = mysqli_real_escape_string($dbcon, $_POST['description']);
		$date = date("Y-m-d");
		$last_updated = $date;
		$cover_photo = $_FILES['file']['name']; // the file name for the photoset cover image

		$sql = "INSERT INTO photo_sets (title, category, cover_photo, display_hide, description, date_created, last_updated) VALUES (?,?,?,?,?,?,?);";
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
		mysqli_stmt_bind_param($stmt, "sssisss", $photoset_title, $photoset_category, $cover_photo, $photoset_display, $photoset_description, $date, $last_updated);

		// executes a prepared query (returns a TRUE or FALSE)
		mysqli_stmt_execute($stmt);

		$user_messages = "<br/>Photoset set data sent.<br/>";
		//  grab the ID for the photo set that was just created in the 'photo_sets' table so that it may be used while inserting the photograph in to the 'photo' table
		$last_photoset_id = mysqli_insert_id($dbcon);

		}

		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// EVERYTHING BELOW HERE DEALS WITH INSERTING THE INFORMATION FOR THE COVER PHOTO FOR THE PHOTOSET IN TO THE DATABASE & UPLOADING THE FILE ITSELF //
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		// $_FILES is an associative array of items  that contains several pieces of 
		$name= $_FILES['file']['name'];

		// get the file type extension 
		$position= strpos($name, "."); 
		$fileextension= substr($name, $position + 1);
		$fileextension= strtolower($fileextension);

		// get data from the submitted form for inserting the photo
		$title = mysqli_real_escape_string($dbcon, $_POST['title']);
		$category = $photoset_category;
		//  convert the id for the photo set that was just created before using it in the insert statement for the 'photo' table
		$photoset_ID = $last_photoset_id;

		$tmp_name= $_FILES['file']['tmp_name'];

		// IF block 2
		// error check to make sure that the title, video summary and category field have been filled in
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
						// Query statement to insert all of the data for the submitted video file in to the 'video' database table
						$sql = "INSERT INTO photo (name, title, category, filedate, photoset_ID) VALUES (?,?,?,?,?);";
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
							//
							mysqli_stmt_bind_param($stmt, "ssssi", $name, $title, $category, $date, $photoset_ID);

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
		} else $user_messages= '<br/>Please enter photoset data.<br/>';
	// END FILE SIZE ELSE
	}
// IF block 1 close	
} else { 
	$user_messages = '<br/>Select a file to upload. Title and category are required.<br/>';
}
?>
