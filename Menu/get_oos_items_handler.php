<?php
require_once '../Dao.php';

$dao = new Dao();

// Get the out of stock items
$oosItems = $dao->getOutOfStockItems($_SESSION['username']);

// format display for oos items
foreach ($oosItems as $item) {
  echo '<li>' . htmlspecialchars($item['item_name'], ENT_QUOTES) . ' ';
  echo '<form action="delete_oos_item_handler.php" method="post">';
  echo '<input type="hidden" name="item_name" value="' . htmlspecialchars($item['item_name'], ENT_QUOTES) . '">';
  echo '<button id="delete_item_button" type="submit">Delete</button>';
  echo '</form>';
  echo '</li>';
}
?>
