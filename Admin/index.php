<?php 

include 'header.php';
try {
    // Fetch total orders
    $stmt_total = $pdo->prepare("SELECT COUNT(*) AS total_orders FROM orders");
    $stmt_total->execute();
    $total_orders = $stmt_total->fetch(PDO::FETCH_ASSOC)['total_orders'];

    // Fetch pending orders
    $stmt_pending = $pdo->prepare("SELECT COUNT(*) AS pending_orders FROM orders WHERE status = 'pending'");
    $stmt_pending->execute();
    $pending_orders = $stmt_pending->fetch(PDO::FETCH_ASSOC)['pending_orders'];

    // Fetch shipped orders
    $stmt_shipped = $pdo->prepare("SELECT COUNT(*) AS shipped_orders FROM orders WHERE status = 'shipped'");
    $stmt_shipped->execute();
    $shipped_orders = $stmt_shipped->fetch(PDO::FETCH_ASSOC)['shipped_orders'];
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<style>
        .card-box {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .card-box:hover {
            background-color: #f8f9fa;
        }
        .card-box h5 {
            font-size: 16px;
            font-weight: 600;
            color: #343a40;
        }
        .card-box .card-content {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        .dashboard-row {
            margin-top: 50px;
        }
    </style>


<div class="container">
    <h2 class="text-center my-4">Admin Dashboard</h2>
    <div class="row dashboard-row">
        <!-- Total Orders Card -->
        <div class="col-md-4">
            <a href="orders.php?status=all" class="text-decoration-none">
                <div class="card-box text-center">
                    <h5>Total Orders</h5>
                    <div class="card-content">
                        <?= htmlspecialchars($total_orders); ?>
                    </div>
                </div>
            </a>
        </div>

        <!-- Pending Orders Card -->
        <div class="col-md-4">
            <a href="orders.php?status=pending" class="text-decoration-none">
                <div class="card-box text-center">
                    <h5>Pending Orders</h5>
                    <div class="card-content text-warning">
                        <?= htmlspecialchars($pending_orders); ?>
                    </div>
                </div>
            </a>
        </div>

        <!-- Shipped Orders Card -->
        <div class="col-md-4">
            <a href="orders.php?status=shipped" class="text-decoration-none">
                <div class="card-box text-center">
                    <h5>Shipped Orders</h5>
                    <div class="card-content text-success">
                        <?= htmlspecialchars($shipped_orders); ?>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
