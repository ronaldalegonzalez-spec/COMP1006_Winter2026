<?php
require "db.php";
require "includes/header.php";


$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // validation
    if (empty($email) || empty($password)) {
        $errors[] = "All fields are required.";
    }

    // reCAPTCHA
    $secretKey = "6Ldmi6gsAAAAAPHNEX6zxxmqRhNpRHlsh4G5Q4IP";
    $responseKey = $_POST['g-recaptcha-response'];
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey");
    $captcha_success = json_decode($verify);
    if (!$captcha_success->success) {
        $errors[] = "Please confirm that you are not a robot.";
    }

    // if there are no errors, proceed with login
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // login successful, set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        } 
        else {
            $errors[] = "Email or password is incorrect.";
        }
    }
}
?>
 
<h2>Login</h2>

<?php foreach ($errors as $error) {
    echo "<div class='alert alert-danger'>$error</div>";
} ?>

<form action="" method="POST">
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="g-recaptcha" data-sitekey="6Ldmi6gsAAAAACAh9H_3WlYm_YPtirjovxrv39w0"></div>

    <button type="submit" class="btn btn-primary mt-3">Login</button>
</form>

<?php require "includes/footer.php"; ?>