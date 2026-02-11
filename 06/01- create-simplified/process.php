<?php
require "includes/header.php";
require "includes/connect.php";
//STEP ONE access the form data and then echo on the screen in a confirmation message 
//grab the data, clean and store in a variable - santize! 
$firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
$lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phone     = filter_input(
    INPUT_POST,
    'phone',
    FILTER_SANITIZE_SPECIAL_CHARS
);
$comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_SPECIAL_CHARS);
$items = $_POST['items'] ?? [];

//STEP TWO - validation time - serverside 

$errors = [];

//require text fields 
if ($firstName === null || $firstName === '') {
    $errors[] = "First Name is Required.";
}

if ($lastName === null || $lastName === '') {
    $errors[] = "Last Name is Required.";
}

//require email and validate proper format 
if ($email === null || $email === '') {
    $errors[] = "Email is Required";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email must be a valid email";
}

// require phone number and validate proper format 
if ($phone === null || $phone === '') {
    $errors[] = "Phone number is required.";
} elseif (!filter_var($phone, FILTER_VALIDATE_REGEXP, [
    'options' => ['regexp' => '/^[0-9\-\+\(\)\s]{7,25}$/']
])) {
    $errors[] = "Phone number format is invalid.";
}

//require address
if ($address === null || $address === '') {
    $errors[] = "Address is required.";
}

//loop through error messages 
//if there are errors, display to user and exit the script 
if (!empty($errors)) {
    foreach ($errors as $error) : ?>
        <li><?php echo $error; ?> </li>
<?php endforeach;
    //stop the script from executing  
    exit;
}

/* INSERT THE ORDER USING A PREPARED STATEMENT*/

//set up the query used named placeholders

//prepare the query 


//bind parameters


//execute the query, matching the placeholder with the data entered by user


//close connection 

?>

<main>
    <!-- echo the data the user submitted -->
    <?php echo "<h2> Thanks for your order " . $firstName . "</h2>"; ?>
</main>

<?php require "includes/footer.php"; ?>