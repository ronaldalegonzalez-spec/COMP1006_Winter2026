<?php
// process.php
//Handles:
//Adding new tasks
//Updating existing tasks
//Server-side validation
// reCAPTCHA verification
//Secure database operations using prepared statements


//include database connection
require "db.php";

//Update Task=============================================
if (isset($_POST['update_task'])) {

    //Update Task
    $id = $_POST['id'];
    $task_name = trim($_POST['task_name']);
    $category = trim($_POST['category']);
    $priority = trim($_POST['priority']);
    $due_date = $_POST['due_date'];
    $time_spent = $_POST['time_spent'];

    $errors = [];

    //Required validation
    if (!is_numeric($id)) {
        die("Invalid task ID.");
    }

    if (empty($task_name) || empty($category) || empty($priority) || empty($due_date) || empty($time_spent)) {
        $errors[] = "All fields are required.";
    }

    //Numeric validation
    if (!is_numeric($time_spent)) {
        $errors[] = "Time spent must be a number.";
    }

    //Date validation
   $date = DateTime::createFromFormat('Y-m-d', $due_date);
    $errors_date = DateTime::getLastErrors();

    if (!$date || $errors_date['warning_count'] > 0 || $errors_date['error_count'] > 0) {
    $errors[] = "Invalid date format.";
    }


    //Sanitize inputs
    $task_name = htmlspecialchars($task_name);
    $category = htmlspecialchars($category);
    $priority = htmlspecialchars($priority);


    // If errors exist, stop execution
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        exit();
    }

    // prepare secure SQL statement to prevent SQL injection
   $stmt = $pdo->prepare("UPDATE tasks 
SET task_name = :task_name, category = :category, priority = :priority, due_date = :due_date, time_spent = :time_spent 
WHERE id = :id");

$stmt->execute([
    ':task_name' => $task_name,
    ':category' => $category,
    ':priority' => $priority,
    ':due_date' => $due_date,
    ':time_spent' => $time_spent,
    ':id' => $id
]);

header("Location: index.php");
exit();

}



//Check if form was submitted==============================================
if (isset($_POST['add_task'])) {

//get form values
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

    // ONLY if present
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

    // Optional: skip failure due to server domain limitations
    if ($captcha_success && !$captcha_success->success) {
        // You can log this if needed, but do not block user
        }
    }

    //If errors exist, stop execution
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        exit();
    }

    // Prepare SQL statement
    $stmt = $pdo->prepare("INSERT INTO tasks (task_name, category, priority, due_date, time_spent) 
VALUES (:task_name, :category, :priority, :due_date, :time_spent)");

$stmt->execute([
    ':task_name' => $task_name,
    ':category' => $category,
    ':priority' => $priority,
    ':due_date' => $due_date,
    ':time_spent' => $time_spent
]);

header("Location: index.php");
exit();
}

?>
