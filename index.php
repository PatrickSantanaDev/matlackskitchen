<?php session_start(); ?>

<?php include_once 'authorized.php'; ?>

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
  <!-- Logout Button -->
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
      <a href="Menu/menu.php"><button>Menu</button></a>
      <a href="Recipes/recipes.php"><button>Recipes</button></a>
      <a href="Builds/builds.php"><button>Builds</button></a>
      <a href="Tasks/tasks.php"><button>Tasks</button></a>
      <a href="Ingredients/ingredients.php"><button>Ingredients</button></a>
      <a href="Schedule/schedule.php"><button>Schedule</button></a>
      <a href="Photos/photos.php"><button>Photos</button></a>
    </div>
  </nav>

  <!--Footer-->
  <?php include_once 'footer.php'; ?>

</body>

</html>