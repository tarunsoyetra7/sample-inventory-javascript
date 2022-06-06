<?php
	if(isset($_COOKIE['login'])){
	
		$login_id= $_COOKIE['login'];
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
  
    
	<script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    

</head>
<body>

    <div id="wrapper">
        <?php  include("header.php");  ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                     <div class="col-lg-12">
                        <h4 align="center"><strong>Employee  Master</strong></h4>                         
					   <hr>
                       
                       <ol class="breadcrumb">
					   

					   
                           <li class="active">
                                <a href="add_employee.php"><i class="fa fa-dashboard"></i> Add Employee</a>
                            </li>
							
							
							<li class="active">
                                <a href="employee_login_status.php"><i class="fa fa-dashboard"></i> Employee Login Status</a>
                            </li>
							
                        </ol>
                    </div>
                  
                    
                  
         
                   
                    
                  
				   <form role="form" name="" method="post" enctype="multipart/form-data" id="employee_frm" action="add_employee_do.php">
                            <div class="col-lg-6">
                            <label>Employee Name</label>
                                        <input id="txt_e_name" autofocus  name="txt_e_name" type="text" class="form-control" placeholder="Name">
                                        <input type="hidden" name="txtHide" id="txtHide" value="">
                                        <br>
                            
                            </div>
                            <div class="col-lg-6">
                            <label>Profile Image</label>
                                    
                                    <input type="file" name="txtImage" class="form-control">
                                       
                           <span class="pull-right">(file type : jpg, jpeg, png)</span>
                                       <br>
                            
                            </div>
                            
                             
        							<div class="col-lg-6" >
                                    <label>Password</label>
				        				<input id="txt_e_pass"  name="txt_e_pass" type="password" class="form-control" placeholder="Password "><br>
        							</div>        
				          			<div class="col-lg-6" >
                                    <label>Confirm Password </label>
          								<input id="txt_e_c_pass"  name="txt_e_c_pass" type="password" class="form-control" placeholder="Confirm Password "><br>
            						</div>
				    		
                                <div class="col-lg-12">  
					    			<button type="button" class="btn btn-success btn-sm btn_emp_submit">Submit </button>
                                    </div>
                                    
							</form> 
							
							
							<div style="clear:both;"></div>
							<br>
                    
                    

<style>
#user_img{
	width:50px; height:50px; margin-right:5px;
}
</style>

</div>

 <table class="table table-middle dataTable table-bordered table-condensed table-hover">

                                            <thead>

                                               <tr style="background:#000; color:#fff;">
                            <th>S No.</th>
                            <th>Name</th>
                            <th>Password</th>                         
                             
                            <th>Option</th>
                        </tr>
						</thead>
						<tbody>
             			<?php
							$Query=$db->query("SELECT * FROM user_infromation where delstatus=0  order by delstatus") or die("error");
							$i=0;
							while($Result=$Query->fetch(PDO::FETCH_ASSOC))
							{
								$i++;									
						?>
            			<tr id='emp_tr_<?php echo $Result['user_id']; ?>'>           
                            <td><?php echo $i; ?> </td>
                            <td>
                            <?php if($Result['profile_ext']=="" || $Result['profile_ext']==NULL){  $imgNAME="default_image.jpg"; } else { $imgNAME=$Result['user_id'].".".$Result['profile_ext']; } ?>
							<img src="employee_profile/<?php echo $imgNAME; ?>" style="width:60px; height:60px; margin-right:5px; float:left;">
							
							<?php echo $Result['user_name']; ?>
                            
                             </td>             
                            <td>*******</td>                
                            
                            <td>
                           <!-- href="delete_employee.php?del_id=<?php echo $Result['user_id']; ?>"-->
                            <?php if($Result['delstatus']==0){ ?>
                            	<button type="button" class="btn btn-sm btn-danger btn_delete" id="<?php echo $Result['user_id']; ?>"><strong>Delete</strong></span></td>
                            <?php } ?>
            			</tr>
          <?php } ?> </tbody>
                                        </table>
                    
                    
                    
                                        
                   </div>
                </div>
            </div>


 <script> 
    $(".btn_delete").on("click",function(e){
	    var del_id=$(this).attr('id');
		$.ajax({
			type:"POST",
			url:"delete_employee.php",
			data:{del_id:del_id},
			success:function(r_data){
				alert(r_data);
				location.reload();
			},
			error:function(err){
				location.reload();
			}
		});
	});
	
	
 	$("#txt_e_name").on("keyup", function(e) {
		if ($("#txt_e_name").hasClass("alert_img") == true) {
			$("#txt_e_name").removeClass("alert_img");
		}
	});	
	$("#txt_e_pass").on("keyup", function(e) {	
		if ($("#txt_e_pass").hasClass("alert_img") == true) {
			$("#txt_e_pass").removeClass("alert_img");
		}
	});	
	$("#txt_e_c_pass").on("keyup", function(e) {	
		if ($("#txt_e_c_pass").hasClass("alert_img") == true) {
			$("#txt_e_c_pass").removeClass("alert_img");
		}
	});  

	$(".btn_emp_submit").on("click",function(e){
		
		if($("#txt_e_name").val()==''){
			$("#txt_e_name").addClass("alert_img");
			$("#txt_e_name").focus();
		}		
		else if($("#txt_e_pass").val()==''){
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
<?php
}
else
{
	header("location:login-page.php");	
}
?>