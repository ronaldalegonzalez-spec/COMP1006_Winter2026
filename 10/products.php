<?php
//challenge students to create independently initially */ 
require "includes/connect.php";
require "includes/header.php";

// Get all products, newest first
//set up the query
$sql = "SELECT * FROM products ORDER BY created_at DESC";
//prepare the query
$stmt - $pdo->prepare($sql);
//execute
$stmt->execute();
//use fetchAll to retun result
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container mt-4">
    <h1 class="mb-4">Our Products</h1>
    <?php if (empty($products)): ?>
        <p>No products available yet.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($product['image_path'])): ?>
                            <img
                                src="<?= htmlspecialchars($product['image_path']); ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars($product['name']); ?>"
                            >
                        <?php endif; ?>

                        <div class="card-body">
                            <h2 class="h5 card-title">
                                <?= htmlspecialchars($product['name']); ?>
                            </h2>

                            <p class="card-text">
                                <?= nl2br(htmlspecialchars($product['description'])); ?>
                            </p>

                            <p class="fw-bold">
                                $<?= number_format((float)$product['price'], 2); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</main>

<?php require "includes/footer.php"; ?>