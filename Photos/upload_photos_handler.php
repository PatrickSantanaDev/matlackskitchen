<?php
require_once '../Dao.php';

$allowedExtensions = array('jpg', 'jpeg', 'png');
$uploadDirectory = '';

if(isset($_FILES['selectPhotos'])) {
  $file = $_FILES['selectPhotos'];
  $fileName = $file['name'];
  $fileTmpName = $file['tmp_name'];
  $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

  if(in_array($fileExtension, $allowedExtensions)) {
    $dao = new Dao();
    $dao->submitPhoto($fileName, $fileExtension);

    if(move_uploaded_file($fileTmpName, $uploadDirectory . $fileName)) {
      header('Location: photos.php');
    } else {
      echo 'error uploading the file.';
      header('Location: photos.php');
    }
  } else {
    echo 'Only JPG, JPEG, and PNG files allowed.';
  }
}
