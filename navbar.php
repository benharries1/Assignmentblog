<?php
 session_start();
?>

<nav class="navbar bg-primary navbar-expand-lg">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php
                if ($_SESSION['UserID'] == NULL)
                {
                    echo ' <li class="nav-item">';
                    echo ' <a class="nav-link active" aria-current="page" href="../">Login</a>';
                    echo ' </li>';
                }
                ?>
                <?php
                if ($_SESSION['UserID'] != NULL) {
                    echo ' <li class="nav-item">';
                    echo '<a class="nav-link" href="../Logout.php">Logout</a>';
                    echo ' </li>';
                }
                ?>
                <?php
                   echo ' <li class="nav-item">';
                       echo ' <a class="nav-link" href="../register.php">Register</a>';
                   echo '</li>';
                ?>
                <?php
                if($_SESSION['RoleID'] == 3)
                {
               echo '<li class="nav-item">';
                 echo '  <a class="nav-link" href="../admin">Admin</a>';
               echo ' </li>';
                }
                ?>
                <?php
                echo ' <li class="nav-item">';
                echo ' <a class="nav-link" href="../blog/ViewAll.php">View Blogs</a>';
                echo '</li>';
                ?>

            </ul>
        </div>
    </div>
</nav>