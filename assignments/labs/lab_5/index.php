<?php
// require "includes/connect.php";
require "includes/header.php";
?>

<div class="container mt-5">
    <h2>Upload Profile Picture</h2>

    <form action="upload.php" method="POST" enctype="multipart/form-data">
        
        <div class="mb-3">
            <input class="form-control" type="file" name="product_image" required>
        </div>

        <button class="btn btn-primary" type="submit">Upload</button>

    </form>
</div>

</body>
</html>