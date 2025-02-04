<?php
    session_start();
    include 'db.php';
    if($_SESSION['status_login'] != true){
        echo '<script>window.location="login.php"</script>';
    }   

    $kategori = mysqli_query($conn, "SELECT * FROM  tb_category WHERE category_id = '".$_GET['id']."' ");
    if(mysqli_num_rows($kategori) == 0){
        echo '<script>window.location="data-kategori.php"</script>';
    }
    $k = mysqli_fetch_object($kategori);
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>·˚ ༘🧸 edit category | nataellashop 🌷·˚</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <!-- header -->
    <header>
    <div class="container">
        <h1><a href="">nataellashop</a></h1>
        
        <!-- Tombol Menu -->
        <div class="menu-toggle" id="menuToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Navbar -->
        <ul id="navbar">
            <!-- Tombol Back -->
            <div class="close-menu" id="closeMenu">X</div>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="data-kategori.php">Data Kategori</a></li>
            <li><a href="data-produk.php">Data Produk</a></li>
            <li><a href="keluar.php">Keluar</a></li>
        </ul>
    </div>
</header>
     <!-- Content -->
      <div class="section">
        <div class="container">
            <h3>☆ · 🧸 Edit Category ·₊̣̇⊰</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" name="nama" placeholder="Category Name" class="input-control" value="<?php echo $k->category_name ?>" required>
                    <input type="submit" name="submit" value="Submit" class="btn">
                </form>
                <?php
                    if(isset($_POST['submit'])){
                        $nama = ucwords($_POST['nama']);
                        $update = mysqli_query($conn, "UPDATE tb_category SET
                                            category_name = '".$nama."'
                                            WHERE category_id = '".$k->category_id."' ");
                        if($update){
                            echo '<script>alert("(✿◡‿◡) successfully edited the category ! ✔")</script>';
                            echo '<script>window.location="data-kategori.php"</script>';
                        }else{
                            echo 'gagal '.mysqli_error($conn);
                        }
                    }
                ?>
            </div>
        </div>
      </div>

      <!-- footer -->
       <footer>
        <div class="container">
        <small>₍ ᐢ. ̫ .ᐢ ₎♡ Copyright &copy; 2024 ✦ nataellashop ♡࿐</small>
        </div>
       </footer>

       <script>
    document.getElementById("menuToggle").addEventListener("click", function () {
        const navbar = document.getElementById("navbar");
        navbar.classList.toggle("active");
        this.classList.toggle("active");
    });

    // Event listener untuk ikon back (X)
    document.getElementById("closeMenu").addEventListener("click", function () {
        const navbar = document.getElementById("navbar");
        const menuToggle = document.getElementById("menuToggle");

        navbar.classList.remove("active");
        menuToggle.classList.remove("active");
    });
</script>
</body>
</html>