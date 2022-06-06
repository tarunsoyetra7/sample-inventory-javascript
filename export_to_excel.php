<?php if(isset($_COOKIE['login']))
{	
	require("root/db_connection.php");
	
?>
<?php
$filename = "Store-out-management.xls"; // File Name
// Download file
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

$startdate=str_replace("'","",$_REQUEST['startdate']);
$enddate=str_replace("'","",$_REQUEST['enddate']);
	
	if($startdate!=null && $enddate!=null)
	{
		$condition="AND item_date>='$startdate' AND item_date<='$enddate'";
	}
	else if($startdate!=null)
	{
		$condition="AND item_date>='$startdate'";
	}
	else if($enddate!=null)
	{
		$condition="AND item_date<='$enddate'";
	} 
?>
<table>
			<thead>
				<tr style=" background:#000; color:#fff;">
						<th style="padding:10px;">ward no.</th>
				<?php $header_check=$db->query("SELECT id,item_name from item_detail_master") or die("");
                while($header_res=$header_check->fetch(PDO::FETCH_ASSOC))
				{ ?>
						<th style="padding:10px;"><?php echo $header_res['item_name'];?></th>
			<?php	}
				?>
				</tr>
			</thead>
			<tbody>
				<?php 
				$ward=$db->query("SELECT id,ward_id,ward_name from ward_master") or die("");
				while($ward_res=$ward->fetch(PDO::FETCH_ASSOC)){ 
						$ward_id=$ward_res['id'];  ?>
						
						<tr>
							<td><?php echo $ward_res['ward_id'].".".$ward_res['ward_name']; ?></td>
						<?php 
						$item_check=$db->query("SELECT id,item_name,item_unit from item_detail_master") or die("");
                while($item_res=$item_check->fetch(PDO::FETCH_ASSOC)){
					if($item_res['item_unit']==1){
								$unit="KG";
							}
							else if($item_res['item_unit']==2){
								$unit="Lt";
							}
							else{
								$unit="Piece";
							}	
							
						$item_id=$item_res['id'];
						
						
						$detail=$db->query("select * from item_master where item_id=$item_id AND in_out_type=2 AND FIND_IN_SET($ward_id,ward_id) $condition") or die("");
						$detail_res=$detail->fetch(PDO::FETCH_ASSOC);
						
						if($detail->rowCount()==0){
						?>	<td> - </td> <?php
						}
						else
						{
							?>	<td> <?php echo $detail_res['item_quantity']." ".$unit; ?></td> <?php
						}
						
						}
						?>
						
						</tr>
						
						
			<?php	} 
				?>
			</tbody>
		</table>
		
<?php } else{
	header("location:../index.php");	
}
?>