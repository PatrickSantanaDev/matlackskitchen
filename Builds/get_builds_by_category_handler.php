<?php
require_once('../Dao.php');
$dao = new Dao();

if(isset($_GET['searchByCategory']) && !empty($_GET['searchByCategory'])) {
  $category = $_GET['searchByCategory'];
  $builds = $dao->getBuildsByCategory($category);
}

include('builds.php');
?>
