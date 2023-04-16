<?php session_start(); ?>

<?php include_once '../authorized.php'; ?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="../css/recipes.css">
  <link rel="stylesheet" type="text/css" href="../css/footer.css">
  <link rel="stylesheet" type="text/css" href="../css/logout_button.css">
  <link rel="stylesheet" type="text/css" href="../css/navigation.css">
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
  <?php
  $currentPage = "recipes";
  include_once '../navigation_bar.php';
  ?>

  <!-- Dropdown Recipe Search -->
  <!-- Category Search -->
  <div class="header">
    <h2>Search for a recipe:</h2>
  </div>
  <form id="catSearch" action="get_recipes_by_category_handler.php" method="get">
    <label for="searchByCategory">Search by recipe category:</label>
    <select id="searchByCategory" name="searchByCategory">
      <option value="">Select a category</option>
      <?php
      include('get_categories_handler.php');
      foreach ($categories as $category) {
        echo '<option value="' . htmlspecialchars($category['category'], ENT_QUOTES) . '">' . htmlspecialchars($category['category'], ENT_QUOTES) . '</option>';
      }
      ?>
    </select>
    <input id="catSearchButton" type="submit" name="submit" value="Search">
  </form>

  <!-- Recipe Search -->
  <form id="recipeSearch" action="recipes.php" method="get">
    <label for="searchbyRecipeName">Search by recipe name:</label>
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
    <div class="errors" style="<?php echo (!empty($errors) ? '' : 'display:none;'); ?>">
      <?php if (!empty($errors)) : ?>
        <?php foreach ($errors as $error) : ?>
          <?php echo $error; ?>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
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
  <div class="header">
    <h2>Add a recipe:</h2>
  </div>
  <form class="uploadRecipeForm" action="upload_recipe_handler.php" method="post" enctype="multipart/form-data">
    <?php if (!empty($_SESSION['errors'])) : ?>
      <div class="errors">
        <?php foreach ($_SESSION['errors'] as $error) : ?>
          <?php echo $error; ?> <br>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <?php unset($_SESSION['errors']); ?>

    <input id="recipeName" type="text" name="name" placeholder="Enter Recipe name..." value="<?php echo (isset($_SESSION['recipeName']) && empty($_SESSION['errors'])) ? $_SESSION['recipeName'] : '' ?>"><br>
    <div>
      <select id="category" name="category">
        <option value="">Select a category</option>
        <option value="Dressings" <?php if (isset($_SESSION['category']) && $_SESSION['category'] == 'Dressings') echo 'selected'; ?>>Dressings</option>
        <option value="Sauces" <?php if (isset($_SESSION['category']) && $_SESSION['category'] == 'Sauces') echo 'selected'; ?>>Sauces</option>
        <option value="Rubs/Brines" <?php if (isset($_SESSION['category']) && $_SESSION['category'] == 'Rubs/Brines') echo 'selected'; ?>>Rubs/Brines</option>
        <option value="Apps" <?php if (isset($_SESSION['category']) && $_SESSION['category'] == 'Apps') echo 'selected'; ?>>Apps</option>
        <option value="Mains" <?php if (isset($_SESSION['category']) && $_SESSION['category'] == 'Mains') echo 'selected'; ?>>Mains</option>
        <option value="Desserts" <?php if (isset($_SESSION['category']) && $_SESSION['category'] == 'Desserts') echo 'selected'; ?>>Desserts</option>
      </select>
    </div>
    <textarea id="ingredients" name="ingredients" placeholder="Enter Ingredients..."><?php echo (isset($_SESSION['ingredients']) && empty($_SESSION['errors'])) ? $_SESSION['ingredients'] : '' ?></textarea><br>
    <textarea id="instructions" name="instructions" placeholder="Enter Instructions..."><?php echo (isset($_SESSION['instructions']) && empty($_SESSION['errors'])) ? $_SESSION['instructions'] : '' ?></textarea><br>

    <button id="uploadRecipeButton" type="submit">Upload Recipe</button>
  </form>

  <!--Footer-->
  <?php include_once '../footer.php'; ?>

</body>

</html>