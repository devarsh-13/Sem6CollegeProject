<?php 
  session_start();
  include_once "../Database/connection.php";
  if(!isset($_SESSION['id'])){
    header("location: ../login.php");
  }
?>
<?php include_once "teacher_head.php"; ?>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php 
          $student_id = mysqli_real_escape_string($Conn, $_GET['student_id']);


          $_SESSION['s_id']=$student_id;
          
          $sql = mysqli_query($Conn, "SELECT * FROM `students` WHERE `S_srn` = {$student_id}");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
          }else{
            header("location: select_students.php");
          }
        ?>
        <a href=" select_students.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <!-- <img src="php/images/<?php// echo $row['img']; ?>" alt=""> -->
        <div class="details">
          <span><?php echo $row['S_name'] ?></span>
          <p><?php echo $row['s_status']; ?></p>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $student_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <script src="teacher_chat.js"></script>

</body>
</html>