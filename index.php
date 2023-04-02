<?php
session_start();
?>

<?php include_once 'authorized.php';?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <link rel="stylesheet" type="text/css" href="css/footer.css">
  <link rel="stylesheet" type="text/css" href="css/logout_button.css">
  <link rel="shortcut icon" type="image/png" href="Images/knife.png?">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap');
  </style>
  <title>Main</title>
</head>

<body>
  <div class="logout">
    <a href="logout.php"><button>Logout</button></a>
  </div>

  <!-- Logo -->
  <div id="logo">
    <img src="Images/klogo.png" />
  </div>

  <!-- Navigation Menu -->
  <nav>
    <div class="menu">
      <a href="https://www.matlacksboise.com/"><button>Website</button></a>
      <a href="menu.php"><button>Menu</button></a>
      <a href="recipes.php"><button>Recipes</button></a>
      <a href="builds.php"><button>Builds</button></a>
      <a href="tasks.php"><button>Tasks</button></a>
      <a href="ingredients.php"><button>Ingredients</button></a>
      <a href="schedule.php"><button>Schedule</button></a>
      <a href="photos.php"><button>Photos</button></a>
    </div>
  </nav>

  <!--Footer-->
  <footer class="footer">
    <p>&copy MATLACK'S PUBLIC HOUSE 1100 WEST FRONT STREET, BOISE, ID, 83702, UNITED STATES 208-336-2561  
      <a href="mailto:matlackskitchen@gmail.com">matlackskitchen@gmail.com</a></p>
  </footer>

</body>

</html>