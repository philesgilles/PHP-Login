<?php
session_start();
// Include config file
require_once "../config/db_config.php";

$id  = $_SESSION['id'];
$sql = "DELETE FROM students WHERE id = '$id';";
if (mysqli_query($link, $sql)) {
    $_SESSION = array();
    session_destroy();
    header('Location: login.php');
} else {
    echo "Error deleting record: " . mysqli_error($link);
}
mysqli_close($link);