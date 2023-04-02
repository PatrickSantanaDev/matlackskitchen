<?php

require_once '../Dao.php';

// Create a new instance of the Dao class
$dao = new Dao();

// Get the out of stock items for the current user
$oosItems = $dao->getOutOfStockItems($_SESSION['username']);

// Loop through the out of stock items and display them in a list
foreach ($oosItems as $item) {
  echo '<li>' . htmlspecialchars($item['item_name'], ENT_QUOTES) . ' ';
  echo '<form action="delete_oos_item_handler.php" method="post">';
  echo '<input type="hidden" name="item_name" value="' . htmlspecialchars($item['item_name'], ENT_QUOTES) . '">';
  echo '<button id="delete_item_button" type="submit">Delete</button>';
  echo '</form>';
  echo '</li>';
}
?>
