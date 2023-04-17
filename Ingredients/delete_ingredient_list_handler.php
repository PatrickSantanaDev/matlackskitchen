<?php
require_once '../Dao.php';

$dao = new Dao();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $ingredientId = $data['ingredientId'];
    $dao->deleteIngredient($ingredientId);
}
