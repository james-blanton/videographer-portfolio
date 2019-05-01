<?php
/*-------------------------------------------
FILE PURPOSE

This file is included within the Admin Dashboard file (admin.php).
The file's purpose is to display a table which list of information in the database for every photographic image. 
This data currently includes the unique ID (primary key), the title, the category and 2 links: edit, and delete.

The titles of the photographs are truncated if they exceed 15 characters in total and an ellipse (...) is added to the end of the truncated title.

/*------------------------------------------*/

// Select statement that counts the total number of rows that exist in the database table
$sql = "SELECT COUNT(*) FROM photo";
// procedural style query on the database using the above select statement
$result = mysqli_query($dbcon, $sql);
//  fetches one row from a result-set and returns it as an enumerated array.
$r = mysqli_fetch_row($result);

// used for paginating the results returned from the query
$numrows = $r[0]; // imagine that this returns a value of 10
$rowsperpage = 5;
$totalpages = ceil($numrows / $rowsperpage); // 10 + 5 = 2 ... if 10 videos are listed in the database, then they will be displayed on 2 pages ... 5 videos per page

if(!isset($_GET['page'])){
	$page = 1;
	$_GET['page'] = 1;
}

// the url would contain a $_GET['page'] value if the user has already navigated back and forth on the pagination navigation links. However, if the page is loaded without clicking on the pagination navigation links, then there will be no page value set in the url, therefor the user needs to be viewing the first page. Setting the $page variable to 1 ensures that this happenss.

// Redirect user away if they put some strange id in the url bar
if(isset($_GET['page']) && is_numeric($_GET['page'])) {
	$page = (INT)$_GET['page'];
} else {
	Redirect('index', false);
	exit();
}

// adjust what data is being  displayed to the administrator in the html table based on where they are in the pagination navigation
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

// A select statement  to return a result-set of photography data based on where the administrator is in the pagination navigation
$sql = "SELECT * FROM photo ORDER BY id DESC LIMIT $offset, $rowsperpage";
// executes a prepared query and stores the result as a result set or FALSE
$result = mysqli_query($dbcon, $sql);

// if no photo data is returned from the query, then let the user know
if(mysqli_num_rows($result) < 1) {
	echo "No post found";
	}
?>

<?php // the following are headers for the top of the table that will display all of the video information to the admin ?>
<table class='w3-table-all'>
<tr class='w3-light-grey w3-hover-light-grey'>
<th class="hide_th_td">ID</th>
<th>Filename</th>
<th>Category</th>
<th>Set</th>
<th>Action</th>
</tr>

<?php
while ($row = mysqli_fetch_assoc($result)) {
	$id = $row['id'];
	$title = substr($row['title'], 0, 15).'&#32;...'; // sunstr() function truncates the titles of the videos if they're longer than 15 characters
    $filename = $row['name'];
    $category = $row['category']; 
    $photoset_id = $row['photoset_ID'];
    if($photoset_id==''){$photoset_id="none";}

     // close php tag for now so that it's easier to code the rest of the table rows
	?>

	<?php // This table is still being displayed within the while loop. I'm placing this comment in php tags in order to hide it from being seen if the user decides to view the source code of the page.?>
	<tr>
	<td class="hide_th_td"><?php echo $id;?></td>
	<td><a href="view?id=<?php echo $id;?>"><?php echo $filename ;?></a></td>
	<td><?php echo $category;?></td>
	<td><?php echo $photoset_id;?></td>

	<td class="desktop_dropdown">
		<a href="edit_photo?id=<?php echo $id;?>">Edit</a> |
		<a href="del_photo?id=<?php echo $id;?>" onclick="return confirm('Are you sure you want to delete this photo?')">Delete</a>
	</td>

	<td class="mobile_dropdown">
		<select id = "mobile_dropdown" onchange="window.location.href=this.value">
			<option value="#">OPTIONS</option>
		    <option value="edit_photo?id=<?php echo $id;?>">Edit</option>
		    <option value="del_photo?id=<?php echo $id;?>">Delete</option>
		</select>
	</td>

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