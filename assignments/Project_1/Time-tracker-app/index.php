<?php
//Displays all tasks ordered by newest first
//shows tasks in a table with edit and delete options
//Priority is displayed using colored Bootstrap badges
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
require("auth.php");

require("db.php");
require("includes/header.php");

$user_id = $_SESSION['user_id'];

//Fetch all tasks from database ordered by creation date
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = :user_id ORDER BY created_at DESC");
$stmt->execute([':user_id' => $user_id]);

$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="mb-3">
    <a href="create.php" class="btn btn-primary">Add New Task</a>
</div>

<?php if (count($tasks) > 0): ?>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Task</th>
            <th>Category</th>
            <th>Priority</th>
            <th>Due Date</th>
            <th>Time Spent</th>
            <th>Actions</th>
            <th>Image</th>
        </tr>
    </thead>
    <tbody>

    
    <?php foreach ($tasks as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['task_name']); ?></td>
            <td><?php echo htmlspecialchars($row['category']); ?></td>
           <!-- Display priority as colored badge -->
           <td><?php $priority = $row['priority'];

            if ($priority == "High") {
                 echo "<span class='badge bg-danger'>High</span>";
             } 
             elseif ($priority == "Medium") {
                 echo "<span class='badge bg-warning text-dark'>Medium</span>";
            } 
            else {
                 echo "<span class='badge bg-success'>Low</span>";
            }
            ?></td>
            <td><?php echo $row['due_date']; ?></td>
            <td><?php echo $row['time_spent']; ?> hrs</td>
            <td>
                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
            <!-- Display image thumbnail if exists -->
            <td>
            <?php if (!empty($row['image_path'])): ?>

                <img src="<?php echo htmlspecialchars($row['image_path']); ?>" width="80">

            <?php else: ?> No image <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>

    </tbody>
</table>

<?php else: ?>

<div class="alert alert-info"> No tasks found. Add your first task!</div>

<?php endif; ?>

<?php require("includes/footer.php"); ?>
