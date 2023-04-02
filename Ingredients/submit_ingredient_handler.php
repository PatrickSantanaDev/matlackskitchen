<?php
// include the submitIngredient function
require_once '../Dao.php';
$dao = new Dao();
// check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get the form data
  $ingredient_name = $_POST['ingredient_name'];
  $category = $_POST['category'];
  $added_by_username = 'your_username'; // replace with your username

  // insert the data into the database
  $dao->submitIngredient($ingredient_name, $category, $added_by_username);

  // redirect the user to the homepage or a success page
  header('Location: ingredients.php');
  exit();
}
?>
