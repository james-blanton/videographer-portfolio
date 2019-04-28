<?php
/*-------------------------------------------
FILE PURPOSE

This file displays a blog post / article

/*------------------------------------------*/

include("../header.php");
// database connection file
include("connect.php");

// Function to check that the id gathered from the url is valid. This function can be found in header.php.
idCheck();

// query statement to get the data related to the article the user is viewing from the database ... safe prepare statement
$sql = "SELECT * FROM posts WHERE id = '$id'";
// executes a prepared query and stores the result as a result set or FALSE
$result = mysqli_query($dbcon, $sql);

if ($stmt = mysqli_prepare($dbcon, $sql)) {

    /* execute query */
    mysqli_stmt_execute($stmt);

    /* store result */
    mysqli_stmt_store_result($stmt);
 
	// if a result is not returned from the query, then redirect the user to the index of the portfolio
	if(mysqli_stmt_num_rows($stmt)==0) {
		Redirect('index', false);
		exit();
	} 
}

// add a view  'hit' / count to the blog post / article every time the page is loaded
// safe prepare statement
$stmt = $dbcon->prepare("UPDATE posts SET hits=hits+1 WHERE id = ?");
// binds variables to a prepared statement as parameters
$stmt->bind_param("i", $id);
// executes a prepared query
$stmt->execute();
// Closes a prepared statement in order to free up memory.  If the current statement has pending or unread results, this function cancels them so that the next query can be executed.
$stmt->close();

// store blog post / article information in variables
// i don't need a while loop here because  i'm only storing the information for one database row in to variables
$row = mysqli_fetch_assoc($result);
$id = $row['id'];
$title = $row['title'];
$des = $row['description'];
$by = $row['posted_by'];
$hits = $row['hits'];
$time = $row['date'];  

// direct user away if they try and view a blog post / article that has its display_hide set to '1' / 'yes'
$display_settings = $row['display_hide'];
if ($display_settings == 1){
	Redirect('index', false);
	exit();
}

?>

<div class="w3-container w3-sand w3-card-4">
<h2>View Article</h2>

<a href="index"> << return to Articles Index</a><br/>

<h3><?php echo $title; ?></h3>
<div class="w3-panel w3-leftbar w3-rightbar  w3-sand w3-card-4">

<?php echo nl2br($des); ?>

<br/><br/>
<div class="w3-text-grey">
<?php 
echo "Posted by: " . $by."<br>"; 
echo "Views: ". $hits."<br>";
echo "$time</div>";
?>


<?php
// if a user is logged in currently, then give them the option to edit or delete the article
if(isset($_SESSION['username'])) {
?>

<div class="w3-text-green"><a href="edit?id=<?php echo $row['id'];?>">[Edit]</a></div>
<div class="w3-text-red">
<a href="del?id=<?php echo $row['id'];?>" onclick="return confirm('Are you sure you want to delete this post?'); ">[Delete]</a></div> 

<?php
}
echo '</div></div>';

include("footer.php"); 
?> 
