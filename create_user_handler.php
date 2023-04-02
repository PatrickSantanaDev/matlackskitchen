<?php
session_start();

require_once 'Dao.php';
require_once 'KLogger.php';

$email_pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
$password_pattern = "/^(?=.*[!@#$%^&*()_+\-=[\]{};':\"\\|,.<>\/?])(?=.*[0-9]).+$/";

$logger = new KLogger ("log.txt" , KLogger::WARN);
$dao = new Dao();

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$_SESSION['signup_inputs'] = $_POST;

$errors = array();

// validate input
if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) 
{
  $errors[] = 'Please fill out all fields';
} 
elseif (!preg_match($email_pattern, $email)) {
  $errors[] = 'Invalid email address';
}
elseif (!preg_match($password_pattern, $password)) {
  $errors[] = 'Invalid password. Password must contain at least one number and one special character';
}
elseif ($password !== $confirm_password) 
{
  $errors[] = 'Passwords do not match';
} 
elseif (5 > strlen($username) || strlen($username) > 20) 
{
  $errors[] = 'Username must be between 5 and 20 characters';
}
elseif (8 > strlen($password) || strlen($password) > 20) 
{
  $errors[] = 'Password must be between 8 and 20 characters';
}


// if there are any errors, redirect back to login page with error message
if (!empty($errors)) 
{
  $_SESSION['signup_errors'] = $errors;
  header("Location: create_user.php");
  exit();
}
else 
{
  // add user to database
  $logger->LogDebug("User [{$username}] attempting to create account");
  $result = $dao->addSignupUser($username, $email, $password);

  if ($result) 
  {
    $logger->LogDebug("User [{$username}] successfully created account");
    $_SESSION['signup_success'] = 'Registration successful! Please log in.';
    header("Location: login.php");
    exit();
  } 
  else 
  {
    $errors[] = 'Username or email already exists. Please choose a different username or email';
    $_SESSION['signup_errors'] = $errors;
    header("Location: create_user.php");
    exit();
  }
}
?>
