<?php
session_start();
require_once '../Dao.php';
$logger = new KLogger("log.txt", KLogger::DEBUG);

$dao = new Dao();
$errors = array();

//santize
function sanitize_input($input)
{
  //tags
  $input = strip_tags($input);
  //unsavory chars
  $input = preg_replace('/[^a-zA-Z0-9\s.]/', '', $input);
  //trim
  $input = trim($input);
  // Limit input to 1000 chars
  $input = substr($input, 0, 1000);
  return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $recipeName = sanitize_input($_POST["name"]);
  $category = sanitize_input($_POST["category"]);
  $ingredients = sanitize_input($_POST["ingredients"]);
  $instructions = sanitize_input($_POST["instructions"]);
  $username = $_SESSION['username'];

  //validation
  if (empty($recipeName) || empty($category) || empty($ingredients) || empty($instructions)) {
    $errors[] = "Please provide input for all fields.";
  }

  if (strlen($recipeName) > 20) {
    $errors[] = "Recipe name should be less than or equal to 20 characters.";
  }

  if (empty($errors)) {
    $dao->postRecipeInfo($recipeName, $category, $ingredients, $instructions, $username);
    unset($_SESSION['recipeName']);
    unset($_SESSION['category']);
    unset($_SESSION['ingredients']);
    unset($_SESSION['instructions']);
    header("Location: recipes.php");
  } else {
    $_SESSION['errors'] = $errors;
    $_SESSION['recipeName'] = $recipeName;
    $_SESSION['category'] = $category;
    $_SESSION['ingredients'] = $ingredients;
    $_SESSION['instructions'] = $instructions;
    header("Location: recipes.php");
  }
}
