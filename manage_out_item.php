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
                        <h4 align="center"><strong>Storage Management</strong></h4>                         
					   <hr>
                    </div>
					<div class="col-lg-12">
						<ul class="nav nav-tabs">
							<li><a href="add_item.php">Add Item</a></li>
							<li><a href="item_master.php">Item Entry</a></li>
							<li ><a href="manage_in_item.php">Manage In Item</a></li>
							<li  class="active"><a href="manage_out_item.php">Manage Out Item</a></li>
							<li><a href="manage_item_record.php">Item Returned</a></li>
							<li><a href="manage_balance_item.php">Balance Sheet</a></li>
							<li><a href="manage_store.php">Manage Store</a></li>
							<li ><a href="manage_store_in.php">Item In Store</a></li>
						</ul>
						<br>
					</div>
					<div class="col-lg-4">
					<label>Select Item: </label>

					<select id="txt_sel_item" name="" class="form-control" >
					<option value='0'>--Select Any Category--</option>
					<?php $list=$db->query("SELECT id,item_name FROM item_detail_master") or die("");
						  while($list_res=$list->fetch(PDO::FETCH_ASSOC))
						  { ?>
							  <option value="<?php echo $list_res['id']; ?>"><?php echo $list_res['item_name']; ?></option>
					<?php	  }	
					?>
					</select>
					
					</div>
					<div class="col-lg-4">
					<label> Select Date From : </label>
					<input type='date' name='startdate'class="form-control"  id="startdate">
					</div>
					<div class="col-lg-4">
					<label> Select Date To : </label>
					<input type='date' name='enddate'class="form-control" id="enddate">
					<br>
					<input type="hidden" id="type" name="type" value="2">
					</div>
					<div class="col-lg-12">
					
					<table id="example1" class="table table-middle dataTable table-bordered table-condensed table-hover">

                        	<thead style="background:#000; color:#fff;">
                            	<tr>
                                	<th>S No</th>
                                    <th>Item Name</th>
                                    <th>Item Quantity</th>
                                    <th>Ward Detail</th>
									<th>Date</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody id="table_show">
							<?php 
							$q=$db->query("SELECT item_name,item_unit,unit_sym,item_master.id,item_master.item_quantity,item_date,item_master.ward_id FROM item_detail_master,item_master,unit_master WHERE in_out_type=2 AND item_detail_master.id=item_master.item_id AND unit_master.id=item_unit order by id desc") or die("");
							$i=0;
							while($res=$q->fetch(PDO::FETCH_ASSOC)){ $i++;
							$ward_id=$res['ward_id'];
							?>
                            	<tr>
                                	<td><?php echo $i; ?></td>
                                    <td><?php echo $res['item_name']; ?></td>
									<td><?php echo $res['item_quantity']."  ".$res['unit_sym']; ?></td>
							<td><?php $ward_q=$db->query("SELECT ward_name,ward_id FROM ward_master where FIND_IN_SET(id,'$ward_id')") or die(""); while($ward_res=$ward_q->fetch(PDO::FETCH_ASSOC)){
							echo "Ward No :- ".$ward_res['ward_id']." ".$ward_res['ward_name']; echo "<br>";} ?></td>
									<td><?php echo $res['item_date']; ?></td> 
                                    <td><button type="button" class="btn btn-sm btn-info btn_edit" id="<?php echo $res['id']; ?>">Edit</button>
                                     <button type="button" class="btn btn-sm btn-danger btn_delete" id="<?php echo $res['id']; ?>">Delete</button>
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
 function check_date(){
	var item_id=$("#txt_sel_item option:selected").val();
	var startdate=$("#startdate").val();
	var enddate=$("#enddate").val();
	var type=$("#type").val();
   
	$.ajax({
		type:"POST",
		data:{startdate:startdate,enddate:enddate,type:type,item_id:item_id},
		url:"search_date_out.php",
		success:function(r_data){
			if(r_data.length==0){
				$("#table_show").html("No Data Found !...");
			}
			else{
			r_data=r_data.trim();
			console.log(r_data);
			$("#table_show").html(r_data);
			}
		},error:function(err){
		 $("#table_show").html("No Data Found !...");		
		}
	}); 
 }
 $("#startdate").on("change",function(e){
	 check_date();
 });
 </script> 
 <script>
 $("#txt_sel_item").on("change",function(e){
	check_date();
 });
 </script>
  <script>
 $("#enddate").on("change",function(e){
	check_date(); 
 });
 </script>
  <script>
 $(".btn_edit").on("click",function(e){
	var cur_id=$(this).attr("id");
	window.location.replace("item_master.php?id="+cur_id);
 });
 </script>
 <script>
 $(".btn_delete").on("click",function(e){
	var del_id=$(this).attr("id");
	$.ajax({
		type:"POST",
		data:{del_id:del_id},
		url:"item_master_do.php",
		success:function(r_data){
			alert(r_data);
			location.reload();
		},error:function(err){
		}
	});
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