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
if($_SESSION['RoleID'] == 3 ) {


    $sql = "SELECT CyberSecurityBlog.Users.*,CyberSecurityBlog.roles.name As RoleName FROM CyberSecurityBlog.Users INNER JOIN CyberSecurityBlog.Roles ON Users.RoleID=roles.ID WHERE Users.ID= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $_GET['id']);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {


            echo '<form action="EditUser.php" method="post">';
            echo '<input type="hidden" id="ID" name="ID" value="' . $_GET['id'] . '">';
            echo '<div class="mb-3">';
            echo '<label for="Username" class="form-label">Username</label>';
            echo '<input type="text" class="form-control" id="Username" name="Username" value="' . htmlspecialchars($row['Username']) . '">';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="Name" class="form-label">name</label>';
            echo '<input type="text" class="form-control" id="Name" name="Name" value="' . htmlspecialchars($row['Name']) . '">';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="Password" class="form-label">password</label>';
            echo '<input type="text" class="form-control" id="Password" name="Password" value="' . htmlspecialchars($row['Password']) . '">';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="RoleID" class="form-label">RoleID</label>';
            echo '<input type="text" class="form-control" id="RoleID" name="RoleID" value="' . htmlspecialchars($row['RoleID']) . '">';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="Email" class="form-label">Email</label>';
            echo '<input type="text" class="form-control" id="Email" name="Email" value="' . htmlspecialchars($row['Email']) . '">';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="Enabled" class="form-label">Enabled</label>';
            echo '<input type="text" class="form-control" id="Enabled" name="Enabled" value="' . htmlspecialchars($row['Enabled']) . '">';
            echo '</div>';
            echo '<button type="submit" class="btn btn-primary">Submit</button>';
            echo '</form>';

        };

    };


//Checks to see if the username is set#
    if (isset($_POST['Username']) & isset($_POST['Name']) & isset($_POST['Password']) & isset($_POST['Email']) & isset($_POST['RoleID']) & isset($_POST['Password']) & isset($_POST['Enabled'])) {
        //Inserts the user details and password into the table
        $sql = "UPDATE CyberSecurityBlog.Users set Username=?, Name=?, RoleID=?, Email=?, Password=?,Enabled=? WHERE id = ?";

        $stmt = $conn->prepare($sql);
        //Binds the parameters into the SQL query.


        $hashPassword = sha1($_POST['Password']);
        $stmt->bind_param('sssssss', $_POST['Username'], $_POST['Name'], $_POST['RoleID'], $_POST['Email'], $hashPassword, $_POST['Enabled'], $_POST['ID']);
        //If the SQL statement executes successfully, the user will be registered and will be greeted with the following.

        if ($stmt->execute()) {
            header("location: ../admin/ViewUser.php?id=" . $_POST['ID']);
        } else {
            echo 'Posting failed. Please try again, if this continues, please contact an administrator.';
        }
    }
}
else
{
    Echo 'You have not got permission to do this';
}
?>

    </body>
</html>

