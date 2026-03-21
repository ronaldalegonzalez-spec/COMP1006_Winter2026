<?php
// require "includes/connect.php";
require "includes/header.php";

$errors = [];
$imagePath = null;

// check if the form was sent
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check if a file was uploaded
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] !== UPLOAD_ERR_NO_FILE) {

        // check if there was an error
        if ($_FILES['product_image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "There was a problem uploading the image!";
        } 
        else {

            // allowed types (as in class)
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $detectedType = mime_content_type($_FILES['product_image']['tmp_name']);

            if (!in_array($detectedType, $allowedTypes)) {
                $errors[] = "Only JPG, PNG, and WEBP images are allowed.";
            } 
            else {

                // create unique name
                $extension = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
                $safeFilename = uniqid() . '.' . strtolower($extension);

                // destination route
                $destination = __DIR__ . '/uploads/' . $safeFilename;

                // move file
                if (move_uploaded_file($_FILES['product_image']['tmp_name'], $destination)) {
                    $imagePath = 'uploads/' . $safeFilename;
                } else {
                    $errors[] = "Image upload failed.";
                }
            }
        }
    } 
    else {
        $errors[] = "Please select an image.";
    }
}
?>

<h2>Upload Result</h2>

<?php
//show erroers
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red;'>$error</p>";
    }
}

// Show picture
if ($imagePath) {
    echo "<p style='color:green;'>Image uploaded successfully!</p>";
    echo "<img src='$imagePath' width='200'>";
}
?>

<br>
<a href="index.php">Upload another image</a>

</body>
</html>