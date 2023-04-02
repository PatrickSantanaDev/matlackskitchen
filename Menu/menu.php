<?php
session_start();
?>

<?php include_once '../authorized.php';?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="../css/menu.css">
  <link rel="stylesheet" type="text/css" href="../css/footer.css">
  <link rel="stylesheet" type="text/css" href="../css/logout_button.css">
  <link rel="shortcut icon" type="image/png" href="../Images/knife.png?">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap');
  </style>
  <title>Menu</title>
</head>

<body>
    <!-- Logo -->
  <div id="logo">
    <img src="../Images/klogo.png" />
  </div>

  <div class="logout">
    <a href="../logout.php"><button>Logout</button></a>
  </div>

  <!-- Page Title -->
  <div id="title">
    <img src="../Images/menutitle.png" />
  </div>

  <!-- Navigation Bar -->
  <div class="menu">
    <a class="active" href="../index.php">Home</a>
    <a href="https://www.matlacksboise.com/">Website</a>
    <a href="menu.php">Menu</a>
    <a href="recipes.php">Recipes</a>
    <a href="builds.html">Builds</a>
    <a href="tasks.html">Tasks</a>
    <a href="ingredients.html">Ingredients</a>
    <a href="schedule.html">Schedule</a>
    <a href="photos.html">Photos</a>
  </div>

  <!-- Menu Viewer -->
  <h2 id="menu_viewer_header">Menu Viewer</h2>
  <div id="menuviewer">
		<?php include 'menu_display_handler.php'; ?>
	</div>

  <!-- Upload Menu -->
  <div id="menuupload">
  <form id="uploadmenu" method="post" action="menu_handler.php" enctype="multipart/form-data">
    <label for="uploadmenu">Select Menu File and Upload (.png):</label><br>
    <input type="file" id="uploadmenu" name="uploadmenu" accept=".png" /><br>
    <button type="submit" name="submit" value="upload">Upload</button>
  </form>

  <form id="deletemenu" method="post" action="delete_menu_handler.php">
    <button type="submit" name="delete">Delete</button>
  </form>
</div>


<!-- Items out of Stock -->
<form id="oositems" action="oos_item_input_handler.php" method="post">
  <h2>Out of Stock Menu Items</h2>
  <input type="text" id="enteritems" name="item_name" placeholder="Enter Out of Stock Item...">
  <button type="submit" id="oosaddbutton">Add</button>
</form>
<ul id="oositemslist">
  <?php include('get_oos_items_handler.php'); ?>
</ul>




  

  <!--Footer-->
  <footer class="footer">
    <p>&copy MATLACK'S PUBLIC HOUSE 1100 WEST FRONT STREET, BOISE, ID, 83702, UNITED STATES 208-336-2561
      <a href="mailto:matlackskitchen@gmail.com">matlackskitchen@gmail.com</a>
    </p>
  </footer>

</body>

</html>