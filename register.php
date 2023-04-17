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
//If the session has been set, then the user is redirected home
if (isset($_SESSION['username'])) {
    header("location: ..\index.php");
}
?>
<html lang="en">
<body>
<form action="register.php" method="post">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username">
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">name</label>
        <input type="text" class="form-control" id="name" name="name">
    </div>


    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="password">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php
//Checks to see if the username is set
if(isset($_POST['username'])) {

    //Inserts the user details and password into the table
    $sql = "INSERT INTO CyberSecurityBlog.Users ( `username`, `name`,  `email`, `password`) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    //Binds the parameters into the SQL query.
    $stmt->bind_param('ssss', $_POST['username'], $_POST['name'],  $_POST['email'], $_POST['password']);
    //If the SQL statement executes successfully, the user will be registered and will be greeted with the following.
    if ($stmt->execute()) {
        echo $_POST['username'] . ' Registered Successfully!';
    }
    else
    {
        echo 'Registration failed. Please try again, if this continues, please contact an administrator.';
    }
}
?>



