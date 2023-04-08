<?php
require_once '../Dao.php';

$dao = new Dao();

if (isset($_GET['refreshIngredients'])) {
    $dairyIngredients = $dao->getIngredientsByCategory('dairy');
    $proteinIngredients = $dao->getIngredientsByCategory('protein');

    header('Content-Type: application/json');
    echo json_encode([
        'dairyIngredients' => $dairyIngredients,
        'proteinIngredients' => $proteinIngredients,
    ]);
    exit;
}
