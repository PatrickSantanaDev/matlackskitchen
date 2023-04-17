<?php
require_once '../Dao.php';

$dao = new Dao();

if (isset($_GET['refreshIngredients'])) {
    $dairyIngredients = $dao->getIngredientsByCategory('dairy');
    $proteinIngredients = $dao->getIngredientsByCategory('protein');
    $produceIngredients = $dao->getIngredientsByCategory('produce');
    $dryGoodsIngredients = $dao->getIngredientsByCategory('drygoods');
    $miscIngredients = $dao->getIngredientsByCategory('misc');


    header('Content-Type: application/json');
    echo json_encode([
        'dairyIngredients' => $dairyIngredients,
        'proteinIngredients' => $proteinIngredients,
        'produceIngredients' => $produceIngredients,
        'dryGoodsIngredients' => $dryGoodsIngredients,
        'miscIngredients' => $miscIngredients
    ]);
    exit;
}
