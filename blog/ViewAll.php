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
include '../navbar.php';

$sql = "SELECT CyberSecurityBlog.Blogs.*, CyberSecurityBlog.Users.Name FROM CyberSecurityBlog.Blogs INNER JOIN CyberSecurityBlog.Users ON Users.ID=blogs.userID";
$stmt = $conn->prepare($sql);


if ($stmt->execute()) {
    $result = $stmt->get_result();
    echo '<div class="container py-5">';
    echo '<div class="row">';
        echo '<a class= "btn btn-primary btn-sm float-end" href="Createblog.php">Create Post</a>';
    echo '</div>';
    echo '<div class="row row-cols-1 row-cols-md-3 g-4 py-5">';

    while($row = $result->fetch_assoc()) {

        if($row['Enabled'] or $_SESSION['RoleID']==3)
        {
            echo '<div class="col">';
            echo '<div class="card h-100">';
            echo '<div class="card-header ' . ($row['Enabled'] ? '' : 'text-bg-danger') . '" >'.htmlspecialchars($row['Title']).'</div>';
            echo '<div class="card-body">';
            echo '<p class="card-text">'. substr($row['Content'],0,100) .'...</p>';

            echo '</div>';
            echo '<div class="card-footer">';
            echo '<small class="text-body-secondary">Created By: '.htmlspecialchars($row['Name'])  .'on ' .htmlspecialchars($row['Timestamp']). '</small>';
            echo '<a class="btn btn-primary btn-sm float-end" href="ViewBlog.php?id='.htmlspecialchars($row['ID']).'">Read post</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }

    echo '</div>';
    echo '</div>';

}
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>