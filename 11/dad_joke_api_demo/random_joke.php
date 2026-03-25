<?php
// ============================================
// Dad Joke API Demo - Random Joke Version
// Instructor File for COMP1006
// ============================================
// This page shows how to:
// 1. send a request to an external API
// 2. ask for JSON data using request headers
// 3. convert JSON into a PHP array
// 4. display the returned joke on the page
$joke = "";

if(isset($_POST['get_joke'])){

    //use headers to tell the API we want JSON returned
    $options = [
        "http" => [
            "method" => "GET",
            "header" => "Accept:application/json\r\n" .
            "User-Agent: COMP1006 Dad Joke Demo (http:localhost)\r\n"
        ]
    ];

    //convert the options array into a stream context
    //file_get_contents can use this context when making a request
    $context = stream_context_create($option);

    //send the request to the random joke endpoint
    $response = file_get_contents('https://icanhazdadjoke.com/', false, $context);


    if($response !== false){
        // var_dump($response); //check what is returned

        //convert the JSON response into PHP associative array
        $data = json_decode($response, true);

        //the joke text is stored in the joke field of the response
        $joke = $data['joke'];

    }else{
        $joke = "Sorry, not Dad jokes today :(";
    }











}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dad Joke Generator</title>
</head>
<body>

    <h1>Dad Joke Generator</h1>
    <p>Click the button to load a random dad joke from an API.</p>

    <!--
        This form submits back to the same page.
        When the button is clicked, PHP sends a request to the API.
    -->
    <form method="post">
        <button type="submit" name="get_joke">Get a Joke</button>
    </form>

    <?php if ($joke != ""): ?>
        <!-- htmlspecialchars() protects the page by escaping special characters. -->
        <p><strong>Joke:</strong> <?php echo htmlspecialchars($joke); ?></p>
    <?php endif; ?>

</body>
</html>
