<?php
session_start();
error_reporting(0);
require('../connection.php');
require "../vendor/autoload.php";
require "store_data.php";
require "../ec_dc.php";



if(strlen($_SESSION['a_id'])=="")
{   
    header("Location: index.php"); 
}
else
{

function get_pass($p2)
{
    $p1=rand(100,999);

    $p3 = $p1."_".$p2;
    return $p3;
}


  if(isset($_POST['submit']))
  {
    
    $ex=pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
       
    if($ex=="xlsx" || $ex=="Xlsx")
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $d=$spreadsheet->getSheet(0)->toArray();
    
        $obj=new Upload();

        $ec = new ecdc();

        $em=$obj->Check_empty($d,$Conn);
        if(sizeof($em)==1)
        {
            $rep=$obj->Check_repeatation($d,$Conn);


            if(sizeof($rep)>=1)
            {
                $error="Data is not updated at row :";

                for ($lines=1; $lines<sizeof($rep); $lines++) 
                { 
                    $error=$error." $rep[$lines],";
                }  
                $error=$error." in Uploaded file";
            }
            else
            {
            	
                $j=0;
                foreach ($d as $t) 
                {
                    if($j==0)
                    {
                        // $gr     =t[0])
                        // $uid    =t[1])
                        // $name   =t[2])
                        // $cast   =t[5])
                        // $cate   =t[6])
                        // $dob    =t[7])
                        // $cont   =t[9])
                        // $ad_date=t[8])
                        // $cls    =t[3])
                        // $stream =t[4])
                        // $adhar  =t[10]
                        // $hos    =t[12]
                        // $hom    =t[11]
                        // $handi  =t[13]
                        // $des    =t[14]
                        // $remarks=t[15]
                        // $ay     =t[16]

                        //$i

                        if($t[0]=="Gr no." && $t[1]=="UID no." && $t[2]=="Name" && $t[5]=="Caste" && $t[6]=="Category" && $t[7]=="DOB" && $t[9]=="Contact no." && $t[8]=="Admission date" && $t[3]=="Class" && $t[4]=="Stream" && $t[10]=="Adhar no." && $t[12]=="Hostel Address" && $t[11]=="Home Address" && $t[13]=="Handicapped" && $t[14]=="Describe" && $t[15]=="Remarks" && $t[16]=="Academic Year")
                        {
                            $flag1=1;
                        }
                        else
                        {
                           $flag1=0;
                        }
                    }
                    if($flag1==0)
                    {
                          echo "<script>alert('Invalid File Please upload a valid file.');window.location.href='pro_stu.php';</script>"; 
                    }
                    else
                    {

                        if($j>0)
                        {
                            if($t[4]=='-' || $t[4]==' ')
                            {
                                $t[4]=NULL;
                            }

                            $q=mysqli_query($Conn,"SELECT `Class_id` FROM `class` WHERE `C_no`='$t[3]' AND `Stream`='$t[4]' ");
                            $c_id=mysqli_fetch_array($q);

                            $q2=mysqli_query($Conn, "SELECT `S_password` FROM `students` WHERE `S_contact`=$t[9] AND `is_deleted`='0' AND `updated`='1' ");
                            $raw_pass=mysqli_fetch_row($q2);

                            if(isset($raw_pass['0']))
                            {
                                $pass=$raw_pass['0'];
                            }
                            else
                            {
                                $pass = $ec->encrypt(get_pass($t[0]));    
                            }

                                    $gr     =$Conn->real_escape_string($t[0]);
                                    $uid    =$Conn->real_escape_string($t[1]);
                                    $name   =$Conn->real_escape_string($t[2]);
                                    $cast   =$Conn->real_escape_string($t[5]);
                                    $cate   =$Conn->real_escape_string($t[6]);
                                    $dob    =$Conn->real_escape_string($t[7]);
                                    $cont   =$Conn->real_escape_string($t[9]);
                                    $ad_date=$Conn->real_escape_string($t[8]);
                                    $cid    =$Conn->real_escape_string($c_id[0]);

                                    $adhar  =$Conn->real_escape_string($t[10]);
                                    $hos    =$Conn->real_escape_string($t[12]);
                                    $hom    =$Conn->real_escape_string($t[11]);
                                    $handi  =$Conn->real_escape_string($t[13]);
                                    $des    =$Conn->real_escape_string($t[14]);
                                    $pass   =$Conn->real_escape_string($pass);
                                    $remarks=$Conn->real_escape_string($t[15]);

                                    $ay     =$Conn->real_escape_string($t[16]);
                                    

                                    $ok=$obj->Store_student($gr,$uid,$name,$cast,$cate,$dob,$cont,$ad_date,$cid,$adhar,$hos,$hom,$handi,$des,$pass,$remarks,$ay,$Conn);
                        }
                        $j++;
                    
                    }
                }
                for($k=0;$k<=10;$k++)
                {
                    $query=mysqli_query($Conn,"UPDATE `students` SET`updated`='2' WHERE `Class_id`='$k' AND `updated`='1'");
                }
            
            }
            
            $action="Students Promoted";
            $log=new Log();
            if(isset($ok))
            {
                if($ok)
                {
                    $log->success_entry($action,$Conn);
                    echo "<script>alert('Student Data Stored Successfully');window.location.href='manage-students.php';</script>";
                }
                else 
                {
                   $str=$log->success_entry($action,$Conn,"Unsuccessful");
                  
                }
            }
        }
        else if(sizeof($em)==2 && strcmp(x, $em[1])==0)
        {
            $error="Uploaded file is empty : Please fill Data in sheet";
        }
        else
        {
            $error="Empty Cell found at row :";

                for ($lines=1; $lines<sizeof($em); $lines++) 
                { 
                    $error=$error." $em[$lines],";
                }  
                $error=$error." in Uploaded file (hint : if Uploaded sheet is perfect but still get this error than delete the last empty row.)";
        }
    }
    else
    {
        echo "<script>alert('Only excel files are accepted (xlsx)');window.location.href='pro_stu.php';</script>";  
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Promote Student | IGHS </title>
     <link rel="stylesheet" href="ssi-uploader/styles/ssi-uploader.css"/>
     
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
         .add  {
                width: 100%;
                margin-left: 100%;
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
                          <h4 class="page-title pull-left">Promote Student</h4>
                                <li><a href="dashboard.php">Home</a></li>
                                
                                <li><span>Promote Student</span></li>
                            </ul>
                </div>
            </div>
              <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            
                                        </div>
                                    </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <!-- MAIN CONTENT GOES HERE -->

                                    <div class="panel-body">
                                        <?php if(isset($error))
                                                {
                                        ?>
                                        <div class="alert alert-danger left-icon-alert" role="alert">
                                            
                                            <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                        <form class="form-horizontal" method="post"  enctype="multipart/form-data">

                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Select Excel Sheet</label>
                                                <div class="col-sm-10">
                                                       <input type="file" required name='file' accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
                                                </div>
                                            </div>

                                         


                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    
                                                    <button type="submit" name="submit" class="btn btn-primary">Upload</button>
                                                </div>
                                            </div>
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
<?php 
    
} 

?>