<?php
$conn = mysqli_connect("localhost", "root", "", "user");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT username, email FROM users";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Username</th><th>Email</th>   <th>Update Username</th><th>Update Email</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row["username"] . "</td><td>" . $row["email"] . "</td><td><a href='update%20profile.php' <button>Update</button></td><td><a href='update%20profile.php' <button>Update</button></td></tr></a></a>";

    }

    echo "</table>";
} else {
    echo "0 results";
}

mysqli_close($conn);
?>

