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
							<li><a href="manage_out_item.php">Manage Out Item</a></li>
							<li><a href="manage_item_record.php">Item Returned</a></li>
							<li  class="active"><a href="manage_balance_item.php">Balance Sheet</a></li>
							<li><a href="manage_store.php">Manage Store</a></li>
							<li ><a href="manage_store_in.php">Item In Store</a></li>
						</ul>
						<br>
					</div>
					<div class="col-lg-12">
					<table id="example1" class="table table-middle dataTable table-bordered table-condensed table-hover">

                        	<thead style="background:#000; color:#fff;">
                            	<tr>
                                	<th>S No</th>
                                    <th>Item Name</th>
                                    <th>Item Quantity</th>
                                    <th>Sender's Name</th>
									<th>Date</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
							<?php $q=$db->query("SELECT item_name,item_master.id,item_master.item_quantity,unit_sym,item_unit,flag,item_date,intake_type,intake_name FROM item_detail_master,item_master,unit_master WHERE in_out_type=1 AND intake_type=3 AND flag=0 AND item_detail_master.id=item_master.item_id AND unit_master.id=item_unit") or die("");
							$i=0;
							while($res=$q->fetch(PDO::FETCH_ASSOC)){ $i++;
							?>
								<tr>
                                	<td><?php echo $i; ?></td>
                                    <td><?php echo $res['item_name']; ?></td>
									<td><?php echo $res['item_quantity']." ".$res['unit_sym']; ?></td>
									<td><?php echo $res['intake_name']; ?></td>
									<td><?php echo $res['item_date']; ?></td> 
                                    <td><button type="button" class="btn btn-sm btn-info btn_return" id="<?php echo $res['id']; ?>">Return</button>
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
 $(".btn_return").on("click",function(e){
	var id=$(this).attr("id");
	$.ajax({
		type:"POST",
		data:{id:id},
		url:"return_item.php",
		success:function(r_data){
			r_data=r_data.trim();
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