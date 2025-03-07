<?php
    session_start();
    include 'db.php';
    if($_SESSION['status_login'] != true){
        echo '<script>window.location="login.php"</script>';
    }

    $query = mysqli_query($conn, "SELECT * FROM tb_admin WHERE admin_id = '".$_SESSION['id']."' ");
    $d = mysqli_fetch_object($query);
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>·˚ ༘🦋 profile | nataellashop 🌷·˚</title>
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
            <h3>♡ · 🍄 Profile ·₊̣̇⊰</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" name="nama" placeholder="Full Name" class="input-control" value="<?php echo $d->admin_name ?>" required>
                    <input type="text" name="user" placeholder="Username" class="input-control" value="<?php echo $d->username ?>" required>
                    <input type="text" name="hp" placeholder="Phone Number" class="input-control" value="<?php echo $d->admin_telp ?>" required>
                    <input type="email" name="email" placeholder="Email" class="input-control" value="<?php echo $d->admin_email ?>" required>
                    <input type="text" name="alamat" placeholder="Address" class="input-control" value="<?php echo $d->admin_address ?>" required>
                    <input type="submit" name="submit" value="Change Profile" class="btn">
                </form>
                <?php
                if(isset($_POST['submit'])){
                    $nama   = $_POST['nama'];
                    $user   = $_POST['user'];
                    $hp     = $_POST['hp'];
                    $email  = $_POST['email'];
                    $alamat = $_POST['alamat']; 

                    $update = mysqli_query($conn, "UPDATE tb_admin SET
                                    admin_name = '".$nama."',
                                    username = '".$user."',
                                    admin_telp = '".$hp."',
                                    admin_email = '".$email."',
                                    admin_address = '".$alamat."'
                                    WHERE admin_id = '".$d->admin_id."' ");
                
                    if($update){
                        echo '<script>alert("^_^ successfully updated your profile ! ✔")</script>';
                        echo '<script>window.location="profile.php"</script>';
                    }else {
                        echo 'gagal '.mysqli_error($conn);
                    }                 
                }
                ?>
            </div>
            
            <br>
            <h3>✯ · 🌱 Change Password ·₊̣̇⊰</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="password" name="pass1" placeholder="New Password" class="input-control" required>
                    <input type="password" name="pass2" placeholder="Confirm New Password" class="input-control" required>
                    <input type="submit" name="ubah_password" value="Change Password" class="btn">
                </form>
                <?php
                if(isset($_POST['ubah_password'])){
                    $pass1   = $_POST['pass1'];
                    $pass2   = $_POST['pass2'];

                    if($pass2 != $pass1){
                        echo '<script>alert("ಠಿ_ಠ uhmm...the password did not match? could u please try again? 🙏")</script>';
                    }else{
                        $u_pass = mysqli_query($conn, "UPDATE tb_admin SET
                                    password = '".MD5($pass1)."'
                                    WHERE admin_id = '".$d->admin_id."' ");
                        if($u_pass){
                            echo '<script>alert("𓍢 💌 you are good to go! i have saved your new pass ♪(´▽｀)")</script>';
                            echo '<script>window.location="profile.php"</script>';
                        }else{
                            echo 'gagal '.mysqli_error($conn);
                        }
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