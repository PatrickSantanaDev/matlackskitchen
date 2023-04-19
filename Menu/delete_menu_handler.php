<?php
session_start();
require_once '../Dao.php';

if (isset($_POST['delete'])) {
    $dao = new Dao();
    $uploadedMenu = $dao->displayMenu();
    
    if ($uploadedMenu && is_string($uploadedMenu)) {
        // Delete file from the /uploads folder
        unlink($uploadedMenu);
        $dao->deleteMenu();
        header('Location: menu.php');
        exit;
    } else {
        $_SESSION['errors'][] = "No uploaded menu available to delete.";
        header('Location: menu.php');
    }
}
