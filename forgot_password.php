<?php
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Generate a unique reset token
        $token = bin2hex(random_bytes(50));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_id = $user['id'];

        // Store the reset token in the database
        $stmt = $pdo->prepare("UPDATE users SET reset_token = :token WHERE id = :user_id");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // Create the reset link
        $reset_link = "http://localhost/surya-stove-house/reset_password.php?token=" . $token;

        // Display the reset link (simulating sending an email)
        echo "<div class='alert alert-success'>Password reset link: <a href='$reset_link'>$reset_link</a></div>";
    } else {
        echo "<div class='alert alert-danger'>No user found with this email.</div>";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Forgot Password</div>
                <div class="card-body">
                    <form action="forgot_password.php" method="post">
                        <div class="form-group">
                            <label for="email">Enter your email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
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
