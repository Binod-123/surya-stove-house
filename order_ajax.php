<?php 
session_start();
include 'includes/functions.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $od_id=$_GET['order_id'];
    $sql="SELECT o.*,U.name FROM orders as o LEFT JOIN users as U on U.id=o.user_id WHERE order_id ='".$od_id."'";
    $stmt = $pdo->query($sql);
   
    $order_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(["success" => true, "data" => $order_details]);
  exit;
}