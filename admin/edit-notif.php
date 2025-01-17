<?php
session_start();
error_reporting(0);
include('../connection.php');
include('store_data.php');
include('../ec_dc.php');
$obj = new ecdc();
$log=new Log();

if(strlen($_SESSION['a_id'])=="")
{   
    header("Location: index.php"); 
    $action="In Edit Notifications";
    $log->success_entry($action,$Conn,"Unsuccessful");
}
else
{
    if(!(isset($_POST['submit'])))
    {
        $action="In Edit Notifications";
        $log->success_entry($action,$Conn);
    }

    $nid=$obj->decrypt($_GET['N_id']);
    
    if(isset($_POST['submit']))
    {
        $nt = $_POST["nt"];
        $notification_text = $_POST["notification"];
        $a = $_SESSION['a_id'];  
        $d = date("Y-m-d");
    
        $Sql="UPDATE `notification` SET `Notification_topic`='$nt', `Notification_text`='$notification_text',`is_deleted`='0',`created_on`='$d',`created_by`='$a' WHERE `Sr_n`='$nid'";

        $q=mysqli_query($Conn,$Sql);
        
              
        $action="Notifications Edited";
        if($q)
        {
            
            $log->success_entry($action,$Conn);
            echo "<script>alert('Notification Edit Successfully.');window.location.href='manage-notif.php';</script>";

        }
        else 
        {
         
            $log->success_entry($action,$Conn,"Unsuccessful");
            echo "<script>alert('Failed To Edit Notification.');window.location.href='manage-notif.php';</script>";
        }

    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Notification | IGHS</title>
     
    <link rel="stylesheet" href="../teacher/css/bootstrap.min.css" media="screen" >
    <link rel="stylesheet" href="../teacher/css/font-awesome.min.css" media="screen" >
    <link rel="stylesheet" href="../teacher/css/animate-css/animate.min.css" media="screen" >
    <link rel="stylesheet" href="../teacher/css/main.css" media="screen" >
    <script src="../teacher/js/modernizr/modernizr.min.js"></script>


    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="../teacher/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../teacher/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../teacher/assets/css/themify-icons.css">
    <link rel="stylesheet" href="../teacher/assets/css/metisMenu.css">
    <link rel="stylesheet" href="../teacher/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../teacher/assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="../teacher/assets/css/typography.css">
    <link rel="stylesheet" href="../teacher/assets/css/default-css.css">
    <link rel="stylesheet" href="../teacher/assets/css/styles.css">
    <link rel="stylesheet" href="../teacher/assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="../teacher/assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <style type="text/css">
        .section
        {
            background-color: white;
            margin-top: 3%;
        }
    </style>

</head>

<body class="top-navbar-fixed">
   <div id="preloader">
        <div class="loader"></div>
    </div>
    <div class="page-container">
       <?php include('leftbar.php'); ?>
    <div class="main-content">
         <?php include('topbar.php'); ?>



      
        <!-- page title area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <ul class="breadcrumbs pull-left">
                          <h4 class="page-title pull-left">Edit Notification</h4>
                                <li><a href="dashboard.php">Home</a></li>
                                
                                <li><span>Edit Notification</span></li>
                            </ul>
                   
                </div>
            </div>
              <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <span>Fill The Notification Info.</span>
                                        </div>
                                    </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <!-- MAIN CONTENT GOES HERE -->

                                    <div class="panel-body">
                                        <?php if($msg){?>
                                        <div class="alert alert-success left-icon-alert" role="alert">
                                            
                                            <?php echo htmlentities($msg); ?>
                                        </div>
                                        <?php } 
else if($error){?>
                                        <div class="alert alert-danger left-icon-alert" role="alert">
                                            
                                            <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                        <form class="form-horizontal" method="post">
<?php 
 $sql = "SELECT * from `notification` WHERE `Sr_n`='$nid'";
$query = mysqli_query($Conn,$sql);

$row = mysqli_num_rows($query);
$cnt=1;
if($row > 0)
{
 while($result=mysqli_fetch_array($query))
    {   ?>
                                             <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Enter Notification Topic</label>
                                                <div class="col-sm-10">
                                             <input type="text" name="nt" class="form-control" id="nt" required="required" value="<?php echo htmlentities($result['Notification_topic']);?>" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Enter Notification</label>
                                                <div class="col-sm-10">
                                                     <textarea rows="5"  name="notification" class="form-control" id="notification" required="required" autocomplete="off"><?php echo htmlentities($result['Notification_text'])?></textarea>
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                            <?php
                                        }}
                                            ?>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                    </div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
      

   <!-- jquery latest version -->
    <script src="../teacher/assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="../teacher/assets/js/popper.min.js"></script>
    <script src="../teacher/assets/js/bootstrap.min.js"></script>
    <script src="../teacher/assets/js/owl.carousel.min.js"></script>
    <script src="../teacher/assets/js/metisMenu.min.js"></script>
    <script src="../teacher/assets/js/jquery.slimscroll.min.js"></script>
    <script src="../teacher/assets/js/jquery.slicknav.min.js"></script>

    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
        zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
        ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <!-- all line chart activation -->
    <script src="../teacher/assets/js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="../teacher/assets/js/pie-chart.js"></script>
    <!-- others plugins -->
    <script src="../teacher/assets/js/plugins.js"></script>
    <script src="../teacher/assets/js/scripts.js"></script>

</body>

</html>
<?PHP } ?>
