<?php
require_once '../Dao.php';

$dao = new Dao();

if (isset($_GET['refreshIngredients'])) {
  $dairyIngredients = $dao->getIngredientsByCategory('dairy');
  $proteinIngredients = $dao->getIngredientsByCategory('protein');
}

include 'ingredients.php';
?>
