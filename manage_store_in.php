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
							<li><a href="manage_balance_item.php">Balance Sheet</a></li>
							<li ><a href="manage_store.php">Manage Store</a></li>
							<li class="active"><a href="manage_store_in.php">Item In Store</a></li>
						</ul>
						<br>
					</div>
					<div style="clear:both"></div>
					
					
			<div class="col-lg-12">		
			<a style="margin-bottom:20px;" href="export_to_excel1.php" target="_blank"><b>Export to Excel</b></a>
		<table class="table table-middle dataTable table-bordered table-condensed table-hover">
			<thead>
				<tr style="background:#000; color:#fff;">
				<th>Item Name</th>	
				<?php $header_check=$db->query("SELECT id,item_name from item_detail_master") or die("");
                while($header_res=$header_check->fetch(PDO::FETCH_ASSOC))
				{ ?>
						<th><?php echo $header_res['item_name'];?></th>
			<?php	}
				?>
				</tr>
			</thead>
			<tbody>
			
						<tr>
						<td>Quantity</td>	
						<?php 
						$item_check=$db->query("SELECT item_detail_master.id,item_quantity,item_unit,unit_sym from item_detail_master,unit_master WHERE unit_master.id=item_unit") or die("");
                while($item_res=$item_check->fetch(PDO::FETCH_ASSOC)){ 	?>
						
						<td><?php echo $item_res['item_quantity']." ".$item_res['unit_sym']; ?></td>
						
					<?php	}
						?>
						
						</tr>
		
			</tbody>
		</table>
		</div>
               
            </div>
        </div>
    </div>
	
 <script src="js/jquery.js"></script>
 <script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php
}
else
{
	header("location:login-page.php");	
}
?>