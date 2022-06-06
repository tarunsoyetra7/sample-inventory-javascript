<?php
include("root/db_connection.php");

if(isset($_REQUEST['item_id'])){
	$item_id=str_replace("'","",$_REQUEST['item_id']);
	$type=$_REQUEST['type'];
	
	$query=$db->query("SELECT item_master.id as i_id,item_detail_master.id,flag,item_master.item_date,item_name,item_unit,item_master.item_quantity,item_master.created_on,intake_name,intake_type from item_master,item_detail_master where in_out_type=$type and item_detail_master.id=$item_id and item_id=item_detail_master.id  order by item_master.id asc ") or die("");
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