<?php session_start(); ?>

<?php include_once '../authorized.php'; ?>
<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="../css/photos.css">
  <link rel="stylesheet" type="text/css" href="../css/footer.css">
  <link rel="stylesheet" type="text/css" href="../css/logout_button.css">
  <link rel="stylesheet" type="text/css" href="../css/navigation.css">
  <link rel="shortcut icon" type="image/png" href="../Images/knife.png?">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap');
  </style>
  <title>Photos</title>
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
    <img src="../Images/photostitle.png" />
  </div>

  <!-- Navigation Bar -->
  <?php
  $currentPage = "photos";
  include_once '../navigation_bar.php';
  ?>

  <!-- Upload Photo -->
  <div id="wholePhotoForm">
  <form id="uploadPhotoForm" action="upload_photos_handler.php" method="post" enctype="multipart/form-data">
    <h2 id="uploadPhotoFormHeading">Upload Photos</h2>
    <?php
    if (isset($_SESSION['errors'])) {
      foreach ($_SESSION['errors'] as $error) {
        echo '<p class="error">' . $error . '</p>';
      }
      unset($_SESSION['errors']);
    }
    ?>
    <label for="selectPhotos">Select photo file and upload (.png):</label><br>
    <input type="file" id="selectPhotos" name="selectPhotos" accept=".png,.jpg" /><br>
    <button id="uploadPhotoButton" type="submit">Upload Photo</button>
  </form>
  </div>

  <!--Photos Viewer-->
  <div id="photosViewer">
    <?php include 'display_photos_handler.php'; ?>
  </div>

  <!-- Delete photo form -->
  <form id="deletePhotoForm" method="post" action="delete_photo_handler.php">
    <input type="hidden" name="photoId" value="">
  </form>

  <!--Footer-->
  <?php include_once '../footer.php'; ?>

</body>

</html>