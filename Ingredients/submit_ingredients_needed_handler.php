<?php
require_once '../Dao.php';
session_start();

$dao = new Dao();

$ingredientNames = $_POST['ingredient_name'];
$addedByUsername = $_SESSION['username'];

$dao = new Dao();
$dao->submitIngredientsNeeded($ingredientNames, $addedByUsername);

header('Location: ingredients.php');
exit;
