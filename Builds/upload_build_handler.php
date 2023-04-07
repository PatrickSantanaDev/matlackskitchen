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
  // Limit input to 2500 chars
  $input = substr($input, 0, 2500);
  return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $buildName = sanitize_input($_POST["name"]);
  $category = sanitize_input($_POST["category"]);
  $build_ingredients = sanitize_input($_POST["build_ingredients"]);
  $build_instructions = sanitize_input($_POST["build_instructions"]);
  $username = $_SESSION['username'];

  //validation
  if (empty($buildName) || empty($category) || empty($build_ingredients) || empty($build_instructions)) {
    $errors[] = "Please provide input for all fields.";
  }

  if (strlen($buildName) > 20) {
    $errors[] = "Build name should be less than or equal to 20 characters.";
  }


  if (empty($errors)) {
    $dao->postBuildInfo($buildName, $category, $build_ingredients, $build_instructions, $username);
    header("Location: builds.php");
  } else {
    $_SESSION['errors'] = $errors;
    $_SESSION['buildName'] = $buildName;
    $_SESSION['category'] = $category;
    $_SESSION['build_ingredients'] = $build_ingredients;
    $_SESSION['build_instructions'] = $build_instructions;
    header("Location: builds.php");
  }
}
