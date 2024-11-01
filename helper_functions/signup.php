<?php
session_start();

class Database {
    private $host = "localhost";
    private $db_name = "ecommerce_db";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        return $this->conn;
    }
}

class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $user_name;
    public $email;
    public $password;
    public $phone_number;
    public $country;
    public $city;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function isEmailExists($email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function register() {
        if ($this->isEmailExists($this->email)) {
            $_SESSION['error'] = 'Email already exists!';
            return false;
        }

        $query = "INSERT INTO " . $this->table_name . " (user_name, email, password, phone_number, country, city, role)
                  VALUES (:user_name, :email, :password, :phone_number, :country, :city, :role)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_name', $this->user_name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':phone_number', $this->phone_number);
        $stmt->bindParam(':country', $this->country);
        $stmt->bindParam(':city', $this->city);

        $role = 1;
        $stmt->bindParam(':role', $role);

          


        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId(); 
            $_SESSION['user_id'] = $this->id;
            $_SESSION['user_name'] = $this->user_name;
            $_SESSION['user_email'] = $this->email;
            return true;
        }

        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    $user->user_name = $_POST['user_name'];
    $user->email = $_POST['email'];
    $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user->phone_number = $_POST['phone_number'];
    $user->country = $_POST['country'];
    $user->city = $_POST['city'];

    if ($user->register()) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "<script>alert('" . $_SESSION['error'] . "'); window.location.href = 'index.php';</script>";
        unset($_SESSION['error']);
        exit();
    }
}
?>
