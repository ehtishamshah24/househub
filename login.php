<?php
include("query.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login Form</title>
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
  <div class="container">
    <div class="login form">
      <header>Login</header>
      <form action="query.php" method="post" id="login_form">
        <input type="email" placeholder="Enter your email" name="login_email" required>
        <input type="password" placeholder="Enter your password" name="login_password" required>
        <a href="#">Forgot password?</a>
        <input type="submit" class="button" value="Login" name="login">
      </form>
      <div class="signup">
        <span>Don't have an account?
          <a href="register.php">Signup</a>
        </span>
      </div>
    </div>
  </div>
</body>
</html>

