<?php 
/*-------------------------------------------
FILE PURPOSE

This file displays tabs for each video category.

Each category tab includes a function that queries the database to display the videos which belong to that specific category. Check functions.php if you wish to edit how the videos are displayed. 

Currently I have commented out the travel, weddings an editorial categories until I have appropriate content for these categories.

/*------------------------------------------*/

include('header.php'); 

?>

<link rel="stylesheet" href="styles/photo_styles.css">

<button class = "full_width_btn" onclick="fullWidthFunction()">MENU</button>

<div id="photography_menu">

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
      <?php $type = 'Motion Graphics'; display_video($type); ?>
    </div>

    <div id="menu2" class="tab-pane fade">
      <h3>PORTRAIT</h3>
      Coming soon ...
      <?php $type = 'Portrait'; display_video($type); ?>
    </div>

    <div id="menu3" class="tab-pane fade">
      <h3>LANDSCAPE</h3>
      Coming soon ...
      <?php $type = 'Landscape'; display_video($type); ?> 
    </div>

    <div id="menu4" class="tab-pane fade">
      <h3>COMMERCIAL</h3>
      Coming soon ...
      <?php $type = 'Landscape'; display_video($type); ?> 
    </div>

    <div id="menu5" class="tab-pane fade">
      <h3>TRAVEL</h3>
      Coming soon ...
      <?php $type = 'Travel'; display_video($type); ?>
    </div>

    <div id="menu6" class="tab-pane fade">
      <h3>WEDDINGS</h3>
      Coming soon ...
      <?php $type = 'Weddings'; display_video($type); ?>  
    </div>

    <div id="menu7" class="tab-pane fade">
      <h3>EDITORIAL</h3>
      Coming soon ...
      <?php $type = 'Editorial'; display_video($type); ?> 
    </div>

  </div>
  
</div>

        
</div>
</div>

<?php include('footer.php'); ?>