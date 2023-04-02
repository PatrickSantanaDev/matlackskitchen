<?php
session_start();

require_once '../Dao.php';
require_once '../KLogger.php';

$logger = new KLogger ("../log.txt" , KLogger::WARN);
$dao = new Dao();

// check if the user is authenticated
// if (!isset($_SESSION['auth'])) {
//   header("Location: login.php");
//   exit();
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_FILES['uploadmenu']['name'];
  $tmp_name = $_FILES['uploadmenu']['tmp_name'];
  $error = $_FILES['uploadmenu']['error'];
  $size = $_FILES['uploadmenu']['size'];
  
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
    header("Location: menu.php");
    exit();
  }

  // generate unique file name
  $file_name = uniqid() . "." . $extension;

  // upload the file to the server
  $upload_dir = "../uploads/";
  $target_file = $upload_dir . $file_name;
  move_uploaded_file($tmp_name, $target_file);

  // add the file to the database
  $dao->storeUploadedMenu($file_name);

  header("Location: menu.php");
  exit();
}

?>
