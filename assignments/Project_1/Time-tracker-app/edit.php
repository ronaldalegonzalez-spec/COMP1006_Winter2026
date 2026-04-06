<?php
//Edit.php
//Loads selected task data
//Displays form pre-filled with existing values
//Sends updated data to process.php
require("auth.php");

require("db.php");
require("includes/header.php");

//Check if ID exists
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

//Fetch task data securely using prepared statement
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id AND user_id = :user_id");
$stmt->execute([':id' => $id, ':user_id' => $user_id]);

$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    echo "Task not found.";
    exit();
}
?>

<h2 class="mb-4">Edit Task</h2>

<form action="process.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $task['id']; ?>">

    <div class="mb-3">
        <label class="form-label">Task Name</label>
        <input type="text" name="task_name" class="form-control" value="<?php echo htmlspecialchars($task['task_name']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Category</label>
        <input type="text" name="category" class="form-control" value="<?php echo htmlspecialchars($task['category']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Priority</label>
        <select name="priority" class="form-select" required>
            <option value="">Select Priority</option>
            <option value="High" <?php if($task['priority']=="High") echo "selected"; ?>>High</option>
            <option value="Medium" <?php if($task['priority']=="Medium") echo "selected"; ?>>Medium</option>
            <option value="Low" <?php if($task['priority']=="Low") echo "selected"; ?>>Low</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Due Date</label>
        <input type="date" name="due_date" class="form-control" value="<?php echo $task['due_date']; ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Time Spent (hours)</label>
        <input type="number" name="time_spent" step="0.1" min="0" class="form-control" value="<?php echo $task['time_spent']; ?>" required>
    </div>

    <div class="mb-3">
    <label class="form-label">Update Image</label>
    <input type="file" name="task_image" class="form-control">
    </div>

    <?php if (!empty($task['image_path'])): ?>
    <div class="mb-3">
        <label>Current Image:</label><br>
        <img src="<?php echo htmlspecialchars($task['image_path']); ?>" width="100">
    </div>
    
<?php endif; ?>

    <button type="submit" name="update_task" class="btn btn-success">Update Task</button>
    <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>

<?php require("includes/footer.php"); ?>
