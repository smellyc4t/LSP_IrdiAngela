<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['received'])) {
        $order_id = $_POST['order_id'];
        $update_status_query = "UPDATE tb_order SET order_status = 'Finished' WHERE order_id = '$order_id'";
        mysqli_query($conn, $update_status_query);
    } else {
        $shipping = $_POST['shipping'];
        $total_price = $_POST['total_price'];
        $customer_id = $_SESSION['customer_id'];

        $customer_query = "SELECT customer_address FROM tb_customer WHERE customer_id = '$customer_id'";
        $customer_result = mysqli_query($conn, $customer_query);
        $customer = mysqli_fetch_object($customer_result);
        $address = $customer->customer_address;

        $payment_proof = $_FILES['payment_proof']['name'];
        $tmp_name = $_FILES['payment_proof']['tmp_name'];
        $file_type = pathinfo($payment_proof, PATHINFO_EXTENSION);
        $allowed_types = array('jpeg', 'jpg', 'png');

        if (in_array($file_type, $allowed_types)) {
            $new_payment_proof = 'upload/' . time() . '_' . $payment_proof;
            move_uploaded_file($tmp_name, $new_payment_proof);
        } else {
            echo '<script>alert("Invalid file type. Only JPEG, JPG, and PNG are allowed.")</script>';
            exit;
        }

        $order_query = "INSERT INTO tb_order (customer_id, total_price, order_status, shipping_method, shipping_address, payment_proof, date_created) VALUES ('$customer_id', '$total_price', 'Processing Your Order 🔃', '$shipping', '$address', '$new_payment_proof', NOW())";
        mysqli_query($conn, $order_query);
        $order_id = mysqli_insert_id($conn);

        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $product_query = "SELECT product_price, stock FROM tb_product WHERE product_id = '$product_id'";
            $product_result = mysqli_query($conn, $product_query);
            $product = mysqli_fetch_object($product_result);

            if ($product) {
                $product_price = $product->product_price;
                $new_stock = $product->stock - $quantity;

                $order_detail_query = "INSERT INTO tb_order_detail (order_id, product_id, quantity, price) VALUES ('$order_id', '$product_id', '$quantity', '$product_price')";
                mysqli_query($conn, $order_detail_query);

                $update_stock_query = "UPDATE tb_product SET stock = '$new_stock' WHERE product_id = '$product_id'";
                mysqli_query($conn, $update_stock_query);
            }
        }

        $_SESSION['cart'] = [];
    }
}

if (isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id'];

    $orders_query = "SELECT * FROM tb_order WHERE customer_id = '$customer_id' ORDER BY date_created DESC";
    $orders_result = mysqli_query($conn, $orders_query);
} else {
    echo '<script>window.location="login.php"</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>·˚ ༘📦 Order Details | nataellashop 🌷·˚</title>
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
            <h3>✦ · 📦 Order Details 📦·₊̣̇⊰</h3><br>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Total Price</th>
                            <th>Address</th>
                            <th>Delivery</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = mysqli_fetch_object($orders_result)) { ?>
                        <tr>
                            <td>
                                <?php
                                $order_details_query = "SELECT tb_product.product_image FROM tb_order_detail JOIN tb_product ON tb_order_detail.product_id = tb_product.product_id WHERE tb_order_detail.order_id = '$order->order_id' LIMIT 1";
                                $order_details_result = mysqli_query($conn, $order_details_query);
                                $detail = mysqli_fetch_object($order_details_result);
                                ?>
                                <a href="produk/<?php echo $detail->product_image; ?>" target="_blank"><img src="produk/<?php echo $detail->product_image; ?>" width="100px"></a>
                                <td>
                                    <ol class="no-numbers">
                                        <?php
                                        $order_details_query = "SELECT tb_order_detail.*, tb_product.product_name FROM tb_order_detail JOIN tb_product ON tb_order_detail.product_id = tb_product.product_id WHERE tb_order_detail.order_id = '$order->order_id'";
                                        $order_details_result = mysqli_query($conn, $order_details_query);
                                        while ($detail = mysqli_fetch_object($order_details_result)) { ?>
                                            <li><?php echo $detail->product_name; ?> x <?php echo $detail->quantity; ?></li>
                                            <?php } ?>
                                        </ol>
                            <td>Rp <?php echo number_format($order->total_price, 0, '.', ','); ?></td>
                            </td>
                            <td><?php echo $order->shipping_address; ?></td>
                            <td><?php echo $order->shipping_method; ?></td>
                            <td><?php echo $order->date_created; ?></td>
                            </td>
                            <td><?php echo $order->order_status; ?></td>
                            <td>
                                <?php if ($order->order_status != 'Finished') { ?>
                                    <form method="post" action="order.php" onsubmit="return confirmReceived()">
                                        <input type="hidden" name="order_id" value="<?php echo $order->order_id; ?>">
                                        <button type="submit" name="received" class="btn-deliver">Package Received📦✅</button>
                                    </form>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
        </div>
    </div>

    <!-- footer -->
    <footer>
        <div class="container">
            <small>₍ ᐢ. ̫ .ᐢ ₎♡ Copyright &copy; 2025 ✦ nataellashop ♡࿐</small>
        </div>
    </footer>

    <script>
        function confirmReceived() {
        return confirm('˚.📦༘⋆ wait ! are you sure you have received the package ? ✅⊹ ࣪ ˖');
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