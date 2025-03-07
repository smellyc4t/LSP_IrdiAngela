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
    <title>·˚ ༘📦 data product | nataellashop 🌷·˚</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
            <h3>✦ ·📦 Data Product ·˚ ༘</h3>
            <div class="box">
                <p><a href="tambah-produk.php" class="btn">➕ Add Product ➕</a></p>
                <br>
                <table border="1" cellspacing="0" class="order-table">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>Category</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Picture</th>
                            <th>Status</th>
                            <th width="150px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            $produk = mysqli_query($conn, "SELECT * FROM tb_product LEFT JOIN tb_category USING (category_id) ORDER BY product_id");
                            if(mysqli_num_rows($produk) > 0){
                            while($row = mysqli_fetch_array($produk)){
                        ?>
                        <tr>
                            <td width="20px" ><?php echo $no++ ?></td>
                            <td width="70px"><?php echo $row['category_name']?></td>
                            <td width="120px"><?php echo $row['product_name']?></td>
                            <td width="100px" style="text-align: center;">Rp <?php echo number_format($row['product_price']) ?></td>
                            <td width="100px" style="text-align: center;"><a href="produk/<?php echo $row['product_image'] ?>" target="_blank"><img src="produk/<?php echo $row['product_image'] ?>" width="140px"></a></td>
                            <td width="50px" style="text-align: center;"><?php echo ($row['product_status'] == 0)? 'Not Active':'Active'; ?></td>
                            <td width="50px" style="text-align: center;">
                                <button class="btn-deliver">
                                    <a href="edit-produk.php?id=<?php echo $row['product_id'] ?>">Edit</a>
                                </button> 
                                <button class="btn-delete">
                                    <a href="proses-hapus.php?idp=<?php echo $row['product_id'] ?>" onclick="return confirm ('wait ! are u sure want to delete it ???')">Delete</a>
                                </button>
                            </td>
                        </tr>
                        <?php }}else{ ?>
                            <tr>
                                <td colspan="7">Nothing here. . .</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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