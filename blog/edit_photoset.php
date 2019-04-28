<?php
/*-------------------------------------------
FILE PURPOSE

This file is found via the admin dashboard. In short, this is used to edit existing photograph sets / collections.

The dropdown menu for the photo collection currently being edited shall be generating by gathering all of the IDs from the 'photo' table that are related to this particular photo collection.

/*------------------------------------------*/

include("../header.php");
// database connection file
include("connect.php");

// Function to check that the id gathered from the url is valid. This function can be found in header.php.
$id = $_GET['id'];
idCheck($id);

// Function to ensure that the user is logged in as an admin. This function can be found in header.php.
loginCheck();

// object oriented style prepare statement to get the data related to the photoset from the database
$stmt = $dbcon->prepare("SELECT id,title,category,cover_photo,display_hide,description,date_created,last_updated FROM photo_sets WHERE id = ?");
// binds variables to a prepared statement as parameters
$stmt->bind_param("i", $id);
// executes a prepared query
$stmt->execute();
// transfers a result set from a prepared statement
$stmt->store_result();
// get the number of rows returned by the query
$numrows = $stmt->num_rows;

// binds variables to a prepared statement for result storage
$stmt->bind_result($id,$title,$category,$cover_photo,$display,$description,$date_created,$last_updated);

// fetch value
$stmt->fetch();

// if a result is not returned from the query, then redirect the user to the index of the portfolio
if($numrows==0) {
	Redirect('index', false);
	exit();
} 

// initialize  a variable for displaying success / errors messages to the user
$error_display = '';

// check if the form has been submitted for updating the photograph set information
if(isset($_POST['upd'])) {
	// if the form has been submitted, then store all of the information entered by the user in to variables
	$title = mysqli_real_escape_string($dbcon, $_POST['title']);
	$category = mysqli_real_escape_string($dbcon, $_POST['category']);
	$cover_photo = mysqli_real_escape_string($dbcon, $_POST['filename']);
	$display = mysqli_real_escape_string($dbcon, $_POST['display']);
	$description = mysqli_real_escape_string($dbcon, $_POST['description']);
	$last_updated = date("Y-m-d");
	$id = (INT)$_GET['id'];

	 // object oriented style prepare statement to update database row related to appropriate photography set / collection details
	$stmt = $dbcon->prepare("UPDATE photo_sets SET title=?, category=?, cover_photo=?, display_hide=?, description=?, last_updated=? WHERE id=?");
	// binds variables to a prepared statement as parameters
	$stmt->bind_param('sssissi', $title, $category, $cover_photo, $display, $description, $last_updated, $id);
	// executes a prepared query
	$status = $stmt->execute();

	// check if the query executed successfully or not
	// display a success or fail message to the user 
	if ($status === false) {
		$error_display = "<br/>Failed to edit photoset.<br/>";
	} else {
		$error_display = "<br/>Photoset edited successfully.<br/>";
		echo "<meta http-equiv='refresh' content='2; url=edit_photoset?id=$id' />";
	}
}
?>

<div class="w3-container w3-light-grey">
<h2>Edit Photoset</h2></div>
<div class="w3-container">

<a href="admin"> << return to Admin Dashboard</a><br/>

<?php echo $error_display; ?>

<form action="" method="POST" class="w3-container">
<input type="hidden" name="id" value="<?php echo $id;?>">
<label>Title</label>
<input type="text" class="w3-input w3-border" name="title" value="<?php echo $title;?>">

<br>
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

<br/><br/>
<label>Cover Photo</label><br/>
<?php
// make sure i have the current photoset id 
$id = (INT)$_GET['id'];

// pull all of the categories specifically for photos
// create a dropdown menu using a loop
$sql = "SELECT name FROM photo WHERE photoset_ID = $id";
$result = mysqli_query($dbcon, $sql);

// $cover_photo displays the file name for the image that is currently being used for the cover photo for the collection
if(mysqli_query($dbcon, $sql)) {
	$select= '<select id="filename" name="filename">';
	$select.='<option name="filename" style="text-transform:uppercase;" value="'.$cover_photo.'">'.$cover_photo.'</option>';
	while($row=mysqli_fetch_array($result)){
	      $select.='<option name="filename" value="'.$row['name'].'">'.$row['name'].'</option>';
	  }
}
$select.='</select>';
echo $select;
?>

<br/><br/>
<label>Hide Display</label><br/>
<select id="display" name="display" >
	<option id="display" name="display" 
	value="<?php echo $display;?>">
	<?php 
	// The current selection for whether this photoset will be hidden from public display or not will come up as an option at the top of the dropdown
	if($display == 1){echo 'YES';}else{echo 'NO';}
	?>
		
	</option>
	<option id="display" name="display" value="1">Yes</option>
	<option id="display" name="display" value="0">No</option>
</select>

<br/><br/>
<label>Description (2000 characters)</label>
<textarea class="w3-input w3-border large_textbox" name="description" maxlength="850"><?php echo $description;?></textarea>

<br/><br/>
<input type="submit" class="w3-btn w3-light-grey w3-round" name="upd" value="Submit">
</form>

<img src="../photo/<?php echo $cover_photo; ?>" alt="<?php echo $cover_photo; ?>">


<?php
// close the connection for security
mysqli_close($dbcon);
include("footer.php");
?>