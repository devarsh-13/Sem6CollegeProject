<?php
include'../ec_dc.php';  
session_start();
$obj = new ecdc();
if (isset($_SESSION['t_id'])) {

    include_once "../Database/connection.php";
    



    $T_srn = $_SESSION['t_id'];
    
    $output = "";
   


    $chat_query = mysqli_query($Conn, "SELECT * FROM `conversation` inner join `students` ON conversation.S_srn=students.S_srn WHERE `T_srn`='$T_srn' and `is_c_deleted`='0'  ");

    if (mysqli_num_rows($chat_query) > 0) {
        while ($row = mysqli_fetch_assoc($chat_query)) {
            if ($row['sender_type'] === "T") {
                $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>' . $obj->decrypt($row['chat_text']) . '</p>
                                </div>
                                </div>';
            } else {
                $output .= '<div class="chat incoming">
                              
                                <div class="details">
                                    <p>' . $obj->decrypt($row['chat_text']) . '</p>
                                </div>
                                </div>';
            }
        }
    } else {
        $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
    }
    echo $output;
} else {
    header("location: ../teacher/teacher_login.php");
}
