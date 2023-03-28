<?php
session_start();

if(isset($_SESSION['username'])) {
    $conn = new mysqli('localhost', 'root', '', 'user');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_SESSION['username'];
    $sql = "SELECT * FROM users WHERE username = '{$_SESSION['username']}'";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        echo '<div class="panel-heading">';
        echo '<h3 class="panel-title">User Details</h3>';
        echo '</div>';

        echo '<div class="panel-body">';
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped table-bordered">';
        echo '<tbody>';
        echo '<tr>';
        echo '<tr>';
        echo '<td><strong>Username:</strong></td>';
        echo '<td>' . (isset($row["username"]) ? $row["username"] : '') . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td><strong>Date of Birth:</strong></td>';
        echo '<td>';
        echo '<form action="update_profile.php" method="POST">';
        echo '<input type="date" name="dob" value="' . (isset($row["date"]) ? $row["date"] : '') . '">';
        echo '<input type="submit" name="submit_dob" value="Save">';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td><strong>Gender:</strong></td>';
        echo '<td>' . (isset($row["gender"]) ? $row["gender"] : '') . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td><strong>Email:</strong></td>';
        echo '<td><a href="' . (isset($row["email"]) ? $row["email"] : '') . '">' . (isset($row["email"]) ? $row["email"] : '') . '</a></td>';
        echo '</tr>';
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
        echo '<div class="panel-footer">';
        echo '<a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>';
        echo '<span class="pull-right">';
        echo '<a href="update%20profile.php" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit">Edit Profile</i></a>';
        echo '<a data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>';
        echo '</span>';
        echo '</div>';
    }

    $conn->close();

}
?>
