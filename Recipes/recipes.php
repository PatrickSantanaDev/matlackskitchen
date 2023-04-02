<?php session_start(); ?>

<?php include_once '../authorized.php'; ?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="../css/recipes.css">
  <link rel="stylesheet" type="text/css" href="../css/footer.css">
  <link rel="stylesheet" type="text/css" href="../css/logout_button.css">
  <link rel="shortcut icon" type="image/png" href="../Images/knife.png?">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap');
  </style>
  <title>Recipes</title>
</head>

<body>

  <!-- Logo -->
  <div id="logo">
    <img src="../Images/klogo.png" />
  </div>

  <!-- Logout -->
  <div class="logout">
    <a href="../logout.php"><button>Logout</button></a>
  </div>

  <!-- Page Title -->
  <div id="title">
    <img src="../Images/recipestitle.png" />
  </div>

  <!-- Navigation Bar -->
  <?php include_once '../navigation_bar.php'; ?>

  <!-- Dropdown Recipe Search -->
  <!-- Category Search -->
  <form id="catSearch" action="get_recipes_by_category_handler.php" method="get">
    <label for="searchByCategory">Search for Recipes by Category:</label>
    <select id="searchByCategory" name="searchByCategory">
      <option value="">Select a category</option>
      <?php
      include('get_categories_handler.php');
      foreach ($categories as $category) {
        echo '<option value="' . htmlspecialchars($category['category'], ENT_QUOTES) . '">' . htmlspecialchars($category['category'], ENT_QUOTES) . '</option>';
      }
      ?>
    </select>
    <input id="catSearchButton" type="submit" value="Search">
  </form>

  <!-- Recipe Search -->
  <form id="searchByRecipeName" action="recipes.php" method="get">
    <label for="searchbyRecipeName">Search for Recipes:</label>
    <select id="searchbyRecipeName" name="recipe_name">
      <option value="">Select a recipe</option>
      <?php
      include('get_recipe_handler.php');
      //movedforeachloop to handler!
      ?>
    </select>
    <input id="nameSearchButton" type="submit" value="View Recipe">
  </form>

  <!-- Recipe Viewer -->
  <div id="recipeViewer">
    <?php if (isset($_GET['recipe_name'])) :
      $recipe_name = $_GET['recipe_name'];
      $recipe = $dao->getRecipeByName($recipe_name);
      if (!$recipe) {
        echo "<p>No recipe found.</p>";
      } else {
    ?>
        <table>
          <tr>
            <th>Recipe Name:</th>
            <td><?php echo htmlspecialchars($recipe['recipe_name'], ENT_QUOTES); ?></td>
          </tr>
          <?php if (isset($recipe['ingredients'])) : ?>
            <tr>
              <th>Ingredients:</th>
              <td><?php echo nl2br(htmlspecialchars($recipe['ingredients'], ENT_QUOTES)); ?></td>
            </tr>
          <?php endif; ?>
          <tr>
            <th>Instructions:</th>
            <td><?php echo nl2br(htmlspecialchars($recipe['instructions'], ENT_QUOTES)); ?></td>
          </tr>
        </table>
    <?php
      }
    elseif (!$recipe) :
      echo "<p>No recipe selected.</p>";
    endif; ?>
  </div>


  <!-- Delete Recipe -->
  <div id="deleteRecipe">
    <?php if ($recipe) : ?>
      <form action="delete_recipe_handler.php" method="POST">
        <input type="hidden" name="recipe_name" value="<?php echo htmlspecialchars($recipe['recipe_name'], ENT_QUOTES); ?>">
        <button id="deleteRecipeButton" type="submit">Delete Recipe</button>
      </form>
    <?php endif; ?>
  </div>


  <!-- Upload Recipe -->
  <form class="uploadRecipeForm" action="upload_recipe_handler.php" method="post" enctype="multipart/form-data">
    <input id="recipeName" type="text" name="name" placeholder="Enter Recipe name..."><br>
    <div><select id="category" name="category">
        <option value="">Select a category</option>
        <option value="Dressings">Dressings</option>
        <option value="Sauces">Sauces</option>
        <option value="Rubs/Brines">Rubs/Brines</option>
        <option value="Apps">Apps</option>
        <option value="Mains">Mains</option>
        <option value="Desserts">Desserts</option>
      </select></div>
    <textarea id="ingredients" name="ingredients" placeholder="Enter Ingredients..."></textarea><br>
    <textarea id="instructions" name="instructions" placeholder="Enter Instructions..."></textarea><br>
    <button id="uploadRecipeButton" type="submit">Upload Recipe</button>
  </form>


  <!--Footer-->
  <?php include_once '../footer.php'; ?>

</body>

</html>