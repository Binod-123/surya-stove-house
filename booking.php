<?php
session_start(); 
include 'includes/functions.php';

print_r($_SESSION['product']);
function generateOrderId() {
    return 'OD' . rand(1000, 9999);  // Generates OD1234 style order ID
}
//$total = 0;

   
$now = date('Y-m-d H:i:s');

//oop through the array and insert each item

    // Bind parameters
   
    // Execute the statement
    try {
       
        $sql = "INSERT INTO orders ( user_id,order_id,product,quantity,price, total, created_at,updated_at) VALUES ( :user,:od_id ,:product,:quantity,:price,:total, :created_at,:updated_at)";

        // Prepare the statement
        $stmt = $pdo->prepare($sql);
        $od_id  = generateOrderId();
        foreach ($_SESSION['product'] as $product) {
            $total += $product['price'] * $product['quantity'];
            $stmt->bindParam(':user', $_SESSION['user_id']);
            $stmt->bindparam(':od_id',$od_id );
            $stmt->bindparam(':product',$product['name']);
            $stmt->bindparam(':quantity',$product['quantity'] );
            $stmt->bindparam(':price',$product['price'] );
            $stmt->bindParam(':total', $total);
            
            $stmt->bindParam(':created_at',$now );
            $stmt->bindParam(':updated_at', $now);
            $stmt->execute();
                $order_id = $pdo->lastInsertId();
                 // Calculate total cost
            }
        echo "Record inserted successfully.\n";
        header("Location:orders.php");
    } catch (PDOException $e) {
        echo "Error inserting record: " . $e->getMessage() . "\n";
    }

?>