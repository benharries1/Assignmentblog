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

$sql = "SELECT CyberSecurityBlog.Users.*,CyberSecurityBlog.roles.name As RoleName FROM CyberSecurityBlog.users INNER JOIN CyberSecurityBlog.roles ON users.RoleID = roles.ID";
$stmt = $conn->prepare($sql);


if ($stmt->execute()) {
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {

        echo '<p style="margin:25px">Username '.htmlspecialchars($row['Username'])  .'</p>';
        echo '<p style="margin:25px">Name '.htmlspecialchars($row['Name']).'</p>';
        echo '<p style="margin:25px">Password'.htmlspecialchars($row['Password']).'</p>';
        echo '<p style="margin:25px">Role '.htmlspecialchars($row['RoleName']).'</p>';
        echo '<p style="margin:25px">Email '.htmlspecialchars($row['Email']).'</p>';
        Echo '<a href="ViewUser.php?id=' .$row['ID'] .'">View User</a>';
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
