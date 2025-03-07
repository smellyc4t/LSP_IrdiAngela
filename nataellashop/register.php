<?php
include 'db.php';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_BCRYPT);

    $insert = mysqli_query($conn, "INSERT INTO tb_customer (customer_name, customer_email, customer_phone, customer_address, customer_password) VALUES ('$username', '$email', '$phone', '$address', '$password')");

    if ($insert) {
        echo '<script>alert("(✿◡‿◡) YAY ~ registration successfull ! ✔"); window.location="login.php";</script>';
    } else {
        echo '<script>alert("oh no , registration failed ! ＞︿＜");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>‧₊˚.🍟 register | nataellashop 🌷·˚</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
</head>
<body id="bg-login">
    <div class="box-login">
        <div class="login-container">
            <img src="img/nataella.png" class="logo">
        </div>
        <h2>୨♥︎. .Register. .♥︎୧</h2>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" class="input-control" required>
            <input type="email" name="email" placeholder="Email" class="input-control" required>
            <input type="text" name="phone" placeholder="Phone" class="input-control" required>
            <textarea name="address" placeholder="Address" class="input-control" required></textarea>
            <input type="password" name="password" id="password" placeholder="Password" class="input-control" required>
            <i class="fas fa-eye" style="font-size:17px;margin-bottom: 15px; color:#212121" id="toggle-password"> Show Password</i><br>
            <input type="submit" name="register" value="Register" class="btn"> 
        </form>
        <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
    </div>
    <script>
        document.getElementById('toggle-password').addEventListener('click', function() {
            var passwordField = document.getElementById('password');
            var icon = this;
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                icon.textContent = ' Hide Password';
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
                icon.textContent = ' Show Password';
            }
        });
    </script>
</body>
</html>