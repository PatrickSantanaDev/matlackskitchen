<?php
session_start();
require_once '../Dao.php';

// Create a new instance of the Dao class
$dao = new Dao();

// Get the item name from the POST request and sanitize it
$itemName = trim($_POST['item_name']); // Remove leading/trailing white space
$itemName = preg_replace('/[^a-zA-Z0-9\s]/', '', $itemName); // Remove any special characters

// Validate the item name
if (empty($itemName) || strlen($itemName) > 50) {
  $_SESSION['error'] = "Invalid item name";
  header('Location: menu.php');
  exit;
}

// Add the item to the database
$success = $dao->addOutOfStockItem($_SESSION['username'], $itemName);

if ($success) {
  // Debugging statement
  error_log("Successfully added out of stock item $itemName");

  // Redirect the user back to the page with the out of stock items
  header('Location: menu.php');
  exit;
} else {
  // Debugging statement
  error_log("Failed to add out of stock item $itemName");
}
?>
