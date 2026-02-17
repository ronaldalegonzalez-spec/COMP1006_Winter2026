<?php

// Include database connection
require "db.php";

//Update Task
if (isset($_POST['update_task'])) {

    //Update Task
    $id = $_POST['id'];
    $task_name = trim($_POST['task_name']);
    $category = trim($_POST['category']);
    $priority = trim($_POST['priority']);
    $due_date = $_POST['due_date'];
    $time_spent = $_POST['time_spent'];

    // Basic server-side validation
    if (
        empty($task_name) ||
        empty($category) ||
        empty($priority) ||
        empty($due_date) ||
        empty($time_spent)
    ) {
        die("All fields are required.");
    }

    if (!is_numeric($time_spent)) {
        die("Time spent must be a number.");
    }

    // Prepare SQL statement (security best practice)
    $stmt = $conn->prepare("UPDATE tasks SET task_name=?, category=?, priority=?, due_date=?, time_spent=? WHERE id=?");

    $stmt->bind_param("ssssdi", $task_name, $category, $priority, $due_date, $time_spent, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}



// Check if form was submitted
if (isset($_POST['add_task'])) {
// Get form values
    $task_name = trim($_POST['task_name']);
    $category = trim($_POST['category']);
    $priority = trim($_POST['priority']);
    $due_date = $_POST['due_date'];
    $time_spent = $_POST['time_spent'];

    if (
        empty($task_name) ||
        empty($category) ||
        empty($priority) ||
        empty($due_date) ||
        empty($time_spent)
    ) {
        die("All fields are required.");
    }

    if (!is_numeric($time_spent)) {
        die("Time spent must be a number.");
    }

    $stmt = $conn->prepare("INSERT INTO tasks (task_name, category, priority, due_date, time_spent) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $task_name, $category, $priority, $due_date, $time_spent);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        die("Error adding task: " . $stmt->error);
    }

    $stmt->close();
}

$conn->close();
?>
