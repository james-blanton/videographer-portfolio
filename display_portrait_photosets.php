<?php
/*-------------------------------------------
FILE PURPOSE

This file is included at the top of the display_portrait.php file above all of the photographs that don't belong to a photoset.
<div class='column'> needs to be displayed inside the loop. If this div is displayed outside the loop when there's no images inside it, 
then it will mess up the spacing of all the images on the page.

/*------------------------------------------*/

include("blog/connect.php");

// Select statement to get all of the data on every photo set in the database that does not have a a boolean flag for display_hide set to 1. Photographs that belong to a photo set will not be individually displayed in the "Portrait" tab.
$sql= "SELECT id, title, cover_photo, display_hide FROM photo_sets WHERE category = 'Portrait' AND display_hide = 0 ORDER BY id";
$result = $dbcon->query($sql);
$num_rows = mysqli_num_rows($result);

?>
<div class='column'>
<?php
if ($num_rows > 0){
	// store all data on each photo set in variables that are easier to use
	while($row = $result->fetch_assoc()) {
	$id_photoset = $row['id']; // the unique id / primary key for the photo set
	$title_photoset = $row['title']; // the title for the photo set
	$cover_photo = $row['cover_photo']; // the file name for the cover photo of the photo set

	// only display a photoset that has photographs assigned to it
	$counting = "SELECT id FROM photo WHERE photoset_ID ='$id_photoset'";
	$results = $dbcon->query($counting);
	$num_rows_return = mysqli_num_rows($results);
?>
	
	<a href="view_photoset?id=<?php echo $id_photoset ?>">
		<div class="img_container">
			<img src="photo/<?php echo $cover_photo; ?>" alt="<?php echo $cover_photo ?>" class="img_resize"></img>
			<div class="photoset_links" class="img_link"><?php echo $title_photoset; echo ' ('.$num_rows_return.')';?></div>
		</div>
	</a>
	

<?php
		
	}
	
}
?>
</div>


