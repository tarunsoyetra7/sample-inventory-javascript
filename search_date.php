<?php
include("root/db_connection.php");

if(isset($_REQUEST['startdate']) || isset($_REQUEST['enddate'])){
	$startdate=str_replace("'","",$_REQUEST['startdate']);
	$enddate=str_replace("'","",$_REQUEST['enddate']);
	$type=str_replace("'","",$_REQUEST['type']);
	$item_id=str_replace("'","",$_REQUEST['item_id']);
	
	if($startdate!=null && $enddate!=null && $item_id!=0)
	{
		$condition="AND item_date>='$startdate' AND item_date<='$enddate' AND item_detail_master.id=$item_id ";
	}
	else if($startdate!=null && $item_id!=0)
	{
		$condition="AND item_date>='$startdate' AND item_detail_master.id=$item_id ";
	}
	else if($enddate!=null && $item_id!=0)
	{
		$condition="AND item_date<='$enddate' AND item_detail_master.id=$item_id ";
	}
	else if($item_id!=0){
		$condition="AND item_detail_master.id=$item_id ";
	}
	else if($startdate!=null && $enddate!=null)
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
	}
	$query=$db->query("SELECT item_master.id as i_id,item_detail_master.id,item_master.item_date,ward_id,item_unit,unit_sym,flag,item_name,item_master.item_quantity,item_master.created_on,intake_name,intake_type from item_master,item_detail_master,unit_master where in_out_type=$type AND unit_master.id=item_unit and item_id=item_detail_master.id $condition order by item_master.id desc ") or die("");
	if($query->rowCount()==0){
		echo json_encode("");
	}
	else{
		while($result=$query->fetch(PDO::FETCH_ASSOC)){
			$fetchArray[]=$result;
		}
		echo json_encode($fetchArray);
	}
}

else {
	echo json_encode("err");
}
?>