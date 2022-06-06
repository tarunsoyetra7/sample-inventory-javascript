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
</head>
<body>

    <div id="wrapper">
        <?php  include("header.php");  ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
				  <div class="col-lg-12">
                        <h4 align="center"><strong>Aawak Jawak System</strong></h4>                         
					   <hr>
                    </div>
					<div class="col-lg-12">
						<ol class="breadcrumb">
                           <li class="active">
                                <a href="letter_in_out.php"><i class="fa fa-dashboard"></i> Add Aawak Jawak Information</a>
                            </li>
							<li class="active">
                                <a href="manage_in_letter.php"><i class="fa fa-dashboard"></i> View Letter Aawak </a>
                            </li>
							<li class="active">
                                <a href="manage_out_letter.php"><i class="fa fa-dashboard"></i> View Letter Jawak </a>
                            </li>
							<li class="active">
                                <a href="manage_in_file.php"><i class="fa fa-dashboard"></i> View File Aawak </a>
                            </li>
							<li class="active">
                                <a href="manage_out_file.php"><i class="fa fa-dashboard"></i> View File Jawak </a>
                            </li>
                        </ol>
						<br>
					</div>
						<?php 
						if(isset($_REQUEST['id'])){
						$edit_id=$_REQUEST['id'];
						$editQ=$db->query("SELECT * FROM letter_in_out where id=$edit_id") or die("");
						$editQ_res=$editQ->fetch(PDO::FETCH_ASSOC);
						?>
						<input type="hidden" id="txt_hide" value="<?php echo $editQ_res['id']; ?>">
						<div class="col-lg-6">
							<label>Select Employee :</label>
							<select id="txt_sel_emp" class="form-control">
								<option value="0"> --SELECT ANY EMPLOYEE-- </option>
								<?php $empQ=$db->query("SELECT user_id,user_name FROM user_infromation WHERE delstatus=0") or die("");
								if($empQ->rowCount()==0) { ?>
								<option value="0"> No Employee Found </option>
								<?php } else { 
								while($empRes=$empQ->fetch(PDO::FETCH_ASSOC)){ 
								if($editQ_res['letter_user']==$empRes['user_id']) { ?>
								<option selected value="<?php echo $empRes['user_id']; ?>"><?php echo $empRes['user_name']; ?></option>
								<?php } else { ?>
								<option value="<?php echo $empRes['user_id']; ?>"><?php echo $empRes['user_name']; ?></option>
								<?php } } } ?>
							</select>
						</div>
						<div class="col-lg-6">
							<label>Enter Sender's Name :</label>
							<input type="text" class="form-control" id="txt_name" placeholder="Enter Name Here **" value="<?php echo $editQ_res['letter_s_name']; ?>"><br>
						</div>
						<div class="col-lg-6">
							<label>Select In/Out Type :</label>
							<select id="txt_sel_in_out" class="form-control">
								<option value="0"> --CHOOSE ANY-- </option>
								<?php if($editQ_res['letter_in_out']==1) { ?>
								<option selected value="1">Aawak</option>
								<option value="2">Jawak</option>
								<?php } else { ?>
								<option  value="1">Aawak</option>
								<option selected value="2">Jawak</option>
								<?php } ?>
							</select>
							<br>
						</div>
						<div class="col-lg-6">
							<label>Enter Id :</label>
							<input value="<?php echo $editQ_res['letter_id']; ?>" type="number" id="txt_id" class="form-control" placeholder="Enter Id of Letter"><br>
						</div>
						<div class="col-lg-6">
							<label>Select Type :</label>
							<select id="txt_sel_type" class="form-control">
								<option value="0"> --CHOOSE ANY-- </option>
								<?php if($editQ_res['letter_in_out']==1) { ?>
								<option selected value="1">Letter</option>
								<option value="2">File</option>
								<?php } else { ?>
								<option  value="1">Letter</option>
								<option selected value="2">File</option>
								<?php } ?>
							</select>
							<br>
						</div>
						<div class="col-lg-6">
							<label>Select Date :</label>
							<input value="<?php echo $editQ_res['letter_date']; ?>" type="date" class="form-control" id="txt_sel_date">
							<br>
						</div>
						<div class="col-lg-6">
							<label>Enter Subject :</label>
							<textarea class="form-control" id="txt_sub" rows="5" placeholder="Enter Subject Of Letter **"><?php echo $editQ_res['letter_sub']; ?></textarea><br>
						</div>
						<div class="col-lg-6">
							<label>Enter Address :</label>
							<textarea class="form-control" id="txt_add" rows="5" placeholder="Enter Address Of Letter **"><?php echo $editQ_res['letter_add']; ?></textarea><br>
						</div>
						<?php } else { ?>
						<input type="hidden" id="txt_hide" value="">
						<div class="col-lg-6">
							<label>Select Employee :</label>
							<select id="txt_sel_emp" class="form-control">
								<option value="0"> --CHOOSE ANY EMPLOYEE-- </option>
								<?php $empQ=$db->query("SELECT user_id,user_name FROM user_infromation WHERE delstatus=0") or die("");
								if($empQ->rowCount()==0) { ?>
								<option value="0"> No Employee Found </option>
								<?php } else { 
								while($empRes=$empQ->fetch(PDO::FETCH_ASSOC)){ ?>
								<option value="<?php echo $empRes['user_id']; ?>"><?php echo $empRes['user_name']; ?></option>
								<?php } } ?>
							</select>
							<br>
						</div>
						<div class="col-lg-6">
							<label>Enter Sender's Name :</label>
							<input type="text" class="form-control" id="txt_name" placeholder="Enter Name Here **" value=""><br>
						</div>
						<div class="col-lg-6">
							<label>Select In/Out Type :</label>
							<select id="txt_sel_in_out" class="form-control">
								<option value="0"> --CHOOSE ANY-- </option>
								<option value="1">Aawak</option>
								<option value="2">Jawak</option>
							</select>
							<br>
						</div>
						<div class="col-lg-6">
							<label>Enter Id :</label>
							<input type="number" id="txt_id" class="form-control" placeholder="Enter Id of Letter"><br>
						</div>
						<div class="col-lg-6">
							<label>Select Type</label>
							<select id="txt_sel_type" class="form-control">
								<option value="0"> --CHOOSE ANY-- </option>
								<option value="1">Letter</option>
								<option value="2">File</option>
							</select>
						</div>
						<div class="col-lg-6">
							<label>Select Date :</label>
							<input type="date" class="form-control" id="txt_sel_date">
							<br>
						</div>
						
						<div class="col-lg-6">
							<label>Enter Subject :</label>
							<textarea class="form-control" id="txt_sub" rows="5" placeholder="Enter Subject Of Letter **"></textarea><br>
						</div>
						<div class="col-lg-6">
							<label>Enter Address :</label>
							<textarea class="form-control" id="txt_add" rows="5" placeholder="Enter Address Of Letter **"></textarea><br>
						</div>
						<?php  } ?>
						<div class="col-lg-12">
						<br>
						<button type="button" class="btn btn-sm btn-success btn_submit">Submit</button>
						</div>
                    </div>                        
                </div>
            </div>
        </div>
    </div>
 <script src="js/jquery.js"></script>
 <script src="js/bootstrap.min.js"></script>
 <script>
 $(".btn_submit").on("click",function(e){
	 if($("#txt_sel_emp option:selected").val()==0){
		 $("#txt_sel_emp").focus();
	 }
	 else  if($("#txt_name").val()=="" || $("#txt_name").val()==null){
		 $("#txt_name").focus();
	 }
	 else  if($("#txt_sel_in_out option:selected").val()==0){
		 $("#txt_sel_in_out").focus();
	 }
	 else  if($("#txt_id").val()=="" || $("#txt_id").val()==null){
		 $("#txt_id").focus();
	 }
	 else  if($("#txt_sel_type option:selected").val()==0){
		 $("#txt_sel_type").focus();
	 }
	 else  if($("#txt_sel_date").val()=="" || $("#txt_sel_date").val()==null){
		 $("#txt_sel_date").focus();
	 }
	 else  if($("#txt_sub").val()=="" || $("#txt_sub").val()==null){
		 $("#txt_sub").focus();
	 }
	 else  if($("#txt_add").val()=="" || $("#txt_add").val()==null){
		 $("#txt_add").focus();
	 } else {
		 var txt_name=$("#txt_name").val();
		 var txt_hide=$("#txt_hide").val();
		 var txt_sub=$("#txt_sub").val();
		 var txt_add=$("#txt_add").val();
		 var txt_id=$("#txt_id").val();
		 var txt_sel_date=$("#txt_sel_date").val();
		 var txt_sel_emp=$("#txt_sel_emp option:selected").val();
		 var txt_sel_in_out=$("#txt_sel_in_out option:selected").val();
		 var txt_sel_type=$("#txt_sel_type option:selected").val();
		 $.ajax({
			 type:"POST",
			 url:"letter_in_out_do.php",
			 data:{txt_name:txt_name,txt_hide:txt_hide,txt_sub:txt_sub,txt_add:txt_add,txt_id:txt_id,txt_sel_date:txt_sel_date,txt_sel_emp:txt_sel_emp,txt_sel_in_out:txt_sel_in_out,txt_sel_type:txt_sel_type},
			 success:function(r_data){
				 alert(r_data);
				 window.location.replace("letter_in_out.php");
			 },
			 error:function(err){
				 alert("Try Again");
			 }
		 });
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