

<?php
session_start();
error_reporting(0);
include('connection.php');
if(strlen($_SESSION['a_id'])=="")
    {   
    header("Location: index.php"); 
    }
    else{

$gid = $_GET['G_id'];

    if (isset($gid))
    {


        
 $sql = "SELECT * from `images`  WHERE `Id`='$gid' ";
$query = mysqli_query($Conn,$sql);
$row = mysqli_num_rows($query);

if($row > 0)
{
     $path="img/";
    while($result=mysqli_fetch_array($query))
    {       $full = $path.$result['Image']; 
          $d=  unlink($full);
    }
}
        $query = "DELETE FROM `images` WHERE `Id`='$gid'";
        $delet = mysqli_query($Conn,$query) or die("Error in query2".$Conn->error);

if($d)
{
    
$msg="Image Deleted Successfully";
}
else 
{
    
$error="Something went wrong. Please try again";
}

}





 if(isset($_POST['delt']))
            {

                $gid=$_POST['recordsCheckBox'];
  foreach ( $gid as $id ) 
{ 
 $sql = "SELECT * from `images`  WHERE `Id`='$id' ";
$query = mysqli_query($Conn,$sql);


     $path="img/";
    while($result=mysqli_fetch_array($query))
    {       $full = $path.$result['Image']; 
          $d=  unlink($full);
    }

}


                   foreach ( $gid as $id ) 
                   { 
                          $query = "DELETE FROM `images` WHERE `Id`='$id'";
                        $result = $Conn->query($query) or die("Error in query".$Conn->error);
                   }


if($d)
{
$msg="Image Deleted Successfully";
}
else 
{
$error="Something went wrong. Please try again";
}
            }








?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>IGHS Admin | Manage Classes</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" > <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>



<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>



<link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />


<script type="text/javascript">
    $(document).ready(function() {
    $('#example').DataTable( {
       
        });
});
</script>
          <style>
        .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}

  
    .scrollmenu table
    {
        
        background-color: #ddd;
        
    }
    .scrollmenu th,td
    {
        border: 1px solid black;
    }

.dl button
{

    float: right;
    margin-top: 10px;
    margin-right: 10px;
}
input.chh
{
    width: 20px;
    height: 20px;
    
}
        </style>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
   <?php include('includes/topbar.php');?> 
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">
<?php include('includes/leftbar.php');?>  

                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Manage Gallery</h2>
                                
                                </div>
                                <div class="dl">
                                                    <form method="post" action="manage-gallery.php">
                                                          <button type="submit" name="delt" class="btn btn-danger">Delete</button>
                                                    
                                                </div>s
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
            							<li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Gallery</li>
            							<li class="active">Manage Gallery</li>
            						</ul>
                                </div>
                             
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->

                        <section class="section">
                            <div class="container-fluid">

                             

                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="panel">
                                            <div class="panel-heading">
                                                 
                                                <div class="panel-title">
                                                    <h5>View Gallery Info</h5>
                                                </div>
                                            </div>
<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <?php echo htmlentities($msg); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                         <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                            <div class="scrollmenu">

                                             <table id="example" class="display nowrap" >
                                                <thead>
                                                        <tr>
                                                            
                                                            <th>Sr.No</th>
                                                            <th>Action</th>
                                                            <th>image</th>
                                                            <th>Created Date</th>
                                                            <th>Created By</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    
                                                   
                                                    
<?php
include 'connection.php';
 $sql = "SELECT * from `images` ORDER BY Uploaded_on DESC";
$query = mysqli_query($Conn,$sql);
$row = mysqli_num_rows($query);
$cnt=1;
if($row > 0)
{
     $path="img/";
    while($result=mysqli_fetch_array($query))
    {       $full = $path.$result['Image']; ?>
                    <tr>
                          <td><?php echo htmlentities($cnt);?></td>
                          <td> <a href="manage-gallery.php?G_id=<?php echo $result['Id'];?>">
                              <img src="images/delete-icon.jpg" height="25px" width='25px'/>&nbsp;Delete</a>  &nbsp;
                              <input type="checkbox" name="recordsCheckBox[]" id="recordsCheckBox" class="chh" value="<?php echo $result['Id'];?>"></td>
                        <td> <img src="<?php echo $full; ?>" height="100px" width="100px"></img></td>
                        <td><?php echo $result['Uploaded_on'];?></td>
                        <td><?php
                                $id=$result['Uploaded_by'];
                                 $q=mysqli_query($Conn,"SELECT `A_name` FROM `admin` WHERE `A_id` = '$id' ");
                                 $name=mysqli_fetch_array($q);
                                echo $name[0];
                            ?></td>
                       
                    </tr>
<?php 
   $cnt=$cnt+1; }
} ?>
                                                       
                                                    
                                                    
                                                </table>

                                         
                                                <!-- /.col-md-12 -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-6 -->

                                                               
                                                </div>
                                                <!-- /.col-md-12 -->
                                            </div>
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    <!-- /.col-md-6 -->

                                </div>
                                <!-- /.row -->

                            </div>
                            <!-- /.container-fluid -->
                        </section>
                        <!-- /.section -->

                    </div>
                    <!-- /.main-page -->

                    

                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /.main-wrapper -->

        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <script src="js/DataTables/datatables.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $('#example').DataTable();

                $('#example2').DataTable( {
                    "scrollY":        "300px",
                    "scrollCollapse": true,
                    "paging":         false
                } );

                $('#example3').DataTable();
            });
        </script>
    </body>
</html>
<?php } ?>
