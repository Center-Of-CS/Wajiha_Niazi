<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <?php 
            $title = "Update Room"; 
            include_once("title.php");
        ?>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- favicon
            ============================================ -->
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
        <!-- Google Fonts
            ============================================ -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
        <!-- Bootstrap CSS
            ============================================ -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- font awesome CSS
            ============================================ -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <!-- owl.carousel CSS
            ============================================ -->
        <link rel="stylesheet" href="css/owl.carousel.css">
        <link rel="stylesheet" href="css/owl.theme.css">
        <link rel="stylesheet" href="css/owl.transitions.css">
        <!-- meanmenu CSS
            ============================================ -->
        <link rel="stylesheet" href="css/meanmenu/meanmenu.min.css">
        <!-- animate CSS
            ============================================ -->
        <link rel="stylesheet" href="css/animate.css">
        <!-- normalize CSS
            ============================================ -->
        <link rel="stylesheet" href="css/normalize.css">
        <!-- mCustomScrollbar CSS
            ============================================ -->
        <link rel="stylesheet" href="css/scrollbar/jquery.mCustomScrollbar.min.css">
        <!-- Notika icon CSS
            ============================================ -->
        <link rel="stylesheet" href="css/notika-custom-icon.css">
        <!-- wave CSS
            ============================================ -->
        <link rel="stylesheet" href="css/wave/waves.min.css">
        <link rel="stylesheet" href="css/wave/button.css">
        <!-- main CSS
            ============================================ -->
        <link rel="stylesheet" href="css/main.css">
        <!-- style CSS
            ============================================ -->
        <link rel="stylesheet" href="style.css">
        <!-- responsive CSS
            ============================================ -->
        <link rel="stylesheet" href="css/responsive.css">
        <!-- modernizr JS
            ============================================ -->
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
<?php  
    include("../lib/crud.php");
    
    $db = new CRUD();
    $room_no = $type= $price= $details="";
    $imageErr = $room_noErr = $typeErr= $priceErr= $detailsErr="";   
    $id = (int) $_GET['updateID'];
    $result = $db->select_one("rooms","room_id='$id'");
    $room_no = $result['room_no'];
    $type = $result['type'];
    $price = $result['price'];
    $details = $result['details'];
    $image = $result['image'];
    if(isset($_POST['submit'])){
        if(empty($_POST['room_no'])){
            $room_noErr = "room_no can not be empty";	
        }else{
            $room_no = cleanData($_POST['room_no']);
        }
        if(empty($_POST['type'])){
            $typeErr = "type can not be empty";	
        }else{
            $type = cleanData($_POST['type']);
        }
        if(empty($_POST['price'])){
            $priceErr = "price can not be empty";	
        }else{
            $price = cleanData($_POST['price']);
        }
        if(empty($_POST['details'])){
            $usdetailsErr = "detail can not be empty";	
        }else{
            $details = cleanData($_POST['details']);
        }
        // file name
        $photoName = $_FILES["image"]["name"];
        // directory
        $file_path = "roomimage/";
        // source
        $source = $_FILES["image"]["tmp_name"];
        $allowed_extension = array("png","jpg","JPG","PNG","jpeg");
        $extension = strtolower(PATHINFO($photoName ,PATHINFO_EXTENSION));
        if(!in_array($extension, $allowed_extension)){
            $fileErr = "Unfortunatly the type file is not allowed!";     
        }
        else{
            $fulldate = date("Y_m_d h_i_s");
            $photoName = "pic _ ".$fulldate.".".$extension;
            move_uploaded_file($source,$file_path.$photoName);
        } 
        if(empty($imageErr) && empty($room_noErr) && empty($typeErr) && empty($priceErr) && empty($detailsErr)){
            $data = sprintf("room_no='%d',type='%s',price='%d',details='%s',image='%s'",
                mysqli_real_escape_string($GLOBALS["DB"],$room_no),
                mysqli_real_escape_string($GLOBALS["DB"],$type),
                mysqli_real_escape_string($GLOBALS["DB"],$price),
                mysqli_real_escape_string($GLOBALS["DB"],$details),
                mysqli_real_escape_string($GLOBALS["DB"],$photoName)
            );
            $update = $db->update("rooms",$data,"room_id='$id'");
            if($update){
                unlink("roomimage/$image");
                header("location:roomsetting.php?update=1");
            }else{
                echo "Failed update";
            }  
        }else{
            echo "Failed";
        }
    }
    function cleanData($data){
        $data = trim($data);
        $data = htmlSpecialChars($data);
        $data = stripslashes($data);
        return $data;
    }
?>
<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- Start Header Top Area -->
    <?php include 'include/header.php'?>
    <!-- Main Menu area End-->
	<!-- Breadcomb area Start-->
	<div class="breadcomb-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="breadcomb-list">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="breadcomb-wp">
									<div class="breadcomb-icon">
										<i class="notika-icon notika-form"></i>
									</div>
									<div class="breadcomb-ctn">
										<h2>Update Rooms</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Breadcomb area End-->
    <!-- Form Element area Start-->
    <div class="form-element-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-element-list">
                        <div class="basic-tb-hd">
                            <h2>Update Room</h2>
                        </div>
                        <form action=" <?php $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group ic-cmp-int">
                                        <div class="form-ic-cmp">
                                            <i class="">Number</i>
                                        </div>
                                        <div class="nk-int-st">
                                            <label class="login2 pull-right pull-right-pro" style="color:red;"><?php echo $room_noErr?></label>
                                            <input type="number" class="form-control" name="room_no" value="<?php echo $room_no;?>" id="room_no"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group ic-cmp-int">
                                        <div class="form-ic-cmp">
                                            <i class="">Type</i>
                                        </div>
                                        <div class="nk-int-st">
                                            <label class="login2 pull-right pull-right-pro" style="color:red;"><?php echo $typeErr?></label>
                                            <input type="text" class="form-control" name="type" id="type"  value="<?php echo $type?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group ic-cmp-int">
                                        <div class="form-ic-cmp">
                                            <i class="">Price</i>
                                        </div>
                                        <div class="nk-int-st">
                                            <label class="login2 pull-right pull-right-pro" style="color:red;"><?php echo $priceErr?></label>
                                            <input type="number" class="form-control" name="price" id="price" value="<?php echo $price?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group ic-cmp-int">
                                        <div class="form-ic-cmp">
                                            <i >Details</i>
                                        </div>
                                        <div class="nk-int-st">
                                            <label class="login2 pull-right pull-right-pro" style="color:red;"><?php echo $detailsErr?></label>
                                            <textarea class="form-control" name="details" id="details" ><?php echo $details?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group ic-cmp-int">
                                        <div class="form-ic-cmp">
                                            <i class="">Image</i>
                                        </div>
                                        <div class="nk-int-st">
                                            <input type="file" class="form-control" name="image" id="image" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
                                    <div class="form-example-int">
                                        <button class="btn btn-success notika-btn-success" type="submit" name="submit" value="Submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Form Element area End-->
    <?php include 'include/footer.php'?>
   
    <!-- End Footer area-->
    <!-- jquery
		============================================ -->
        <script src="js/vendor/jquery-1.12.4.min.js"></script>
        <!-- bootstrap JS
            ============================================ -->
        <script src="js/bootstrap.min.js"></script>
        <!-- wow JS
            ============================================ -->
        <script src="js/wow.min.js"></script>
        <!-- price-slider JS
            ============================================ -->
        <script src="js/jquery-price-slider.js"></script>
        <!-- owl.carousel JS
            ============================================ -->
        <script src="js/owl.carousel.min.js"></script>
        <!-- scrollUp JS
            ============================================ -->
        <script src="js/jquery.scrollUp.min.js"></script>
        <!-- meanmenu JS
            ============================================ -->
        <script src="js/meanmenu/jquery.meanmenu.js"></script>
        <!-- counterup JS
            ============================================ -->
        <script src="js/counterup/jquery.counterup.min.js"></script>
        <script src="js/counterup/waypoints.min.js"></script>
        <script src="js/counterup/counterup-active.js"></script>
        <!-- mCustomScrollbar JS
            ============================================ -->
        <script src="js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
        <!-- sparkline JS
            ============================================ -->
        <script src="js/sparkline/jquery.sparkline.min.js"></script>
        <script src="js/sparkline/sparkline-active.js"></script>
        <!-- flot JS
            ============================================ -->
        <script src="js/flot/jquery.flot.js"></script>
        <script src="js/flot/jquery.flot.resize.js"></script>
        <script src="js/flot/flot-active.js"></script>
        <!-- knob JS
            ============================================ -->
        <script src="js/knob/jquery.knob.js"></script>
        <script src="js/knob/jquery.appear.js"></script>
        <script src="js/knob/knob-active.js"></script>
        <!-- icheck JS
            ============================================ -->
        <script src="js/icheck/icheck.min.js"></script>
        <script src="js/icheck/icheck-active.js"></script>
        <!--  wave JS
            ============================================ -->
        <script src="js/wave/waves.min.js"></script>
        <script src="js/wave/wave-active.js"></script>
        <!--  Chat JS
            ============================================ -->
        <script src="js/chat/jquery.chat.js"></script>
        <!--  todo JS
            ============================================ -->
        <script src="js/todo/jquery.todo.js"></script>
        <!-- plugins JS
            ============================================ -->
        <script src="js/plugins.js"></script>
        <!-- main JS
            ============================================ -->
        <script src="js/main.js"></script>
        <!-- tawk chat JS
            ============================================ -->
        <script src="js/tawk-chat.js"></script>
    </body>
    
    </html>