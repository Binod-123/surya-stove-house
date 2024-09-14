<?php session_start(); 
require_once '../includes/functions.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query without parameter binding (not secure, vulnerable to SQL injection)
    $query = "SELECT id, password FROM admin_users WHERE name = '$username' LIMIT 1";
    $result = $pdo->query($query);
    $admin = $result->fetch();

    // Check if user exists and verify the password
    if ($admin && password_verify($password, $admin['password'])) {
        // Password is correct, create session and redirect to admin dashboard
        $_SESSION['admin_user'] = $admin['id'];
        header('Location: index.php');
        exit;
    } else {
        // Invalid login credentials
        $_SESSION['errorMessage'] = "Invalid username or password.";
    }
}

?>

<!DOCTYPE html>
<html>
<head lang="en">
	<title>Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/registrations/registration-7/assets/css/registration-7.css">
</head>
<body>
<!-- Registration 7 - Bootstrap Brain Component -->
<section class=" p-3 p-md-4 p-xl-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5">
        <div class="card border border-light-subtle rounded-4">
          <div class="card-body p-3 p-md-4 p-xl-5">
            <div class="row">
              <div class="col-12">
                <div class="mb-2">
                  <div class="text-center mb-1">
                  </div>
                  <h2 class="h4 text-center">Admin Sign In</h2>
                  <h3 class="fs-6 fw-normal text-secondary text-center m-0">Enter your details to Sign In</h3>
                </div>
              </div>
            </div>
            <?php
            if (isset($_SESSION['errorMessage'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['errorMessage'] ?>
                </div>
                <?php unset($_SESSION['errorMessage']); // Clear the message after displaying ?>
            <?php endif; ?>
            <form action="" method="post">
            <?//= csrf_field() ?>
              <div class="row gy-3 overflow-hidden">
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="username" id="username" placeholder="username" required>
                    <label for="username" class="form-label">User name</label>
                  </div>
                  <span class="error"></span>
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
                    <label for="password" class="form-label">Password</label>
                  </div>
                  <span class="error"></span>
                </div>
                <div class="col-12">
                  <div class="d-grid">
                    <button class="btn bsb-btn-xl btn-primary" type="submit">Sign In</button>
                  </div>
                </div>
              </div>
            </form>
            <div class="row">
              <div class="col-12">
                <hr class="mt-5 mb-4 border-secondary-subtle">
                <p class="m-0 text-secondary text-center">Create Account? <a href="<?php isset($_GET['redirect']) && $_GET['redirect'] ? 'register.php?redirect=ca' : 'register.php';?>" class="link-primary text-decoration-none">Sign up</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  $(document).ready(function() {
    $("#myForm").validate({
        rules: {
            
            username: {
                required: true,
                
            },
            password: {
                required: true,
              
            }
        },
        messages: {
            
            username: {
                required: "Please enter your username",
               
            },
            password: {
                required: "Please provide your password",
                
            }
        },
        errorPlacement: function(error, element) {
                // Adjust this placement to ensure the error message is shown correctly
                error.insertAfter(element.parent());
            },
        highlight: function(element) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function(element) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        }
    });
});
</script>
</body>
</html>
