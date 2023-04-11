<?php
require_once '../Dao.php';

session_start();

if (isset($_SESSION['username'])) {
  $dao = new Dao();

  $tasks = array_map('str_getcsv', file('weekly_duties.csv'));

  $dayOfWeek = date('D');
  $duties = array();

  foreach ($tasks as $index => $task) {
    $taskDays = explode(',', strtoupper($task[1]));
    if (in_array(strtoupper($dayOfWeek), $taskDays)) {
      $taskId = 'task' . ($index + 1);
      $completed = isset($_POST['tasks']) && in_array($task[0], $_POST['tasks']) ? 1 : 0;
      $duties[] = array(
        'duty_name' => $task[0],
        'completed' => $completed,
      );
    }
  }

  $username = $_SESSION['username'];
  $dao->submitWeeklyDuties($duties, $username);

  header("Location: tasks.php");
} else {
  header("Location: login.php");
}