<?php
require_once('../Dao.php');
$dao = new Dao();

$errors = array();

if (isset($_GET['submit'])) {
  $category = $_GET['searchByCategory'];
  if (empty($category)) {
    $errors[] = "Please select a category";
  } else {
    $recipes = $dao->getRecipesByCategory($category);
  }
}

include('recipes.php');
