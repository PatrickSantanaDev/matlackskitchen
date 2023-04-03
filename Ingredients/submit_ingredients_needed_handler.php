<?php
require_once '../Dao.php';
$dao = new Dao();

// Get the selected ingredient names from the form
$ingredientNames = $_POST['ingredient_name'];

// Get the current user's username from the session
session_start();
$addedByUsername = $_SESSION['username'];

// Submit the ingredients to the database
$dao = new Dao();
$dao->submitIngredientsNeeded($ingredientNames, $addedByUsername);

  // Redirect to a success page
  header('Location: ingredients.php');
  exit;

