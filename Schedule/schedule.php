<?php session_start(); ?>

<?php include_once '../authorized.php'; ?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="../css/schedule.css">
  <link rel="stylesheet" type="text/css" href="../css/footer.css">
  <link rel="stylesheet" type="text/css" href="../css/logout_button.css">
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
  <?php include_once '../navigation_bar.php'; ?>

  <!-- Schedule Viewer -->

  <!-- When unable to load an item, <object> tag has a feature that 
      loads the content inside itself i.e tag. Since object tag cannot 
      load on mobile view, embed tag will become active on mobile devices-->
  <div id="schedulePdfViewer">
    <object data="Images/schedule.pdf" type="application/pdf" height="505px" width="99%">
      <embed src="https://drive.google.com/file/d/1y6n2yliYlKsB5_5jz8bA8Wev1A1O68DN/preview?usp=share_link" height="505px" width="99%" />
    </object>
  </div>

  <!-- Upload Schedule -->
  <form id="uploadSchedulePdf" method="post" enctype="multipart/form-data">
    <label for="uploadSchedulePdf">Select Schedule File and Upload (.pdf):</label><br>
    <input type="file" id="selectMenuUpload" name="selectMenuUpload" accept=".pdf" /><br>
    <button type="submit">Upload</button>
    <button type="submit">Delete</button>
  </form>

  <!--Footer-->
  <?php include_once '../footer.php'; ?>

</body>

</html>