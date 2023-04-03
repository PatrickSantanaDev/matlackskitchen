<?php
if(!($_SESSION['auth'] == true)){ //if login in session is not set
  header("Location: ../login.php");
}
?>