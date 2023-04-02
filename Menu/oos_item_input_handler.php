<?php
session_start();
require_once '../Dao.php';

// Create a new instance of the Dao class
$dao = new Dao();

// Get the item name from the POST request
$itemName = $_POST['item_name'];

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
