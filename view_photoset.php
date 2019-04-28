<?php 
/*-------------------------------------------
FILE PURPOSE
Displays all photographs related to a particular photo set / collection with the ID for photoset being gathered from the url. 

I first do a security check to make sure that the user has edited a false ID for the photoset in to the url.

/*------------------------------------------*/

include('header.php'); 
// database connection file
include("blog/connect.php");

?>

<?php
// Function to check that the id gathered from the url is valid. This function can be found in header.php.
$id = $_GET['id'];
idCheck($id);

// CHECK TO MAKE SURE THAT THE ID GATHERED FROM THE URL ACTUALLY EXISTS IN THE 'photo_sets' TABLE
// object oriented style prepare statement to get the data related to the photoset from the database
$stmt = $dbcon->prepare("SELECT id FROM photo_sets WHERE id = ?");
// binds variables to a prepared statement as parameters
$stmt->bind_param("i", $id);
// executes a prepared query
$stmt->execute();
// transfers a result set from a prepared statement
$stmt->store_result();
// get the number of rows returned by the query
$numrows = $stmt->num_rows;

// binds variables to a prepared statement for result storage
$stmt->bind_result($id);

// fetch value
$stmt->fetch();

// if a result is not returned from the query, then redirect the user to the index of the portfolio
if($numrows==0) {
  Redirect('index', false);
  exit();
} 
?>

<link rel="stylesheet" href="styles/photo_styles.css">

<a href="photography"> << return to Photography</a><br/><br/>

<div id="fixedbutton"><button class="switch">Toggle Width</button></div>

<div class="flex">

<?php
// Select statement to get all of the data on every portrait photograph in the database that does not have a a boolean flag for display_hide set to 1. Photographs that belong to a photo set will not be individually displayed in the "Portrait" tab.
$sql= "SELECT id, title, name, display_hide, photoset_ID FROM photo WHERE photoset_ID = $id AND display_hide = 0";
$result = $dbcon->query($sql);

// store all data on each portrait photograph in variables that are easier to use
while($row = $result->fetch_assoc()) {
$id = $row['id']; // the unique id / primary key for the portrait photograph
$title= $row['title']; // the title for each portrait photograph
$filename= $row['name']; // the file name for each portrait photograph including the file extension

?>

<div class='column'>
<a href="photo/<?php echo $filename; ?>" target="_new">
<img src="photo/<?php echo $filename; ?>" alt="<?php echo $filename; ?>" width='100%' style='float:left'>
</a>
</div>

<?php
}
?>
</div>

<button class="switch">Toggle Width</button>

</div>

        
</div>
</div>

<script>    
    $('.switch').on('click', function(e) {
      $('.column').toggleClass("column-full"); // can list several class names 
      e.preventDefault();
    });
</script>

<script type="text/javascript">
  function fullWidthFunction() {
  var x = document.getElementById("photography_menu");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>

<?php include('footer.php'); ?>