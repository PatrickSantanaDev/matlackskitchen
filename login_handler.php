<?php
session_start();

require_once 'Dao.php';
require_once 'KLogger.php';

$logger = new KLogger ("log.txt" , KLogger::WARN);
$dao = new Dao();

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $logger->LogDebug("User [{$username}] attempting to log in");

    // check if the username is greater than 20 characters
    if (strlen($username) > 20) {
        $errors[] = "Username cannot be greater than 20 characters";
    }

    // check if the username is less than 5 characters
    if (!empty($username) && strlen($username) < 5) {
        $errors[] = "Username must be at least 5 characters";
    }

    // check if the username is empty or not, if it is empty, check if password is empty too
    if (empty($username)) {
        if (!empty($password)) {
            $errors[] = "Username is required";
        }
        else if (empty($password)) {
            $errors[] = "Username and password are required";
        }
    }

    // check if the password is empty or not
    if (empty($password) && !empty($username)) {
        $errors[] = "Password is required";
    }

    // if there are any errors, redirect back to login page with error message
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['inputs']['username'] = $username;
        $_SESSION['inputs']['password'] = $password;
        header("Location: login.php");
        exit();
    }

    // check the database
    $result = $dao->checkUser($username, $password);

    if ($result) {
        $_SESSION['auth'] = true;
        $_SESSION['username'] = $username;
        $logger->LogWarn("User [{$username}] successfully logged in.");
        header("Location: index.php");
        exit();
    } else {
        $logger->LogWarn("User [{$username}] invalid username or password");
        $errors[] = 'Invalid Username or password';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['inputs']['username'] = $username;
        $_SESSION['inputs']['password'] = $password;
        header("Location: login.php");
        exit();
    }
}
?>
