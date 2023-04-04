<?php
session_start();
require_once '../Dao.php';

$dao = new Dao();

// Get the item name from the POST request and sanitize it
$itemName = trim($_POST['item_name']); // white space
$itemName = preg_replace('/[^a-zA-Z0-9\s]/', '', $itemName); // special characters

// Validate
if (empty($itemName)) {
  $_SESSION['oos_errors'] = "Empty item name";
  $_SESSION['item_name'] = $itemName;
  header('Location: menu.php');
  exit;
}

if (strlen($itemName) > 50) {
  $_SESSION['oos_errors'] = "Item name must be less than 50 characters";
  $_SESSION['item_name'] = $itemName;
  header('Location: menu.php');
  exit;
}

$success = $dao->addOutOfStockItem($_SESSION['username'], $itemName);

if ($success) {
  error_log("Successfully added out of stock item $itemName");
  header('Location: menu.php');
  exit;
} else {
  error_log("Failed to add out of stock item $itemName");
}
?>
