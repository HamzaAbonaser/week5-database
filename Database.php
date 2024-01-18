<?php

class Database
{
    private $pdo;
    public $message;

    public function __construct(string $servername = 'localhost', string $username = 'root', string $password = 'QweMus?!123!', string $dbname = 'car')
    {
        $this->pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function AddUser(string $user_name, string $password, string $email)
    {
        $stmt = $this->pdo->prepare("INSERT INTO log (user_name, password, email) VALUES (:user_name, :password, :email)");
        $stmt->bindParam(':user_name', $user_name);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $this->message = 'User added successfully!';
    }

    public function CheckUser(string $user_name, string $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM log WHERE user_name = :user_name");
        $stmt->bindParam(':user_name', $user_name);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user_name;
            $this->message = 'Login successful.';
            return $this->message;
        } else {
            $this->message = 'Invalid username or password.';
            return $this->message;
        }
    }
}