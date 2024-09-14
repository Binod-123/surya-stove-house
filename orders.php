<?php 
include 'header.php';
$user_id = $_SESSION['user_id'];

try {
    // SQL query to fetch orders for the logged-in user
    $sql = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY id ASC";
    
    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);
    
    // Bind the user_id parameter
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    
    // Execute the statement
    $stmt->execute();
    
} catch (PDOException $e) {
    echo "Error fetching orders: " . $e->getMessage();
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Orders Table</h2>
    
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Check if there are any results
            if ($stmt->rowCount() > 0) {
                // Fetch each order row by row using a while loop
                while ($order = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['product']); ?></td>
                        <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($order['price']); ?></td>
                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                        <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                        <td><?php echo htmlspecialchars($order['updated_at']); ?></td>
                        <td>
                            
                            <button data-id="<?php echo $order['order_id']; ?>" id="view-order" class="view-order btn btn-primary btn-sm">View</button>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="7">No orders found.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="order-box">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">
                                    <h4>Order Id #: <span id="orderNumber"></span></h4>
                                    <p>Created: <span id="orderDate"></span></p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="heading">
                                <th>S.No</th>
                                <th>Product</th>
                                <th class="text-right">Quantity</th>
                                <th class="text-right">Price</th>
                                <th class="text-right">Total</th>
                            </tr>
                            <tbody id="itemList">
                                <!-- Items will be inserted here dynamically -->
                            </tbody>
                            <tr class="total">
                                <td colspan="4" class="text-right"><strong>Subtotal:</strong></td>
                                <td class="text-right"><strong><span id="totalPrice">0.00</span></strong></td>
                            </tr>
                            <tr class="total">
                                <td colspan="4" class="text-right"><strong>GST (18%):</strong></td>
                                <td class="text-right"><strong><span id="gstAmount">0.00</span></strong></td>
                            </tr>
                            <tr class="total">
                                <td colspan="4" class="text-right"><strong>Grand Total (Including GST):</strong></td>
                                <td class="text-right"><strong><span id="grandTotal">0.00</span></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<footer class="bg-dark text-white" style="position: absolute; bottom:0px; width:100%;">
    <p class="text-center p-2 m-0">surya stove house</p>
</footer>
<!-- Bootstrap JS and Dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="js/cart.js"></script>
<script src="js/main.js"></script>
<script>


</script>
</body>

</html>

