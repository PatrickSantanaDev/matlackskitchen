<?php session_start(); ?>

<?php include_once '../authorized.php'; ?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="../css/builds.css">
  <link rel="stylesheet" type="text/css" href="../css/footer.css">
  <link rel="stylesheet" type="text/css" href="../css/logout_button.css">
  <link rel="shortcut icon" type="image/png" href="../Images/knife.png?">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap');
  </style>
  <title>Builds</title>
</head>

<body>

  <!-- Logo -->
  <div id="logo">
    <img src="../Images/klogo.png" />
  </div>

  <!-- Logout Button -->
  <div class="logout">
    <a href="../logout.php"><button>Logout</button></a>
  </div>

  <!-- Page Title -->
  <div id="title">
    <img src="../Images/buildstitle.png" />
  </div>


  <!-- Navigation Bar -->
  <?php include_once '../navigation_bar.php'; ?>

  <!-- Dropdown Builds Search-->
  <!-- Category Search -->
  <form id="catSearch" action="" method="get">
    <label for="searchbyCategory">Search for Builds by Category:</label>
    <select id="searchByCategory" name="searchbyCategory">
      <option value="">Select a category</option>
      <option value="sandwiches">Sandwiches</option>
      <option value="salads">Salads</option>
      <option value="apps">Appetizers</option>
    </select>
    <button id="catSearchButton" type="submit">Search</button>
  </form>

  <!-- Name Search -->
  <form id="nameSearch" action="" method="get">
    <label for="searchByName">Search for Build by Name:</label>
    <select id="searchByName" name="searchByName">
      <option value="">Select a Build Name</option>
      <option value="bossHog">Boss Hog</option>
      <option value="triTip">Tri-Tip</option>
      <option value="banhMi">Banh Mi</option>
    </select>
    <button id="nameSearchButton" type="submit">Search</button>
  </form>

  <!-- Builds Viewer -->
  <table id="recipeViewer">
    <tr>
      <th>Build Name:</th>
      <td>Boss Hog</td>
    </tr>
    <tr>
      <th>Ingredients:</th>
      <td>Smoked Pork Loin<br>
        Mama Lils Peppers<br>
        Thin, Sliced Mozzarella<br>
        Chive Aioli
      </td>
    </tr>
    <tr>
      <th>Instructions:</th>
      <td>Put 2 oz. chive aioli on both sides of bread<br>
        Add 5 oz. sliced pork to bottom half of toasted ciabatta<br>
        Add 2 pieces of mozzarella on top of pork<br>
        Place 2 oz. mama lil's peppers to top half of toasted ciabatta
      </td>
      </td>
    </tr>
    <tr>
      <th>Build Photos:</th>
      <td><img id="buildPhotos" src="../Images/bosshog.jpg"></td>
    </tr>
  </table>
  </div>

  <!-- Delete Build -->
  <div id="deleteRecipe">
    <form action="" method="POST">
      <input type="hidden" name="recipe_id" value="">
      <button id="deleteRecipeButton" type="submit">Delete Build</button>
    </form>
  </div>

  <!-- Upload Build -->
  <form class="uploadRecipeForm" action="" method="post" enctype="multipart/form-data">
    <input id="recipeName" type="text" name="recipeName" placeholder="Enter Build name..."><br>
    <textarea id="ingredients" name="ingredients" placeholder="Enter Ingredients..."></textarea><br>
    <textarea id="instructions" name="instructions" placeholder="Enter Instructions..."></textarea><br>
    <input type="file" id="selectBuildPhotos" name="selectBuildPhotos" accept=".jpg" /><br>
    <button id="uploadRecipeButton" type="submit">Upload Build</button>
  </form>

  <!--Footer-->
  <?php include_once '../footer.php'; ?>

</body>

</html>