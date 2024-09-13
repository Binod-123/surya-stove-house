<?php 
//session_start();
require_once 'includes/functions.php';

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
        registerUser($name, $email, $password);
        header('Location: login.php');
        exit;
    } else {
        // Token is invalid, handle the error
        echo "Invalid CSRF token.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>form</title>
	<link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
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
<section class="bg-light p-3 p-md-4 ">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5">
        <div class="card border border-light-subtle rounded-4">
          <div class="card-body p-3 p-md-4 p-xl-5">
            <div class="row">
              <div class="col-12">
                <div class="mb-5">
                  <div class="text-center mb-4">
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
