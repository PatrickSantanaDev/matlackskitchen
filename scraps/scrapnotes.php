<?php

class Daop {
    /* Connect to a MySQL database using driver invocation */
    public $dsn = 'mysql:dbname=matlacks;host=127.0.0.1';
    public $user = 'root';
    public $password = '';

    public function getConnection() {
        try {
            $connection = new PDO($this->dsn, $this->user, $this->password);
            //echo "it worked";
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
        return $connection;
    }

    public function getUsers() {
        $connection = $this->getConnection();
        try {
            $rows = $dbh->query("SELECT user_id, username, pass, email, actualname FROM users ORDER BY user_id", PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo print_r($e, 1);
            exit;
        }
        return $rows;
    }

}


// foreach ($rows as $row) {
//     echo print_r($row, 1);
// }
// foreach ($rows as $row) {
//     print ('user id ='. $row['user_id'] . "\t");
//     print ('username = ' . $row['username'] . "\t");
//     print ('password = ' . $row['pass'] . "\t");
//     print ('email = ' . $row['email'] . "\t");
//     print ('actualname = ' . $row['actualname'] . "\t");
// }


?>