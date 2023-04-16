<?php session_start(); ?>

<?php include_once '../authorized.php'; ?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="../css/ingredients.css">
  <link rel="stylesheet" type="text/css" href="../css/footer.css">
  <link rel="stylesheet" type="text/css" href="../css/logout_button.css">
  <link rel="stylesheet" type="text/css" href="../css/navigation.css">
  <link rel="shortcut icon" type="image/png" href="../Images/knife.png?">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap');
  </style>
  <title>Ingredients</title>

  <!-- Javascript -->
  <script src="../Ingredients/ingredients.js"></script>
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
  <?php
  $currentPage = "ingredients";
  include_once '../navigation_bar.php';
  ?>

  <!-- Add Ingredient Form -->
  <div id="addIngredientViewer">
    <form id="addIngredient" action="submit_ingredient_handler.php" method="post">
      <h2>Add Ingredient:</h2>
      <?php if (isset($_SESSION['errors'])) : ?>
        <div class="errors">
          <?php foreach ($_SESSION['errors'] as $error) : ?>
            <p><?php echo $error; ?></p>
          <?php endforeach;
          unset($_SESSION['errors']); ?>
        </div>
      <?php endif; ?>
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
  <form id="ingredientsList" method="POST" action="submit_ingredients_needed_handler.php">
    <fieldset class="ingredientsList">
      <h2>Select Ingredients Needed:</h2>

      <div id="ingredientsDiv"></div>

      <div class="submit">
        <button id="submitIngredientsButton" name="submitIngredients" type="submit">Submit Ingredients List</button>
      </div>
    </fieldset>
  </form>

  <div id="ingredients_needed_display">
    <h2>Ingredients Needed:</h2>
    <table id="ingredientsTable">
      <thead>
        <tr>
          <th>Ingredient Name</th>
          <th>Needed?</th>
          <th>Added By</th>
          <th>Date Added</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

  <form method="post" action="clear_ingredients_needed_handler.php">
    <button id="clear_ingredients_needed" type="submit">Clear Ingredients Needed</button>
  </form>

  <!--Footer-->
  <?php include_once '../footer.php'; ?>

</body>

</html>