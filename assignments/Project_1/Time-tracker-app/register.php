<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "db.php";
require "includes/header.php";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // reCAPTCHA
    $secretKey = "6Ldmi6gsAAAAAPHNEX6zxxmqRhNpRHlsh4G5Q4IP";
    $responseKey = $_POST['g-recaptcha-response'];
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey");
    $captcha_success = json_decode($verify);
    if (!$captcha_success->success) {
        $errors[] = "Please confirm that you are not a robot.";
    }

    // if there are no errors, proceed with registration
    if (empty($errors)) {
        // check if username or email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
        $stmt->execute([':username' => $username, ':email' => $email]);

        if ($stmt->fetch()) {
            $errors[] = "The username or email already exists.";
        } 
        
        else {
            // save user with hashed password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashed_password
            ]);
            echo "<div class='alert alert-success'>Registration successful. <a href='login.php'>Login</a></div>";
        }
    }
}
?>

<h2>Registration</h2>

<?php foreach ($errors as $error) {
    echo "<div class='alert alert-danger'>$error</div>";
} ?>

<form action="" method="POST">
    <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control" required>
    </div>

    <div class="g-recaptcha" data-sitekey="6Ldmi6gsAAAAACAh9H_3WlYm_YPtirjovxrv39w0"></div>

    <button type="submit" class="btn btn-primary mt-3">Register</button>
</form>

<?php require "includes/footer.php"; ?>