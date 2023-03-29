<?php

require_once('helper.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conn = mysqli_connect('localhost', 'root', '', 'user');
    $stmt = mysqli_prepare($conn, 'SELECT * FROM users WHERE username = ?');
    if (!$stmt) {
        die('Error: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        $_SESSION['error'] = 'Invalid username or password.';
        echo '<div class="alert alert-danger">Invalid username or password.</div>';
    } else {
        // Verify the password
        $hashed_password = $row['password'];
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $row['username'];
            setUser($row);
            header('Location: profile.php');
        } else {
            $_SESSION['error'] = 'Invalid username or password.';
            echo '<div class="alert alert-danger">Invalid username or password.</div>';
        }
    }
    exit();


}
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<body>
<div id="login">
    <h3 class="text-center text-white pt-5">Login form</h3>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" action="" method="POST">
                        <h3 class="text-center text-info">Login</h3>
                        <div class="form-group">
                            <label for="username" class="text-info">Username:</label><br>
                            <input type="text" name="username" id="username" class="form-control"required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-info">Password:</label><br>
                            <input type="password" name="password" id="password" class="form-control"required>
                        </div>
                        <div class="form-group">
                            <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                             <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                        </div>
                        <div id="admin-link" class="text-right">
                            <a href="admin.php" class="text-info">admin login</a>
                        </div>
                        <div id="register-link" class="text-right">
                            <a href="reg.php" class="text-info">Register here</a>
                        </div>
                        <div id="restpassword-link" class="text-right">
                            <a href="rest.php"  class="text-info">forget my password</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>