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
<style>
.machine{
	display:none;
}
</style>
    <div id="wrapper">
        <?php  include("header.php");  ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
				  <div class="col-lg-12">
                        <h4 align="center"><strong>Storage Management</strong></h4>                         
					   <hr>
                    </div>
					<div class="col-lg-12">
						<ul class="nav nav-tabs">
							<li  class="active"><a href="add_item.php">Add Item</a></li>
							<li><a href="item_master.php">Item Entry</a></li>
							<li ><a href="manage_in_item.php">Manage In Item</a></li>
							<li><a href="manage_out_item.php">Manage Out Item</a></li>
							<li><a href="manage_item_record.php">Item Returned</a></li>
							<li><a href="manage_balance_item.php">Balance Sheet</a></li>
							<li><a href="manage_store.php">Manage Store</a></li>
							<li ><a href="manage_store_in.php">Item In Store</a></li>
						</ul>
						<br>
					</div>
					</div>
						<?php 
						if(isset($_REQUEST['edit_id'])){
						$edit_id=$_REQUEST['edit_id'];
						$editQ=$db->query("SELECT * FROM item_detail_master where id=$edit_id") or die("");
						$editQ_res=$editQ->fetch(PDO::FETCH_ASSOC);
						if($editQ_res['item_type']==2){
							$condition='display:block;';
						}
						else {
							$condition='';
						}
						?>
						<div class="col-lg-6">
						<label>Item Name</label>
						<input type="text" id="txt_name" value="<?php echo $editQ_res['item_name']; ?>" class="form-control" placeholder="Enter Item Name *">
						<input type="hidden" id="txt_hide" value="<?php echo $edit_id; ?>"><br>
						</div>
						<div class="col-lg-6">
						<label>Item Unit</label>
						<select id="txt_sel_unit" class="form-control">
						<option value='0'>Select Unit</option>
						<?php $unitQ=$db->query("SELECT id,unit_sym FROM unit_master") or die("");
						while($unit_res=$unitQ->fetch(PDO::FETCH_ASSOC)){
							if($unit_res['id']==$editQ_res['item_unit']){	?>
							<option selected value="<?php echo $unit_res['id']; ?>"><?php echo $unit_res['unit_sym']; ?></option>
							<?php } else { ?>
							<option value="<?php echo $unit_res['id']; ?>"><?php echo $unit_res['unit_sym']; ?></option>
						<?php } } ?>
						</select><br>
						<input type="hidden" id="txt_hide" value="<?php echo $edit_id; ?>">
						</div>
						<div class="col-lg-6">
						<label>Item Type</label>
						<select id="txt_sel_type" class="form-control">
						<option value="0">Select Type</option>
						<?php if($editQ_res['item_type']==1){ ?>
						<option selected value="1">Goods</option>
						<option value="2">Machine</option>
						<?php } else if($editQ_res['item_type']==2){ ?>
						<option  value="1">Goods</option>
						<option selected value="2">Machine</option>
						<?php } else { ?>
						<option value="1">Goods</option>
						<option value="2">Machine</option>
						<?php } ?>
						</select><br>
						<input type="hidden" id="txt_hide" value="<?php echo $edit_id; ?>">
						</div>
						<div class="col-lg-6 machine" style="<?php echo $condition; ?>">
						<label>Machine Number</label>
						<input type="text" value="<?php echo $editQ_res['machine_number']; ?>" id="txt_machine" class="form-control" placeholder="Enter Machine Number *">
						<br>
						</div>
						<?php } else { ?>
						<div class="col-lg-6">
						<label>Item Name</label>
						<input type="text" id="txt_name" class="form-control" placeholder="Enter Item Name *">
						<input type="hidden" id="txt_hide"><br>
						</div>
						<div class="col-lg-6">
						<label>Item Unit</label>
						<select id="txt_sel_unit" class="form-control">
						<option value='0'>Select Unit</option>
						<?php $unitQ=$db->query("SELECT id,unit_sym FROM unit_master") or die("");
						while($unit_res=$unitQ->fetch(PDO::FETCH_ASSOC)){ ?>
							<option value="<?php echo $unit_res['id']; ?>"><?php echo $unit_res['unit_sym']; ?></option>
						<?php } ?>
						</select><br>
						</div>
						<div class="col-lg-6">
						<label>Item Type</label>
						<select id="txt_sel_type" class="form-control">
						<option value="0">Select Type</option>
						<option value="1">Goods</option>
						<option value="2">Machine</option>
						</select><br>
						<input type="hidden" id="txt_hide" value="">
						</div>
						<div class="col-lg-6 machine">
						<label>Machine Number</label>
						<input type="text" value="" id="txt_machine" class="form-control" placeholder="Enter Machine Number *">
						<input type="hidden" id="txt_hide"><br>
						</div>
						<?php } ?>
						<div class="col-lg-2" style="padding-top:5px;">
						<br>
						<button type="button" class="btn btn-sm btn-success btn_submit">Submit</button>
						</div>
						<div class="col-lg-12" style="clear:both"><hr><br></div>
						<div class="col-lg-12">
						<table id="example1" class="table table-middle dataTable table-bordered table-condensed table-hover">
							<thead style="background:#000; color:#fff;">
                            	<tr>
                                	<th>S No</th>
                                    <th>Item Name</th>
                                    <th>Item Quantity</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
							<tbody>
							<?php 
							$i=0;
							$selQ=$db->query("SELECT item_detail_master.id,item_name,item_quantity,unit_sym,item_type,machine_number FROM item_detail_master,unit_master WHERE unit_master.id=item_unit order by id desc") or die("");
							while($selQ_res=$selQ->fetch(PDO::FETCH_ASSOC)){ $i++;
							if($selQ_res['item_type']==2){
								$condition="  (".$selQ_res['machine_number'].")";
							} else {
								$condition="";
							}
							?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $selQ_res['item_name'].$condition; ?></td>
									<td><?php echo $selQ_res['item_quantity']."  ".$selQ_res['unit_sym']; ?></td>
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
 $("#txt_sel_type").on("change",function(e){
	 var id=$("#txt_sel_type option:selected").val();
	 if(id==2){
		 $(".machine").css("display","block");
	 }
	 else{
		 $(".machine").css("display","none");
	 }
 });
 $(".btn_edit").on("click",function(e){
	var edit_id=$(this).attr("id");
	window.location.replace("add_item.php?edit_id="+edit_id);
 });
 
 $(".btn_delete").on("click",function(e){
	var del_id=$(this).attr("id");
	$.ajax({
		type:"POST",
		url:"add_item_do.php",
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
	 if($("#txt_name").val()=="" || $("#txt_name").val()==null){
		 $("#txt_name").focus();
	 }
	 else  if($("#txt_sel_unit option:selected").val()==0){
		 $("#txt_sel_unit").focus();
	 }
	 else  if($("#txt_sel_type option:selected").val()==0){
		 $("#txt_sel_type").focus();
	 }
	 else  if($("#txt_sel_type option:selected").val()==2 && $("#txt_machine").val()=="" || $("#txt_machine").val()==null){
		 $("#txt_machine").focus();
	 }
	 else{
		 var txt_name=$("#txt_name").val();
		 var txt_hide=$("#txt_hide").val();
		 var txt_machine=$("#txt_machine").val();
		 var txt_unit=$("#txt_sel_unit option:selected").val();
		 var txt_sel_type=$("#txt_sel_type option:selected").val();
		 $.ajax({
			 type:"POST",
			 url:"add_item_do.php",
			 data:{txt_name:txt_name,txt_hide:txt_hide,txt_unit:txt_unit,txt_sel_type:txt_sel_type,txt_machine:txt_machine},
			 success:function(r_data){
				 alert(r_data);
				 window.location.replace("add_item.php");
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