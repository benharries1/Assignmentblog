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
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
<?php

$sql = "SELECT CyberSecurityBlog.Blogs.*, CyberSecurityBlog.Users.Name FROM CyberSecurityBlog.Blogs INNER JOIN CyberSecurityBlog.Users ON Users.ID=blogs.userID WHERE blogs.ID= ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_GET['id']);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        if ($row['Enabled'])
        {
            echo '<h1 style="margin:25px">'.htmlspecialchars($row['Title']).'</h1>';
            echo '<p style="margin:25px">'.htmlspecialchars($row['Content']).'</p>';
            echo '<p style="margin:25px">Created By: '.htmlspecialchars($row['Name'])  .'</p>';
            echo '<p style="margin:25px">Date Created: '.htmlspecialchars($row['Timestamp']).'</p>';
            Echo '<a href="ViewAll.php">return to blog </a>';
            if($_SESSION['RoleID'] == 3 or $_SESSION['UserID'] == $row['UserID'])
            {
                Echo '<a href="EditBlog.php?id=' . $_GET['id'] . '">edit blog </a>';
            }

        }
        else
        {
            echo '<p>Blog has been deleted</p>';

        }

    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>