<?php 
session_start();
require_once 'includes/functions.php';
if (isset($_GET['redirect'])) {

  $_SESSION['redirect_after_login'] = $_GET['redirect'];
}
// Generate a CSRF token if it does not exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check CSRF token
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $login =registerUser($name, $email, $password);
        if ($login) {
          if (isset($_SESSION['redirect_after_login'])&& $_SESSION['redirect_after_login']=='ca') {
            header("Location: login.php?redirect=ca"); 
            exit;
        } else if($_SESSION['redirect_after_login']=='st'){ 
          header("Location: login.php?redirect=st"); // 
           
        } else  {
            // Default redirect if no specific redirect URL is set
            header("Location: login.php"); // Replace with your default post-login page
            exit;
        }
        exit;
    } else {
        // Token is invalid, handle the error
        $_SESSION['errorMessage'] = "Invalid CSRF token.";
        //echo "Invalid CSRF token.";
    }
}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/registrations/registration-7/assets/css/registration-7.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.9.0/jquery.validate.min.js" integrity="sha512-FyKT5fVLnePWZFq8zELdcGwSjpMrRZuYmF+7YdKxVREKomnwN0KTUG8/udaVDdYFv7fTMEc+opLqHQRqBGs8+w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
    .error{
        color: red;
        font-size:0.875em;
    }
</style>
</head>
<body>
<!-- Registration 7 - Bootstrap Brain Component -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Surya Stove House</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-2">
                    <li class="nav-item rounded">
                        <a class="nav-link active" aria-current="page" href="index.php"><i class="fas fa-home me-2"></i>Home</a>
                    </li>
                    
                    
                </ul>
            </div>
        </div>
    </nav>

<section class=" p-3 p-md-4 ">
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
                  <h2 class="h4 text-center">Registration</h2>
                  <h3 class="fs-6 fw-normal text-secondary text-center m-0">Enter your details to register</h3>
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
            <form id="myForm" action="" method="post">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
              <div class="row gy-3 overflow-hidden">
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="name" id="name" autocomplete="off" placeholder="User Name">
                    <label for="name" class="form-label"> Name</label>
                    
                  </div>
                  <span class="error"></span>
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="email" class="form-control" name="email" id="email" autocomplete="off" placeholder="name@example.com" >
                    <label for="email" class="form-label">Email</label>
                    
                  </div>
                  <span class="error"></span>
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="password" autocomplete="off" value="" placeholder="Password" >
                    <label for="password" class="form-label">Password</label>
                  
                  </div>
                  <span class="error"></span>
                </div>
                <div class="col-12">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" name="iAgree" id="iAgree" required>
                    <label class="form-check-label text-secondary" for="iAgree">
                      I agree to the <a href="#!" class="link-primary text-decoration-none">terms and conditions</a>
                    </label>
                    <span class="error"></span>
                  </div>
                </div>
                <div class="col-12">
                  <div class="d-grid">
                    <button class="btn bsb-btn-xl btn-primary" type="submit">Sign up</button>
                  </div>
                </div>
              </div>
            </form>
            <div class="row">
              <div class="col-12">
                <hr class="mt-5 mb-4 border-secondary-subtle">
                <p class="m-0 text-secondary text-center">Already have an account? <a href="/login" class="link-primary text-decoration-none">Sign in</a></p>
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
            name: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            name: {
                required: "Please enter your name",
                minlength: "Your name must consist of at least 2 characters"
            },
            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
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
