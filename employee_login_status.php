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
    <meta name="description" content="">
    <meta name="author" content="">
    <title></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
  
    
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
                        <h4 align="center"><strong>Employee Activity  Master</strong></h4>                         
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
                  
                    
                  
         
                    <div class="col-lg-12">
                    
     
 <table class="table table-middle dataTable table-bordered table-condensed table-hover">

                                            <thead>

                                               <tr style="background:#000; color:#fff;">
                            <th>S No.</th>
                            <th>Employee Detail</th>
                            <th>Login Date & Time</th>                         
                        </tr>
						</thead>
						<tbody>
             			<?php
							$Query=$db->query("select id,login_id,(select user_name from user_infromation where user_id=login_id) as emp_name,login_date_time from login_status where flag='true' order by id desc ") or die("error");
							$i=0;
							while($Result=$Query->fetch(PDO::FETCH_ASSOC))
							{
								$i++;									
						?>
            			<tr >           
                            <td><?php echo $i; ?> </td>
                            <td>
                            <strong>User Name : </strong> <?php echo $Result['emp_name']; ?><br>
							
                             </td>             
                            <td><?php echo $Result['login_date_time']; ?></td>                
                           
            			</tr>
						<?php } ?>
						</tbody>
                                        </table>
                    </div>
                    
                    
                                        
                   </div>
                </div>
            </div>
        </div>
    </div>


 <script>
 
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