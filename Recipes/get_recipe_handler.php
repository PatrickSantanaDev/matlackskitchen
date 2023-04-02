<?php
require_once('../Dao.php');
$dao = new Dao();

$recipe = null; 

if (isset($_GET['recipe_name'])) {
  $recipeName = $_GET['recipe_name'];
  $recipe = $dao->getRecipeByName($recipeName);
}

foreach ($recipes as $recipe) {
  echo '<option value="' . htmlspecialchars($recipe['recipe_name'], ENT_QUOTES) . '">' . htmlspecialchars($recipe['recipe_name'], ENT_QUOTES) . '</option>';
}

?>
