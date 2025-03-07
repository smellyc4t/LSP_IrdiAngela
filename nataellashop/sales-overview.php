<?php
session_start();
include 'db.php'; 

$sales_query = "SELECT SUM(total_price) as total_sales FROM tb_order WHERE order_status IN ('Processing Your Order 🔃', 'Delivering. . .🚛📦', 'Finished')";
$sales_result = mysqli_query($conn, $sales_query);
$sales = mysqli_fetch_object($sales_result);

$orders_query = "SELECT COUNT(*) as total_orders FROM tb_order";
$orders_result = mysqli_query($conn, $orders_query);
$orders = mysqli_fetch_object($orders_result);

$purchased_products_query = "
    SELECT
        tb_order.order_id,
        tb_product.product_name,
        tb_customer.customer_name as username,
        tb_customer.customer_address as shipping_address,
        tb_customer.customer_phone as phone_number,
        tb_order.date_created,
        tb_order_detail.quantity,
        tb_order_detail.price,
        tb_order.payment_proof
    FROM tb_order
    JOIN tb_order_detail ON tb_order.order_id = tb_order_detail.order_id
    JOIN tb_product ON tb_order_detail.product_id = tb_product.product_id
    JOIN tb_customer ON tb_order.customer_id = tb_customer.customer_id
";
$purchased_products_result = mysqli_query($conn, $purchased_products_query);
$purchased_products = mysqli_fetch_all($purchased_products_result, MYSQLI_ASSOC);

// Fetch all customers
$customers_query = "SELECT customer_name FROM tb_customer";
$customers_result = mysqli_query($conn, $customers_query);
$customers = mysqli_fetch_all($customers_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>·˚ ༘📊 sales overview | nataellashop 🌷·˚</title>
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

    <!-- Content -->
    <div class="section">
        <div class="container">
                <h3>᧔ ˖ ࣪ 🗒️ ࣪ ⤹ Sales Overview 𓂃 𓈒𓏸</h3><br>
                
                <!-- Total Money Earned Table -->
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>✦ ·💰 Total Money Earned 💰· ✦</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="color:green; font-weight:bold;">Rp <?php echo number_format($sales->total_sales, 0, '.', ','); ?></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Customer List Table -->
                <br>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>── ✮ Customer List 🍒 ⋅ ˚✮</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $customer) { ?>
                        <tr>
                            <td><?php echo $customer['customer_name']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- Products Purchased Table -->
                <br>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Date & Time</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Payment Proof</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($purchased_products as $product) { ?>
                        <tr>
                            <td><?php echo $product['username']; ?></td>
                            <td><?php echo $product['phone_number']; ?></td>
                            <td><?php echo $product['shipping_address']; ?></td>
                            <td><?php echo $product['date_created']; ?></td>
                            <td><?php echo $product['product_name']; ?></td>
                            <td><?php echo $product['quantity']; ?></td>
                            <td>Rp <?php echo number_format($product['price'] * $product['quantity'], 0, '.', ','); ?></td>
                            <td>
                                <?php if ($product['payment_proof']) { ?>
                                    <button class="btn-deliver"><a href="<?php echo $product['payment_proof']; ?>" target="_blank">View</a></button>
                                <?php } else { ?>
                                    No Proof
                                <?php } ?>
                            </td>
                            <td>
                                <form method="post" action="delete_order.php" onsubmit="return confirm('( ꩜ ᯅ ꩜;)⁭ ⁭ are you sure you want to delete this ?')">
                                    <input type="hidden" name="order_id" value="<?php echo $product['order_id']; ?>">
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
        </div>
    </div>
    
    <script>
        document.getElementById("menuToggle").addEventListener("click", function () {
            const navbar = document.querySelector("header ul");
            navbar.classList.toggle("active");
            this.classList.toggle("active");
        });
        document.getElementById("closeMenu").addEventListener("click", function () {
            const navbar = document.querySelector("header ul");
            navbar.classList.remove("active");
            document.getElementById("menuToggle").classList.remove("active");
        });
        document.addEventListener("click", function (event) {
            const navbar = document.querySelector("header ul");
        });
    </script>
</body>
</html>