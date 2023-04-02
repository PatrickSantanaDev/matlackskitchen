<?php
require_once('../Dao.php');
$dao = new Dao();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipe_name = $_POST['recipe_name'];
    $dao->deleteRecipeByName($recipe_name);
    header('Location: ../recipes.php');
    exit();
  }
  

