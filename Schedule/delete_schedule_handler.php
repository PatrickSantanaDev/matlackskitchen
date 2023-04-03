<?php
require_once '../Dao.php';

if (isset($_POST['delete'])) {
    $dao = new Dao();
    $uploadedSchedule = $dao->displaySchedule();
    
    if ($uploadedSchedule && is_string($uploadedSchedule)) {
        // Delete file from the uploads folder
        unlink($uploadedSchedule);
        
        // Delete row from the uploaded_menu table in the database
        $dao->deleteSchedule();
        
        // Redirect to the menu page
        header('Location: schedule.php');
        exit;
    } else {
        echo 'No menu available.';
    }
}
?>
