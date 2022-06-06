<?php
if(isset($_COOKIE['login'])){
	$login_id=$_COOKIE['login'];
	require("root/db_connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
	<script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
   
</head>
<body>
    <div id="wrapper">
        <?php
        include("header.php");
        ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                    	<h4 align="center"><strong>Employee Authentication</strong></h4>
                        <hr>
						
						 <ol class="breadcrumb">
                  		<li class="active">
                                <a href="authentication_page.php"><i class="fa fa-dashboard"></i> Add Authentication</a>
                            </li>
                            
                        </ol>
										
						
                        <form class="form-horizontal">
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <input type="hidden" id="txtHide" value="<?php echo $login_id; ?>">
                                        <label >Select Employee :</label>
                                        <select name="" id="select_emp_name" class="form-control">
                                            <option value="s_emp">---Select Employee---</option>
                                                <?php $emp_name=$db->query("select user_id,user_name from user_infromation where delstatus=0 order by user_name desc") or die("");
                                                     while($emp_name_res=$emp_name->fetch(PDO::FETCH_ASSOC)) { ?>
                                                        <option value="<?php echo $emp_name_res['user_id']; ?>"><?php echo $emp_name_res['user_name']; ?></option>
                                             	<?php } ?>
                                       </select>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <button style="margin-top:24px; " type="button" class="btn btn-success btn-sm btn_emp_submit">
                                    Submit
                                </button>
                            </div>
                        </form>
                       <table class="table table-middle dataTable table-bordered table-condensed table-hover">
                        	<thead style="background:#000; color:#fff;">
                            	<tr>
                                	<th>S No</th>
                                    <th>Field Name</th>
                                  
                                </tr>
                            </thead>
                            <tbody class="chk_auth_data">
                            	<?php $auth_q=$db->query("select a_id,a_field_name from authentication order by a_field_name") or die("");
									  $i=0;
									  while($auth_q_res=$auth_q->fetch(PDO::FETCH_ASSOC)){
									  $i++;
							    ?>
                            	<tr>
                                	<td>
										<?php echo $i; ?>
                                    </td>
                                    <td>
                                    	<input class="chk_field_name" id="<?php echo $auth_q_res['a_id']; ?>" type="checkbox">&nbsp;<?php echo $auth_q_res['a_field_name']; ?>
                                    </td>
                                    
                               </tr>
                              <?php } ?>
                            </tbody>
                        </table>
  					</div>
				</div>
            </div>
        </div>
    </div>

    <script>
	$(document).ready(function(e) {
        var emp_id=$("#txtHide").val();
		//fetch_chk_values(emp_id);
    });
	
	function fetch_chk_values(id){		
		if($(".chk_auth_data .auth_chk").length==0){
		}else{
			for(i=0; i<$(".chk_auth_data .auth_chk").length; i++){
				var chkAttrID=$(".chk_auth_data .auth_chk:eq("+i+")").attr('id');
				$("#"+chkAttrID).removeClass("auth_chk");
				$("#"+chkAttrID).prop('checked', false);
			}
		}		
		var emp_id=id;
		$.ajax({
			type:"POST",
			data:{emp_id:emp_id},
			url:"fetch_checked_auth_detail.php",
			dataType:"json",
			cache:false,
			success: function(r_res){
				if(r_res.length==0){
					
					$("#"+r_res[i].auth_id).prop('checked', false);
					$("#"+r_res[i].auth_id).removeClass("auth_chk");
						
					   }
				else{
					for(i=0; i<r_res.length; i++){
						console.log(r_res[i].auth_id);
						$("#"+r_res[i].auth_id).prop('checked', true);
						$("#"+r_res[i].auth_id).addClass("auth_chk");	}					
				}
			}
		});
	}	
	$('input:checkbox').change(function(){
		if($(this).is(":checked")){
			$(this).addClass("auth_chk"); }
		else{
			$(this).removeClass("auth_chk");}
	});
	$("#select_emp_name").on("change",function(e){
		if($("#select_emp_name option:selected").val()=='s_emp'){
			$("#select_emp_name").addClass("alert_img");}
		else{
			$("#select_emp_name").removeClass("alert_img");
			var id=$("#select_emp_name option:selected").val();
			fetch_chk_values(id);}
	});	
	$(".btn_emp_submit").on("click",function(e){
		if($("#select_emp_name option:selected").val()=='s_emp'){
			$("#select_emp_name").addClass("alert_img");}
		else{
			$("#select_emp_name").removeClass("alert_img");
			if($(".chk_auth_data .auth_chk").length==0){
				alert("Please Provide Some Authentication !..");}
			else{
				var empty_chk_val="";
				for(i=0; i<$(".chk_auth_data .auth_chk").length; i++){
					empty_chk_val=empty_chk_val+$(".auth_chk:eq('"+i+"')").attr('id');
					empty_chk_val=empty_chk_val+",";}
				empty_chk_val=empty_chk_val.slice(0,-1);
				var emp_id=$("#select_emp_name option:selected").val();
				var auth_values=empty_chk_val;
				$.ajax({
						type:"POST",
						data:{emp_id:emp_id,auth_values:auth_values},
						url:"provide_authentication_page.php",
						success: function(r_data){
									alert(r_data); 
									
									location.reload();
									}
				});
			}
		}
	});
	</script>
</body>
</html>
<?php } else{
	header("location:login-page.php"); }
?>