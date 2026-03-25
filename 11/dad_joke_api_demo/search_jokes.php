<?php
// ============================================
// Dad Joke API Demo - Search Version
// Instructor File for COMP1006
// ============================================
// This page shows how to:
// 1. collect user input from a form
// 2. send that input to an API as part of the URL
// 3. decode JSON results returned by the API
// 4. loop through multiple jokes and display them

//Store the search term
$searchTerm = "";

//this array will hold the jokes returned by the API
$jokes = [];

//create a message variable to hold error / success message
$message = "";

//only run the search after the search button is clicked
if(isset($_POST['search_jokes'])){
    //trim any white space on teh search term entered
    $searchTerm = Trim($_POST['search_term']);

    //check the the user entered a search term
    if($searchTerm !== ""){
        $url = "https://icanhazdadjoke.com/search?term=" . urlencode($searchTerm);

        //use headers to tell the API we want JSON returned
         $options = [
        "http" => [
            "method" => "GET",
            "header" => "Accept:application/json\r\n" .
            "User-Agent: COMP1006 Dad Joke Demo (http:localhost)\r\n"
        ]
    ];

    //build a stream context using the request options above
    $context = stream_context_create($options);

    //send the request
    $response = file_get_contents($url, false, $context);

    if($response !== false){
        //convert the JSOn response into a PHP associative array
        $data = json_decode($response, true);
        //store the matching jokes in $jokes
        $jokes = $data['results'];

        if(count($jokes) == 0){

            $message = "No jokes about that! Enter a new search term!"
        }
    } else{

        $message = "Sorry something is wrong with Dad jokes API"
    }
    
    } else{
        $message = "Please enter a search term!"

    }

}


















?>
 <!--
        This form sends the user's search word back to this same page.
        PHP then uses that word to build the API request URL.
  -->
    <form method="post">
        <label for="search_term">Enter a word:</label>
        <input
            type="text"
            name="search_term"
            id="search_term"
            value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit" name="search_jokes">Search</button>
    </form>

    <?php if ($message != ""): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <?php if (!empty($jokes)): ?>
        <h2>Results for "<?php echo htmlspecialchars($searchTerm); ?>"</h2>

        <ul>
            <?php foreach ($jokes as $joke): ?>
                <!--
                    Each item in the results array is itself an array.
                    The actual joke text is stored in the 'joke' field.
                -->
                <li><?php echo htmlspecialchars($joke['joke']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</body>
</html>
