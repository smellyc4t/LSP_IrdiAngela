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
            <h3>✧ · 🍡 Edit Product ·₊̣̇⊰</h3>
            <div class="box">
            <form action="" method="post" enctype="multipart/form-data">
            <select name="kategori" class="input-control" required>
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
            <label for="stock">Stock:</label>
            <input type="number" name="stock" id="stock" class="input-control stock-input" value="<?php echo $p->stock; ?>" required>
            <select class="input-control" name="status">
                <option value="">--Choose--</option>
                <option value="1" <?php echo ($p->product_status == 1)? 'selected':''; ?>>Active</option>
                <option value="0" <?php echo ($p->product_status == 0)? 'selected':''; ?>>Not Active</option>   
            </select>
            <input type="submit" name="submit" value="Submit" class="btn">
        </form>
        <?php
        if(isset($_POST['submit'])){
            // Data input from form
            $kategori  = $_POST['kategori'];
            $nama      = $_POST['nama'];
            $harga     = $_POST['harga'];
            $deskripsi = $_POST['deskripsi'];
            $stock     = $_POST['stock'];
            $status    = $_POST['status'];
            $foto      = $_POST['foto'];

            if($_FILES['gambar']['name'] != ''){
                $filename = $_FILES['gambar']['name'];
                $tmp_name = $_FILES['gambar']['tmp_name'];
                $type1 = explode('.', $filename);
                $type2 = $type1[1];
                $newname = 'produk'.time().'.'.$type2;

                $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');

                if(!in_array($type2, $tipe_diizinkan)){
                    echo '<script>alert("File type not allowed")</script>';
                }else{
                    move_uploaded_file($tmp_name, './produk/'.$newname);
                    $namagambar = $newname;
                }
            }else{
                $namagambar = $foto;
            }

            $update = mysqli_query($conn, "UPDATE tb_product SET 
                                            category_id = '".$kategori."',
                                            product_name = '".$nama."',
                                            product_price = '".$harga."',
                                            product_description = '".$deskripsi."',
                                            product_image = '".$namagambar."',
                                            stock = '".$stock."',
                                            product_status = '".$status."'
                                            WHERE product_id = '".$p->product_id."' ");

            if($update){
                echo '<script>alert("(๛ ˘ ³˘ )♡ successfully edited the product ! ")</script>';
                echo '<script>window.location="data-produk.php"</script>';
            }else{
                echo 'oh no , failed to update the product ! ＞︿＜ '.mysqli_error($conn);
            }
        }
        ?>
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