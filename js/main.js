$(document).ready(function() {
    // Intercept form submission
    $('#mycartForm').submit(function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        // AJAX call to check if the user is logged in
        $.ajax({
            url: 'check_login.php', // Backend endpoint to check login status
            type: 'GET',            // Request type
            dataType: 'json',       // Expecting JSON response
            success: function(response) {
                if (response.logged_in) {
                    // If logged in, submit the form
                    $('#mycartForm')[0].submit(); // Submit the form programmatically
                } else {
                    // If not logged in, redirect to the login page
                    window.location.href = 'login.php?redirect=ca'; // Replace with your login page URL
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('An error occurred:', error);
            }
        });
    });
});

function populateorderModal(orderDetails, order) {
    // Assuming orderDetails is an array of product objects
    // Initialize subtotal
    let subtotal = 0;

    // Clear existing items in the table
    var itemList = $('#itemList');
    itemList.empty();

    // Populate items in the table
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
        
        // Accumulate subtotal
        subtotal += productTotalPrice;
    });

    // Calculate GST and grand total
    var gst = subtotal * (18 / 100);
    var grand_total_price = subtotal + gst;
    orderNumber
    // Update the total price, GST amount, and grand total in the modal
    $('#totalPrice').text(`₹${subtotal.toFixed(2)}rs`);
    $('#gstAmount').text(`₹${gst.toFixed(2)}rs`);
    $('#grandTotal').text(`₹${grand_total_price.toFixed(2)}rs`);
    $('#orderNumber').text(`${orderDetails[0]['order_id']}`);
    $('#orderDate').text(`${orderDetails[0]['created_at']}`);
}

// Example AJAX call to fetch and show order data
$(document).on('click', '.view-order', function() {
    
    var orderId = $(this).data('id');
   // alert(orderId);
    $.ajax({
        url: 'order_ajax.php', // Adjust URL as needed
        method: 'GET',
        data: { order_id: orderId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
               
                populateorderModal(response.data,response.orderdata);
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

$(document).ready(function() {
    $('#order').change(function() {
        var orderId = $(this).val();
        if (orderId !== "") {
            // Perform AJAX request to fetch order details
            $.ajax({
                url: 'order_details.php',  // Path to your PHP file that fetches order details
                method: 'GET',
                data: { order_id: orderId },  // Send the selected order ID
                success: function(response) {
                    if (response) {
                        // Populate the order details
                        $('#product').text(response.product);
                        $('#quantity').text(response.quantity);
                        $('#price').text(parseFloat(response.price).toFixed(2));
                        $('#orderDate').text(new Date(response.created_at).toLocaleDateString());

                        // Show the details section
                        $('#orderDetails').show();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching order details:', error);
                }
            });
        } else {
           
            $('#orderDetails').hide();
        }
    });
});

$(document).ready(function () {
    
    loadTickets(); 

    // Fetch orders for the user


    // Submit a ticket based on the selected order
    $('#create-ticket-form').on('submit', function (e) {
        e.preventDefault();
        const order_id = $('#order').val();
        const subject = $('#subject').val();
        const message = $('#message').val();
        alert(message);

        $.ajax({
            url: 'create_ticket.php',
            type: 'POST',
            data: {order_id: order_id, subject: subject, message: message},
             dataType: 'text',
            success: function (response) {
                console.log(response);
                loadTickets(); // Reload tickets after submission
            }
        });
    });

    // Load ticket messages
    function loadTickets() {
        $.ajax({
            url: 'create_ticket.php',
            type: 'GET',
            success: function (data) {

                $('#ticket-list').html(data);
            }
        });
    }

    $(document).on('click', '.view-ticket', function () {
        const ticket_id = $(this).data('id');
        // Implement logic to view the details of the ticket (e.g., open a modal or redirect)
        window.location.href = `view_ticket.php?ticket_id=${ticket_id}`;
    });
});