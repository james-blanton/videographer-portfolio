<?php
/*-------------------------------------------
FILE PURPOSE

This file is found via the admin dashboard. In short, this is used to edit existing videos. All of the content edited in this file is related to the "video" table.

/*------------------------------------------*/

include("../header.php");
// database connection file
include("connect.php");

// Function to check that the id gathered from the url is valid. This function can be found in header.php.
idCheck();

// if the user is not logged in, then redirect the user away to the login page before executing any more of this file
if(!isset($_SESSION['username'])) {
	Redirect('login', false);
	exit();
} 

// query statement to get a portion of the data related to the photograph from the database
$sql = "SELECT * FROM video WHERE id = '$id'";
// execute the query
$result = mysqli_query($dbcon, $sql);

// if a result is not returned from the query, then redirect the user to the index of the portfolio
if(mysqli_num_rows($result) ==0) {
	Redirect('index', false);
	exit();
} 

// store video's information in variables
// i don't need a while loop here because i'm only storing the information for one database row in to variables
$row = mysqli_fetch_assoc($result);
$id = $row['id'];
$title = $row['title'];
$description = $row['description'];
$index = $row['index_vid'];
$display = $row['display_hide'];
$category = $row['category'];

// initialize  a variable for displaying success / errors messages to the user
$error_display = '';

// check if the form has been submitted for updating the photograph's information
if(isset($_POST['upd'])) {
	// if the form has been submitted, then store all of the information entered by the user in to variables
	$id = (INT)$_POST['id'];
	$title = mysqli_real_escape_string($dbcon, $_POST['title']);
	$description = $_POST['description'];
	$index = mysqli_real_escape_string($dbcon, $_POST['index']);
	$display = mysqli_real_escape_string($dbcon, $_POST['display']);
	$category = mysqli_real_escape_string($dbcon, $_POST['category']);
	
	 // object oriented style prepare statement to update database row related to appropriate video details
	$stmt = $dbcon->prepare("UPDATE video SET title=?, description=?, index_vid=?, display_hide=?, category=? WHERE id=?");
	// binds variables to a prepared statement for result storage
	$stmt->bind_param('ssiisi', $title, $description, $index, $display, $category, $id);
	// executes a prepared query
	$status = $stmt->execute();

	// check if the query executed successfully or not
	// display a success or fail message to the user 
	if ($status === false) {
		$error_display = "<br/>Failed to edit.<br/>";
	} else {
		$error_display = "<br/>Video edited successfully.<br/>";
		echo "<meta http-equiv='refresh' content='2; url=edit_video?id=$id' />";
	}
}
?>

<div class="w3-container w3-light-grey">
<h2>Edit Video</h2></div>
<div class="w3-container">

<a href="admin.php"> << return to Admin Dashboard</a><br/>

<?php echo $error_display; ?>

<form action="" method="POST" class="w3-container">
<input type="hidden" name="id" value="<?php echo $id;?>">
<label>Title</label>
<input type="text" class="w3-input w3-border" name="title" value="<?php echo $title;?>">

<label>Summary (850 characters)</label>
<textarea class="w3-input w3-border large_textbox" name="description" maxlength="850"><?php echo $description;?></textarea>
<br/>

<label>Video Category</label><br/>
<select id="video_category" name="category" >
	<option id="category" name="category" style="text-transform:uppercase;" value="<?php echo $category;?>">
	<?php 
	// The current category that has been set in the 'photo' table for this respective photograph will be displayed at the top of the dropdown in caps.
	echo $category;
	?>
	</option>
	<option id="category" name="category" value="">No Category</option>
	<option id="category" name="category" value="Motion Graphics">Motion Graphics</option>
	<option id="category" name="category" value="Portrait">Portrait</option>
	<option id="category" name="category" value="Landscape">Landscape</option>
	<option id="category" name="category" value="Commercial">Commercial</option>
	<option id="category" name="category" value="Travel">Travel</option>
	<option id="category" name="category" value="Weddings">Weddings</option>
	<option id="category" name="category" value="Editorial">Editorial</option>
</select>
<br><br>

<label>Index Display</label><br/>
<select id="index" name="index" >
	<option id="index" name="index" 
	value="<?php echo $index;?>">
	<?php 
	if($index == 1){echo 'YES';}else{echo 'NO';}
	?>
		
	</option>
	<option id="index" name="index" value="1">Yes</option>
	<option id="index" name="index" value="0">No</option>
</select>

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


<?php
// close the connection for great security
mysqli_close($dbcon);
include("footer.php");
?>