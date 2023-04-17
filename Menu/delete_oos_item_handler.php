<?php
session_start();
require_once '../Dao.php';

$dao = new Dao();

$itemName = $_POST['item_name'];

error_log("Deleting out of stock item $itemName");

$success = $dao->deleteOutOfStockItem($itemName);

if ($success) {
  error_log("Deleted out of stock item $itemName");
} else {
  error_log("Failed to delete out of stock item $itemName");
}

header('Location: menu.php');
exit;
