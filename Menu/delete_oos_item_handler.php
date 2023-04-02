<?php
session_start();
require_once '../Dao.php';

// Create a new instance of the Dao class
$dao = new Dao();

// Get the item name from the POST request
$itemName = $_POST['item_name'];

// Debugging statement
error_log("Deleting out of stock item $itemName");

// Delete the item from the database
$success = $dao->deleteOutOfStockItem($_SESSION['username'], $itemName);

if ($success) {
  // Debugging statement
  error_log("Successfully deleted out of stock item $itemName");
} else {
  // Debugging statement
  error_log("Failed to delete out of stock item $itemName");
}

// Redirect the user back to the page with the out of stock items
header('Location: menu.php');
exit;
?>
