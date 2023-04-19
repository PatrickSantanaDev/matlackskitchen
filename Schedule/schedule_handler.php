<?php
session_start();

require_once '../Dao.php';
require_once '../KLogger.php';

$logger = new KLogger ("../log.txt" , KLogger::WARN);
$dao = new Dao();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (!isset($_FILES['uploadschedule']) || $_FILES['uploadschedule']['error'] == UPLOAD_ERR_NO_FILE) {
    $_SESSION['errors'][] = "No file selected. Please select a file to upload.";
    header("Location: schedule.php");
    exit();
  }

  $name = $_FILES['uploadschedule']['name'];
  $tmp_name = $_FILES['uploadschedule']['tmp_name'];
  $error = $_FILES['uploadschedule']['error'];
  $size = $_FILES['uploadschedule']['size'];
  
  $allowed_extensions = array('png', 'jpg', 'jpeg');
  $extension = pathinfo($name, PATHINFO_EXTENSION);

  // check if the file extension is allowed
  if (!in_array($extension, $allowed_extensions)) {
    $errors[] = "File extension not allowed. Allowed extensions are .png, .jpg, .jpeg";
  }

  // 3MB
  if ($size > 3145728) {
    $errors[] = "File size cannot be greater than 3MB";
  }

  // if there are any errors, redirect back to upload page with error message
  if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: schedule.php");
    exit();
  }

  // generate unique file name
  $file_name = uniqid() . "." . $extension;

  // upload the file to the server
  $upload_dir = "";
  $target_file = $upload_dir . $file_name;
  move_uploaded_file($tmp_name, $target_file);

  // add the file to the database
  $dao->storeUploadedSchedule($file_name);

  header("Location: schedule.php");
  exit();
}

?>
