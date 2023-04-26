<?php
session_start();

session_destroy();

echo "You have been logged out successfully. ";

echo "<a href='..\index.php'>Return to home page</a>";