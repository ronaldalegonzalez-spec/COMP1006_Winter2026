<?php
require "connect.php";

//Make sure is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Wrong request method");
}

//Sanitize input
$title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS));
$author = trim(filter_input(INPUT_POST, 'author', FILTER_SANITIZE_SPECIAL_CHARS));
$rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_INT);
$review_text = trim(filter_input(INPUT_POST, 'review_text', FILTER_SANITIZE_SPECIAL_CHARS));

//array of errors
$errors = [];

//title required
if ($title == null || $title == "") {
    $errors[] = "Title is required";
}

//Author required
if ($author == null || $author == "") {
    $errors[] = "Author is required";
}

//rating required and must be between 1 and 5
if ($rating == null || $rating == "") {
    $errors[] = "Rating is required";
}
elseif (!is_numeric($rating) || $rating < 1 || $rating > 5) {
    $errors[] = "Rating must be between 1 and 5";
}

//review text required
if ($review_text == null || $review_text == "") {
    $errors[] = "Review can not be empty";
}

//if there is errors show them
if (!empty($errors)) {
    echo "<h2>Please fix this:</h2>";
    echo "<ul>";

    foreach ($errors as $e) {
        echo "<li>" . htmlspecialchars($e) . "</li>";
    }

    echo "</ul>";
    echo "<a href='index.php'>Go Back</a>";

    exit();
}

//insert to database
try {
    $sql = "INSERT INTO reviews (title, author, rating, review_text)
            VALUES (:title, :author, :rating, :review_text)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":author", $author);
    $stmt->bindParam(":rating", $rating);
    $stmt->bindParam(":review_text", $review_text);

    $stmt->execute();

    echo "<h2>Review added succesfully!</h2>";
    echo "<a href='admin.php'>Go to Admin Page</a>";
} 

catch (PDOException $e) {
    echo "Something went wrong... maybe DB issue.";
}