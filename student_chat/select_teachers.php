<?php
session_start();
if (isset($_SESSION['s_id'])) {

    include_once "../connection.php";

    $sql = "SELECT * FROM `teachers` where `is_deleted`= 0";
    $query = mysqli_query($Conn, $sql);
    $output = "";
    if (mysqli_num_rows($query) == 0) {
        $output .= "No teachers are available to chat";
    } elseif (mysqli_num_rows($query) > 0) {
        include_once "data.php";
    }
    echo $output;
} else {

    header("location:../login.php");
}
?>
