<?php
require_once('../Dao.php');
$dao = new Dao();

$build = null;

if (isset($_GET['build_name'])) {
  $buildName = $_GET['build_name'];

  if (empty($buildName)) {
    $errors[] = "Please select a build";
  } else {
    $build = $dao->getBuildByName($buildName);
  }
}

foreach ($builds as $build) {
  echo '<option value="' . htmlspecialchars($build['build_name'], ENT_QUOTES) . '">' . htmlspecialchars($build['build_name'], ENT_QUOTES) . '</option>';
}
