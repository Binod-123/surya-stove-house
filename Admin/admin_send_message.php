<?php
session_start();
include '../includes/functions.php';
$user_id = $_SESSION['user_id'];  // Assuming user ID is stored in session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ticket_id = $_POST['ticket_id'];
    $message = $_POST['message'];

    try {
        // Database pdoection using PDO
      

        // Insert message into the ticket_messages table
        $sql = "INSERT INTO ticket_messages (ticket_id, sender_type, sender_id, message, created_at) 
                VALUES (:ticket_id, 'admin', :user_id, :message, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        $stmt->execute();

        // Return the message back to the front-end to be appended
        echo "<div class='message mb-3'>
                <strong>You:</strong> 
                <p>" . htmlspecialchars($message) . "</p>
                <small><em>Sent just now</em></small>
              </div><hr>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
