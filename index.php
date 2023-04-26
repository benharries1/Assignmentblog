<?php
//provide the username and the server name of the SQL database
$server_name ='localhost' ;
$username = 'root';
$password ='';
//Establish a connection with the SQL database
$conn = new mysqli($server_name, $username, $password);
session_start();

//if ($conn->connect_error) {
//    die("Connection Failed: " . $conn-> connect_error);
//}
//else {
//    echo "Connection successful!";
//}


?>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
<form action="index.php" method="post">
    <p>Username: <input type="text" name="username"></p>
    <p>Password: <input type="password" name="password"></p>
    <p><input type="submit"/></p>
</form>
</body>
</html>
<?php

//This will check to see if the user has pressed the submit button and the values are set
if(isset($_POST['username']) & isset($_POST['password'])){

    //We select all the values from the database table where the username is the same that the user entered
    $stmt = $conn->prepare("SELECT * from CyberSecurityBlog.Users WHERE username = ?");
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    //Get all the values from the table and store them as variables
    $DB_UserID = $row['ID'];
    $DB_Username = $row['Username'];
    $DB_Password = $row['Password'];
    $DB_Name = $row['Name'];
    $DB_Email = $row['Email'];
    $DB_RoleID = $row['RoleID'];
    $DB_Enabled = $row['Enabled'];


    //This function checks to see if the hash of the password is the same as the one entered by the user
    if(sha1($_POST['password'])==$DB_Password & $DB_Enabled == 1){
        //Adds session variables from the values of the database table.
        $_SESSION['UserID'] = $DB_UserID;
        $_SESSION['Username'] = $DB_Username;
        $_SESSION['Name'] = $DB_Name;
        $_SESSION['Email'] = $DB_Email;
        $_SESSION['RoleID'] = $DB_RoleID;
        //Once set, the user is then redirected to the home page after logging in successfully.
        header("location: blog/ViewAll.php");
    } else {
        echo sha1($_POST['password']) . '<br>';
        echo $DB_Password. '<br>';
        echo $DB_Enabled. '<br>';


        echo "Login Unsuccessful - Please try again";
    }
}
?>