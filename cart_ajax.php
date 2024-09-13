<?php
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle adding items to the cart
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    if($action==='add'){
       
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
$name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
$price = isset($_POST['price']) ? floatval($_POST['price']) : 0.0;
$image = isset($_POST['image']) ? htmlspecialchars($_POST['image']) : '';
    if ($productId > 0 && $quantity > 0) {
       
        if (!isset($_SESSION['cart'])) {
          
            $_SESSION['cart'] = [];
            $_SESSION['product'] = [];
        }
        
        if (isset($_SESSION['cart'][$productId])) {
         
            $_SESSION['cart'][$productId] += $quantity;
            $_SESSION['product'][$productId] = ['id' => $productId,'name' => $name,'price' => $price,'image' => $image,'quantity'=>$_SESSION['cart'][$productId]];
        } else {
            //echo json_encode(['message' => 'Product added to cart!']);exit;
            $_SESSION['cart'][$productId] = $quantity;
            $_SESSION['product'][$productId] = ['id' => $productId,'name' => $name,'price' => $price,'image' => $image,'quantity'=>$_SESSION['cart'][$productId]];
        }

        // Return success response
        echo json_encode(['success' => true, 'message' => 'Product added to cart!','product' => $_SESSION['product']]); exit;
       // echo $_SESSION['cart'];
    } else {
        // Return error response
        echo json_encode(['success' => false, 'message' => 'Invalid product ID or quantity.']); exit;
    }
}

    if ($action === 'update_quantity') {
        $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
       
        if ($productId > 0 && $quantity > 0) {
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId] = $quantity;
                $_SESSION['product'][$productId]['quantity']=$_SESSION['cart'][$productId];
                // Return success response
                echo json_encode(['success' => true, 'message' => 'Quantity updated successfully.']);exit;
            } else {
                // Return error response
                echo json_encode(['success' => false, 'message' => 'Product not found in cart.']);exit;
            }
        } else {
            // Return error response
            echo json_encode(['success' => false, 'message' => 'Invalid product ID or quantity.']);exit;
        }
    } else {
        // Handle other actions if needed
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);exit;
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle retrieving the cart count
    if (isset($_SESSION['cart'])) {
        $cartCount = count($_SESSION['cart']);
        $cartproduct=$_SESSION['product'];
        echo json_encode(['cart_count' => $cartCount,'cart_product'=>$cartproduct]);
    } else {
        echo json_encode(['cart_count' => 0]);
    }
} else {
    // Handle invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
