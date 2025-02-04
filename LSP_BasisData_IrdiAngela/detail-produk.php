<?php
    error_reporting(0);
    include 'db.php';
    $kontak = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin
    WHERE admin_id =1");
    $a = mysqli_fetch_object($kontak);

    $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE 
    product_id = '".$_GET['id']."' ");
    $p = mysqli_fetch_object($produk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>·˚ ༘🎀 detail product | nataellashop 🌷·˚</title>
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
            <li><a href="produk.php">Produk</a></li>
            <li><a href="login.php">Login</a></li>
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

      <!-- Detail Product -->
       <div class="section">
        <div class="container">
            <h3>Product Details</h3>
            <div class="box">
                <div class="col-2">
                    <img src="produk/<?php echo $p->product_image ?>" width="100%">
                </div>
                <div class="col-2">
                    <h2><?php echo $p->product_name ?></h2>
                    <h3>Rp. <?php echo number_format($p->product_price)  ?></h3>
                    <p><b>Description :</b><br> 
                        <?php echo $p->product_description?>
                    </p><br>
                    <p><a href="https://api.whatsapp.com/send?phone=<?php echo $a->admin_telp ?>&text=(´▽`ʃ♡ƪ) Holaaa ~ i am interested in your product !" target="_blank"><i class="fa fa-whatsapp" style="font-size:20px;color:#ff5ebf;float:right;padding-top:50px"> Contact via WhatsApp</i></a></p>
                </div>
            </div>
        </div>
       </div>



        <!-- Footer -->
         <div class="footer">
            <div class="container">
                <h4>Address</h4>
                <p>Jl. Kebenaran 17</p>
                
                <h4>E-Mail</h4>
                <p><?php echo $a->admin_email ?></p>

                <h4>Phone Number</h4>
                <p><?php echo $a->admin_telp ?></p>

                <small>₍ ᐢ. ̫ .ᐢ ₎♡ Copyright &copy; 2024 ✦ nataellashop ♡࿐</small>
                </div>
            </div>

        <script>
        document.getElementById("menuToggle").addEventListener("click", function () {
        const navbar = document.querySelector("header ul");
        navbar.classList.toggle("active");
        this.classList.toggle("active");
        });
        </script>
</body>
</html>