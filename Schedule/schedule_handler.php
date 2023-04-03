<?php
session_start();

require_once '../Dao.php';
require_once '../KLogger.php';

$logger = new KLogger ("../log.txt" , KLogger::WARN);
$dao = new Dao();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

  // check if the file size is greater than 1MB
  if ($size > 1048576) {
    $errors[] = "File size cannot be greater than 1MB";
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
  $upload_dir = "../uploads/";
  $target_file = $upload_dir . $file_name;
  move_uploaded_file($tmp_name, $target_file);

  // add the file to the database
  $dao->storeUploadedSchedule($file_name);

  header("Location: schedule.php");
  exit();
}

?>
