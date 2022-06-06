<?php
if(isset($_COOKIE['login'])){
$login_id=$_COOKIE['login'];
require("root/db_connection.php");
if(isset($_REQUEST['cur_id'])){
$cur_id=str_replace("'","",$_REQUEST['cur_id']);
$q=$db->query("SELECT item_quantity FROM item_detail_master where id=$cur_id") or die("");
$q_res=$q->fetch(PDO::FETCH_ASSOC);
echo $q_res['item_quantity'];
}else{
echo"Try Again";	
}		
}else{
header("location:login-page.php");	
}
?>

