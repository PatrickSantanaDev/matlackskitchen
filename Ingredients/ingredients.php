<?php session_start(); ?>

<?php include_once '../authorized.php'; ?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="../css/ingredients.css">
  <link rel="stylesheet" type="text/css" href="../css/footer.css">
  <link rel="stylesheet" type="text/css" href="../css/logout_button.css">
  <link rel="shortcut icon" type="image/png" href="../Images/knife.png?">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap');
  </style>
  <title>Ingredients</title>
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
    <img src="../Images/ingredientstitle.png" />
  </div>

  <!-- Navigation Bar -->
  <?php include_once '../navigation_bar.php'; ?>

  <!-- Add Ingredient Form -->
  <div id="addIngredientViewer">
    <form id="addIngredient" action="submit_ingredient_handler.php" method="post">
      <legend class="legend">Add Ingredient:</legend>
      <label for="ingredient_name">Ingredient Name:</label>
      <input type="text" id="ingredient_name" name="ingredient_name" required><br><br>

      <label for="category">Category:</label>
      <select id="category" name="category">
        <option value="dairy">Dairy</option>
        <option value="protein">Protein</option>
      </select><br><br>

      <input id="addIngredientButton" type="submit" value="Submit">
    </form>
  </div>

  <!-- Ingredients List -->
  <form id="ingredientsList">
    <fieldset class="ingredientsList">
      <legend class="legend">Select Ingredients Needed:</legend>

      <div class="submit">
        <button id="refreshIngredientsButton" method="GET" formaction="get_ingredients_handler.php" name="refreshIngredients" type="submit">Show Ingredients</button>
      </div>

      <!-- Proteins -->
      <?php if (isset($proteinIngredients)) { ?>
        <fieldset class="proteins">
          <legend class="legend">Proteins</legend>
          <?php foreach ($proteinIngredients as $ingredient) { ?>
            <div>
              <input type="checkbox" id="<?= $ingredient['id'] ?>" name="ingredient_name[]" value="<?= $ingredient['ingredient_name'] ?>" />
              <label for="<?= $ingredient['id'] ?>"><?= $ingredient['ingredient_name'] ?></label>
            </div>
          <?php } ?>
        </fieldset>
      <?php } ?>

      <!-- Dairy -->
      <?php if (isset($dairyIngredients)) { ?>
        <fieldset class="dairy">
          <legend class="legend">Dairy</legend>
          <?php foreach ($dairyIngredients as $ingredient) { ?>
            <div>
              <input type="checkbox" id="<?= $ingredient['id'] ?>" name="ingredient_name[]" value="<?= $ingredient['ingredient_name'] ?>" />
              <label for="<?= $ingredient['id'] ?>"><?= $ingredient['ingredient_name'] ?></label>
            </div>
          <?php } ?>
        </fieldset>
      <?php } ?>

      <div class="submit">
        <button id="submitIngredientsButton" method="POST" formaction="submit_ingredients_needed_handler.php" name="submitIngredients" type="submit">Submit Ingredients List</button>
      </div>
    </fieldset>
  </form>

  <!--Footer-->
  <?php include_once '../footer.php'; ?>

</body>

</html>