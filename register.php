<?php
include("query.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signup Form</title>
    <link rel="stylesheet" href="css/login.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Password Validation Function
            function validatePassword() {
                var password = $('#password').val();
                var confirmPassword = $('#confirm_password').val();
                var error = '';

                // Regular expressions for password validation
                var upperCase = /[A-Z]/;
                var lowerCase = /[a-z]/;
                var digit = /\d/;
                var symbol = /[!@#$%^&*(),.?":{}|<>]/;
                var minLength = 8;
                var maxLength = 16;

                if (password.length < minLength || password.length > maxLength) {
                    error += "Password must be between 8 and 16 characters long.<br>";
                }
                if (!upperCase.test(password)) {
                    error += "Password must contain at least one uppercase letter.<br>";
                }
                if (!lowerCase.test(password)) {
                    error += "Password must contain at least one lowercase letter.<br>";
                }
                if (!digit.test(password)) {
                    error += "Password must contain at least one digit.<br>";
                }
                if (!symbol.test(password)) {
                    error += "Password must contain at least one symbol.<br>";
                }
                if (password !== confirmPassword) {
                    error += "Passwords do not match.<br>";
                }

                $('#password_error').html(error);
                return error === '';
            }

            // Validate password on input
            $('#password, #confirm_password').on('keyup', function() {
                validatePassword();
            });

            // Handle form submission
            $('#register_form').on('submit', function(e) {
                if (!validatePassword()) {
                    e.preventDefault(); // Prevent form submission if validation fails
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="registration form">
            <header>Register</header>
            <form action="" id="register_form" method="post">
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                <span id="email_error" style="color: red;"></span>
                
                <input type="password" id="password" name="password" placeholder="Create a password" required>
                <span id="password_error" style="color: red;"></span>

                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>

                <input type="submit" name="register" class="button" value="Signup">
            </form>
            <div class="signup">
                <span>Already have an account?
                    <a href="login.php">Login</a>
                </span>
            </div>
        </div>
    </div>
</body>
</html>
