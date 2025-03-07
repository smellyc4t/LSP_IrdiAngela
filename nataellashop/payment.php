<?php
session_start();
include 'db.php';
$total_price = isset($_GET['total_price']) ? $_GET['total_price'] : 0;
$kontak = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin WHERE admin_id = 1");
$a = mysqli_fetch_object($kontak);

$total_sales = mysqli_query($conn, "SELECT SUM(total_price) AS total_sales FROM tb_order WHERE order_status = 'Completed'");
$total_orders = mysqli_query($conn, "SELECT COUNT(order_id) AS total_orders FROM tb_order WHERE order_status = 'Completed'");

$sales = mysqli_fetch_object($total_sales);
$orders = mysqli_fetch_object($total_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>·˚ ༘💸 payment | nataellashop 🌷·˚</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <!-- header -->
    <header>
    <div class="container">
        <h1><a href="index.php">nataellashop</a></h1>
        <div class="menu-toggle" id="menuToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul id="navbar">
            <li><a href="index.php">Home</a></li>
            <li><a href="produk.php">Product</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="order.php">Order</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </div>
    </header>

    <div class="section">
        <div class="container">
            <h3>✦ · 💸 Payment 💸·₊̣̇⊰</h3>
            <div class="box">
                <p style="text-align:center;"><strong>‧₊ ᵎᵎ 🍒 ⋅ ˚✮ Thank you for your purchase! Please proceed with the payment 🍒 •ᴗ• . . .</strong></p>
                <br>
                <p style="color:#ff5ebf; font-size:18px;text-align:center;"><strong>Total Price: Rp <?php echo number_format($total_price, 0, '.', ','); ?></strong></p>
                
                <!-- Payment Method -->
                <div class="payment-method"><br>
                    <button onclick="toggleQriss()" class="btn-payment">Pay with QRIS</button>
                    <div id="qriss" style="display:none;">
                        <img src="img/qriss.jpg" alt="QRIS Payment" class="qriss-image"><br><br>
                        <form action="order.php" method="POST" enctype="multipart/form-data">
                            <label for="payment_proof">Upload Payment Proof:</label>
                            <input type="file" name="payment_proof" id="payment_proof" accept="image/jpeg, image/jpg, image/png" required>
                            <br><br>
                            <label for="shipping">Choose Shipping Method:</label>
                            <select name="shipping" id="shipping" required>
                                <option value="JNE">JNE</option>
                                <option value="Grab Exp">Grab Exp</option>
                                <option value="Gosend">Gosend</option>
                            </select>
                            <br><br>
                            <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                            <input type="submit" value="Submit" class="btn">
                        </form>
                    </div>
                </div>
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
        function toggleQriss() {
            var qriss = document.getElementById('qriss');
            if (qriss.style.display === 'none' || qriss.style.display === '') {
                qriss.style.display = 'block';
            } else {
                qriss.style.display = 'none';
            }
        }

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