<?php 
session_start();
$dsn = 'mysql:host=localhost;dbname=surya_stove_house_db';
$username = 'root';
$password = '';
$options = [ PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throws exceptions on errors
             PDO::ATTR_EMULATE_PREPARES   => false,             // Disables emulation of prepared statements       
            PDO::ATTR_PERSISTENT         => true                    // Enables persistent connections
        ];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>