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
<style>
.table_show{
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
							<li><a href="add_item.php">Add Item</a></li>
							<li><a href="item_master.php">Item Entry</a></li>
							<li ><a href="manage_in_item.php">Manage In Item</a></li>
							<li><a href="manage_out_item.php">Manage Out Item</a></li>
							<li><a href="manage_item_record.php">Item Returned</a></li>
							<li><a href="manage_balance_item.php">Balance Sheet</a></li>
							<li class="active"><a href="manage_store.php">Manage Store</a></li>
							<li ><a href="manage_store_in.php">Item In Store</a></li>
						</ul>
						<br>
					</div>
					
<?php if(isset($_REQUEST['startdate']) || isset($_REQUEST['enddate'])){
	$startdate=str_replace("'","",$_REQUEST['startdate']);
	$enddate=str_replace("'","",$_REQUEST['enddate']);
	
	 if($startdate!=null && $enddate!=null)
	{
		$condition="AND item_date>='$startdate' AND item_date<='$enddate' ";
	}
	else if($startdate!=null)
	{
		$condition="AND item_date>='$startdate'";
	}
	else if($enddate!=null)
	{
		$condition="AND item_date<='$enddate'";
	} ?>	
					<div class="col-lg-6">
					<label> Select Date From : </label>
					<input type='date' value="<?php echo $startdate; ?>" name='startdate'class="form-control"  id="startdate">
					</div>
					<div class="col-lg-6">
					<label> Select Date To : </label>
					<input type='date' value="<?php echo $enddate; ?>" name='enddate'class="form-control" id="enddate">
					<br>
					<input type="hidden" id="type" name="type" value="2">
					</div>
					<div style="clear:both"></div>	
					<div class="col-lg-12">
					<a style="margin-bottom:20px;" href="export_to_excel.php?startdate=<?php echo $startdate; ?>&enddate=<?php echo $enddate; ?>" target="_blank"><b>Export to Excel</b></a>
		<table class="table table-middle dataTable table-bordered table-condensed table-hover">
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
						
						$item_check=$db->query("SELECT item_detail_master.id,item_name,item_unit,unit_sym from item_detail_master,unit_master WHERE unit_master.id=item_unit") or die("");
                while($item_res=$item_check->fetch(PDO::FETCH_ASSOC)){	
							
						$item_id=$item_res['id'];
						
						$detail=$db->query("select * from item_master where item_id=$item_id AND in_out_type=2 AND FIND_IN_SET($ward_id,ward_id) $condition") or die("");
						if($detail->rowCount()==0){
						?>	<td> - </td> <?php
						}$b=0; $count=0;
						while($detail_res=$detail->fetch(PDO::FETCH_ASSOC)){
						$count++;
						
						$a=$detail_res['item_quantity'];
					       $b=(float)$a+(float)$b;
						if($detail->rowCount()==$count){
							?>	<td> <?php echo $b." ".$item_res['unit_sym']; ?></td> <?php
						}
					     
						}
						}
						
						?>
						
						</tr>

			<?php	} 
				?>
				<tr>
						<td>Total :-</td> <?php 
						$itmQ=$db->query("SELECT item_detail_master.id,item_name,item_unit,unit_sym from item_detail_master,unit_master WHERE unit_master.id=item_unit");
						while($res=$itmQ->fetch(PDO::FETCH_ASSOC)){
							$item_id=$res['id'];
						$query1=$db->query("SELECT SUM(item_quantity) as sum FROM item_master WHERE  in_out_type=2 $condition AND item_id=$item_id");
						$result=$query1->fetch(PDO::FETCH_ASSOC);
						if($result['sum']==null) {
							?><td> - <?php 
						}
						else {
							?><td><?php echo $result['sum']." ".$res['unit_sym']; ?></td><?php 
						}
						}
						?>
						</tr>
				
			</tbody>
		</table>
		</div>
<?php } else { ?>
					<div class="col-lg-6">
					<label> Select Date From : </label>
					<input type='date' name='startdate'class="form-control"  id="startdate">
					</div>
					<div class="col-lg-6">
					<label> Select Date To : </label>
					<input type='date'  name='enddate'class="form-control" id="enddate">
					<br>
					<input type="hidden" id="type" name="type" value="2">
					</div>
					<div style="clear:both"></div>
<?php } ?>
                </div>
            </div>
        </div>
    </div>
	
 <script src="js/jquery.js"></script>
 <script src="js/bootstrap.min.js"></script>
 <script>
 $("#startdate").on("change",function(e){
	var startdate=$("#startdate").val();
	var enddate=$("#enddate").val();	
    window.location.replace("manage_store.php?startdate="+startdate+"&enddate="+enddate);
 });
 </script> 
  <script>
 $("#enddate").on("change",function(e){
	var startdate=$("#startdate").val();
	var enddate=$("#enddate").val();
    window.location.replace("manage_store.php?startdate="+startdate+"&enddate="+enddate);
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