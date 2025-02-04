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
    <title>·˚ ༘➕ add product | nataellashop 🌷·˚</title>
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
            <h3>☆ · ➕ Add Product ·₊̣̇⊰</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <select class="input-control" name="kategori" required>
                        <option value="">--Choose--</option>
                        <?php
                            $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id");
                            while($r = mysqli_fetch_array($kategori)){
                        ?>
                        <option value="<?php echo $r['category_id'] ?>"><?php echo $r['category_name'] ?></option>
                        <?php } ?>
                    </select>

                    <input type="text" name="nama" class="input-control" placeholder="Product Name" required>
                    <input type="text" name="harga" class="input-control" placeholder="Price" required>
                    <input type="file" name="gambar" class="input-control" required>
                    <textarea class="input-control" name="deskripsi" placeholder="Description"></textarea>
                    <select class="input-control" name="status">
                        <option value="">--Choose--</option>
                        <option value="1">Active</option>
                        <option value="0">Not Active</option>
                    </select>
                    <input type="submit" name="submit" value="Submit" class="btn">
                </form>
                <?php
                    if(isset($_POST['submit'])){
                        // print_r($_FILES['gambar']);
                        // menampung inputan dari form
                        $kategori  = $_POST['kategori'];
                        $nama      = $_POST['nama'];
                        $harga     = $_POST['harga'];
                        $deskripsi = $_POST['deskripsi'];
                        $status    = $_POST['status'];

                        // menampung data file yang diupload
                        $filename = $_FILES['gambar']['name'];
                        $tmp_name = $_FILES['gambar']['tmp_name'];

                        $type1 = explode('.', $filename);
                        $type2 = $type1[1];

                        $newname = 'produk'.time().'.'.$type2;

                        // menampung data format file yang diizinkan
                        $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');

                        // validasi format file
                        if(!in_array($type2, $tipe_diizinkan)){
                            // jika format file tidak ada di dalam tipe diizinkan
                            echo '<script>alert("Format file tidak diizinkan")</script>';
                        }else{
                            //jika format file sesuai dengan yang di dalam array tipe diizinkan
                            //proses upload file sekaligus insert ke database
                            move_uploaded_file($tmp_name, './produk/'.$newname);

                            $insert = mysqli_query($conn, "INSERT INTO tb_product VALUES (
                                        null,
                                        '".$kategori."',
                                        '".$nama."',
                                        '".$harga."',
                                        '".$deskripsi."',
                                        '".$newname."',
                                        '".$status."',
                                        null
                                            ) ");
                            if($insert){
                                echo '<script>alert("(╹ڡ╹ ) it looks like your new product is ready ! ✔")</script>';
                                echo '<script>window.location="data-produk.php"</script>';
                            }else{
                                echo 'gagal '.mysqli_error($conn);
                            }
                        }

                        // proses upload file sekaligus insert ke database

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