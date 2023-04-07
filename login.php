<?php
session_start();
?>

<html>

<head>
  <link rel="stylesheet" type="text/css" href="css/login.css">
  <link rel="shortcut icon" type="image/png" href="Images/knife.png?">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap');
  </style>
  <title>Login</title>
</head>

<body>
  <!-- Page Title -->
  <div id="title">
    <img src="Images/logintitle.png" />
  </div>

  <form id="login" method="POST" action="login_handler.php">
    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) : ?>
      <div class="error">
        <?php foreach ($_SESSION['errors'] as $error) : ?>
          <p><?php echo $error; ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <label for="username" id="usernametitle">Username:</label>
    <div><input type="text" id="username" name="username" value="<?php echo isset($_SESSION['inputs']['username']) ? $_SESSION['inputs']['username'] : '' ?>"></div>

    <label for="password" id="passwordtitle">Password:</label>
    <div><input type="password" id="password" name="password" value="<?php echo isset($_SESSION['inputs']['password']) ? $_SESSION['inputs']['password'] : '' ?>"></div>

    <div><input type="submit" id="submitbutton" value="Submit"></div>
  </form>
  <p id="createaccount">Don't have an account? <a href="create_user.php">Create one here</a>.</p>
</body>

</html>

<?php
unset($_SESSION['errors']);
unset($_SESSION['inputs']);
?>