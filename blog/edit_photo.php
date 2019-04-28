<?php
/*-------------------------------------------
FILE PURPOSE

This file is found via the admin dashboard. In short, this is used to edit existing photographs. All of the content edited in this file is related to the "photo" & "photo_sets" table.

Read the notes carefully in order to get a thorough understanding of why I reset the cover_photo column in the 'photo_sets' table every time the form on this page is submitted. 

/*------------------------------------------*/

include("../header.php");
// database connection file
include("connect.php");

// Function to check that the id gathered from the url is valid. This function can be found in header.php.
$id = $_GET['id'];
idCheck($id);

// Function to ensure that the user is logged in as an admin. This function can be found in header.php.
loginCheck();

// object oriented style prepare statement to get the data related to the photograph from the database
$stmt = $dbcon->prepare("SELECT id,title,category,filedate,name,display_hide,photoset_ID FROM photo WHERE id = ?");
// binds variables to a prepared statement as parameters
$stmt->bind_param("i", $id);
// executes a prepared query
$stmt->execute();
// transfers a result set from a prepared statement
$stmt->store_result();
// get the number of rows returned by the query
$numrows = $stmt->num_rows;

// binds variables to a prepared statement for result storage
$stmt->bind_result($id,$title,$category,$date,$filename,$display,$current_photoset_ID);

// fetch values
$stmt->fetch();

// if a result is not returned from the query, then redirect the user to the index of the portfolio
if($numrows==0) {
	Redirect('index', false);
	exit();
} 

// initialize  a variable for displaying success / errors messages to the user
$error_display = '';

// check if the form has been submitted for updating the photograph's information
if(isset($_POST['upd'])) {

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// SECOND. Reset the cover_photo column in "photo_sets" table to a NULL value for the photo set / collection that this photograph currently belongs to.
	// We need to use the constant value in order for this to work currently.
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$null = NULL;
	 // object oriented style prepare statement to update database row related to appropriate video details
	$stmt = $dbcon->prepare("UPDATE photo_sets SET cover_photo=? WHERE id=?");
	// binds variables to a prepared statement as parameters
	$stmt->bind_param('si', $null, $current_photoset_ID);
	// executes a prepared query
	$status = $stmt->execute();

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// THIRD. Update the 'photo' table using info submitted by the user.
	// The photoset ID being used here is ontained by the dropdown menu.
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$id = (INT)$_POST['id'];
	$title = mysqli_real_escape_string($dbcon, $_POST['title']);
	$category = mysqli_real_escape_string($dbcon, $_POST['category']);
	$display = mysqli_real_escape_string($dbcon, $_POST['display']);
	$photoset_ID = mysqli_real_escape_string($dbcon, $_POST['photoset']);
	if($_POST['photoset'] == ""){$photoset_ID = NULL;}
	 // object oriented style prepare statement to update database row related to appropriate video details
	$stmt = $dbcon->prepare("UPDATE photo SET title=?, category=?, display_hide=?, photoset_ID=? WHERE id=?");
	// binds variables to a prepared statement as parameters
	$stmt->bind_param('ssiii', $title, $category, $display, $photoset_ID, $id);
	// executes a prepared query
	$status = $stmt->execute();

	// check if the query executed successfully or not
	// display a success or fail message to the user 
	if ($status === false) {
		$error_display = "<br/>Failed to edit.<br/>";
	} else {
		$error_display = "<br/>Photo edited successfully.<br/>";
		echo "<meta http-equiv='refresh' content='2; url=edit_photo?id=$id' />";
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// FORTH. Update the 'photo_sets' table row for the photo set that the user has chosen to assign this photograph to.
	// The form at the bottom of the page provides a list of photo sets / photo collections to select from.
	// The value for each selection in the dropdown is the ID (primary key) for each photo set.
	// If the use elects that they wish to remove this image from a photoset, then we need to set the cover photo column to a true NULL.
	// The $filename variable being used here was gethered when the page first loaded.
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	if($_POST['photoset'] == ""){$filename == NULL;}

	 // object oriented style prepare statement to update database row related to appropriate photoset details
	$stmt = $dbcon->prepare("UPDATE photo_sets SET cover_photo=? WHERE id=?");
	// binds variables to a prepared statement as parameters
	$stmt->bind_param('si', $filename, $photoset_ID);
	// executes a prepared query
	$status = $stmt->execute();

}
?>

<div class="w3-container w3-light-grey">
<h2>Edit Photo</h2></div>
<div class="w3-container">

<a href="admin"> << return to Admin Dashboard</a><br/>

<?php echo $error_display; ?>

<form action="" method="POST" class="w3-container">
<input type="hidden" name="id" value="<?php echo $id;?>">
<label>Title</label>
<input type="text" class="w3-input w3-border" name="title" value="<?php echo $title;?>">

<br><br>
<label>Category</label><br/>
<?php
// pull all of the categories specifically for photos
// create a dropdown menu using a loop
$sql = "SELECT * FROM category_photo";
$result = mysqli_query($dbcon, $sql);

if(mysqli_query($dbcon, $sql)) {
	$select= '<select id="category" name="category">';
	$select.='<option id="category" name="category" style="text-transform:uppercase;" value="'.$category.'">'.$category.'</option>';
	while($row=mysqli_fetch_array($result)){
	      $select.='<option name="category" value="'.$row['id'].'">'.$row['catname'].'</option>';
	  }
}
$select.='</select>';
echo $select;
?>

<br><br>
<label>Photo Set</label><br/>
<?php
// get the photos appropriate photoset name
$sql_photoset_title = "SELECT title FROM photo_sets WHERE id = '$current_photoset_ID'";
$result_set_title = mysqli_query($dbcon, $sql_photoset_title);
$numrows_title = mysqli_num_rows($result_set_title);
if ($numrows != 0){
	if(mysqli_query($dbcon, $sql_photoset_title)) {
		while($row=mysqli_fetch_array($result_set_title)){
		$current_photoset_title = $row['title'];
		}
	} else $current_photoset_title = "NONE";
}

// pull all list of available photo sets
//query statement and execution of query
$sql_photosets = "SELECT id, title FROM photo_sets";
$result_sets = mysqli_query($dbcon, $sql_photosets);
//count the number of rows returned
$numrows = mysqli_num_rows($result_sets);

// display a dropdown of available photo sets if any exist in the database
// echo a message to the user if no photo sets are returned
// list the category that the photograph currently belongs to before listing any other categories
// utelize the constant variable that gets assigned  every time the page loads in order to ensure that the dropdown has an accurate current photoset ID
if ($numrows != 0){
	if(mysqli_query($dbcon, $sql_photosets)) {
		$select= '<select id="photoset" name="photoset">';
		if (isset($current_photoset_title)){
				$select.='<option name="photoset" class="uppercase" value="'.$current_photoset_ID.'">'.$current_photoset_title.'</option>';
		}
		$select.='<option name="photoset" value="">None</option>';
		while($row=mysqli_fetch_array($result_sets)){
		      $select.='<option name="photoset" value="'.$row['id'].'">'.$row['title'].'</option>';
		  }
	}
	$select.='</select>';
	echo $select;
} else echo 'No photo sets currently exist.'
?>

<br/><br/>
<label>Hide Display</label><br/>
<select id="display" name="display" >
	<option id="display" name="display" 
	value="<?php echo $display;?>">
	<?php 
	// The current selection for whether this photo will be hidden from public display or not will come up as an option at the top of the dropdown
	if($display == 1){echo 'YES';}else{echo 'NO';}
	?>
		
	</option>
	<option id="display" name="display" value="1">Yes</option>
	<option id="display" name="display" value="0">No</option>
</select>

<br/><br/>
<input type="submit" class="w3-btn w3-light-grey w3-round" name="upd" value="Submit">
</form>

<img src="../photo/<?php echo $filename; ?>" alt="<?php echo $filename; ?>">


<?php
// close the connection for security
mysqli_close($dbcon);
include("footer.php");
?>