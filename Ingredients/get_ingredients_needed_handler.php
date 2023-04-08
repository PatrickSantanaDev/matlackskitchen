<?php
require_once '../Dao.php';

$dao = new Dao();

if (isset($_GET['refreshIngredients'])) {
	$ingredientsNeeded = $dao->getIngredientsNeeded();

	header('Content-Type: application/json');
	echo json_encode($ingredientsNeeded);
	exit;
}
