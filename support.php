 <?php 
 include 'header.php'; 
 if (!isset($_SESSION['user_id'])) {
    // If no session is set, redirect to the login page
    header("Location: login.php?redirect=st");
    exit;
}
 $oder_sql = "SELECT id, order_id, product FROM orders WHERE user_id = '".$_SESSION['user_id']."'";
 $od_stmt = $pdo->prepare($oder_sql);
 $od_stmt->execute();
 $orders_drop = $od_stmt->fetchAll(PDO::FETCH_ASSOC);
 
 
 
 ?>
<div class="container card mt-3">
    <div class="card-header">Create a Ticket for an Order</div>
    <div class="card-body">
        <form id="create-ticket-form">
            <div class="mb-3">
                <label for="order" class="form-label">Select Order</label>
                <select class="form-select" id="order" name="order" required>
                    <option value="">Select Order</option>
                  <?php  foreach ($orders_drop as $order) {
                        echo '<option value="' . $order['id'] . '">';
                        echo $order['order_id'] . ' - ' . $order['product'];
                        echo '</option>';
                    }?>
                </select>
            </div>
            <div class="mb-3" id="orderDetails" style="display: none;">
                <p><strong>Product:</strong> <span id="product"></span></p>
                <p><strong>quantity:</strong> <span id="quantity"></span></p>
                <p><strong>Price:</strong> ₹<span id="price"></span></p>
                <p><strong>Order Date:</strong> <span id="orderDate"></span></p>
            </div>
            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" class="form-control" id="subject" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Ticket</button>
        </form>
    </div>
</div>

<!-- Ticket and Messages Display -->
<!-- Ticket List -->
<div class="card mt-5">
    <div class="card-header">Your Support Tickets</div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="ticket-list">
                <!-- Tickets will be dynamically loaded here -->
            </tbody>
        </table>
    </div>
</div>

<footer class="bg-dark text-white" style=" bottom:0px; width:100%;">
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
