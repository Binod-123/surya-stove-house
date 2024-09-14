<?php
include 'header.php'; 
$user_id = $_SESSION['user_id'];  // Assuming user ID is stored in session
$ticket_id = $_GET['ticket_id'];

try {
    // Database connection using PDO

    // Fetch ticket and order details
    $sql_ticket = "SELECT t.subject, o.order_id, o.created_at, o.price, o.product, o.quantity
                   FROM tickets t
                   JOIN orders o ON t.order_id = o.id 
                   WHERE t.id = :ticket_id AND t.user_id = :user_id";
    $stmt_ticket = $pdo->prepare($sql_ticket);
    $stmt_ticket->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
    $stmt_ticket->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt_ticket->execute();
    $ticket = $stmt_ticket->fetch(PDO::FETCH_ASSOC);

    // Calculate grand total
    $grand_total = ($ticket['price'] * $ticket['quantity']) + (($ticket['price'] * $ticket['quantity']) * (18 / 100));

    // Fetch messages for the ticket
    $sql_messages = "SELECT tm.message, tm.sender_type, tm.created_at
                     FROM ticket_messages tm
                     WHERE tm.ticket_id = :ticket_id
                     ORDER BY tm.created_at ASC";
    $stmt_messages = $pdo->prepare($sql_messages);
    $stmt_messages->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
    $stmt_messages->execute();
    $messages = $stmt_messages->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!-- Back Button -->
<div class="container mt-3">
    <a href="user_dashboard.php" class="btn btn-secondary">Back to Ticket List</a>
</div>

<!-- Display Ticket Details -->
<div class="card mt-5">
    <div class="card-header">
        Ticket: <?= htmlspecialchars($ticket['subject']) ?>
    </div>
    <div class="card-body">
        <h5>Order Details</h5>
        <p><strong>Order Number:</strong> <?= htmlspecialchars($ticket['order_id']) ?></p>
        <p><strong>Order Date:</strong> <?= htmlspecialchars($ticket['created_at']) ?></p>
        <p><strong>Product:</strong> <?= htmlspecialchars($ticket['product']) ?></p>
        <p><strong>Quantity:</strong> <?= htmlspecialchars($ticket['quantity']) ?></p>
        <p><strong>Total Amount:</strong> <?= htmlspecialchars(number_format($grand_total, 2)) ?></p>
    </div>
</div>

<!-- Display Messages -->
<div class="card mt-3">
    <div class="card-header">Messages</div>
    <div class="card-body" id="message-list">
        <?php if ($messages): ?>
            <?php foreach ($messages as $message): ?>
                <div class="message mb-3">
                    <strong><?= htmlspecialchars($message['sender_type']) == 'user' ? 'You' : 'Admin' ?>:</strong> 
                    <p><?= htmlspecialchars($message['message']) ?></p>
                    <small><em>Sent on: <?= htmlspecialchars($message['created_at']) ?></em></small>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No messages yet.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Message Input Form -->
<div class="card mt-3">
    <div class="card-header">Send a Message</div>
    <div class="card-body">
        <form id="sendMessageForm">
            <div class="form-group">
                <textarea class="form-control" id="message" rows="3" placeholder="Enter your message"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Handle sending message
    $('#sendMessageForm').submit(function(e) {
        e.preventDefault();
        var message = $('#message').val();
        
        if (message.trim() === '') {
            alert('Message cannot be empty');
            return;
        }

        $.ajax({
            url: 'send_message.php',
            type: 'POST',
            data: {
                ticket_id: <?= $ticket_id ?>,
                message: message
            },
            success: function(response) {
                $('#message-list').append(response);  // Append the new message to the message list
                $('#message').val('');  // Clear the input field
            }
        });
    });
</script>
