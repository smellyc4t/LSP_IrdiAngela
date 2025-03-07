<?php
include 'db.php';

$query = "SELECT product_name AS name, product_stock AS stock FROM tb_product";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query Error: ' . mysqli_error($conn));
}

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

header('Content-Type: application/json');
echo json_encode($products);
?>