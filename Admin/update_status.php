<?php session_start(); 
include '../includes/functions.php'; 

if (isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    try {
        // SQL query to update the status
        $sql = "UPDATE orders SET status = :status WHERE order_id = :order_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':status', $new_status);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);

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