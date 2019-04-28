<?php
/*-------------------------------------------
FILE PURPOSE

This file is the backend administrator control panel.
This page can currently be accessed by anyone who has an account setup in the database.

The control panel currently provides links to do the following:
- Create blog posts / articles (title, description, category)

- Upload videos (file, title, summary (a brief description), category, index display [y/n], & whether the video is hidden from public display or not)

- Upload photographs (file, title, category, photo set, & whether the photograph is hidden from public display or not)

- Create photo sets (cover image, title of cover image, photoset title, the photo category to which the set belongs, a description of the photoset & whether the photoset is hidden from public display or not)

Below these links there's 4 tabs that will display information and modification options for these 4 content types just mentioned; articles / blog posts, videos, photos & photo sets.

The code each tab of content is contained within a seperate php file in order to make my code more organized and easier to manage. 

/*------------------------------------------*/

include("../header.php");
// database connection file
include("connect.php");

// Function to ensure that the user is logged in as an admin. This function can be found in header.php.
loginCheck();
		
?>
<div class="w3-container w3-light-grey"><h2>Admin Dashboard</h2></div>

<div class="w3-container">
<a href="index"> << return to Blog index</a><br/><br/>

<p>Welcome <?php echo $_SESSION['username']; ?></p>
<a href="edit_contact.php">Edit Contact Page</a><br/><br/>
<a href="new">Create Article</a><br/><br/>
<a href="video_upload">Upload Video</a><br/><br/>
<a href="photo_upload">Upload Photo</a><br/><br/>
<a href="new_photoset">Create Photo Set</a><br/><br/>
<p><a href="logout">Logout</a></p>
</div>

<!-- tabs for switching between the display of articles, videos and posts data / modification options -->
 <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">ARTICLES</a></li>
    <li><a data-toggle="tab" href="#menu1">VIDEOS</a></li>
    <li><a data-toggle="tab" href="#menu2">PHOTO</a></li>
  <li><a data-toggle="tab" href="#menu3">PHOTOSETS</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3>ARTICLES</h3>
      <p><?php include("tab_articles.php"); ?></p>
    </div>
    <div id="menu1" class="tab-pane fade">
      <h3>VIDEOS</h3>
      <p><?php include("tab_video.php"); ?></p>
    </div>
    <div id="menu2" class="tab-pane fade">
      <h3>PHOTOS</h3>
      <p><?php include("tab_photo.php"); ?></p>
    </div>
      <div id="menu3" class="tab-pane fade">
      <h3>PHOTOSETS</h3>
      <p><?php include("tab_photoset.php"); ?></p>
    </div>
  </div>
<!-- tabs close -->

<?php
include("footer.php");
?>