<?php
require_once '../Dao.php';

if (isset($_POST['delete'])) {
    $dao = new Dao();
    $uploadedMenu = $dao->displayMenu();
    
    if ($uploadedMenu && is_string($uploadedMenu)) {
        // Delete file from the uploads folder
        unlink($uploadedMenu);
        
        // Delete row from the uploaded_menu table in the database
        $dao->deleteMenu();
        
        // Redirect to the menu page
        header('Location: menu.php');
        exit;
    } else {
        echo 'No menu available.';
    }
}
?>
