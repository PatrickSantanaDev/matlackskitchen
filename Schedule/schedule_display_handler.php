<?php
require_once '../Dao.php';

$dao = new Dao();
$uploadedSchedule = $dao->displaySchedule();

if ($uploadedSchedule) {
    echo '<img src="' . $uploadedSchedule . '">';
  } else {
    echo 'No schedule available. Please upload schedule to view.';
  }
