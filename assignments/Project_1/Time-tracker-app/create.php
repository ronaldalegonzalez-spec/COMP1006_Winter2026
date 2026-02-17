<?php require("includes/header.php"); ?>

<h2 class="mb-4">Add New Task</h2>

<form action="process.php" method="POST">

    <div class="mb-3">
        <label class="form-label">Task Name</label>
        <input type="text" name="task_name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Category</label>
        <input type="text" name="category" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Priority</label>
        <select name="priority" class="form-select" required>
            <option value="">Select Priority</option>
            <option value="High">High</option>
            <option value="Medium">Medium</option>
            <option value="Low">Low</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Due Date</label>
        <input type="date" name="due_date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Time Spent (hours)</label>
        <input type="number" name="time_spent" step="0.1" min="0" class="form-control" required>
    </div>

    <button type="submit" name="add_task" class="btn btn-success">
        Save Task
    </button>

    <a href="index.php" class="btn btn-secondary">Cancel</a>

</form>

<?php require("includes/footer.php"); ?>
