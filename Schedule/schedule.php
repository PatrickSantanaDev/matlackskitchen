<?php session_start(); ?>

<?php include_once '../authorized.php'; ?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="../css/schedule.css">
  <link rel="stylesheet" type="text/css" href="../css/footer.css">
  <link rel="stylesheet" type="text/css" href="../css/logout_button.css">
  <link rel="stylesheet" type="text/css" href="../css/navigation.css">
  <link rel="shortcut icon" type="image/png" href="../Images/knife.png?">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap');
  </style>
  <title>Schedule</title>
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
    <img src="../Images/scheduletitle.png" />
  </div>

  <!-- Navigation Bar -->
  <?php
  $currentPage = "schedule";
  include_once '../navigation_bar.php';
  ?>

  <!-- Schedule Viewer -->
  <div id="wholescheduleviewer">
    <h2 id="schedule_viewer_header">Schedule Viewer</h2>
    <div id="scheduleviewer">
      <?php include 'schedule_display_handler.php'; ?>
    </div>

    <!-- Upload Schedule -->
    <div id="scheduleupload">
    <?php if (isset($_SESSION['errors'])) : ?>
        <div class="error">
          <?php foreach ($_SESSION['errors'] as $error) : ?>
            <?php echo $error; ?>
          <?php endforeach; ?>
        <?php endif;
      unset($_SESSION['errors']); ?>
      </div>
      <form id="uploadschedule" method="post" action="schedule_handler.php" enctype="multipart/form-data">
        <label for="uploadschedule">Select Schedule File and Upload (.png):</label><br>
        <input type="file" id="uploadschedule" name="uploadschedule" accept=".png" /><br>
        <button type="submit" name="submit" value="upload">Upload</button>
      </form>

      <form id="deleteschedule" method="post" action="delete_schedule_handler.php">
        <button type="submit" name="delete">Delete</button>
      </form>
    </div>
  </div>

  <!-- <embed src="https://witeboard.com/1fb5cae0-d2b3-11ed-9cf0-fdcc78ce19ea"  width="100%" height="100%" /> -->
  <!--Footer-->
  <?php include_once '../footer.php'; ?>

</body>

</html>