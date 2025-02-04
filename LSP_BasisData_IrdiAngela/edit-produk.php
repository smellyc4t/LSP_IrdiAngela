<?php
    session_start();
    include 'db.php';
    if($_SESSION['status_login'] != true){
        echo '<script>window.location="login.php"</script>';
    }

    $produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id ='".$_GET['id']."'");
    if(mysqli_num_rows($produk) == 0){
        echo '<script>window.location="data-produk.php"</script>';
    }
    $p = mysqli_fetch_object($produk);
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>·˚ ༘🍡 edit product | nataellashop 🌷·˚</title>
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
            <h3>✧ · 🍡 Edit Product ·₊̣̇⊰</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <select class="input-control" name="kategori" required>
                        <option value="">--Choose--</option>
                        <?php
                            $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id");
                            while($r = mysqli_fetch_array($kategori)){
                        ?>
                        <option value="<?php echo $r['category_id'] ?>" <?php echo ($r['category_id'] == $p->category_id)? 'selected':''; ?>><?php echo $r['category_name'] ?></option>
                        <?php } ?>
                    </select>

                    <input type="text" name="nama" class="input-control" placeholder="Product Name" value="<?php echo $p->product_name ?>" required>
                    <input type="text" name="harga" class="input-control" placeholder="Price" value="<?php echo $p->product_price ?>" required>

                    <img src="produk/<?php echo $p->product_image ?>" width="150px">
                    <input type="text" name="foto" value="<?php echo $p->product_image ?>">
                    <input type="file" name="gambar" class="input-control">
                    <textarea class="input-control" name="deskripsi" placeholder="Description"><?php echo $p->product_description ?></textarea>
                    <select class="input-control" name="status">
                        <option value="">--Choose--</option>
                        <option value="1" <?php echo ($p->product_status == 1)? 'selected':''; ?>>Active</option>
                        <option value="0" <?php echo ($p->product_status == 0)? 'selected':''; ?>>Not Active</option>   
                    </select>
                    <input type="submit" name="submit" value="Submit" class="btn">
                </form>
                <?php
                    if(isset($_POST['submit'])){
                        
                        // data inputan dari form
                        $kategori  = $_POST['kategori'];
                        $nama      = $_POST['nama'];
                        $harga     = $_POST['harga'];
                        $deskripsi = $_POST['deskripsi'];
                        $status    = $_POST['status'];
                        $foto      = $_POST['foto'];

                        // data gambar yang baru
                        $filename = $_FILES['gambar']['name'];
                        $tmp_name = $_FILES['gambar']['tmp_name'];


                        // jika admin ganti gambar
                        if($filename != ''){
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
                                unlink('./produk/'.$foto);
                                move_uploaded_file($tmp_name, './produk/'.$newname);
                                $namagambar = $newname;
                            }
                        }else{
                            // jika admin tidak ganti gambar
                            $namagambar = $foto;
                        }

                        // query update data produk
                        $update = mysqli_query($conn, "UPDATE tb_product SET
                                                category_id         = '".$kategori."',
                                                product_name        = '".$nama."',
                                                product_price       = '".$harga."',
                                                product_description = '".$deskripsi."',
                                                product_image       = '".$namagambar."', 
                                                product_status      = '".$status."'
                                                WHERE product_id    = '".$p->product_id."' ");
                        if($update){
                            echo '<script>alert("(｡･∀･)ﾉﾞ phew~ your data is updated ! ✔")</script>';
                            echo '<script>window.location="data-produk.php"</script>';
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