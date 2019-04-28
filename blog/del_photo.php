<?php
/*-------------------------------------------
FILE PURPOSE

This file is meant to delete an existing entry in the 'photo' table related to a photographic image upload. It also deletes the files itself from a "photo" directory found within the root directory.

This file may not be accessed if the user is not logged in to an account.

Keep in mind that currently anyone who has an account in the database can access this file.
This file is executed on the admin dashboard page when a "delete" link is clicked, but this page itself does not actually display anything to the user.

I need to improve the error display at the bottom of this file. Right now I haven't set a direct location for this error display text. 

I included a redirect function in this file that is exclusive to this file, but I could and should go ahead and use it in other files as well

/*------------------------------------------*/

include("../header.php");

// database connection file
include("connect.php");

// Function to check that the id gathered from the url is valid. This function can be found in header.php.
$id = $_GET['id'];
idCheck($id);

// Function to ensure that the user is logged in as an admin. This function can be found in header.php.
loginCheck();

// check if the photo ID has been recieved from the url or not
// if the url has been recieved, then perform the delete
if(isset($_GET['id'])) {
	// object oriented style prepare statement to determine the file name for the video that has this unique id in the database
	$stmt = $dbcon->prepare("SELECT name FROM photo WHERE id = ?");
	// binds variables to a prepared statement as parameters
	$stmt->bind_param("i", $id);
	// executes a prepared query
	$stmt->execute();
	// transfers a result set from a prepared statement
	$stmt->store_result();
	// count the number of rows returned by the query
	$numrows = $stmt->num_rows;

	// display error if there's no row returned to delete photo entry
	if($numrows === 0) exit('No rows returned.');

	if($numrows > 0) {
		/* bind result variables */
		$stmt->bind_result($filename);

		while ($stmt->fetch()) {
			// delete the file itself
			unlink('../photo/'.$filename);

			// object oriented style prepare statement ... query the entry in the database related to the video file 	
			$stmt = $dbcon->prepare("DELETE FROM photo WHERE id = ?");
			// binds variables to a prepared statement as parameters
			$stmt->bind_param("i", $id);
			// executes a prepared query and stores the result as TRUE or FALSE
			$stmt->execute();

			// if the deletion of the database row was successful, then redirect the user back to the admin dashboard
			if($result) {
				Redirect('admin', false);
				exit();
			}
			else {
				echo "Failed to delete.";
			}
		}

		mysqli_close($dbcon);
	}
}

// redirect the user to the admin panel if they attempt the access this file without having a video id set in the url
Redirect('admin', false);
?>

<?php

Include("footer.php"); 
?>