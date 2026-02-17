<?php
require("db.php");
require("includes/header.php");

// Check if ID exists
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Fetch task data
$stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "Task not found.";
    exit();
}

$task = $result->fetch_assoc();
$stmt->close();
?>

<h2 class="mb-4">Edit Task</h2>

<form action="process.php" method="POST">
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

    <button type="submit" name="update_task" class="btn btn-success">Update Task</button>
    <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>

<?php require("includes/footer.php"); ?>
