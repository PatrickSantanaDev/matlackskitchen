<?php
require_once('../Dao.php');
$dao = new Dao();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $build_name = $_POST['build_name'];
    $dao->deleteBuildByName($build_name);
    header('Location: ../Builds/builds.php');
    exit();
  }
  

