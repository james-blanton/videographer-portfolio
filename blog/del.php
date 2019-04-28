<?php
/*-------------------------------------------
FILE PURPOSE

This file is meant to delete an existing blog / article post from the 'posts' table.
This file may not be accessed if the user is not logged in to an account.

Keep in mind that currently anyone who has an account in the database can access this file.
This file is executed on the admin dashboard page when a "delete" link is clicked, but this page itself does not actually display anything to the user.

I need to improve the error display at the bottom of this file. Right now I haven't set a direct location for this error display text. 

/*------------------------------------------*/

include("../header.php");

// database connection file
include("connect.php");

// if the user is not logged in, then redirect the user away to the index page before executing any more of this file
if(!isset($_SESSION['username'])) {
	Redirect('index', false);
	exit();
} 

// typecast article id
// Redirect user away if they put some strange id in the url bar
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
	$id = (INT)$_GET['id'];
} else {
	Redirect('index', false);
	exit();
}

// check if an article / blog post ID has been recieved from the url or not
if(isset($_GET['id'])) {

	// object oriented style prepare statement ... Delete statement to remove the article / blog post information fron the database based on the id provided in the url
	$stmt = $dbcon->prepare("DELETE FROM posts WHERE id = ?");
	// binds variables to a prepared statement as parameters
	$stmt->bind_param("i", $id);
	// executes a prepared query and stores the result as TRUE or FALSE
	$stmt->execute();

	// Redirect the user to the index dashboard page of the blog / article directory once the deletion is complete.
	if($stmt->affected_rows === 1) 
	{
		Redirect('admin', false);
		exit();
	}
	else {
		// This error display needs to be improved. Right now I don't have a set location for where errors appear. 
		echo "Failed to delete.";
	}

}

mysqli_close($dbcon);
?>
 