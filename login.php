<?php session_start(); require_once 'includes/functions.php';
if (isset($_GET['redirect'])) {

  $_SESSION['redirect_after_login'] = $_GET['redirect'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Check CSRF token
  
  $email = $_POST['email'];
  $password = $_POST['password'];
  $user = authenticateUser($email, $password);
  if ($user) {

    $_SESSION['user_id'] = $user['id'];

   if (isset($_SESSION['redirect_after_login'])&& $_SESSION['redirect_after_login']=='ca') {
        $redirect_url ="cart.php";
        unset($_SESSION['redirect_after_login']); // Clear the redirect URL from session
        header("Location: $redirect_url"); // Redirect to the home page or specified page
        exit;
    }if (isset($_SESSION['redirect_after_login'])&& $_SESSION['redirect_after_login']=='st') {
      $redirect_url ="support.php";
      unset($_SESSION['redirect_after_login']); // Clear the redirect URL from session
      header("Location: $redirect_url"); // Redirect to the home page or specified page
      exit;
  } 
    else {
        // Default redirect if no specific redirect URL is set
        header("Location: index.php"); // Replace with your default post-login page
        exit;
    }
    exit;
} else {
  $_SESSION['errorMessage'] ="Invalid email or password.";
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
                  <h2 class="h4 text-center">Sign In</h2>
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
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                    <label for="E-mail" class="form-label">E-mail</label>
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
                <p class="m-0 text-secondary text-center"> <a href="forgot_password.php" class="link-primary text-decoration-none">Forgot Password</a></p>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <hr class="mt-5 mb-4 border-secondary-subtle">
                <p class="m-0 text-secondary text-center">Create Account? <a href="<?php echo isset($_GET['redirect']) && $_GET['redirect'] ? 'register.php?redirect=' . urlencode($_GET['redirect']) : 'register.php'; ?>" class="link-primary text-decoration-none">Sign up</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<footer class="bg-dark text-white" style="position: absolute; bottom:0px; width:100%;">
  <p class="text-center p-2 m-0">surya stove house</p>
</footer>
<script>
  $(document).ready(function() {
    $("#myForm").validate({
        rules: {
            
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
              
            }
        },
        messages: {
            
            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address"
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
