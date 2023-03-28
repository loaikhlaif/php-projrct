<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $conn = mysqli_connect('localhost', 'root', '', 'user');
    $stmt = mysqli_prepare($conn, 'SELECT * FROM tot WHERE email = ?');
    if (!$stmt) {
        die('Error: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        $_SESSION['error'] = 'Email not found.';
        header('Location: forgot_password.php');
        exit();
    }
    if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = 'New password and confirm password do not match.';
        header('Location: forgot_password.php');
        exit();
    }
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, 'UPDATE tot SET password = ? WHERE email = ?');
    if (!$stmt) {
        die('Error: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, 'ss', $hashedPassword, $email);
    mysqli_stmt_execute($stmt);
    $_SESSION['success'] = 'Password updated successfully.';
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
<?php

if (isset($_SESSION['error'])) {
    echo '<p>' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    echo '<p>' . $_SESSION['success'] . '</p>';
    unset($_SESSION['success']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        form {
            margin: 50px auto;
            width: 50%;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0,0,0,0.2);
            font-family: Arial, sans-serif;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            text-align: left;
        }

        input[type=email], input[type=password] {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 2px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s ease-in-out;
        }

        input[type=submit]:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
<form method="post" action="rest.php">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required><br><br>
    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" id="new_password" required><br><br>
    <label for="confirm_password">Confirm Password:</label>
    <input type="password" name="confirm_password" id="confirm_password" required><br><br>
    <input type="submit" value="Reset Password">
</form>
</body>
</html>
