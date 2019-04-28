<?php
/*-------------------------------------------
FILE PURPOSE

This file is included within the Admin Dashboard file (admin.php).
The file's purpose is to display a table which list of information in the database for every blog post / article / analytical writings that I put on my portfolio. 
This data currently includes the unique ID (primary key), the title of the article, the date it was submitted, the number of views it has recieved and 2 links: edit, and delete.

The titles of the article are truncated if they exceed 15 characters in total and an ellipse (...) is added to the end of the truncated title.

The "edit" link takes the administrator user to edit.php, which allows them to edit the title, content, and category for the article.

/*------------------------------------------*/

// The following PHP block is for pagination

// Select statement that counts the total number of rows that exist in the 'posts' table, which contains all blog / article data
$sql = "SELECT COUNT(*) FROM posts";
// procedural style query on the database using the above select statement
$result = mysqli_query($dbcon, $sql);
$r = mysqli_fetch_row($result);

// used for paginating the results returned from the query
$numrows = $r[0]; // imagine that this returns a value of 10
$rowsperpage = 5;
$totalpages = ceil($numrows / $rowsperpage); // 10 + 5 = 2 ... if 10 videos are listed in the database, then they will be displayed on 2 pages ... 5 videos per page

if(!isset($_GET['page'])){
	$page = 1;
	$_GET['page'] = 1;
}

// the url would contain a $_GET['page'] value if the user has already navigated back and forth on the pagination navigation links. However, if the page is loaded without clicking on the pagination navigation links, then there will be no page value set in the url, therefor the user needs to be viewing the first page. Setting the $page variable to 1 ensures that this happenss

// typecast page first for security
// Redirect user away if they put some strange id in the url bar
if(isset($_GET['page']) && is_numeric($_GET['page'])) {
	$page = (INT)$_GET['page'];
} else {
	header("location: index");
	exit();
}

// adjust what article / blog post data is being  displayed to the administrator in the html table based on where they are in the pagination navigation
if(isset($_GET['page']) && is_numeric($_GET['page'])) {
	$page = (INT)$_GET['page'];
	} 
	if($page > $totalpages) {
		$page = $totalpages;
		} 
		if($page < 1) {
			$page = 1;
			}
			$offset = ($page - 1) * $rowsperpage;
?>

<?php
// A select statement  to return a result-set of blog post / article data based on where the administrator is in the pagination navigation
$sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $offset, $rowsperpage";
// executes a prepared query and stores the result as a result set or FALSE
$result = mysqli_query($dbcon, $sql);

// if no blog post / article data is returned from the query, then let the user know
if(mysqli_num_rows($result) < 1) {
	echo "No post found";
} 
?>

<?php // the following are headers for the top of the table that will display all of the video information to the admin ?>
<table class='w3-table-all'>
<tr class='w3-light-grey w3-hover-light-grey'>
<th>ID</th>
<th>Title</th>
<th>Date</th>
<th>Views</th>
<th>Action</th>
</tr>

<?php
// store the video information returned from the database query in variables
while ($row = mysqli_fetch_assoc($result)) {
	$id = $row['id'];
	$title = substr($row['title'], 0, 15).'&#32;...'; // sunstr() function truncates the titles of the videos if they're longer than 15 characters
    $by = $row['posted_by'];
    $time = $row['date'];
    $time = date("m/d/y", strtotime($row['date'])); // formats the display of the datae as month / day / year
    $hits = $row['hits']; // the number of times that the article has been viewed

	?>

	<?php // This table is still being displayed within the while loop. I'm placing this comment in php tags in order to hide it from being seen if the user decides to view the source code of the page.?>
	<tr>
	<td><?php echo $id;?></td>
	<td><a href="view?id=<?php echo $id;?>"><?php echo $title ;?></a></td>
	<td><?php echo $time;?></td>
	<td><?php echo $hits;?></td>
	<td><a href="edit?id=<?php echo $id;?>">Edit</a> | <a href="del?id=<?php echo $id;?>" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a></td>
	</tr>

<?php 
} 
echo "</table>";

// the remaining code seen below is used to display the pagination navigation links
// this first div tag ensures that the pagination links are centered on the page
echo "<div class='w3-bar w3-center'>";

if($page > 1) {
	echo "<a href='?page=1' class='w3-btn'><<</a>";
	$prevpage = $page - 1;
	echo "<a href='?page=$prevpage' class='w3-btn'><</a>";
}

$range = 3;

for($i = ($page - $range);$i < ($page + $range) + 1;$i++) {
	if(($i > 0) && ($i <= $totalpages)) {
		if($i == $page) {
			echo "<div class='w3-btn w3-light-grey w3-hover-grey'> $i</div>";
		} 
		else {
			echo "<a href='?page=$i' class='w3-btn w3-border'>$i</a>";
		} 
	} 
} 

if($page != $totalpages) {
	$nextpage = $page + 1;
	echo "<a href='?page=$nextpage' class='w3-btn'>></a>";
	echo "<a href='?page=$totalpages' class='w3-btn'>>></a>";
}

echo "</div>";

?>