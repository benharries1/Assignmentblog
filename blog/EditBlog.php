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
session_start();

//If the session has not been set (user not logged in), then the user is redirected home
//if(!isset($_SESSION['username'])){
//    header("location: ..\index.php");
//}
?>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
<?php

$sql = "SELECT * FROM CyberSecurityBlog.Blogs  WHERE blogs.ID= ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_GET['id']);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        //RoleID 3 is Moderator
        if($_SESSION['RoleID'] == 3 or $_SESSION['UserID'] == $row['UserID'])
        {
            echo '<form action="EditBlog.php" method="post">';
            echo '<input type="hidden" id="id" name="id" value="' . $_GET['id'] . '">';
            echo '<div class="mb-3">';
            echo '<label for="title" class="form-label">title</label>';
            echo '<input type="text" class="form-control" id="title" name="title" value="' . htmlspecialchars($row['Title'])  . '">';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="content" class="form-label">content</label>';
            echo '<input type="text" class="form-control" id="content" name="content" value="' . htmlspecialchars($row['Content']) . '">';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="Enabled" class="form-label">Enabled</label>';
            echo '<input type="text" class="form-control" id="Enabled" name="Enabled" value="' . htmlspecialchars($row['Enabled']) . '">';
            echo'</div>';
            echo '<button type="submit" class="btn btn-primary">Submit</button>';
            echo '</form>';
        }
        else
        {
            Echo '<p>You do not have permission to perform this action</p>';
        }
    }
}

//Checks to see if the username is set#
if(isset($_POST['title']) & isset($_POST['content']) & isset($_POST['Enabled'])){
    echo 'here!';
    //Inserts the user details and password into the table
    $sql = "UPDATE CyberSecurityBlog.Blogs set Title=?, Content=?,Enabled=? WHERE id = ?";

    $stmt = $conn->prepare($sql);
    //Binds the parameters into the SQL query.



    $stmt->bind_param('ssss', $_POST['title'], $_POST['content'], $_POST['Enabled'],$_POST['id'] );
    //If the SQL statement executes successfully, the user will be registered and will be greeted with the following.
    if ($stmt->execute()) {
        header("location: ../blog/ViewBlog.php?id=" . $_POST['id']);
    }
    else
    {
        echo 'Posting failed. Please try again, if this continues, please contact an administrator.';
    }
}
?>


</body>
</html>
