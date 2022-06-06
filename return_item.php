<?php 
include("root/db_connection.php");
if(isset($_REQUEST['id'])){
	$id=$_REQUEST['id'];
	$retQ=$db->query("UPDATE item_master set flag=1 where id=$id") or die("");
	echo "Successfully Returned...";
}
else{
}
?>