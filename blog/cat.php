<?php
/*-------------------------------------------
FILE PURPOSE

This file is displayed after a user clicks on a category classification found on the index page of the blog / article section for the portfolio.

The page will display the title, description, author, view count, and date for the article. 
Finally, the page will display an edit and delete link if an admin is logged in to their account while viewing this page.

/*------------------------------------------*/

// connection to the database
include("connect.php");
include("../header.php");

echo '<a href="index"> << return to Articles Index</a><br/>';

// Function to check that the id gathered from the url is valid. This function can be found in header.php.
idCheck();

/*
If the user attempts to view a category id that does not exist in the database, 
then redirect them away from this file. This select query will also be used to display the category name at the top of page
*/
$sql = "SELECT * FROM category WHERE id = '$id'";
// executes a prepared query and stores the result as TRUE or FALSE
$result = mysqli_query($dbcon, $sql);
// if no row is returned, then redirect the user
if(mysqli_num_rows($result) == 0){
	Redirect('index', false);
	exit();
} 

// display the category name within a gray div area that stretched the full width its container div
while ($row = mysqli_fetch_assoc($result)) {
	$post_cat = $row['id'];
	$catname = $row['catname'];
	$description = $row['description'];
	echo '<div class="w3-container w3-center w3-light-grey">';
	echo "<h3>".$catname."</h3></div>";
	echo $description."<hr>";
}
	
/*
Find all of blog posts / articles that have the same category ID as the current category that the user is viewing.
*/
$sql1 = "SELECT * FROM posts WHERE post_cat = '$post_cat' ORDER BY id DESC";
// executes a query and stores the result as TRUE or FALSE
$res = mysqli_query($dbcon, $sql1); 

// If a result is not returned for the query, then  display an error message to the user.
// This error check seems unnecessary considering that the file will redirect you to the index if the category does not exist
if(mysqli_num_rows($res) == 0) {
	echo "No article or blog posts found related to this specific category.";
} else {

	//
	while($r = mysqli_fetch_assoc($res)) {
		// the following variables store data related to the respective post that belongs to this category
		$id = $r['id']; // unique id for the post / article
		$title = $r['title']; // title for the post that belongs to this category
		$description = $r['description']; // the full article / blog post text, which will be truncated in a moment
		$time = $r['date']; // the date that the article / blog post was submitted

		echo '<div class="w3-panel w3-sand w3-card-4">';
		echo "<h3><a href='view?id=$id'>$title</a></h3><p>";

		// truncate the text for the article and display the beginning of the article to the user
		if(strlen($description) > 100) {
			echo substr($description, 0, 100)."...";
		} else 
			echo $description;


		echo '</p><div class="w3-text-light-grey">';
		echo "<a href='view?id=$id'>Read more</a>";

		echo '</div> <div class="w3-text-grey">';
		echo "$time</div>";
		echo '</div>';
	}
}

include("footer.php");
?>