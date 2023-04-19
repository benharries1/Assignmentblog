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

$sql = "SELECT CyberSecurityBlog.Blogs.*, CyberSecurityBlog.Users.Name FROM CyberSecurityBlog.Blogs INNER JOIN CyberSecurityBlog.Users ON Users.ID=blogs.userID ";
$stmt = $conn->prepare($sql);


if ($stmt->execute()) {
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        echo '<h1 style="margin:25px">'.
            ($row['Title']).'</h1>';
        echo '<p style="margin:25px">'.htmlspecialchars($row['Content']).'</p>';
        echo '<p style="margin:25px">Created By: '.htmlspecialchars($row['Name'])  .'</p>';
        echo '<p style="margin:25px">Date Created: '.htmlspecialchars($row['Timestamp']).'</p>';
Echo '<a href="ViewBlog.php?id='.htmlspecialchars($row['ID']).'">read post</a>';

    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>