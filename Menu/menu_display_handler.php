<?php
require_once '../Dao.php';

$dao = new Dao();
$uploadedMenu = $dao->displayMenu();

if ($uploadedMenu) {
    echo '<img src="' . $uploadedMenu . '">';
  } else {
    echo 'No menu available. Please upload menu to view.';
  }
