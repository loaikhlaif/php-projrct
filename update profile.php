
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
$conn = mysqli_connect('localhost', 'root', '', 'user');
$username = $_SESSION['username'];
$user = $_SESSION['user'];
$stmt = mysqli_prepare($conn, 'SELECT * FROM users WHERE username = ?');
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $stmt = mysqli_prepare($conn, 'UPDATE users SET email = ? WHERE username = ?');
    mysqli_stmt_bind_param($stmt, 'ss', $email, $username);
    mysqli_stmt_execute($stmt);
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, 'UPDATE users SET password = ? WHERE username = ?');
    mysqli_stmt_bind_param($stmt, 'ss', $hashed_password, $username);
    mysqli_stmt_execute($stmt);
    $username = $_POST['username'];
    $stmt = mysqli_prepare($conn, 'UPDATE users SET username = ? WHERE email = ?');
    mysqli_stmt_bind_param($stmt, 'ss',$username , $email);
    mysqli_stmt_execute($stmt);
    $username = $_POST['id'];
    $stmt = mysqli_prepare($conn, 'UPDATE users SET id = ? WHERE email = ?');
    mysqli_stmt_bind_param($stmt, 'ss',$id , $email);
    mysqli_stmt_execute($stmt);
    $date = $_POST['date'];
    $stmt = mysqli_prepare($conn, 'UPDATE users SET date = ? WHERE email = ?');
    mysqli_stmt_bind_param($stmt, 'ss',$date , $email);
    mysqli_stmt_execute($stmt);
    if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['profile_picture']['tmp_name'];
        $name = $_FILES['profile_picture']['name'];
        $path = 'uploads/' . $name;
        move_uploaded_file($tmp_name, $path);
        $stmt = mysqli_prepare($conn, 'UPDATE users SET profile_picture = ? WHERE username = ?');
        mysqli_stmt_bind_param($stmt, 'ss', $path, $email);
        mysqli_stmt_execute($stmt);
    }
    header('Location: profile.php');
    exit();
}
?>
<h1 style="text-align: center;">Edit Profile</h1>
<form method="post" enctype="multipart/form-data" style="width: 50%; margin: auto;">
    <div style="display: flex; flex-direction: column; margin-bottom: 10px;">
        <label for="email">Email Address:</label>
        <input type="email" name="email" id="email" value="<?php echo $row['email']; ?>" style="padding: 5px;">
    </div>
    <div style="display: flex; flex-direction: column; margin-bottom: 10px;">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" style="padding: 5px;">
    </div>
    <div style="display: flex; flex-direction: column; margin-bottom: 10px;">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" style="padding: 5px;">
    </div>
    <div style="display: flex; flex-direction: column; margin-bottom: 10px;">
        <label for="date">Date of Birth:</label>
        <input type="date" id="date" name="date" required style="padding: 5px;">
    </div>
    <div style="display: flex; flex-direction: column; margin-bottom: 10px;">
        <label for="profile_picture">Profile Picture:</label>
        <input type="file" name="profile_picture" id="profile_picture" style="padding: 5px;">
    </div>
    <input type="submit" value="Save Changes" style="padding: 5px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
</form>