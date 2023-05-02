<?php
//Provide the username and the server name of the SQL database
$server_name = 'localhost';
$username = 'Databaseadmin';
$password = 'Astrongpassword1';
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

$sql = "SELECT CyberSecurityBlog.Blogs.*, CyberSecurityBlog.Users.Name FROM CyberSecurityBlog.Blogs INNER JOIN CyberSecurityBlog.Users ON Users.ID=blogs.userID WHERE blogs.ID= ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_GET['id']);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    echo '<div class="container py-5">';
    echo '<div class="row row-cols-md-9 g-4">';
    while($row = $result->fetch_assoc()) {

        if (!$row['Enabled'])
        {
            echo '<div class="alert alert-danger" role="alert">';
            echo 'Blog has been deleted';
            echo '</div>';
        }



        if ($row['Enabled'] or $_SESSION['RoleID']==3)
        {

            echo '<div class="col">';
            echo '<div class="card h-100">';
            echo '<div class="card-header">'.htmlspecialchars($row['Content']).'</div>';
            echo '<div class="card-body">';
            echo '<p class="card-text">'.htmlspecialchars($row['Content']).'</p>';

            echo '</div>';
            echo '<div class="card-footer">';
            echo '<small class="text-body-secondary">Created By: '.htmlspecialchars($row['Name'])  .'on ' .htmlspecialchars($row['Timestamp']). '</small>';
            if($_SESSION['RoleID'] == 3 or $_SESSION['UserID'] == $row['UserID'])
            {
                echo '<a class="btn btn-primary btn-sm float-end" href="EditBlog.php?id='. $_GET['id'] .'">Edit Blog</a>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';


        }
    }
    echo'</div>';
    Echo '<a class="btn btn-primary btn-sm mt-3 float-end" href="ViewAll.php">Return to blog</a>';
    echo'</div>';


}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>