<?php
$conn = mysqli_connect("localhost", "root", "", "user");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $gender = $_POST["gender"];
    $date = $_POST["date"];

    // Check if a file was uploaded
    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0) {
        // Get the details of the uploaded file
        $file_name = $_FILES["profile_picture"]["name"];
        $file_size = $_FILES["profile_picture"]["size"];
        $file_tmp = $_FILES["profile_picture"]["tmp_name"];
        $file_type = $_FILES["profile_picture"]["type"];
        $upload_dir = "uploads/";
        $file_path = $upload_dir . $file_name;

    } else {
        $file_path = "";
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql_check_email = "SELECT email FROM users WHERE email = '$email'";
    $result_check_email = mysqli_query($conn, $sql_check_email);
    if (mysqli_num_rows($result_check_email) > 0) {
        echo "Error: email already exists.";
    } else {
        $sql = "INSERT INTO users (username, email, password, gender, `date`, profile_picture) VALUES ('$username', '$email', '$hashed_password', '$gender', '$date', '$file_path')";
        if (mysqli_query($conn, $sql)) {
            echo "Registration successful!";
            header('Location: login.php');
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
}
?>

<form action="reg.php" method="post" enctype="multipart/form-data" style="max-width: 400px; margin: 0 auto;">
    <h2 style="text-align: center;">Register</h2>
    <div style="display: flex; flex-direction: column; margin-bottom: 10px;">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required style="padding: 5px;">
    </div>
    <div style="display: flex; flex-direction: column; margin-bottom: 10px;">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required style="padding: 5px;">
    </div>
    <div style="display: flex; flex-direction: column; margin-bottom: 10px;">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required style="padding: 5px;">
    </div>
    <div style="display: flex; flex-direction: column; margin-bottom: 10px;">
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required style="padding: 5px;">
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
    </div>
    <div style="display: flex; flex-direction: column; margin-bottom: 10px;">
        <label for="date">Date of Birth:</label>
        <input type="date" id="date" name="date" required style="padding: 5px;">
    </div>
    <div style="display: flex; flex-direction: column; margin-bottom: 10px;">
        <label for="profile_picture">Profile Picture:</label>
        <input type="file" id="profile_picture" name="profile_picture" style="padding: 5px;">
    </div>
    <button type="submit" name="submit" style="padding: 10px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">Register</button>
</form>

