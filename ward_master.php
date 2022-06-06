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
	<link rel="stylesheet" href="css/buttons.dataTables.min.css">

  <link rel="stylesheet" href="css/jquery.dataTables.min.css">

</head>
<body>

    <div id="wrapper">
        <?php  include("header.php");  ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
				  <div class="col-lg-12">
                        <h4 align="center"><strong>Ward Management</strong></h4>                         
					   <hr>
                    </div>
					<div class="col-lg-12">
						<ol class="breadcrumb">
                             <li class="active">
                                <a href="ward_master.php"><i class="fa fa-dashboard"></i> Ward Master</a>
                            </li>
                        </ol>
					</div>
						<?php 
						if(isset($_REQUEST['edit_id'])){
						$edit_id=$_REQUEST['edit_id'];
						$editQ=$db->query("SELECT * FROM ward_master where id=$edit_id") or die("");
						$editQ_res=$editQ->fetch(PDO::FETCH_ASSOC);
						?>
						<div class="col-lg-6">
						<label>Ward Number</label>
						<input type="number" id="txt_id" value="<?php echo $editQ_res['ward_id']; ?>" class="form-control" placeholder="Enter Ward Number *">
						<input type="hidden" id="txt_hide" value="<?php echo $edit_id; ?>">
						</div>
						<div class="col-lg-6">
						<label>Ward Area</label>
						<input type="text" id="txt_name" value="<?php echo $editQ_res['ward_name']; ?>" class="form-control" placeholder="Enter Ward Area *">
						</div>
						<?php } else { ?>
						<div class="col-lg-6">
						<label>Ward Number</label>
						<input type="number" id="txt_id" class="form-control" placeholder="Enter Ward Number *">
						</div>
						<div class="col-lg-6">
						<label>Ward Area</label>
						<input type="text" id="txt_name" class="form-control" placeholder="Enter Ward Area *">
						<input type="hidden" id="txt_hide">
						</div>
						<?php } ?>
						<div class="col-lg-12">
						<br>
						<button type="button" class="btn btn-sm btn-success btn_submit">Submit</button>
						</div>
						<div class="col-lg-12" style="clear:both"><hr><br></div>
						<div class="col-lg-12">
						<table id="example1" class="table table-middle dataTable table-bordered table-condensed table-hover">
							<thead style="background:#000; color:#fff;">
                            	<tr>
                                	<th>S No</th>
                                    <th>Ward Number</th>
                                    <th>Ward Name</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
							<tbody>
							<?php 
							$i=0;
							$selQ=$db->query("SELECT * FROM ward_master order by id desc") or die("");
							while($selQ_res=$selQ->fetch(PDO::FETCH_ASSOC)){ $i++;
							?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $selQ_res['ward_id'];; ?></td>
									<td><?php echo $selQ_res['ward_name'];; ?></td>
									<td><button type="button" class="btn btn-sm btn-info btn_edit" id="<?php echo $selQ_res['id']; ?>">Edit</button>&nbsp;<button type="button" class="btn btn-sm btn-danger btn_delete" id="<?php echo $selQ_res['id']; ?>">Delete</button></td>
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

 <script src="js/jquery.js"></script>
 <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
 <script type="text/javascript">    
	$(function () {
	  
		$('#example1').DataTable({
		  "paging": true,
		  "lengthChange": true,
		  "searching": true,
		  "ordering": true,
		  "info": true,
		  "autoWidth": false,
		   dom: 'Bfrtip',
        buttons: [
             'excel', 'pdf', 'print'
        ]
		});
	  });
 </script>
 <script>
 $(".btn_edit").on("click",function(e){
	var edit_id=$(this).attr("id");
	window.location.replace("ward_master.php?edit_id="+edit_id);
 });
 
 $(".btn_delete").on("click",function(e){
	var del_id=$(this).attr("id");
	$.ajax({
		type:"POST",
		url:"ward_master_do.php",
		data:{del_id:del_id},
		success:function(r_data){
			alert(r_data);
			location.reload();
		},
		error:function(err){
		}
	});
 });
 </script>
 <script>
 $(".btn_submit").on("click",function(e){
	  if($("#txt_id").val()=="" || $("#txt_id").val()==null){
		 $("#txt_id").focus();
	 }
	 else if($("#txt_name").val()=="" || $("#txt_name").val()==null){
		 $("#txt_name").focus();
	 }
	 else{
		 var txt_name=$("#txt_name").val();
		 var txt_hide=$("#txt_hide").val();
		 var txt_id=$("#txt_id").val();
		 $.ajax({
			 type:"POST",
			 url:"ward_master_do.php",
			 data:{txt_name:txt_name,txt_hide:txt_hide,txt_id:txt_id},
			 success:function(r_data){
				 alert(r_data);
				 window.location.replace("ward_master.php");
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