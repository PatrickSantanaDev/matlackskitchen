<?php
require_once 'KLogger.php';

class Dao {

  private $host = "127.0.0.1";//"localhost:8889";
  private $db = "matlacks";
  private $user = "root";
  private $pass = "";
  private $logger;

  public function __construct () {
    $this->logger = new KLogger ("log.txt" , KLogger::DEBUG);
  }


  public function getConnection () {
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



  public function checkUsernameAndEmail($userName, $userEmail){
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
  public function checkUser($userName, $userPass){
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
  public function addSignupUser($userName, $userEmail, $userPass) {
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

public function storeUploadedMenu($fileName) {
  $this->logger->LogInfo("Storing uploaded menu file $fileName");

  $conn = $this->getConnection();
  $saveQuery = "INSERT INTO uploaded_menu (file_name, uploaded_on) VALUES (:file_name, :uploaded_on)";
  $q = $conn->prepare($saveQuery);
  $q->bindParam(":file_name", $fileName);
  $uploadedOn = date("Y-m-d H:i:s");
  $q->bindParam(":uploaded_on", $uploadedOn);
  $q->execute();
}

public function displayMenu() {
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

public function deleteMenu() {
  $this->logger->LogInfo("Deleting uploaded menu");

  $conn = $this->getConnection();
  $query = "DELETE FROM uploaded_menu ORDER BY uploaded_on DESC LIMIT 1";
  $stmt = $conn->prepare($query);
  $stmt->execute();
}

public function addOutOfStockItem($username, $itemName) {
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

public function getOutOfStockItems() {
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


public function deleteOutOfStockItem($username, $itemName) {
  $this->logger->LogInfo("Deleting out of stock item $itemName for user $username");

  $conn = $this->getConnection();
  $deleteQuery = "DELETE FROM out_of_stock_items WHERE username = :username AND item_name = :item_name";
  $q = $conn->prepare($deleteQuery);
  $q->bindParam(":username", $username);
  $q->bindParam(":item_name", $itemName);
  return $q->execute();
}

public function postRecipeInfo($recipeName, $category, $ingredients, $instructions, $username) {
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
  } catch(PDOException $e) {
    $this->logger->error($e->getMessage());
  }
}

public function getCategories() {
  try {
    $conn = $this->getConnection();
    $query = "SELECT DISTINCT category FROM recipes ORDER BY category";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch(PDOException $e) {
    $this->logger->error($e->getMessage());
  }
}

public function getRecipesByCategory($category) {
  try {
    $conn = $this->getConnection();
    $query = "SELECT recipe_name FROM recipes WHERE category = :category ORDER BY recipe_name";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':category', $category);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch(PDOException $e) {
    $this->logger->error($e->getMessage());
  }
}

public function getRecipeByName($recipe_name) {
  try {
    $conn = $this->getConnection();
    $query = "SELECT * FROM recipes WHERE recipe_name = :recipe_name";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':recipe_name', $recipe_name);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $e) {
    $this->logger->error($e->getMessage());
  }
}

public function deleteRecipeByName($recipe_name) {
  try {
    $conn = $this->getConnection();
    $query = "DELETE FROM recipes WHERE recipe_name = :recipe_name";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':recipe_name', $recipe_name);
    $stmt->execute();
    return true;
  } catch(PDOException $e) {
    $this->logger->error($e->getMessage());
    return false;
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

public function submitIngredient($ingredient_name, $category, $added_by_username) {
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

public function getIngredientsByCategory($category) {
  try {
    $conn = $this->getConnection();
    $query = "SELECT * FROM ingredients WHERE category = :category";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':category', $category);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch(PDOException $e) {
    $this->logger->error($e->getMessage());
  }
}

public function submitIngredientsNeeded($ingredient_name, $is_needed) {
  $conn = $this->getConnection();
  $query = "INSERT INTO ingredients_needed (ingredient_name, is_needed, added_by_username, date_added) VALUES (:ingredient_name, :is_needed, :added_by_username, :date_added)";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(":ingredient_name", $ingredient_name);
  $is_needed_bool = ($is_needed == "on") ? true : false;
$stmt->bindParam(":is_needed", $is_needed_bool, PDO::PARAM_BOOL);

  session_start();
  $username = $_SESSION["username"];
  $stmt->bindParam(":added_by_username", $username);
  $date = date("Y-m-d H:i:s");
  $stmt->bindParam(":date_added", $date);
  $stmt->execute();
}

public function getIngredientNameById($id) {
  $conn = $this->getConnection();
  $query = "SELECT ingredient_name FROM ingredients WHERE id = :id";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $result = $stmt->fetch();
  return $result["ingredient_name"];
}









 
}
