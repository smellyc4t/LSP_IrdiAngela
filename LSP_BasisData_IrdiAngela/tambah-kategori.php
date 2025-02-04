<?php
    session_start();
    include 'db.php';
    if($_SESSION['status_login'] != true){
        echo '<script>window.location="login.php"</script>';
    }
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>·˚ ༘➕ add category | nataellashop 🌷·˚</title>
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
            <h3>♡ · ➕ Add Category ·₊̣̇⊰</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" name="nama" placeholder="Category Name" class="input-control" required>
                    <input type="submit" name="submit" value="Submit" class="btn">
                </form>
                <?php
                    if(isset($_POST['submit'])){
                        $nama = ucwords($_POST['nama']);
                        $insert = mysqli_query($conn, "INSERT INTO tb_category VALUES
                                            (null,
                                            '".$nama."') ");
                        if($insert){
                            echo '<script>alert("(●ˇ∀ˇ●) successfully added a category ! ✔")</script>';
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