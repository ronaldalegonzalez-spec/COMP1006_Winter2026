CREATE TABLE tasks (
id INT AUTO_INCREMENT PRIMARY KEY, -- unique task identifier --> 
task_name VARCHAR(100), -- task name -->
category VARCHAR(50),  -- task category -->
priority VARCHAR(20), -- priority level (High, Medium, Low) -- >
due_date DATE, deadline for completing the task -- deadline for completing the task -->
time_spent DECIMAL(10,2) -- time spent in hours
created_at (TIMESTAMP) -- date and time the task was automatically created -->
);