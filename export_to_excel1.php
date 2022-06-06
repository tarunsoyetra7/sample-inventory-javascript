<?php if(isset($_COOKIE['login']))
{	
	require("root/db_connection.php");
	
?>
<?php
$filename = "Store-in-management.xls"; // File Name
// Download file
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

?>
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
		
<?php } else{
	header("location:../index.php");	
}
?>