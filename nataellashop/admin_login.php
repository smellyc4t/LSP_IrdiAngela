<?php
session_start();
include 'db.php';

if (isset($_POST['submit'])) {
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);

    // Check admin
    $cek_admin = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username = '$user' AND password = '" . MD5($pass) . "'");
    if (mysqli_num_rows($cek_admin) > 0) {
        $d = mysqli_fetch_object($cek_admin);
        $_SESSION['status_login'] = true;
        $_SESSION['a_global'] = $d;
        $_SESSION['id'] = $d->admin_id;
        echo '<script>window.location="dashboard.php"</script>';
    } else {
        echo '<script>alert("＞﹏＜ oops! ✖ i think you put the wrong username or password~ please try again ♡₊˚.༄")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>‧₊˚.🍄 Admin Login | nataellashop 🌷·˚</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body id="bg-login">
    <div class="box-login">
        <div class="login-container">
            <img src="img/nataella.png" class="logo">
        </div>
        <h2>୨♥︎. .Admin Login. .♥︎୧</h2>
        <form action="" method="POST">
            <input type="text" name="user" placeholder="Username" class="input-control">
            <input type="password" name="pass" placeholder="Password" class="input-control">
            <input type="submit" name="submit" value="Login" class="btn">
        </form>
        <p>Not an admin? <a href="customer_login.php">Customer Login</a></p>
    </div>
</body>
</html>