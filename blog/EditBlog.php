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
<html lang="en">
<body>
<?php

$sql = "SELECT * FROM CyberSecurityBlog.Blogs INNER JOIN CyberSecurityBlog.Users ON Users.ID=blogs.userID WHERE blogs.ID= ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_GET['id']);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
//        echo '<h1 style="margin:25px">'.htmlspecialchars($row['Title']).'</h1>';
//        echo '<p style="margin:25px">'.htmlspecialchars($row['Content']).'</p>';
//        echo '<p style="margin:25px">Created By: '.htmlspecialchars($row['Name'])  .'</p>';
//        echo '<p style="margin:25px">Date Created: '.htmlspecialchars($row['Timestamp']).'</p>';
//        Echo '<a href="ViewAll.php">return to blog </a>';



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
            echo '<button type="submit" class="btn btn-primary">Submit</button>';
        echo '</form>';

    }
}

//Checks to see if the username is set#
if(isset($_POST['title']) & isset($_POST['content'])){
    echo 'here!';
    //Inserts the user details and password into the table
    $sql = "UPDATE CyberSecurityBlog.Blogs set Title=?, Content=? WHERE id = ?";

    $stmt = $conn->prepare($sql);
    //Binds the parameters into the SQL query.



    $stmt->bind_param('sss', $_POST['title'], $_POST['content'] ,$_POST['id'] );
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
