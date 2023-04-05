<?php
// Include the DAO
include_once '../Dao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $photoId = $_POST['photoId'];

    $dao = new Dao();
    $dao->deletePhoto($photoId);

    header('Location: photos.php');
    exit();
}
