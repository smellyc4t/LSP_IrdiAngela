<?php
session_start();
include 'db.php';
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
    exit;
}

$total_sales = mysqli_query($conn, "SELECT SUM(total_price) AS total_sales FROM tb_order WHERE order_status = 'Completed'");
$total_orders = mysqli_query($conn, "SELECT COUNT(order_id) AS total_orders FROM tb_order");
$total_products = mysqli_query($conn, "SELECT COUNT(product_id) AS total_products FROM tb_product");
$total_customers = mysqli_query($conn, "SELECT COUNT(customer_id) AS total_customers FROM tb_customer");

$sales = mysqli_fetch_object($total_sales);
$orders = mysqli_fetch_object($total_orders);
$products = mysqli_fetch_object($total_products);
$customers = mysqli_fetch_object($total_customers);

$stock_query = "SELECT product_name, stock FROM tb_product"; 
$stock_result = mysqli_query($conn, $stock_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>·˚ ༘🍮 dashboard | nataellashop 🌷·˚</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
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
            <h3>✦ · 📁 Dashboard ·₊̣̇⊰</h3><br>
            <div class="box">
                <h3>₍˄·͈༝·͈˄₎◞ ̑̑   🍓 Howdy, <?php echo $_SESSION['a_global']->admin_name ?> : : Welcome to Admin Dashboard! ✩‧🧁</h3><br>
                <p><a href="index.php" class="btn" target="_blank">Go To NataellaShop</a></p>
            </div>
            
            <!-- Overviews -->
            <div class="box table-container" style="text-align: center;">
                <h4>᧔ ˖ ࣪ 🗒️ ࣪ ⤹ Sales Overview 𓂃 𓈒𓏸</h4>
                <p><a href="sales-overview.php" class="btn-qriss">Open Sales Overview</a></p><br><br>
                <h4>᧔ ˖ ࣪ 🚛 ࣪ ⤹ Shipping Management 𓂃 𓈒𓏸</h4>
                <p><a href="shipping.php" class="btn-qriss">Open Shipping Management</a></p>
            
            </div>
    </div>



    <div class="section">
        <div class="container">
            <div class="box table-container">
                <h4>📊 Stock Overview</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($stock_result)) { ?>
                            <tr>
                                <td><?php echo $row['product_name']; ?></td>
                                <td><?php echo $row['stock']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- footer -->
    <footer>
        <div class="container">
            <small>₍ ᐢ. ̫ .ᐢ ₎♡ Copyright &copy; 2025 ✦ nataellashop ♡࿐</small>
        </div>
    </footer>

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
            const menuToggle = document.getElementById("menuToggle");
            const closeMenu = document.getElementById("closeMenu");
            if (!navbar.contains(event.target) && !menuToggle.contains(event.target) && !closeMenu.contains(event.target)) {
                navbar.classList.remove("active");
                menuToggle.classList.remove("active");
            }
        });
    </script>
</body>
</html>