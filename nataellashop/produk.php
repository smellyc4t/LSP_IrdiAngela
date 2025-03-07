<?php
    error_reporting(0);
    include 'db.php';
    $kontak = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin
    WHERE admin_id =1");
    $a = mysqli_fetch_object($kontak);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>·˚ ༘👗 product | nataellashop 🌷·˚</title>
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

     <!-- Search -->
      <div class="search">
        <div class="container">
            <form action="produk.php">
                <input type="text" name="search" placeholder="⌕. . . search fashion" value="<?php echo $_GET['search'] ?>">
                <input type="hidden" name="kat" value="<?php echo $_GET['kat'] ?>">
                <input type="submit" name="cari" value="🔎">
            </form>
        </div>
      </div>

       <!-- New Product -->
        <div class="section">
            <div class="container">
                <h3>✦ · 🎗 Product 🎗·₊̣̇⊰</h3>
                <div class="box">
                    <?php
                        if($_GET['search'] != '' || $_GET['kat'] != ''){
                            $where = "AND product_name LIKE '%".$_GET['search']."%' AND category_id LIKE '%".$_GET['kat']."%' ";
                        }
                            $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_status = 1 $where ORDER BY product_id");
                            if(mysqli_num_rows($produk) > 0){
                                while($p = mysqli_fetch_array($produk)){
                    ?>
                        <a href="detail-produk.php?id=<?php echo $p['product_id'] ?>">
                            <div class="col-4">
                                <img src="produk/<?php echo $p['product_image'] ?>">
                                <p class="nama"><?php echo substr($p['product_name'], 0, 30) ?></p>
                                <p class="harga">Rp <?php echo number_format($p['product_price'])?></p>
                            </div>
                        </a>
                    <?php }}else{ ?>
                        <p>There is no product</p>
                    <?php } ?>
                    </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="container">
                <h4>Address</h4>
                <p><?php echo $a->admin_address ?></p>
                
                <h4>E-Mail</h4>
                <p><?php echo $a->admin_email ?></p>

                <h4>Phone Number</h4>
                <p><?php echo $a->admin_telp ?></p>

                <small>₍ ᐢ. ̫ .ᐢ ₎♡ Copyright &copy; 2025 ✦ nataellashop ♡࿐</small>
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