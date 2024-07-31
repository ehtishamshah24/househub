<?php
session_start();
include("db.php");

// login ...
if (isset($_POST['login'])) {
    $loginEmail = $_POST['login_email'];
    $loginPassword = $_POST['login_password'];

    // Prepare and execute query to check if user exists
    $query = $pdo->prepare("SELECT * FROM users WHERE Email = :lEmail");
    $query->bindParam(':lEmail', $loginEmail);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify the password against the hashed password
        if (password_verify($loginPassword, $user['Password'])) {
            // Start session and set session variables
            $_SESSION['userId'] = $user['UserID'];
            $_SESSION['userEmail'] = $user['Email'];
            $_SESSION['userName'] = $user['Name'];

            echo "<script>alert('Login successful'); location.assign('index.php');</script>";
        } else {
            echo "<script>alert('Incorrect email or password');</script>";
        }
    } else {
        echo "<script>alert('Incorrect email or password');</script>";
    }
}

// user register code ....
if (isset($_POST['register'])) {
    $userEmail = $_POST['email'];
    $userPassword = $_POST['password'];
    // Use password_hash to securely hash passwords
    $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

    // Check if the email already exists in the database
    $checkQuery = $pdo->prepare("SELECT Email FROM users WHERE Email = ?");
    $checkQuery->execute([$userEmail]);

    if ($checkQuery->rowCount() > 0) {
        echo "<script>alert('Email already registered.');</script>";
    } else {
        // Insert user data into the database
        $insertQuery = $pdo->prepare("INSERT INTO users (Email, Password) VALUES (?, ?)");
        if ($insertQuery->execute([$userEmail, $hashedPassword])) {
            echo "<script>alert('Registration successful! Please log in.');
                            location.assign('login.php');</script>";
        } else {
            echo "<script>alert('Error during registration. Please try again.');</script>";
        }
    }
}
?>