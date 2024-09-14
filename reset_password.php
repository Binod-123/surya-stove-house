<?php
include 'header.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify if the token exists in the database
    $stmt = $pdo->prepare("SELECT id FROM users WHERE reset_token = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $new_password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($new_password === $confirm_password) {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $user_id = $user['id'];

                // Update the password and remove the reset token
                $stmt = $pdo->prepare("UPDATE users SET password = :new_password, reset_token = NULL WHERE id = :user_id");
                $stmt->bindParam(':new_password', $hashed_password);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->execute();

                echo "<div class='alert alert-success'>Your password has been reset successfully.</div>";
            } else {
                echo "<div class='alert alert-danger'>Passwords do not match.</div>";
            }
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid or expired token.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>No token provided.</div>";
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Reset Password</div>
                <div class="card-body">
                    <form action="reset_password.php?token=<?= htmlspecialchars($_GET['token']) ?>" method="post">
                        <div class="form-group">
                            <label for="password">New Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password:</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
