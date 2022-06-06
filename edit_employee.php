<?php
if(isset($_COOKIE['login']))
{
	$login_id=$_COOKIE['login'];
	
 header( 'Content-Type: text/html; charset=utf-8' ); 

require("root/db_connection.php");

 ?>
	<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  
   
    

</head>
<body>

    <div id="wrapper">
        <?php  include("header.php");  ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                     <div class="col-lg-12">
                        <h4 align="center"><strong>Profile Setting</strong></h4>                         
					   <hr>							
					   </div>
					   <div class="col-lg-12">
						<ol class="breadcrumb">
                             <li class="active">
                                <a href="edit_employee.php"><i class="fa fa-dashboard"></i> Edit Profile</a>
                            </li>
                        </ol>
					</div>
					   
					   <?php $editQ=$db->query("select * from user_infromation where user_id=$login_id") or die("");
								$editQ_res=$editQ->fetch(PDO::FETCH_ASSOC);
								
								?>
								 <form role="form" name="" method="post" enctype="multipart/form-data" id="employee_frm" action="edit_employee_do.php">
                                <div class="col-lg-6">
                                <label>Employee Name</label>
                                        <input id="txt_e_name" autofocus  name="txt_e_name" type="text" class="form-control" placeholder="Name" value="<?php echo $editQ_res['user_name']; ?>" disabled>
                                        <input type="hidden" name="txtHide" id="txtHide" value="<?php echo $login_id; ?>">
                                        <br>
                            
                            </div>
                            <div class="col-lg-6">
                            <label>Profile Image</label>
                                    
                                    <input type="file" name="txtImage" class="form-control">
                                       
                           <span class="pull-right">(file type : jpg, jpeg, png)</span>
						  <?php if($editQ_res['profile_ext']=="" || $editQ_res['profile_ext']==NULL){  $imgNAME="default_image.jpg"; } else { $imgNAME=$editQ_res['user_id'].".".$editQ_res['profile_ext']; } ?>
							<img src="employee_profile/<?php echo $imgNAME; ?>" style="width:60px; height:60px; margin-right:5px; margin-top:5px; float:left;">
                                       <br>
                            
                            </div>
                           
                            
                             
        							<div class="col-lg-6" >
                                    <label>Password</label>
				        				<input id="txt_e_pass"  name="txt_e_pass" type="password" class="form-control" value="<?php echo $editQ_res['user_pass']; ?>" placeholder="Password "><br>
        							</div>        
				          			<div class="col-lg-6" >
                                    <label>Confirm Password </label>
          								<input id="txt_e_c_pass"  name="txt_e_c_pass" type="password"  class="form-control" value="<?php echo $editQ_res['user_pass']; ?>" placeholder="Confirm Password "><br>
            						</div>
						
							<div class="col-lg-12">  
					    			<button type="button" class="btn btn-success btn-sm btn_emp_submit">Submit </button>
                                    </div>
									</form>
</div>
</div>
</div>
</div>
 
	<script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script>
	$(".btn_emp_submit").on("click",function(e){
			
		if($("#txt_e_pass").val()==''){
			$("#txt_e_pass").addClass("alert_img");
			$("#txt_e_pass").focus();
		}
		else if($("#txt_e_c_pass").val()==''){
			$("#txt_e_c_pass").addClass("alert_img");
			$("#txt_e_c_pass").focus();
		}
		else{ 
		if($("#txt_e_pass").val()==$("#txt_e_c_pass").val()){				
				$("#employee_frm").submit();
			}
			else{
				$("#txt_e_pass").addClass("alert_img");
				$("#txt_e_c_pass").addClass("alert_img");
			}
		}
	});
</script>	

</body>
</html>			
<?php } else {
	header("location:login-page.php");	
} ?>