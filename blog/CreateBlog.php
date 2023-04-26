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
echo $_SESSION['UserID'];
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
<form action="CreateBlog.php" method="post">
    <div class="mb-3">
        <label for="title" class="form-label">title</label>
        <input type="text" class="form-control" id="title" name="title">
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">content</label>
        <input type="text" class="form-control" id="content" name="content">
    </div>



    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php

//Checks to see if the username is set#
if(isset($_POST['title']) & isset($_POST['content'])){
    //Inserts the user details and password into the table
    $sql = "INSERT INTO CyberSecurityBlog.Blogs ( Title, `Content`,  `UserID`) VALUES (?,?,?)";

    $stmt = $conn->prepare($sql);
    //Binds the parameters into the SQL query.

    echo $_SESSION['userid'];

    $stmt->bind_param('sss', $_POST['title'], $_POST['content'],  $_SESSION['UserID']);
    //If the SQL statement executes successfully, the user will be registered and will be greeted with the following.
    if ($stmt->execute()) {
        $id = $conn->insert_id;
        header("location: ../blog/ViewBlog.php?id=" . $id);
    }
    else
    {
        echo 'Posting failed. Please try again, if this continues, please contact an administrator.';
    }
}
?>
</body>
</html>


