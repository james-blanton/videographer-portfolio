<?php
/*-------------------------------------------
FILE PURPOSE

This file processes a photo set / collection deletion request. Options are given to the user on whether they wish to do the following:

(option A)
remove all photos from the collection (reset the photoset_ID to NULL for the associated photos),
then delete the set (delete the photo_sets row) ...

or

(option B)
delete all files associated with the set (delete physical file & entry in the 'photo table'),
then delete the set (delete the photo_sets row) ...

If the user selects to go with option A, then the photographs belonging to the set will have their display_hidden column set  to 1.

CURRENTLY THIS FILE AUTOMATICALLY DELETES THE PHOTOSET AND EVERY IMAGE ASSOCIATED WITH IT. There is a javascript yes / no check with the user before the deletion occurs.
/*------------------------------------------*/

include("../header.php");
// database connection file
include("connect.php");

// Function to check that the id gathered from the url is valid. This function can be found in header.php.
$id = $_GET['id'];
idCheck($id);

// Function to ensure that the user is logged in as an admin. This function can be found in header.php.
loginCheck();

/////////////////////////////////////////
// Make sure that the photoset exists //
///////////////////////////////////////

// object oriented style prepare statement to determine the file name for the video that has this unique id in the database
$stmt = $dbcon->prepare("SELECT id FROM photo_sets WHERE id = ?");
// binds variables to a prepared statement as parameters
$stmt->bind_param("i", $id);
// executes a prepared query and stores the result as TRUE or FALSE
$stmt->execute();
// transfers a result set from a prepared statement
$stmt->store_result();
// count the number of rows returned by the query
$numrows = $stmt->num_rows;

//////////////////////////////////////////////////////
// If the photoset exists, then begin the deletion //
////////////////////////////////////////////////////
if($numrows > 0) {
	// Start by pulling the photos assigned the same photoset ID as the photoset gathered from the URL.

	// object oriented style prepare statement to determine which photos correspond to this photo collection
	$stmt = $dbcon->prepare("SELECT id, name, photoset_ID FROM photo WHERE photoset_ID = ?");
	// binds variables to a prepared statement as parameters
	$stmt->bind_param("i", $id);
	// executes a prepared query and stores the result as TRUE or FALSE
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
   			// if the admin selects to delete all photographs attached to the photo set, then this block will execute
   			if ($_GET['p']==1){
				// delete the file itself
				unlink('../photo/'.$filename);

				// object oriented style prepare statement ... query the entry in the database related to the video file 
				$stmt = $dbcon->prepare("DELETE FROM photo WHERE photoset_ID = ?");
				// binds variables to a prepared statement as parameters
				$stmt->bind_param("i", $id);
				// executes a prepared query and stores the result as TRUE or FALSE
				$stmt->execute();
			}

			// if the admin selects to delete all photographs attached to the photo set, then this block will execute
   			if ($_GET['p']==2){
				// object oriented style prepare statement ... query the entry in the database related to the video file 
				$stmt = $dbcon->prepare("UPDATE photo SET photoset_ID = NULL WHERE photoset_ID = ?");
				// binds variables to a prepared statement as parameters
				$stmt->bind_param("i", $id);
				// executes a prepared query and stores the result as TRUE or FALSE
				$stmt->execute();
			}

			// object oriented style prepare statement ... delete the details related to the video from the 'vid_details' table
			$stmt = $dbcon->prepare("DELETE FROM photo_sets WHERE id = ?");
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
				echo "Failed to delete database entry.";
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