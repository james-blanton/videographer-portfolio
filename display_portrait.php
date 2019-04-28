<?php
/*-------------------------------------------
FILE PURPOSE

This file is included in the photography.php file.
If the user clicks on the "PORTRAIT" tab while on photography.php, then this file will be displayed on the page.
This particular tab will display all of the photographs that have been entered in to the database with the category of "Portrait"
Portrait photo sets are displays before all photographs that do not belong to a set through the use of the display_portrait_photosets.php file.

The 'display_hide' field in the datbase is a boolean. If the display_hide row is set to '1' instead of zero for a specific photo row, then that photograph will not be displayed when the user is viewing this tab on the photography.php page

DATA QUERIED FOR THIS FILE:

id = unique id / primary key ... datatype int(255)
title = the title of the photograph  .... datatype varchar(255)
category = the category to which each photographh belongs ... datatype varchar(255)
filedate = the date that the photograph was submitted to the database ... datatype date
name = the file name with the extension ... datatype varchar(255)
display_hide = sets if the video is hidden from public display  tinyint(1) ... AKA a boolean value

/*------------------------------------------*/

include("blog/connect.php");

?>

<div class="flex">

<?php include("display_portrait_photosets.php"); ?>

<?php
// Select statement to get all of the data on every portrait photograph in the database that does not have a a boolean flag for display_hide set to 1. Photographs that belong to a photo set will not be individually displayed in the "Portrait" tab with the exception of the 'cover photo', which will link to the other photographs belong to that set.
$sql= "SELECT id, title, name, filedate, display_hide, photoset_ID FROM photo WHERE category = 'Portrait' AND display_hide = 0 AND photoset_ID IS NULL ORDER BY id";
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

