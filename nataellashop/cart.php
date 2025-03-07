<?php
session_start();
include 'db.php';
$kontak = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin WHERE admin_id = 1");
$a = mysqli_fetch_object($kontak);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['action'])) {
    $product_id = isset($_GET['id']) ? $_GET['id'] : null;
    switch ($_GET['action']) {
        case 'add':
            if ($product_id && !isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] = 1;
            } elseif ($product_id) {
                $_SESSION['cart'][$product_id]++;
            }
            break;
        case 'remove':
            if ($product_id && isset($_SESSION['cart'][$product_id])) {
                unset($_SESSION['cart'][$product_id]);
            }
            break;
        case 'increase':
            if ($product_id && isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]++;
            }
            break;
        case 'decrease':
            if ($product_id && isset($_SESSION['cart'][$product_id]) && $_SESSION['cart'][$product_id] > 1) {
                $_SESSION['cart'][$product_id]--;
            }
            break;
        case 'checkout':
            header('Location: payment.php?total_price=' . array_sum(array_map(function($id) use ($conn) {
                $product = mysqli_query($conn, "SELECT product_price FROM tb_product WHERE product_id = $id");
                $product_data = mysqli_fetch_object($product);
                return $product_data->product_price * $_SESSION['cart'][$id];
            }, array_keys($_SESSION['cart']))));
            exit;
    }
    header('Location: cart.php');
    exit;
}

$cart_items = [];
$total_price = 0;
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $cart_items = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id IN ($ids)");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>·˚ ༘🛒 cart | nataellashop 🌷·˚</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
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
            <h3>✦ · 🛒 <?php echo isset($_SESSION['customer_name']) ? $_SESSION['customer_name']: 'Admin';?>'s Cart 🛒·₊̣̇⊰</h3>
            <div class="box">
                <?php if (empty($cart_items)): ?>
                    <p>Your cart is empty.</p>
                <?php else: ?>
                    <table class="cart-table">
                        <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                        <?php while ($item = mysqli_fetch_object($cart_items)): ?>
                            <tr>
                                <td><?php echo $item->product_name; ?></td>
                                <td><img src="produk/<?php echo $item->product_image; ?>" class="cart-image" target="_blank"></td>
                                <td>Rp <?php echo number_format($item->product_price, 0, '.', ','); ?></td>
                                <td><?php echo $_SESSION['cart'][$item->product_id]; ?></td>
                                <td>Rp <?php echo number_format($item->product_price * $_SESSION['cart'][$item->product_id], 0, '.', ','); ?></td>
                                <td>
                                    <a href="cart.php?action=increase&id=<?php echo $item->product_id; ?>" class="btn-action">+</a>
                                    <a href="cart.php?action=decrease&id=<?php echo $item->product_id; ?>" class="btn-action">-</a>
                                    <a href="cart.php?action=remove&id=<?php echo $item->product_id; ?>" class="btn-action">Remove</a>
                                </td>
                            </tr>
                            <?php $total_price += $item->product_price * $_SESSION['cart'][$item->product_id]; ?>
                        <?php endwhile; ?>
                        <tr>
                            <td colspan="4" align="right"><strong>Total Price:</strong></td>
                            <td>Rp <?php echo number_format($total_price, 0, '.', ','); ?></td>
                            <td><button onclick="confirmCheckout(<?php echo $total_price; ?>)" class="btn-checkout">Checkout</button></td>
                        </tr>
                    </table>
                <?php endif; ?>
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
        function confirmCheckout(totalPrice) {
            if (confirm("˚.🛒༘⋆ wait ! are you sure you want to purchase the current cart ? ")) {
                window.location.href = "cart.php?action=checkout&total_price=" + totalPrice;
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