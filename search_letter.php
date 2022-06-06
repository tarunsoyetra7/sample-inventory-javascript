<?php
include("root/db_connection.php");

if(isset($_REQUEST['startdate']) || isset($_REQUEST['enddate'])){
	$startdate=str_replace("'","",$_REQUEST['startdate']);
	$enddate=str_replace("'","",$_REQUEST['enddate']);
	$type=str_replace("'","",$_REQUEST['type']);
	$item_id=str_replace("'","",$_REQUEST['item_id']);
	if($startdate!=null && $enddate!=null && $item_id!=0)
	{
		$condition="AND letter_date>='$startdate' AND letter_date<='$enddate' AND user_id=$item_id ";
	}
	else if($startdate!=null && $item_id!=0)
	{
		$condition="AND letter_date>='$startdate' AND user_id=$item_id ";
	}
	else if($enddate!=null && $item_id!=0)
	{
		$condition="AND letter_date<='$enddate' AND user_id=$item_id ";
	}
	else if($item_id!=0){
		$condition="AND user_id=$item_id ";
	}
	else if($startdate!=null && $enddate!=null)
	{
		$condition="AND letter_date>='$startdate' AND letter_date<='$enddate' ";
	}
	else if($startdate!=null)
	{
		$condition="AND letter_date>='$startdate'";
	}
	else if($enddate!=null)
	{
		$condition="AND letter_date<='$enddate'";
	}
	if($type==1){
		$letter="AND letter_in_out=1 AND letter_type=1";
	}
	else if($type==2){
		$letter="AND letter_in_out=1 AND letter_type=2";
	}
	else if($type==3){
		$letter="AND letter_in_out=2 AND letter_type=1";
	}
	else{
		$letter="AND letter_in_out=2 AND letter_type=2";
	}
	$query=$db->query("SELECT id,letter_s_name,letter_date,letter_id,letter_sub,letter_add,flag,user_name FROM letter_in_out,user_infromation WHERE letter_user=user_id $letter $condition") or die("");
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