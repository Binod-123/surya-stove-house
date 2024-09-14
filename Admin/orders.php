<?php 
include 'header.php';

$status = isset($_GET['status']) ? $_GET['status'] : 'all';

try {
    // Base SQL query
    $sql = "SELECT * FROM  orders O LEFT JOIN users AS U ON O.user_id = U.id";
     
    // Append condition based on status
    if ($status !== 'all') {
        $sql .= " WHERE status = :status";
    }

    $stmt = $pdo->prepare($sql);
    
    // Bind the status parameter if it's not 'all'
    if ($status !== 'all') {
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    }
    
    $stmt->execute();
    //$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<div class=" ">
    <h2 class="text-center mb-4">Orders</h2>
    
    <table id="ordersTable" class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>S No </th>
                <th>User Name </th>
                <th>Order ID</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>total</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Check if there are any results
            if ($stmt->rowCount() > 0) {
                $i=0;
                // Fetch each order row by row using a while loop
                while ($order = $stmt->fetch(PDO::FETCH_ASSOC)) { $i++ ;?>
                    <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo htmlspecialchars($order['name']); ?></td>
                        <td class="order-id" data-id="<?php echo $order['order_id']; ?>"><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['product']); ?></td>
                        <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($order['price']); ?></td>
                        <td><?php echo htmlspecialchars($order['total']); ?></td>
                        <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                        <td><?php echo htmlspecialchars($order['updated_at']); ?></td>
                        <td>
                            <button data-id="<?php echo $order['order_id']; ?>" class="view-order btn btn-primary btn-sm">View</button>
                            <a href="#" class="change-status btn btn-primary btn-sm" data-id="<?php echo $order['order_id']; ?>" data-status="<?php echo $order['status']; ?>"><?= htmlspecialchars($order['status'])?></a>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="8">No orders found.</td>
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
                                    <p>User Name: <span id="orderedby"></span></p>
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
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- Initialize DataTable -->
<script>
    $(document).ready(function() {
        $('#ordersTable').DataTable();
        
        
        $('.change-status').on('click', function() {
          
            let orderId = $(this).data('id');
            let currentStatus = $(this).data('status');
          
            let newStatus;


            if (currentStatus.toLowerCase() === 'pending') {
                newStatus = 'Shipped';
            } else if (currentStatus.toLowerCase() === 'shipped') {
                newStatus = 'Pending';
            } else {
                alert('Invalid current status. Cannot update.');
                return;
            }
            if (confirm(`Are you sure you want to change status to ${newStatus}?`)) {
              
                $.ajax({
                    url: 'update_status.php',
                    type: 'POST',
                    data: {
                        order_id: orderId,
                        status: newStatus
                    },
                    success: function(response) {
                      
                        if (response === 'success') {
                           
                            location.reload(); 
                        } else {
                            alert('Error updating status.');
                        }
                    },
                    error: function() {
                        alert('Failed to send request.');
                    }
                });
            }
        });
    });



   
    function populateorderModal(orderDetails) {
    
    let subtotal = 0;
    $('#orderedby').text(`${orderDetails[0]['name']}`);
    $('#orderNumber').text(`${orderDetails[0]['order_id']}`);
    $('#orderDate').text(`${orderDetails[0]['created_at']}`);
    
    var itemList = $('#itemList');
    itemList.empty();

    
    orderDetails.forEach(function(item, index) {
        var productTotalPrice = item.quantity * item.price;
        
        itemList.append(
            `<tr class="item">
                <td>${index + 1}</td>
                <td>${item.product}</td>
                <td>${item.quantity}</td>
                <td>₹${parseFloat(item.price).toFixed(2)}rs</td>
                <td>₹${productTotalPrice.toFixed(2)}rs</td>
            </tr>`
        );
        
        
        subtotal += productTotalPrice;
    });

    
    var gst = subtotal * (18 / 100);
    var grand_total_price = subtotal + gst;
    $('#gstAmount').text(`₹${gst.toFixed(2)}rs`);
    
    $('#totalPrice').text(`₹${subtotal.toFixed(2)}rs`);
   
    $('#grandTotal').text(`₹${grand_total_price.toFixed(2)}rs`);
}


$(document).on('click', '.order-id, .view-order', function() {
    
    var orderId = $(this).data('id');
   
    $.ajax({
        url: '../order_ajax.php', 
        method: 'GET',
        data: { order_id: orderId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                console.log(response);
                populateorderModal(response.data);
                $('#orderModal').modal('show');
            } else {
                alert('order data not found.');
            }
        },
        error: function() {
            alert('Failed to fetch order data.');
        }
    });
});
</script>

</body>
</html>
