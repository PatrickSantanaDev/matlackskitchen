<?php
require_once "../Dao.php";
$dao = new Dao();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $incompleteDuties = $dao->getIncompleteDuties();
    if (count($incompleteDuties) == 0) {
        echo "No incomplete daily duties.";
      } else {
        echo "<h2>Incomplete A.M./P.M. Tasks</h2>";
        echo "<table>";
        echo "<thead><tr><th>Task</th><th>User</th><th>Date Completed</th></tr></thead>";
        echo "<tbody>";
        foreach ($incompleteDuties as $duty) {
          echo "<tr><td>" . $duty["duty_name"] . "</td><td>" . $duty["username"] . "</td><td>" . $duty["date_completed"] . "</td></tr>";
        }
        echo "</tbody>";
        echo "</table>";
      }
      
} else {
    header("Location: tasks.php");
    exit;
}
