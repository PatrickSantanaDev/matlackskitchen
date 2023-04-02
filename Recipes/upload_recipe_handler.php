<?php
session_start();
require_once '../Dao.php';
$logger = new KLogger ( "log.txt" , KLogger::DEBUG );

$dao = new Dao();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $recipeName = $_POST["name"];
  $category = $_POST["category"];
  $ingredients = $_POST["ingredients"];
  $instructions = $_POST["instructions"];
  $username = $_SESSION['username'];

  $dao->postRecipeInfo($recipeName, $category, $ingredients, $instructions, $username);

  header("Location: recipes.php");
}
