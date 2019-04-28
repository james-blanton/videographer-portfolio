<?php
/*-------------------------------------------
FILE PURPOSE
All this file does is loop through the 'category' table.

Currently, all that I am in displaying is the category name and it's description while also providing a link to navigate
to a file that will display all of the articles that have been classified under that category name.

I decided to make the categories for informative writings (articles) seperate from the videos and photos because I know
that I will want to add categories in the future that will not relate to photographs or videos. 

Currently I am truncating the description of the categories after 150 characters.

/*------------------------------------------*/
?>

<div class="w3-container w3-center w3-light-grey"><h3>Categories</div>

<?php
// query all rows from the category table
$sql = "SELECT * FROM category";
// executes a prepared query and stores the result as a result set or FALSE
$result = mysqli_query($dbcon, $sql);

if(mysqli_num_rows($result) < 1) {
	// Display an error message if there's no categories listed in the database for some reason.
	echo "<div class='w3-container w3-border-category'>No categories found.</div>";
}

	echo "<div class='w3-container w3-border-category'>";

	while ($row = mysqli_fetch_assoc($result)) {
		$id = $row['id']; // unique id for the category
		$catname = $row['catname']; // name of the category
		$description = $row['description']; // a short description of the category
	?>
	
	<a class="italic" href="cat?id=<?php echo $id;?>"><?php echo $catname;?></a><br>
	<?php 
	// truncate the description of the category down to 150 characters
	echo substr($description, 0, 250).'&#32;...'.'<br/><hr>';
	?>
	
<?php
	}

echo "</div>";
	
?>