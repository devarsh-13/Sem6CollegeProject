<?php
    session_start();
   // include_once "config.php";
   include_once "../Database/connection.php";
    // $outgoing_id = $_SESSION['unique_id'];
  //  $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} ORDER BY user_id DESC";
    $sql = "SELECT * FROM `teachers` where 'is_deleted'= 0";
    $query = mysqli_query($Conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No users are available to chat";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }
    echo $output;
?>