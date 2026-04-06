<?php
require "db.php";
require "includes/header.php";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validación básica
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "Todos los campos son obligatorios.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email no válido.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Las contraseñas no coinciden.";
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
        // Revisar si username o email ya existen
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
        $stmt->execute([':username' => $username, ':email' => $email]);
        if ($stmt->fetch()) {
            $errors[] = "El usuario o email ya existe.";
        } else {
            // Guardar usuario
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashed_password
            ]);
            echo "<div class='alert alert-success'>Registro exitoso. <a href='login.php'>Inicia sesión</a></div>";
        }
    }
}
?>

<h2>Registro</h2>

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

    <div class="g-recaptcha" data-sitekey="TU_SITE_KEY"></div>

    <button type="submit" class="btn btn-primary mt-3">Registrarse</button>
</form>

<?php require "includes/footer.php"; ?>