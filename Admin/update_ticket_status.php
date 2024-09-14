<?php session_start(); 
include '../includes/functions.php'; 

if (isset($_POST['ticketId']) && isset($_POST['status'])) {
    $ticketId = $_POST['ticketId'];
    $new_status = $_POST['status'];

    try {
        // SQL query to update the status
        $sql = "UPDATE tickets SET status = :status WHERE id = :ticketId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':status', $new_status);
        $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);

        // Execute the update query
        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
    } catch (PDOException $e) {
        echo 'error: ' . $e->getMessage();
    }
} else {
    echo 'invalid_request';
}
?>