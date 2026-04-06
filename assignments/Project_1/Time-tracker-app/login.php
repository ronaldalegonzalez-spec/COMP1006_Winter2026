<?php
require "db.php";
require "includes/header.php";
session_start();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validación básica
    if (empty($email) || empty($password)) {
        $errors[] = "Todos los campos son obligatorios.";
    }

    // reCAPTCHA
    $secretKey = "TU_SECRET_KEY";
    $responseKey = $_POST['g-recaptcha-response'];
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey");
    $captcha_success = json_decode($verify);
    if (!$captcha_success->success) {
        $errors[] = "Por favor confirma que no eres un robot.";
    }

    // Si no hay errores
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Login exitoso
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            $errors[] = "Email o contraseña incorrectos.";
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

    <div class="g-recaptcha" data-sitekey="TU_SITE_KEY"></div>

    <button type="submit" class="btn btn-primary mt-3">Iniciar Sesión</button>
</form>

<?php require "includes/footer.php"; ?>