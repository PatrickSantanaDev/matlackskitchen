<?php
session_start();
require_once '../Dao.php';
$logger = new KLogger ( "log.txt" , KLogger::DEBUG );

$dao = new Dao();

function sanitize_input($input) {
  // Remove any tags
  $input = strip_tags($input);

  // Replace any unwanted characters
  $input = preg_replace('/[^a-zA-Z0-9\s]/', '', $input);

  // Trim the input
  $input = trim($input);

  // Limit input to 5000 chars
  $input = substr($input, 0, 5000);

  // Return the sanitized input
  return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $recipeName = sanitize_input($_POST["name"]);
  $category = sanitize_input($_POST["category"]);
  $ingredients = sanitize_input($_POST["ingredients"]);
  $instructions = sanitize_input($_POST["instructions"]);
  $username = $_SESSION['username'];

  if (strlen($recipeName) > 20) {
    $recipeName = substr($recipeName, 0, 20);
  }

  $dao->postRecipeInfo($recipeName, $category, $ingredients, $instructions, $username);

  header("Location: recipes.php");
}
