<?php
session_start();
require_once("../Dao.php");

$dao = new Dao();

if (isset($_POST["submitIngredients"])) {
    $ingredients = array();

    // Get all checked ingredients from the form
    foreach ($_POST["ingredient_name"] as $ingredient_id) {
        $is_needed = ($_POST[$ingredient_id] == "on") ? 1 : 0; // check if the checkbox is checked
        $ingredient_name = $dao->getIngredientNameById($ingredient_id);
        $ingredients[] = array("ingredient_name" => $ingredient_name, "is_needed" => $is_needed);
    }

    // Insert each ingredient into the ingredients_needed table in the database
    foreach ($ingredients as $ingredient) {
        $dao->submitIngredientsNeeded($ingredient["ingredient_name"], $ingredient["is_needed"]);
    }

    header("Location: ingredients.php");
    exit();
} else {
    header("Location: ingredients.php");
    exit();
}
?>
