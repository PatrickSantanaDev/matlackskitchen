<?php
session_start();
require_once '../Dao.php';
$logger = new KLogger("log.txt", KLogger::DEBUG);

$dao = new Dao();
$errors = array();

//sanitize
function sanitize_input($input)
{
  //tags
  $input = strip_tags($input);
  //unsavory chars
  $input = preg_replace('/[^a-zA-Z0-9\s.]/', '', $input);
  //trim
  $input = trim($input);
  // Limit input to 25 chars
  $input = substr($input, 0, 25);
  return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $ingredient_name = sanitize_input($_POST['ingredient_name']);
  $category = sanitize_input($_POST['category']);
  $added_by_username = 'your_username';

  //validation
  if (empty($ingredient_name) || empty($category)) {
    $errors[] = "Please provide input for all fields.";
  }

  if (strlen($ingredient_name) > 20) {
    $errors[] = "Ingredient name should not exceed 20 characters.";
  }

  if (empty($errors)) {
    $dao->submitIngredient($ingredient_name, $category, $added_by_username);
    header("Location: ingredients.php");
  } else {
    $_SESSION['errors'] = $errors;
    $_SESSION['ingredient_name'] = $ingredient_name;
    $_SESSION['category'] = $category;
    header("Location: ingredients.php");
  }
}
