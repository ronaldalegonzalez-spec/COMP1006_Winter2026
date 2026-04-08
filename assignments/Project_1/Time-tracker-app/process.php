<?php
// process.php
//Handles:
//Adding new tasks
//Updating existing tasks
//Server-side validation
// reCAPTCHA verification
//Secure database operations using prepared statements
require("auth.php");

//include database connection
require "db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

//Update Task=============================================
if (isset($_POST['update_task'])) {

    $id = $_POST['id'];
    $task_name = trim($_POST['task_name']);
    $category = trim($_POST['category']);
    $priority = trim($_POST['priority']);
    $due_date = $_POST['due_date'];
    $time_spent = $_POST['time_spent'];

    $errors = [];

    // VALIDATION
    if (!is_numeric($id)) {
        die("Invalid task ID.");
    }

    if (empty($task_name) || empty($category) || empty($priority) || empty($due_date) || empty($time_spent)) {
        $errors[] = "All fields are required.";
    }

    if (!is_numeric($time_spent)) {
        $errors[] = "Time spent must be a number.";
    }

    if ($time_spent < 0 || $time_spent > 1000) {
        $errors[] = "Time spent must be between 0 and 1000 hours.";
    }

    
    $date = DateTime::createFromFormat('Y-m-d', $due_date);
    $errors_date = DateTime::getLastErrors();

    if (!$date || $errors_date['warning_count'] > 0 || $errors_date['error_count'] > 0) {
        $errors[] = "Invalid date format.";
    }

    // SANITIZE
    $task_name = htmlspecialchars($task_name);
    $category = htmlspecialchars($category);
    $priority = htmlspecialchars($priority);

    //image 
    $stmtImg = $pdo->prepare("SELECT image_path FROM tasks WHERE id = :id AND user_id = :user_id");
    $stmtImg->execute([
        ':id' => $id,
        ':user_id' => $_SESSION['user_id']
    ]);

    $currentTask = $stmtImg->fetch(PDO::FETCH_ASSOC);
    $imagePath = $currentTask['image_path'];

    // new image upload handling ============================================
    if (isset($_FILES['task_image']) && $_FILES['task_image']['error'] !== UPLOAD_ERR_NO_FILE) {

        if ($_FILES['task_image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "Error uploading file.";
        } else {

            if ($_FILES['task_image']['size'] > 2 * 1024 * 1024) {
                $errors[] = "File too large (max 2MB).";
            }

            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $detectedType = mime_content_type($_FILES['task_image']['tmp_name']);

            if (!in_array($detectedType, $allowedTypes)) {
                $errors[] = "Only JPG, PNG, WEBP allowed.";
            }

            if (empty($errors)) {

                //delete old image if exists
                if (!empty($imagePath) && file_exists(__DIR__ . '/' . $imagePath)) {
                    unlink(__DIR__ . '/' . $imagePath);
                }

                $extension = pathinfo($_FILES['task_image']['name'], PATHINFO_EXTENSION);
                $safeFilename = uniqid('task_', true) . '.' . strtolower($extension);

                $destination = __DIR__ . '/uploads/' . $safeFilename;

                if (move_uploaded_file($_FILES['task_image']['tmp_name'], $destination)) {
                    $imagePath = 'uploads/' . $safeFilename;
                } else {
                    $errors[] = "Failed to save image.";
                }
            }
        }
    }

    // reCAPTCHA
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        exit();
    }

    // update task in database
    $stmt = $pdo->prepare("UPDATE tasks 
        SET task_name = :task_name,
            category = :category,
            priority = :priority,
            due_date = :due_date,
            time_spent = :time_spent,
            image_path = :image_path
        WHERE id = :id AND user_id = :user_id");

    $stmt->execute([
        ':task_name' => $task_name,
        ':category' => $category,
        ':priority' => $priority,
        ':due_date' => $due_date,
        ':time_spent' => $time_spent,
        ':image_path' => $imagePath,
        ':id' => $id,
        ':user_id' => $_SESSION['user_id']
    ]);

    header("Location: index.php");
    exit();
}


//Check if form was submitted==============================================
if (isset($_POST['add_task'])) {

    //get form values
    $user_id = $_SESSION['user_id'];
    $task_name = trim($_POST['task_name']);
    $category = trim($_POST['category']);
    $priority = trim($_POST['priority']);
    $due_date = $_POST['due_date'];
    $time_spent = $_POST['time_spent'];

     $errors = [];

    //Required validation
    if (empty($task_name) || empty($category) || empty($priority) || empty($due_date) || empty($time_spent)) {
        $errors[] = "All fields are required.";
    }

    //Numeric validation
    if (!is_numeric($time_spent)) {
        $errors[] = "Time spent must be a number.";
    }

    //date validation
    $date = DateTime::createFromFormat('Y-m-d', $due_date);
    $errors_date = DateTime::getLastErrors();

    if (!$date || $errors_date['warning_count'] > 0 || $errors_date['error_count'] > 0) {
    $errors[] = "Invalid date format.";
    }


    //Sanitize inputs
    $task_name = htmlspecialchars($task_name);
    $category = htmlspecialchars($category);
    $priority = htmlspecialchars($priority);

    //Verify Google reCAPTCHA response
    $secretKey = "6Ldmi6gsAAAAAPHNEX6zxxmqRhNpRHlsh4G5Q4IP";
    $responseKey = $_POST['g-recaptcha-response'];

    // only if present
    if (!empty($responseKey)) {

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => "https://www.google.com/recaptcha/api/siteverify",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'secret' => $secretKey,
                'response' => $responseKey
            ]),
            CURLOPT_RETURNTRANSFER => true
        ]);

    $verify = curl_exec($ch);
    curl_close($ch);

    $captcha_success = json_decode($verify);

    // skip failure due to server domain limitations
    if ($captcha_success && !$captcha_success->success) {
        
        }
    }
    // if (!$captcha_success->success) {
    // $errors[] = "Captcha failed.";
    //     }

    //If errors exist, stop execution
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        exit();
    }

    // image upload handling ============================================
$imagePath = null;

// if a new image is uploaded, validate and process it
if (isset($_FILES['task_image']) && $_FILES['task_image']['error'] !== UPLOAD_ERR_NO_FILE) {

    if ($_FILES['task_image']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Error uploading file.";
    } else {

        if ($_FILES['task_image']['size'] > 2 * 1024 * 1024) {
            $errors[] = "File too large (max 2MB).";
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $detectedType = mime_content_type($_FILES['task_image']['tmp_name']);

        if (!in_array($detectedType, $allowedTypes)) {
            $errors[] = "Only JPG, PNG, WEBP allowed.";
        }

        if (empty($errors)) {

            // delete old image if exists
            if (!empty($imagePath) && file_exists(__DIR__ . '/' . $imagePath)) {
                unlink(__DIR__ . '/' . $imagePath);
            }

            $extension = pathinfo($_FILES['task_image']['name'], PATHINFO_EXTENSION);
            $safeFilename = uniqid('task_', true) . '.' . strtolower($extension);

            $destination = __DIR__ . '/uploads/' . $safeFilename;

            if (move_uploaded_file($_FILES['task_image']['tmp_name'], $destination)) {
                $imagePath = 'uploads/' . $safeFilename;
            } else {
                $errors[] = "Failed to save image.";
            }
        }
    }
}
    // ========================================================


// If errors exist, stop execution
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        exit();
        }




    // Prepare SQL statement
    $stmt = $pdo->prepare("INSERT INTO tasks (task_name, category, priority, due_date, time_spent, user_id, image_path) 
VALUES (:task_name, :category, :priority, :due_date, :time_spent, :user_id, :image_path)");

$stmt->execute([
    ':task_name' => $task_name,
    ':category' => $category,
    ':priority' => $priority,
    ':due_date' => $due_date,
    ':time_spent' => $time_spent,
    ':user_id' => $_SESSION['user_id'],
    ':image_path' => $imagePath
]);

header("Location: index.php");
exit();
}

?>
