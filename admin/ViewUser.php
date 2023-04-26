<?php
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
<body>
<?php

$sql = "SELECT CyberSecurityBlog.Users.*,CyberSecurityBlog.roles.name As RoleName FROM CyberSecurityBlog.Users INNER JOIN CyberSecurityBlog.Roles ON Users.RoleID=roles.ID WHERE Users.ID= ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_GET['id']);



if ($stmt->execute()) {
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        echo '<p style="margin:25px">ID: '.htmlspecialchars($row['ID']).'</p>';
        echo '<p style="margin:25px">Username: '.htmlspecialchars($row['Username']).'</p>';
        echo '<p style="margin:25px">Name: '.htmlspecialchars($row['Name']).'</p>';
        echo '<p style="margin:25px">RoleName: '.htmlspecialchars($row['RoleName'])  .'</p>';
        echo '<p style="margin:25px">Password: '.htmlspecialchars($row['Password']).'</p>';
        Echo '<a href="index.php">View all users</a>';
        Echo '<a href="EditUser.php?id=' . $_GET['id'] . '">Edit User</a>';
    }
}

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>