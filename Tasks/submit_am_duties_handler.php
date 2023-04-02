<?php
require_once '../Dao.php';

session_start();

if (isset($_SESSION['username'])) {
  $dao = new Dao();

  $tasks = array();

  if (($handle = fopen("am_duties.csv", "r")) !== false) {
    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
      array_push($tasks, $data[0]);
    }
    fclose($handle);
  }

  $username = $_SESSION['username'];
  $duties = array();

  foreach ($tasks as $index => $task) {
    $taskId = 'duty' . ($index + 1);
    $completed = isset($_POST[$taskId]) ? 1 : 0;
    $duties[] = array(
      'duty_name' => $task,
      'completed' => $completed,
    );
  }

  $dao->submitAmDuties($duties, $username);


  header("Location: tasks.php");
} else {
  header("Location: login.php");
}
