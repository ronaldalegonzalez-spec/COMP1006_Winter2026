<?php
/**
 * delete.php
 * ------------------------------------------------------------
 * Deletes one order from the orders1 table.
 * - Gets the customer_id from the URL (delete.php?id=5)
 * - Uses PDO + bindParam for safety
 * - Redirects back to orders.php
 */
require 'includes/connect.php';

// make sure we received an ID
$customerId = $_GET['id'];

// create the query 
$sql = "DELETE FROM orders WHERE customer_id = :customer_id";
//prepare 
$stmt = $pdo->prepare($sql);
//bind
$stmt->bindParam(':customer_id', $customerId); 
//execute 
$stmt->execute();
// Redirect back to admin list
header("Location: orders.php");
exit;
