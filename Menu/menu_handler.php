<?php
session_start();

require_once '../Dao.php';

$dao = new Dao();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (!isset($_FILES['uploadmenu']) || $_FILES['uploadmenu']['error'] == UPLOAD_ERR_NO_FILE) {
    $_SESSION['errors'][] = "No file selected. Please select a file to upload.";
    header("Location: menu.php");
    exit();
  }

  $name = $_FILES['uploadmenu']['name'];
  $tmp_name = $_FILES['uploadmenu']['tmp_name'];
  $error = $_FILES['uploadmenu']['error'];
  $size = $_FILES['uploadmenu']['size'];

  // validate
  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $mime_type = finfo_file($finfo, $tmp_name);
  if (!in_array($mime_type, ['image/png', 'image/jpeg', 'image/jpg'])) {
    $errors[] = "Invalid file type. Only PNG, JPEG, and JPG files are allowed.";
  }
  finfo_close($finfo);

  // >1MB?
  if ($size > 1048576) {
    $errors[] = "File size cannot be greater than 1MB";
  }

  // errors and redirect
  if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: menu.php");
    exit();
  }

  // sanitize 
  $file_name = preg_replace('/[^a-zA-Z0-9]+/', '', $name);
  $file_name = uniqid() . "_" . $file_name;

  // upload file
  $upload_dir = "../uploads/";
  $target_file = $upload_dir . $file_name;
  move_uploaded_file($tmp_name, $target_file);

  $dao->storeUploadedMenu($file_name);

  header("Location: menu.php");
  exit();
}
