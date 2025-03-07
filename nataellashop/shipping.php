<?php
session_start();
include 'db.php';

if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = 'Delivering. . .🚛📦';
    mysqli_query($conn, "UPDATE tb_order SET order_status = '$new_status' WHERE order_id = '$order_id'");
}

$orders = mysqli_query($conn, "SELECT tb_order.*, tb_customer.customer_name AS user_name, tb_customer.customer_address AS shipping_address, tb_customer.customer_phone AS phone_number FROM tb_order JOIN tb_customer ON tb_order.customer_id = tb_customer.customer_id WHERE tb_order.order_status = 'Processing Your Order 🔃'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>·˚ ༘🚛 shipping | nataellashop 🌷·˚</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <!-- header -->
    <header>
        <div class="container">
            <h1><a href="dashboard.php">nataellashop</a></h1>
            <div class="menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul id="navbar">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="data-kategori.php">Data Category</a></li>
                <li><a href="data-produk.php">Data Product</a></li>
                <li><a href="keluar.php">Logout</a></li>
            </ul>
        </div>
    </header>
    <div class="section">
        <div class="container">
            <h3>᧔ ˖ ࣪ 🚛 ࣪ ⤹ Shipping Management 𓂃 𓈒𓏸</h3><br>
                <table class="shipping-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User Name</th>
                            <th>Phone Number</th>
                            <th>Product Details</th>
                            <th>Total Price</th>
                            <th>Date & Time</th>
                            <th>Shipping Method</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = mysqli_fetch_object($orders)) { ?>
                        <tr>
                            <td><?php echo $order->order_id; ?></td>
                            <td><?php echo $order->user_name; ?></td>
                            <td><?php echo $order->phone_number; ?></td>
                            <td>
                                <ol class="no-numbers">
                                    <?php
                                    $order_details_query = "SELECT tb_order_detail.*, tb_product.product_name FROM tb_order_detail JOIN tb_product ON tb_order_detail.product_id = tb_product.product_id WHERE tb_order_detail.order_id = '$order->order_id'";
                                    $order_details_result = mysqli_query($conn, $order_details_query);
                                    while ($detail = mysqli_fetch_object($order_details_result)) { ?>
                                        <li><?php echo $detail->product_name; ?> x <?php echo $detail->quantity; ?></li>
                                    <?php } ?>
                                </ol>
                            </td>
                            <td>Rp <?php echo number_format($order->total_price, 0, '.', ','); ?></td>
                            <td><?php echo $order->date_created; ?></td>
                            <td><?php echo $order->shipping_method; ?></td>
                            <td><?php echo $order->shipping_address; ?></td>
                            <td>
                                <form method="post" action="shipping.php">
                                    <input type="hidden" name="order_id" value="<?php echo $order->order_id; ?>">
                                    <button type="submit" name="update_status" class="btn-deliver">Deliver 🚛✅</button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
        </div>
    </div>
</body>
</html>