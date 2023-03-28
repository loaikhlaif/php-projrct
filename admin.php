<?php
$conn=mysqli_connect("localhost",'root',"","");
session_start();
if(isset($_SESSION['admin_id'])){
    header('Location: admin.php');
    exit();
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];
    if($username === 'admin' && $password === '12345678'){
        $_SESSION['admin_id'] = 'admin';
        header('Location: tabels.php');
        exit();
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
    <h1>Admin Login</h1>
    <?php if(isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" value="Login">
        <a href="tabels.php"</a>
    </form>
</body>
</html>
