<?php
/* What's the Problem? 
    - PHP logic + HTML in one file
    - Works, but not scalable
    - Repetition will become a problem

    How can we refactor this code so it’s easier to maintain?
*/

$items = ["Home", "About", "Contact"];
//added year variable to make footer dynamic
$year = date("Y");

//function to render menu items
function renderMenu($items) {
    foreach ($items as $item) {
        echo "<li>$item</li>";
    }
}
//function to render footer
function renderFooter($year) {
    echo "<footer><p>&copy; $year</p></footer>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My PHP Page</title>
</head>
<body>

<h1>Welcome</h1>

<ul> <!-- renderMenu function called here -->
    <?php renderMenu($items); ?>
</ul>
<!-- renderFooter function called here -->
<?php renderFooter($year); ?>

</body>
</html>

<!-- What I learned:

I learned from this lab how to use functions and separating logic to make the code easier to maintain and learn the logic for future projects-->