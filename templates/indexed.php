<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "cholera_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Signup form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO log (name, email, password) VALUES ('$name', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Reset checkbox state to unchecked, triggering the flip animation to the login section
        echo "<script>document.getElementById('flip').checked = false;</script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate user credentials against database
    $sql = "SELECT * FROM log WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Redirect to http://127.0.0.1:5004 upon successful login
        echo "<script>window.location.href = 'http://127.0.0.1:5004';</script>";
        exit();
    } else {
        echo "Invalid email or password"; // You may want to display an error message to the user
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Login and Registration Form</title>
    <link rel="stylesheet" href="styled.css">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container">
        <input type="checkbox" id="flip" <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) echo 'checked'; ?>>
        <div class="cover">
            <div class="front">
                <img src="images/frontImg.jpg" alt="">
                <div class="text">
                    <span class="text-1">Every new friend is a <br> new adventure</span>
                    <span class="text-2">Let's get connected</span>
                </div>
            </div>
            <div class="back">
                <img class="backImg" src="images/backImg.jpg" alt="">
                <div class="text">
                    <span class="text-1">Complete miles of journey <br> with one step</span>
                    <span class="text-2">Let's get started</span>
                </div>
            </div>
        </div>
        <div class="forms">
            <div class="form-content">
                <div class="login-form">
                    <div class="title">Login</div>
                    <form action="#" method="post" name="login-form">
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <input type="text" name="email" placeholder="Enter your email" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <div class="text"><a href="#">Forgot password?</a></div>
                            <div class="button input-box">
                                <input type="submit" name="login" value="Submit">
                            </div>
                            <div class="text sign-up-text">Don't have an account? <label for="flip">Sign up now</label></div>
                        </div>
                    </form>
                </div>
                <div class="signup-form">
                    <div class="title">Signup</div>
                    <form action="#" method="post" name="signup-form">
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="fas fa-user"></i>
                                <input type="text" name="name" placeholder="Enter your name" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" placeholder="Enter your email" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <div class="button input-box">
                                <input type="submit" name="signup" value="Submit">
                            </div>
                            <div class="text sign-up-text">Already have an account? <label for="flip">Login now</label></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
