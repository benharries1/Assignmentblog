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
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>

<div class="container container py-5">

    <div class="row align-items-center">
        <div class="col col-4"></div>
        <div class="col col-4 align-self-center">

            <div class="card">
                <div class="card-header">
                    Register
                </div>
                <div class="card-body">
                    <form action="register.php" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <button type="submit" class="d-grid btn btn-primary mx-auto">Submit</button>
                    </form>
                </div>
            </div>






        </div>
    </div>
</div>





<?php
//Checks to see if the username is set
if(isset($_POST['username'])) {

    //Inserts the user details and password into the table
    $sql = "INSERT INTO CyberSecurityBlog.Users ( `username`, `name`,  `email`, `password`) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    //Binds the parameters into the SQL query.
    $hashPassword = sha1($_POST['password']);
    $stmt->bind_param('ssss', $_POST['username'], $_POST['name'],  $_POST['email'], $hashPassword);
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
</body>
</html>


