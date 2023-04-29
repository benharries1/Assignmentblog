<?php
session_start();
//Provide the username and the server name of the SQL database
$server_name = 'localhost';
$username = 'root';
$password = '';
//Establish a connection with the SQL database
$conn = new mysqli($server_name, $username, $password);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);


}
?>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>

<?php

include '../navbar.php';

if($_SESSION['RoleID'] == 3 ) {
    $sql = "SELECT CyberSecurityBlog.Users.*,CyberSecurityBlog.roles.name As RoleName FROM CyberSecurityBlog.users INNER JOIN CyberSecurityBlog.roles ON users.RoleID = roles.ID";
    $stmt = $conn->prepare($sql);

    echo '<table class="table">';
    echo '<tr>';
    echo '<td>Username</td>';
    echo '<td>Name</td>';
    echo '<td>Email</td>';
    echo '<td>Role</td>';
    echo '<td>View</td>';
    echo '</tr>';


    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {

            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['Username']) . '</td>';
            echo '<td>' . htmlspecialchars($row['Name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['Email']) . '</td>';
            echo '<td>' . htmlspecialchars($row['RoleName']) . '</td>';
            echo '<td><a href="ViewUser.php?id=' . $row['ID'] . '">View User</a></td>';
            echo '</tr>';
        }
    }

    echo '</table>';


}
else
{
    echo 'You do not have permission to view this';
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
