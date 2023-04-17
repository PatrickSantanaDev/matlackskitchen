<?php
require_once '../Dao.php';

session_start();

$allowedExtensions = array('jpg', 'jpeg', 'png');
$uploadDirectory = '';

if(isset($_FILES['selectPhotos'])) {
  $file = $_FILES['selectPhotos'];
  $fileName = $file['name'];
  $fileTmpName = $file['tmp_name'];
  $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
  $errors = array();

  // validate
  if(empty($fileName)) {
    $errors[] = 'Please select a file to upload.';
  }

  if(!in_array($fileExtension, $allowedExtensions) && !empty($fileName)) {
    $errors[] = 'Only JPG, JPEG, and PNG files allowed.';
  }

  if($file['size'] > 3145728 ) {
    $errors[] = 'File size cannot be greater than 3MB';
  }

  // check for errors
  if(!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: photos.php');
    exit();
  }

  // sanitize
  $fileName = preg_replace('/[^a-zA-Z0-9]+/', '', $fileName);
  $fileName = uniqid() . "_" . $fileName;

  // upload file
  if(move_uploaded_file($fileTmpName, $uploadDirectory . $fileName)) {
    $dao = new Dao();
    $dao->submitPhoto($fileName, $fileExtension);
    header('Location: photos.php');
    exit();
  } else {
    echo 'error uploading the file.';
    header('Location: photos.php');
    exit();
  }
}
