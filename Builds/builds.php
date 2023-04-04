<?php session_start(); ?>

<?php include_once '../authorized.php'; ?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="../css/builds.css">
  <link rel="stylesheet" type="text/css" href="../css/footer.css">
  <link rel="stylesheet" type="text/css" href="../css/logout_button.css">
  <link rel="shortcut icon" type="image/png" href="../Images/knife.png?">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap');
  </style>
  <title>Builds</title>
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
    <img src="../Images/buildstitle.png" />
  </div>


  <!-- Navigation Bar -->
  <?php include_once '../navigation_bar.php'; ?>

  
  <!-- Dropdown Build Search -->
  <!-- Category Search -->
  <form id="catSearch" action="get_builds_by_category_handler.php" method="get">
    <label for="searchByCategory">Search for Builds by Category:</label>
    <select id="searchByCategory" name="searchByCategory">
      <option value="">Select a category</option>
      <?php
      include('get_categories_handler.php');
      foreach ($categories as $category) {
        echo '<option value="' . htmlspecialchars($category['category'], ENT_QUOTES) . '">' . htmlspecialchars($category['category'], ENT_QUOTES) . '</option>';
      }
      ?>
    </select>
    <input id="catSearchButton" type="submit" value="Search">
  </form>

  <!-- Build Search -->
  <form id="searchByBuildName" action="builds.php" method="get">
    <label for="searchbyBuildName">Search for Builds:</label>
    <select id="searchbyBuildName" name="build_name">
      <option value="">Select a build</option>
      <?php
      include('get_builds_handler.php');
      //movedforeach to handler!
      ?>
    </select>
    <input id="nameSearchButton" type="submit" value="View Build">
  </form>

  <!-- Build Viewer -->
  <div id="buildViewer">
    <?php if (isset($_GET['build_name'])) :
      $build_name = $_GET['build_name'];
      $build = $dao->getBuildByName($build_name);
      if (!$build) {
        echo "<p>No build found.</p>";
      } else {
    ?>
        <table>
          <tr>
            <th>Build Name:</th>
            <td><?php echo htmlspecialchars($build['build_name'], ENT_QUOTES); ?></td>
          </tr>
          <?php if (isset($build['ingredients'])) : ?>
            <tr>
              <th>Ingredients:</th>
              <td><?php echo nl2br(htmlspecialchars($build['ingredients'], ENT_QUOTES)); ?></td>
            </tr>
          <?php endif; ?>
          <tr>
            <th>Instructions:</th>
            <td><?php echo nl2br(htmlspecialchars($build['instructions'], ENT_QUOTES)); ?></td>
          </tr>
        </table>
    <?php
      }
    elseif (!$build) :
      echo "<p>No build selected.</p>";
    endif; ?>
  </div>


  <!-- Delete Build -->
  <div id="deleteBuild">
    <?php if ($build) : ?>
      <form action="delete_build_handler.php" method="POST">
        <input type="hidden" name="build_name" value="<?php echo htmlspecialchars($build['build_name'], ENT_QUOTES); ?>">
        <button id="deleteBuildButton" type="submit">Delete Build</button>
      </form>
    <?php endif; ?>
  </div>


  <!-- Upload Build -->
  <form class="uploadBuildForm" action="upload_build_handler.php" method="post" enctype="multipart/form-data">
    <input id="buildName" type="text" name="name" placeholder="Enter Build name..."><br>
    <div><select id="category" name="category">
        <option value="">Select a category</option>
        <option value="Apps">Apps</option>
        <option value="Salads">Salads</option>
        <option value="Mains">Mains</option>
        <option value="Desserts">Desserts</option>
      </select></div>
    <textarea id="ingredients" name="ingredients" placeholder="Enter Ingredients..."></textarea><br>
    <textarea id="instructions" name="instructions" placeholder="Enter Instructions..."></textarea><br>
    <button id="uploadBuildButton" type="submit">Upload Build</button>
  </form>

  <!--Footer-->
  <?php include_once '../footer.php'; ?>

</body>

</html>