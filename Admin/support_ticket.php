<?php
include 'header.php';

try {
   

    // Fetch all tickets
    $sql_tickets = "SELECT t.id, t.subject, u.name AS customer_name, t.status
                    FROM tickets t
                    JOIN users u ON t.user_id = u.id
                    ORDER BY t.created_at DESC";
    $stmt_tickets = $pdo->prepare($sql_tickets);
    $stmt_tickets->execute();
    $tickets = $stmt_tickets->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!-- Ticket List -->
<div class="container mt-3">
    <h2>Tickets</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Subject</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td><?= htmlspecialchars($ticket['id']) ?></td>
                    <td><?= htmlspecialchars($ticket['subject']) ?></td>
                    <td><?= htmlspecialchars($ticket['customer_name']) ?></td>
                    <td><?= htmlspecialchars($ticket['status']) ?></td>
                    <td><a href="admin_view_ticket.php?ticket_id=<?= htmlspecialchars($ticket['id']) ?>" class="btn btn-primary">View</a>
                    <a href="#" class="change-status btn btn-primary btn-sm" data-id="<?php echo $ticket['id']; ?>" data-status="<?php echo $ticket['status']; ?>"><?= htmlspecialchars($ticket['status'])?></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
     $('.change-status').on('click', function() {
          
          let ticketId = $(this).data('id');
          let currentStatus = $(this).data('status');
        
          let newStatus;


          if (currentStatus.toLowerCase() === 'open') {
              newStatus = 'closed';
          
          } else {
              alert('Invalid current status. Cannot update.');
              return;
          }
          if (confirm(`Are you sure you want to change status to ${newStatus}?`)) {
            
              $.ajax({
                  url: 'update_ticket_status.php',
                  type: 'POST',
                  data: {
                    ticketId: ticketId,
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

    </script>
