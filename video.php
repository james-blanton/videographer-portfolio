<?php 
/*-------------------------------------------
FILE PURPOSE

This file displays tabs for each video category. 
Each category tab includes a seperate file that queries the database to display the videos that belong to that specific category.

The javascript function at the end of this file toggles the width of video to display at 100% the width of its parent container div. Currently this javascript is unneccessary because I have the width of all videos on the portfolio set to 100%. However, I may change this behavior in the future once I have more videos to submit to the portfolio.

Currently I have commented out the travel, weddings an editorial categories until I have appropriate content for these categories.

/*------------------------------------------*/

include('header.php'); 

?>

<link rel="stylesheet" href="styles/photo_styles.css">

<button class = "full_width_btn" onclick="fullWidthFunction()">MENU</button>

<div id="photography_menu" style="display: block;">

 <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">ALL</a></li>
    <li><a data-toggle="tab" href="#menu1">MOTION GRAPHICS</a></li>
    <li><a data-toggle="tab" href="#menu2">PORTRAIT</a></li>
    <li><a data-toggle="tab" href="#menu3">LANDSCAPE</a></li>
    <li><a data-toggle="tab" href="#menu4">COMMERCIAL</a></li>
    <!--
    <li><a data-toggle="tab" href="#menu5">TRAVEL</a></li>
    <li><a data-toggle="tab" href="#menu6">WEDDINGS</a></li>
    <li><a data-toggle="tab" href="#menu7">EDITORIAL</a></li>
  -->
  </ul>
  </div>


  <div class="tab-content">

    <div id="home" class="tab-pane fade in active">
      <h3>ALL</h3>
      <?php include('display_video.php'); ?>
    </div>

    <div id="menu1" class="tab-pane fade">
      <h3>MOTION GRAPHICS</h3> 
      <?php include('displayv_motion_graphic.php'); ?>
    </div>

    <div id="menu2" class="tab-pane fade">
      <h3>PORTRAIT</h3>
      Coming soon ...
      <?php include('displayv_portrait.php'); ?>
    </div>

    <div id="menu3" class="tab-pane fade">
      <h3>LANDSCAPE</h3>
      Coming soon ...
      <?php include('displayv_landscape.php'); ?>  
    </div>

    <div id="menu4" class="tab-pane fade">
      <h3>COMMERCIAL</h3>
      Coming soon ...
      <?php include('displayv_commercial.php'); ?>   
    </div>

    <div id="menu5" class="tab-pane fade">
      <h3>TRAVEL</h3>
      Coming soon ...
      <?php include('displayv_travel.php'); ?>   
    </div>

    <div id="menu6" class="tab-pane fade">
      <h3>WEDDINGS</h3>
      Coming soon ...
      <?php include('displayv_weddings.php'); ?>   
    </div>

    <div id="menu7" class="tab-pane fade">
      <h3>EDITORIAL</h3>
      Coming soon ...
      <?php include('displayv_editorial.php'); ?>   
    </div>

  </div>
  
</div>

        
</div>
</div>

<!-- displays the image at the full width of the parent div,  can be toggled on and off --> 
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