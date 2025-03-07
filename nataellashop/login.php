<?php
session_start();
include 'db.php';

if (isset($_POST['submit'])) {
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);
    $login_type = $_POST['login_type'];

    if ($login_type == 'admin') {
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
    } else {
        // Check customer by username
        $cek_customer = mysqli_query($conn, "SELECT * FROM tb_customer WHERE customer_name = '$user'");
        if (mysqli_num_rows($cek_customer) > 0) {
            $customer = mysqli_fetch_object($cek_customer);
            if ($customer && password_verify($pass, $customer->customer_password)) {
                $_SESSION['customer_id'] = $customer->customer_id;
                $_SESSION['customer_name'] = $customer->customer_name;
                echo '<script>window.location="index.php"</script>';
            } else {
                echo '<script>alert("＞﹏＜ oops! ✖ i think you put the wrong username or password~ please try again ♡₊˚.༄")</script>';
            }
        } else {
            echo '<script>alert("＞﹏＜ oops! ✖ i think you put the wrong username or password~ please try again ♡₊˚.༄")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>‧₊˚.🍄 login | nataellashop 🌷·˚</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body id="bg-login">
    <div class="box-login">
        <div class="login-container">
            <img src="img/nataella.png" class="logo">
        </div>
        <h2>୨♥︎. .Login. .♥︎୧</h2>
        <form action="" method="POST">
            <div class="radio-container"><br>
                <input type="radio" id="customer" name="login_type" value="customer" checked>
                <label for="customer" class="radio-label">Customer</label>
                <input type="radio" id="admin" name="login_type" value="admin">
                <label for="admin" class="radio-label">Admin</label>
            </div>
            <input type="text" name="user" placeholder="Username" class="input-control" required>
            <input type="password" name="pass" placeholder="Password" class="input-control" required>
            <input type="submit" target="_blank" name="submit" value="Login" class="btn"><br>
        </form>
        <p class="register-link">New customer? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>