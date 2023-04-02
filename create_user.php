<?php
session_start();
?>

<html>

<head>
  <link rel="stylesheet" type="text/css" href="css/create_user.css">
  <link rel="shortcut icon" type="image/png" href="Images/knife.png?">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap');
  </style>
  <title>SignUp</title>
</head>
<body>
  <div class="signup-box">
    <!-- Page Title -->
    <div id="title">
      <img src="Images/signuptitle.png" />
    </div>

    <form id = "createuser" method="POST" action="create_user_handler.php">
    <?php if (isset($_SESSION['signup_errors']) && !empty($_SESSION['signup_errors'])): ?>
      <div class="error">
        <?php foreach ($_SESSION['signup_errors'] as $signup_error): ?>
          <p><?php echo $signup_error; ?></p>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <label for="username" id = "usernametitle">Username:</label>
      <div><input type="text" id="username" name="username" value="<?php echo isset($_SESSION['signup_inputs']['username']) ? $_SESSION['signup_inputs']['username'] : '' ?>"></div>
      
      <label for="email" id = "emailtitle">Email:</label>
      <div><input type="text" id="email" name="email" value="<?php echo isset($_SESSION['signup_inputs']['email']) ? $_SESSION['signup_inputs']['email'] : '' ?>"></div>
      
      <label for="password" id = "passwordtitle">Password:</label>
      <div><input type="password" id="password" name="password" value="<?php echo isset($_SESSION['signup_inputs']['password']) ? $_SESSION['signup_inputs']['password'] : '' ?>"></div>
      
      <label for="confirm_password" id = "confirmtitle">Confirm Password:</label>
      <div><input type="password" id="confirm_password" name="confirm_password" value="<?php echo isset($_SESSION['signup_inputs']['confirm_password']) ? $_SESSION['signup_inputs']['confirm_password'] : '' ?>"></div>
      
      <input type="submit" id = "signupbutton" name="submit">
    </form>
  </div>
  <p id = "login">Already have an account? <a href="login.php">Return to login here.</a>.</p>
</body>
</html>

<?php
  unset($_SESSION['signup_errors']);
  unset($_SESSION['signup_inputs']);
?> 