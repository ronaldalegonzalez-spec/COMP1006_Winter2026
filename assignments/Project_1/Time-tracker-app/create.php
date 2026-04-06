<?php
require("auth.php");
require("includes/header.php"); ?>

<!-- Displays form to create a new task -->
<!-- Includes client-side validation and Google reCAPTCHA -->

<h2 class="mb-4">Add New Task</h2>

<form action="process.php" method="POST">

    <div class="mb-3">
        <label class="form-label">Task Name</label>
        <input type="text" name="task_name" class="form-control" required
        pattern="[A-Za-z0-9\s]{3,50}" 
        title="Only letters and numbers, 3-50 characters">
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
        <input type="number" name="time_spent" step="0.1" min="0"  max="1000" class="form-control"  required>
        
    </div>

<!-- Google reCAPTCHA widget -->
    <div class="g-recaptcha" data-sitekey="6Ldmi6gsAAAAACAh9H_3WlYm_YPtirjovxrv39w0"></div>

    <!-- Submit button -->
    <button type="submit" name="add_task" class="btn btn-success">
        Save Task
    </button>
   <!-- Cancel button -->
    <a href="index.php" class="btn btn-secondary">Cancel</a>

</form>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php require("includes/footer.php"); ?>
