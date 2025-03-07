<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];

    $order_query = "SELECT total_price FROM tb_order WHERE order_id = '$order_id'";
    $order_result = mysqli_query($conn, $order_query);
    $order = mysqli_fetch_object($order_result);
    $total_price = $order->total_price;

    $delete_order_details_query = "DELETE FROM tb_order_detail WHERE order_id = '$order_id'";
    mysqli_query($conn, $delete_order_details_query);

    $delete_order_query = "DELETE FROM tb_order WHERE order_id = '$order_id'";
    mysqli_query($conn, $delete_order_query);

    $update_sales_query = "UPDATE tb_order SET total_price = total_price - '$total_price' WHERE order_status IN ('Processing Your Order 🔃', 'Delivering. . .🚛📦', 'Finished')";
    mysqli_query($conn, $update_sales_query);

    echo '<script>alert("(๛ ˘ ³˘ )♡ successfully deleted the order data !"); window.location="sales-overview.php";</script>';
}
?>