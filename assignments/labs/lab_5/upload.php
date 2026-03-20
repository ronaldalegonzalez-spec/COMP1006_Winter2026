<?php
// require "includes/connect.php";
require "includes/header.php";

$errors = [];
$imagePath = null;

// verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // verificar si se subió un archivo
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] !== UPLOAD_ERR_NO_FILE) {

        // verificar si hubo error
        if ($_FILES['product_image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "There was a problem uploading the image!";
        } else {

            // tipos permitidos (como en clase)
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $detectedType = mime_content_type($_FILES['product_image']['tmp_name']);

            if (!in_array($detectedType, $allowedTypes)) {
                $errors[] = "Only JPG, PNG, and WEBP images are allowed.";
            } else {

                // crear nombre único
                $extension = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
                $safeFilename = uniqid() . '.' . strtolower($extension);

                // ruta destino
                $destination = __DIR__ . '/uploads/' . $safeFilename;

                // mover archivo
                if (move_uploaded_file($_FILES['product_image']['tmp_name'], $destination)) {
                    $imagePath = 'uploads/' . $safeFilename;
                } else {
                    $errors[] = "Image upload failed.";
                }
            }
        }
    } else {
        $errors[] = "Please select an image.";
    }
}
?>

<h2>Upload Result</h2>

<?php
// mostrar errores
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red;'>$error</p>";
    }
}

// mostrar imagen
if ($imagePath) {
    echo "<p style='color:green;'>Image uploaded successfully!</p>";
    echo "<img src='$imagePath' width='200'>";
}
?>

<br>
<a href="index.php">Upload another image</a>

</body>
</html>