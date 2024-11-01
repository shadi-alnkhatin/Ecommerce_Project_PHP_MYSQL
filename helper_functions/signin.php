<?php
session_start();
ob_start(); // Start output buffering

class Database {
    private $host = "localhost";
    private $db_name = "ecommerce_project";
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
    public $email;
    public $password;
    public $user_name;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->password = $row['password'];
            $this->user_name = $row['user_name'];
            $deleted = $row['deleted'];

            if ($deleted == 1) {
                $_SESSION['blocked'] = true;
                return false;
            }

            if (isset($_POST['password']) && password_verify($_POST['password'], $this->password)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $user->email = $_POST['email'];

        if ($user->login()) {
            $_SESSION['id'] = $user->id;
            $_SESSION['email'] = $user->email;
            $_SESSION['user_name'] = $user->user_name;

            echo "<!DOCTYPE html>
            <html>
            <head>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
            <script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Login successful!',
                    text: 'Welcome, " . $user->user_name . "!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = '../index.php';
                });
            </script>
            </body>
            </html>";
        } else {
            if (isset($_SESSION['blocked']) && $_SESSION['blocked']) {
                unset($_SESSION['blocked']); // Reset session flag
                echo "<!DOCTYPE html>
                <html>
                <head>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                </head>
                <body>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'This account is blocked.',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php';
                        }
                    });
                </script>
                </body>
                </html>";
            } else {
                echo "<!DOCTYPE html>
                <html>
                <head>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                </head>
                <body>
                <script>
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Invalid email or password.',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                </script>
                </body>
                </html>";
            }
        }
    }
}

ob_end_flush(); 
?>