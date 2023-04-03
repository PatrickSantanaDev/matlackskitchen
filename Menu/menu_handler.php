<?php
session_start();

require_once '../Dao.php';

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
  
  // validate the file type using the fileinfo extension
  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $mime_type = finfo_file($finfo, $tmp_name);
  if (!in_array($mime_type, ['image/png', 'image/jpeg', 'image/jpg'])) {
    $errors[] = "Invalid file type. Only PNG, JPEG, and JPG files are allowed.";
  }
  finfo_close($finfo);

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

  // sanitize the file name
  $file_name = preg_replace('/[^a-zA-Z0-9]+/', '', $name);
  $file_name = uniqid() . "_" . $file_name;

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
