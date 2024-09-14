<?php

include 'includes/functions.php'; 

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch the order details from the database
    $sql = "SELECT id, product, price,quantity, created_at FROM orders WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$order_id]);

    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return the order details as JSON
    header('Content-Type: application/json');
    echo json_encode($order);
}
?>