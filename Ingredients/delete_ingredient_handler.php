<?php
require_once '../Dao.php';

$dao = new Dao();

$ingredient_id = $_POST['ingredient_id'];
$dao->deleteNeededIngredient($ingredient_id);

