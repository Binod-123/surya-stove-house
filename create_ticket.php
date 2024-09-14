<?php
session_start();
include 'includes/functions.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming PDO has been initialized earlier and session started
    $user_id = $_SESSION['user_id'];
    $order_id = $_POST['order_id'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    try {
        // Enable PDO error mode to exception
      

        // Insert ticket using prepared statement
        $sql = "INSERT INTO tickets (user_id, order_id, subject, created_at, updated_at) VALUES (:user_id, :order_id, :subject, NOW(), NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':subject', $subject);
        
        if ($stmt->execute()) {
            // Get the last inserted ticket ID
            $ticket_id = $pdo->lastInsertId();
            
            // Insert first message
            $sql_message = "INSERT INTO ticket_messages (ticket_id, sender_type, sender_id, message, created_at) 
                            VALUES (:ticket_id, 'user', :sender_id, :message, NOW())";
            $stmt_message = $pdo->prepare($sql_message);
            $stmt_message->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
            $stmt_message->bindParam(':sender_id', $user_id, PDO::PARAM_INT);
            $stmt_message->bindParam(':message', $message, PDO::PARAM_STR);
            
            if ($stmt_message->execute()) {
                echo "Ticket created successfully!";
            } else {
                echo "Failed to create the first message.";
            }
        } else {
            echo "Failed to create the ticket.";
        }
    } catch (PDOException $e) {
        // Output error message
        echo "Error: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user_id = $_SESSION['user_id'];

    // Prepare the SQL statement to fetch all tickets and messages for the logged-in user
   // Assuming $pdo is properly initialized and $user_id is set
// Updated SQL query with two different placeholders for user_id
// Assuming $pdo is already initialized and the user ID is set in $user_id
$sql = "SELECT id, subject, status, created_at, updated_at 
        FROM tickets 
        WHERE user_id = :user_id";

// Prepare the statement
$stmt = $pdo->prepare($sql);

// Bind the user ID parameter
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

// Execute the query
$stmt->execute();

// Fetch the results
$tickets = '';
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($rows) > 0) {
    foreach ($rows as $row) {
        $tickets .= "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['subject']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['created_at']}</td>
                        <td>{$row['updated_at']}</td>
                        <td><button class='btn btn-info view-ticket' data-id='{$row['id']}'>View</button></td>
                    </tr>";
    }
} else {
    $tickets = "<tr><td colspan='6'>No tickets found</td></tr>";
}

// Output the tickets
echo $tickets;





}
?>
