<?php
session_start();
include_once "./Database/connection.php";

$S_srn = $_SESSION['id'];


//   if(!isset($_SESSION['unique_id'])){
//     header("location: login.php");
//   }
?>
<?php include_once "chat_header.php"; ?>

<body>
    <div class="wrapper">
        <section class="users">
            <header>
                <div class="content">
                    <?php

                    $sql = "SELECT * FROM `teachers` where 'is_deleted'= 0";

                    $query = mysqli_query($Conn, $sql);


                    if (mysqli_num_rows($query) > 0) {
                        $row = mysqli_fetch_assoc($query);
                    }
                    ?>
                    <img src="php/images/" alt="">
                    <div class="details">

                    </div>
                </div>
                <a href="php/logout.php?logout_id=<?php //echo $row['unique_id']; 
                                                    ?>" class="logout">Logout</a>
            </header>
            <div class="search">
                <span class="text">Select an user to start chat</span>
                <input type="text" placeholder="Enter name to search...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="users-list">
                <span><?php echo $row['T_name'];
                        ?></span>
                <p><?php //echo $row['status']; 
                    ?></p>
            </div>
        </section>
    </div>

    <script src="js/show_users.js"></script>

</body>

</html>