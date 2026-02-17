<?php
require("db.php");
require("includes/header.php");

// Fetch all tasks
$result = $conn->query("SELECT * FROM tasks ORDER BY created_at DESC");
?>

<div class="mb-3">
    <a href="create.php" class="btn btn-primary">Add New Task</a>
</div>

<?php if ($result->num_rows > 0): ?>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Task</th>
            <th>Category</th>
            <th>Priority</th>
            <th>Due Date</th>
            <th>Time Spent</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['task_name']); ?></td>
            <td><?php echo htmlspecialchars($row['category']); ?></td>
            <td><?php echo htmlspecialchars($row['priority']); ?></td>
            <td><?php echo $row['due_date']; ?></td>
            <td><?php echo $row['time_spent']; ?> hrs</td>
            <td>
                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>

    </tbody>
</table>

<?php else: ?>

<div class="alert alert-info">
    No tasks found. Add your first task!
</div>

<?php endif; ?>

<?php require("includes/footer.php"); ?>
