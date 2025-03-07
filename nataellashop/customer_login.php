<?php
session_start();
include 'db.php';

if (isset($_POST['submit'])) {
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>‧₊˚.🍄 Customer Login | nataellashop 🌷·˚</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body id="bg-login">
    <div class="box-login">
        <div class="login-container">
            <img src="img/nataella.png" class="logo">
        </div>
        <h2>୨♥︎. .Customer Login. .♥︎୧</h2>
        <form action="" method="POST">
            <input type="text" name="user" placeholder="Username" class="input-control">
            <input type="password" name="pass" placeholder="Password" class="input-control">
            <input type="submit" name="submit" value="Login" class="btn">
        </form>
        <p>New customer? <a href="register.php">Register here</a></p>
        <p>Admin? <a href="admin_login.php">Admin Login</a></p>
    </div>
</body>
</html>