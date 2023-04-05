<?php
require_once 'KLogger.php';

class Dao
{
  // private $host = "127.0.0.1"; //"localhost:8889";
  // private $db = "matlacks";
  // private $user = "root";
  // private $pass = "";
  private $host = "us-cdbr-east-06.cleardb.net";
  private $db = "heroku_0e393ccaa1b4923";
  private $user = "ba3621c4a28738";
  private $pass = "12f186c3";

  private $logger;

  public function __construct()
  {
    $this->logger = new KLogger("log.txt", KLogger::DEBUG);
  }

  public function getConnection()
  {
    $this->logger->LogDebug("getting a connection");
    try {
      $conn = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
      return $conn;
    } catch (Exception $e) {
      //echo print_r($e,1);
      $this->logger->LogFatal("Connection failed: " . print_r($e, 1));
      exit;
    }
  }

  public function checkUsernameAndEmail($userName, $userEmail)
  {
    $this->logger->LogInfo("Checking if user exists");
    $conn = $this->getConnection();
    $sth = $conn->prepare("SELECT * from users where users.username = :username OR users.email = :email");
    $sth->bindParam(":username", $userName);
    $sth->bindParam(":email", $userEmail);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result ? $result : false;
  }

  //to confirm data for logging in.
  public function checkUser($userName, $userPass)
  {
    $this->logger->LogInfo("Checking if username and password match to the one present in the database.");
    $conn = $this->getConnection();
    $sth = $conn->prepare("SELECT * from users where users.username  like :username and users.pass like :pass");
    $sth->bindParam(":username", $userName);
    $sth->bindParam(":pass", $userPass);
    $sth->execute();
    $result = $sth->fetchAll();
    return $result;
  }
  // to add data of the user to the database.
  public function addSignupUser($userName, $userEmail, $userPass)
  {
    $this->logger->LogInfo("Creating user Account!");

    // Check if the username or email already exists
    $userExists = $this->checkUsernameAndEmail($userName, $userEmail);
    if ($userExists !== false) {
      return false;
    }

    $conn = $this->getConnection();
    $saveQuery = "insert into users (username, email, pass) values (:username, :email, :pass)";
    $q = $conn->prepare($saveQuery);
    $q->bindParam(":username", $userName);
    $q->bindParam(":email", $userEmail);
    $q->bindParam(":pass", $userPass);
    $q->execute();
    return true;
  }

  public function storeUploadedMenu($fileName)
  {
    $this->logger->LogInfo("Storing uploaded menu file $fileName");

    $conn = $this->getConnection();
    $saveQuery = "INSERT INTO uploaded_menu (file_name, uploaded_on) VALUES (:file_name, :uploaded_on)";
    $q = $conn->prepare($saveQuery);
    $q->bindParam(":file_name", $fileName);
    $uploadedOn = date("Y-m-d H:i:s");
    $q->bindParam(":uploaded_on", $uploadedOn);
    $q->execute();
  }

  public function displayMenu()
  {
    $this->logger->LogInfo("Displaying uploaded menu");

    $conn = $this->getConnection();
    $query = "SELECT file_name FROM uploaded_menu ORDER BY uploaded_on DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
      $file_path = "../uploads/" . $result['file_name'];
      if (file_exists($file_path)) {
        return $file_path;
      } else {
        $this->logger->LogError("File not found: $file_path");
        return false;
      }
    } else {
      $this->logger->LogError("No menu found in the database.");
      return false;
    }
  }

  public function deleteMenu()
  {
    $this->logger->LogInfo("Deleting uploaded menu");

    $conn = $this->getConnection();
    $query = "DELETE FROM uploaded_menu ORDER BY uploaded_on DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
  }

  public function addOutOfStockItem($username, $itemName)
  {
    $this->logger->LogInfo("Adding out of stock item $itemName for user $username");

    $conn = $this->getConnection();
    $saveQuery = "INSERT INTO out_of_stock_items (username, item_name, date_added) VALUES (:username, :item_name, :date_added)";
    $q = $conn->prepare($saveQuery);
    $q->bindParam(":username", $username);
    $q->bindParam(":item_name", $itemName);
    $dateAdded = date("Y-m-d");
    $q->bindParam(":date_added", $dateAdded);
    return $q->execute();
  }

  public function getOutOfStockItems()
  {
    $this->logger->LogInfo("Getting out of stock items");

    $conn = $this->getConnection();
    $query = "SELECT * FROM out_of_stock_items WHERE item_name != ''";
    $q = $conn->query($query);

    $results = array();
    while ($row = $q->fetch()) {
      $results[] = array(
        "id" => $row["id"],
        "item_name" => $row["item_name"]
      );
    }

    return $results;
  }

  public function deleteOutOfStockItem($username, $itemName)
  {
    $this->logger->LogInfo("Deleting out of stock item $itemName for user $username");

    $conn = $this->getConnection();
    $deleteQuery = "DELETE FROM out_of_stock_items WHERE username = :username AND item_name = :item_name";
    $q = $conn->prepare($deleteQuery);
    $q->bindParam(":username", $username);
    $q->bindParam(":item_name", $itemName);
    return $q->execute();
  }

  public function postRecipeInfo($recipeName, $category, $ingredients, $instructions, $username)
  {
    try {
      $category = $_POST['category'];
      $conn = $this->getConnection();
      $query = "INSERT INTO recipes (username, recipe_name, category, ingredients, instructions, date_added) VALUES (:username, :recipeName, :category, :ingredients, :instructions, NOW())";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':recipeName', $recipeName);
      $stmt->bindParam(':category', $category);
      $stmt->bindParam(':ingredients', $ingredients);
      $stmt->bindParam(':instructions', $instructions);
      $stmt->execute();
    } catch (Exception $e) {
      //echo print_r($e,1);
      $this->logger->LogFatal("postRecipeInfo failed: " . print_r($e, 1));
      exit;
    }
  }

  public function getCategories()
  {
    try {
      $conn = $this->getConnection();
      $query = "SELECT DISTINCT category FROM recipes ORDER BY category";
      $stmt = $conn->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      //echo print_r($e,1);
      $this->logger->LogFatal("getCategories failed: " . print_r($e, 1));
      exit;
    }
  }

  public function getRecipesByCategory($category)
  {
    try {
      $conn = $this->getConnection();
      $query = "SELECT recipe_name FROM recipes WHERE category = :category ORDER BY recipe_name";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':category', $category);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      //echo print_r($e,1);
      $this->logger->LogFatal("getRecipesByCategory failed: " . print_r($e, 1));
      exit;
    }
  }

  public function getRecipeByName($recipe_name)
  {
    try {
      $conn = $this->getConnection();
      $query = "SELECT * FROM recipes WHERE recipe_name = :recipe_name";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':recipe_name', $recipe_name);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      //echo print_r($e,1);
      $this->logger->LogFatal("getRecipeByName failed: " . print_r($e, 1));
      exit;
    }
  }

  public function deleteRecipeByName($recipe_name)
  {
    try {
      $conn = $this->getConnection();
      $query = "DELETE FROM recipes WHERE recipe_name = :recipe_name";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':recipe_name', $recipe_name);
      $stmt->execute();
      return true;
    } catch (Exception $e) {
      //echo print_r($e,1);
      $this->logger->LogFatal("deleteRecipeByName failed: " . print_r($e, 1));
      exit;
    }
  }

  /***********************/
  /*    BUILDS METHODS   */
  /***********************/
  public function getBuildsByCategory($category)
  {
    try {
      $conn = $this->getConnection();
      $query = "SELECT build_name FROM builds WHERE category = :category ORDER BY build_name";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':category', $category);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      //echo print_r($e,1);
      $this->logger->LogFatal("getBuildsByCategory failed: " . print_r($e, 1));
      exit;
    }
  }

  public function getBuildByName($build_name)
  {
    try {
      $conn = $this->getConnection();
      $query = "SELECT * FROM builds WHERE build_name = :build_name";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':build_name', $build_name);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      //echo print_r($e,1);
      $this->logger->LogFatal("getBuildByName failed: " . print_r($e, 1));
      exit;
    }
  }

  public function getBuildCategories()
  {
    try {
      $conn = $this->getConnection();
      $query = "SELECT DISTINCT category FROM builds ORDER BY category";
      $stmt = $conn->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      //echo print_r($e,1);
      $this->logger->LogFatal("getBuildCategories failed: " . print_r($e, 1));
      exit;
    }
  }

  public function deleteBuildByName($build_name)
  {
    try {
      $conn = $this->getConnection();
      $query = "DELETE FROM builds WHERE build_name = :build_name";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':build_name', $build_name);
      $stmt->execute();
      return true;
    } catch (Exception $e) {
      //echo print_r($e,1);
      $this->logger->LogFatal("deleteBuildByName failed: " . print_r($e, 1));
      exit;
    }
  }

  public function postBuildInfo($buildName, $category, $ingredients, $instructions, $username)
  {
    try {
      $category = $_POST['category'];
      $conn = $this->getConnection();
      $query = "INSERT INTO builds (username, build_name, category, ingredients, instructions, date_added) VALUES (:username, :buildName, :category, :ingredients, :instructions, NOW())";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':buildName', $buildName);
      $stmt->bindParam(':category', $category);
      $stmt->bindParam(':ingredients', $ingredients);
      $stmt->bindParam(':instructions', $instructions);
      $stmt->execute();
    } catch (Exception $e) {
      //echo print_r($e,1);
      $this->logger->LogFatal("postBuildInfo failed: " . print_r($e, 1));
      exit;
    }
  }

  public function submitAmDuties($duties, $username)
  {
    $conn = $this->getConnection();
    $query = "INSERT INTO am_duties (duty_name, username, completed, date_completed) VALUES (:duty_name, :username, :completed, :date_completed)";
    $stmt = $conn->prepare($query);

    $date_completed = date('Y-m-d');

    foreach ($duties as $duty) {
      $stmt->execute([
        'duty_name' => $duty['duty_name'],
        'username' => $username,
        'completed' => $duty['completed'],
        'date_completed' => $duty['completed'] ? $date_completed : null,
      ]);
    }
  }

  public function submitPmDuties($duties, $username)
  {
    $conn = $this->getConnection();
    $query = "INSERT INTO pm_duties (duty_name, username, completed, date_completed) VALUES (:duty_name, :username, :completed, :date_completed)";
    $stmt = $conn->prepare($query);

    $date_completed = date('Y-m-d');

    foreach ($duties as $duty) {
      $stmt->execute([
        'duty_name' => $duty['duty_name'],
        'username' => $username,
        'completed' => $duty['completed'],
        'date_completed' => $duty['completed'] ? $date_completed : null,
      ]);
    }
  }

  public function submitWeeklyDuties($duties, $username)
  {
    $conn = $this->getConnection();
    $query = "INSERT INTO weekly_duties (duty_name, username, completed, date_completed) VALUES (:duty_name, :username, :completed, :date_completed)";
    $stmt = $conn->prepare($query);

    $date_completed = date('Y-m-d');

    foreach ($duties as $duty) {
      $stmt->execute([
        'duty_name' => $duty['duty_name'],
        'username' => $username,
        'completed' => $duty['completed'],
        'date_completed' => $duty['completed'] ? $date_completed : null,
      ]);
    }
  }

  public function getIncompleteDuties()
  {
    $conn = $this->getConnection();
    $stmt = $conn->prepare("SELECT username, duty_name FROM am_duties WHERE completed = 0 UNION ALL SELECT username, duty_name FROM pm_duties WHERE completed = 0");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getIncompleteWeeklyDuties()
  {
    $conn = $this->getConnection();
    $stmt = $conn->prepare("SELECT username, duty_name FROM weekly_duties WHERE completed = 0");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function submitIngredient($ingredient_name, $category, $added_by_username)
  {
    $conn = $this->getConnection();
    $query = "INSERT INTO ingredients (ingredient_name, category, added_by_username) VALUES (:ingredient_name, :category, :added_by_username)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':ingredient_name', $ingredient_name);
    $stmt->bindParam(':category', $category);
    session_start();
    $username = $_SESSION['username'];
    $stmt->bindParam(':added_by_username', $username);
    $stmt->execute();
  }

  public function getIngredientsByCategory($category)
  {
    try {
      $conn = $this->getConnection();
      $query = "SELECT * FROM ingredients WHERE category = :category";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':category', $category);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      //echo print_r($e,1);
      $this->logger->LogFatal("getIngredientsByCategory failed: " . print_r($e, 1));
      exit;
    }
  }

  public function submitIngredientsNeeded($ingredientNames, $addedByUsername)
  {
    $conn = $this->getConnection();

    $stmt = $conn->prepare('INSERT INTO ingredients_needed (ingredient_name, is_needed, added_by_username, date_added) VALUES (:ingredient_name, :is_needed, :added_by_username, :date_added)');

    $dateAdded = date('Y-m-d');

    foreach ($ingredientNames as $ingredientName) {
      $stmt->bindValue(':ingredient_name', $ingredientName);
      $stmt->bindValue(':is_needed', true, PDO::PARAM_BOOL);
      $stmt->bindValue(':added_by_username', $addedByUsername);
      $stmt->bindValue(':date_added', $dateAdded);

      $stmt->execute();
    }
  }

  public function storeUploadedSchedule($fileName)
  {
    $this->logger->LogInfo("Storing uploaded schedule file $fileName");

    $conn = $this->getConnection();
    $saveQuery = "INSERT INTO uploaded_schedule (file_name, uploaded_on) VALUES (:file_name, :uploaded_on)";
    $q = $conn->prepare($saveQuery);
    $q->bindParam(":file_name", $fileName);
    $uploadedOn = date("Y-m-d H:i:s");
    $q->bindParam(":uploaded_on", $uploadedOn);
    $q->execute();
  }

  public function displaySchedule()
  {
    $this->logger->LogInfo("Displaying uploaded schedule");

    $conn = $this->getConnection();
    $query = "SELECT file_name FROM uploaded_schedule ORDER BY uploaded_on DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
      $file_path = "../uploads/" . $result['file_name'];
      if (file_exists($file_path)) {
        return $file_path;
      } else {
        $this->logger->LogError("File not found: $file_path");
        return false;
      }
    } else {
      $this->logger->LogError("No menu found in the database.");
      return false;
    }
  }

  public function deleteSchedule()
  {
    $this->logger->LogInfo("Deleting uploaded schedule");

    $conn = $this->getConnection();
    $query = "DELETE FROM uploaded_schedule ORDER BY uploaded_on DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
  }

  public function submitPhoto($fileName, $imageType)
  {
    $conn = $this->getConnection();

    $stmt = $conn->prepare('INSERT INTO photos (file_name, image_type, date_added) VALUES (:file_name, :image_type, :date_added)');
    $dateAdded = date('Y-m-d');

    $stmt->bindValue(':file_name', $fileName);
    $stmt->bindValue(':image_type', $imageType);
    $stmt->bindValue(':date_added', $dateAdded);

    $stmt->execute();

    $conn = null;
  }

  public function getAllPhotos()
  {
    $conn = $this->getConnection();
    $stmt = $conn->prepare('SELECT id, file_name, image_type FROM photos WHERE image_status = :image_status ORDER BY date_added DESC');
    $imageStatus = 1;
    $stmt->bindValue(':image_status', $imageStatus);
    $stmt->execute();
    $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $photos;
  }

  public function deletePhoto($photoId)
  {
    $conn = $this->getConnection();

    // Get file name and image type from database using photo id
    $stmt = $conn->prepare('SELECT file_name, image_type FROM photos WHERE id = :id');
    $stmt->bindValue(':id', $photoId);
    $stmt->execute();
    $photo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Delete file from uploads directory
    unlink( $photo['file_name']);

    // Delete photo record from database
    $stmt = $conn->prepare('DELETE FROM photos WHERE id = :id');
    $stmt->bindValue(':id', $photoId);
    $stmt->execute();
  }
}
