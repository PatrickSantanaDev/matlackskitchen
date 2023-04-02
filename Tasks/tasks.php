<?php session_start(); ?>

<?php include_once '../authorized.php'; ?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="../css/tasks.css">
  <link rel="stylesheet" type="text/css" href="../css/footer.css">
  <link rel="stylesheet" type="text/css" href="../css/logout_button.css">
  <link rel="shortcut icon" type="image/png" href="../Images/knife.png?">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap');
  </style>
  <title>Tasks</title>
</head>

<body>

  <!-- Logo -->
  <div id="logo">
    <img src="../Images/klogo.png" />
  </div>

  <!-- Logout Button -->
  <div class="logout">
    <a href="../logout.php"><button>Logout</button></a>
  </div>

  <!-- Page Title -->
  <div id="title">
    <img src="../Images/taskstitle.png" />
  </div>

  <!-- Navigation Bar -->
  <?php include_once '../navigation_bar.php'; ?>


  <!-- AM Duties Viewer -->
  <form id="amDutiesViewer" action="submit_am_duties_handler.php" method="post">
    <h2>A.M. Duties</h2>
    <table>
      <thead>
        <tr>
          <th>Duty</th>
          <th>Completed?</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $tasks = array_map('str_getcsv', file('am_duties.csv'));

        foreach ($tasks as $index => $task) {
          $taskName = $task[0];
          $taskId = 'duty' . ($index + 1);
        ?>
          <tr>
            <td><?= $taskName ?></td>
            <td><input type="checkbox" name="<?= $taskId ?>" value="1" id="<?= $taskId ?>"></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <button id="submitAMDutiesButton" type="submit">Submit</button>
  </form>

  <!-- PM Duties Viewer -->
  <form id="pmDutiesViewer" action="submit_pm_duties_handler.php" method="post">
    <h2>P.M. Duties</h2>
    <table>
      <thead>
        <tr>
          <th>Duty</th>
          <th>Completed?</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $tasks = array_map('str_getcsv', file('pm_duties.csv'));

        foreach ($tasks as $index => $task) {
          $taskName = $task[0];
          $taskId = 'duty' . ($index + 1);
        ?>
          <tr>
            <td><?= $taskName ?></td>
            <td><input type="checkbox" name="<?= $taskId ?>" value="1" id="<?= $taskId ?>"></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <button id="submitPMDutiesButton" type="submit">Submit</button>
  </form>

  <!-- Weekly Duties Viewer -->
  <form id="weeklyDutiesViewer" action="submit_weekly_duties_handler.php" method="post">
    <h2>Weekly Duties</h2>
    <table>
      <thead>
        <tr>
          <th>Duty</th>
          <th>Completed?</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $tasks = array_map('str_getcsv', file('weekly_duties.csv'));

        foreach ($tasks as $index => $task) {
          $taskName = $task[0];
          $taskId = 'duty' . ($index + 1);
        ?>
          <tr>
            <td><?= $taskName ?></td>
            <td><input type="checkbox" name="<?= $taskId ?>" value="1" id="<?= $taskId ?>"></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <button id="submitWeeklyDutiesButton" type="submit">Submit</button>
  </form>

  <!-- Incomplete Duties Viewer - using AJAX-->
  <div id="incomplete_daily_viewer">
    <form id="incompleteDutiesViewer">
      <input id="incomplete_button" type="submit" value="View Incomplete Daily Tasks">
    </form>
    <form id="incompleteWeeklyViewer">
      <input id="incomplete_button" type="submit" value="View Incomplete Weekly Tasks">
    </form>
    <!-- Results Area -->
    <div id="incompleteResults"></div>
    <script>
      // Add event listener to form submission
      document.getElementById("incompleteDutiesViewer").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent form from submitting normally

        // Send AJAX request to handler
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "get_incomplete_duties_handler.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
          if (xhr.status === 200) {
            // Display results in designated area
            document.getElementById("incompleteResults").innerHTML = xhr.responseText;
          } else {
            alert('Request failed.  Returned status of ' + xhr.status);
          }
        };
        xhr.send();
      });
    </script>

    <!-- Results Area -->
    <div id="incompleteResults"></div>
    <script>
      // Add event listener to form submission
      document.getElementById("incompleteWeeklyViewer").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent form from submitting normally

        // Send AJAX request to handler
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "get_incomplete_weekly_handler.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
          if (xhr.status === 200) {
            // Display results in designated area
            document.getElementById("incompleteResults").innerHTML = xhr.responseText;
          } else {
            alert('Request failed.  Returned status of ' + xhr.status);
          }
        };
        xhr.send();
      });
    </script>
  </div>

  <!--Footer-->
  <?php include_once '../footer.php'; ?>

</body>

</html>