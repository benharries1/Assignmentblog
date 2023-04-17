<?php
//provide the username and the server name of the SQL database
$server_name ='localhost' ;
$username = 'root';
$password ='';
//Establish a connection with the SQL database
$conn = new mysqli($server_name, $username, $password);
session_start();
$sessionfile = ini_get('session.save_path') . '/' . 'sess_'.session_id();
echo 'session file: ', $sessionfile, ' ';
echo 'size: ', filesize($sessionfile), "\n";
//if ($conn->connect_error) {
//    die("Connection Failed: " . $conn-> connect_error);
//}
//else {
//    echo "Connection successful!";
//}


?>
<html lang="en">
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
    $DB_user_id = $row['ID'];
    $DB_username = $row['Username'];
    $DB_password = $row['Password'];
    $DB_name = $row['Name'];
    $DB_email = $row['Email'];


    //This function checks to see if the hash of the password is the same as the one entered by the user
    if($_POST['password']==$DB_password){
        //Adds session variables from the values of the database table.
        $_SESSION['UserID'] = $DB_user_id;
        $_SESSION['Username'] = $DB_username;
        $_SESSION['Name'] = $DB_name;
        $_SESSION['email'] = $DB_email;
        //Once set, the user is then redirected to the home page after logging in successfully.
        header("location: blog/CreateBlog.php");
    } else {
        echo "Login Unsuccessful - Please try again";
    }
}
?>