<?php
if(isset($_COOKIE['login'])){
$login_id=$_COOKIE['login'];
require("root/db_connection.php"); 
if(isset($_REQUEST['txtItem']) && isset($_REQUEST['txtType']) && isset($_REQUEST['txtQuantity']) && isset($_REQUEST['txtDate'])){
$txtItem=str_replace("'","",$_REQUEST['txtItem']);
$txtType=str_replace("'","",$_REQUEST['txtType']);
$txtQuantity=str_replace("'","",$_REQUEST['txtQuantity']);
$txtDate=str_replace("'","",$_REQUEST['txtDate']);
$txtPaymode=str_replace("'","",$_REQUEST['txtPaymode']);
$txtPayname=str_replace("'","",$_REQUEST['txtPayname']);
$txt_hide_service_id=str_replace("'","",$_REQUEST['txt_hide_service_id']);
$txt_hide=str_replace("'","",$_REQUEST['txt_hide']);
if($txt_hide=="" || $txt_hide==NULL){
$selQ=$db->query("SELECT item_quantity FROM item_detail_master WHERE id=$txtItem") or die("");
$selQ_res=$selQ->fetch(PDO::FETCH_ASSOC);
$quantity=$selQ_res['item_quantity'];
if($txtType==1 || $txtType==3){
$quantity=$quantity+$txtQuantity;
} else {
$quantity=$quantity-$txtQuantity;
}
$qU=$db->query("update item_detail_master set item_quantity='$quantity',updated_by=$login_id,updated_on=NOW() where id=$txtItem") or die("");
$q=$db->query("insert into item_master(item_id,ward_id,in_out_type,item_date,item_quantity,intake_type,intake_name,created_by,created_on) values($txtItem,'$txt_hide_service_id',$txtType,'$txtDate',$txtQuantity,$txtPaymode,'$txtPayname',$login_id,NOW())") or die("");
echo"Successfully Added ...";
}else{
$selIQ=$db->query("SELECT item_quantity FROM item_master WHERE id=$txt_hide") or die("");
$selIQ_res=$selIQ->fetch(PDO::FETCH_ASSOC);
$selQ=$db->query("SELECT item_quantity FROM item_detail_master WHERE id=$txtItem") or die("");
$selQ_res=$selQ->fetch(PDO::FETCH_ASSOC);
$Quan=$txtQuantity-$selIQ_res['item_quantity'];
$quantity=$selQ_res['item_quantity'];
if($txtType==1 || $txtType==3){
$quantity=$quantity+$Quan;
} else {
$quantity=$quantity-$Quan;
}
$qU=$db->query("update item_detail_master set item_quantity='$quantity',updated_by=$login_id,updated_on=NOW() where id=$txtItem") or die("");
$q=$db->query("update item_master set item_id=$txtItem,in_out_type=$txtType,ward_id='$txt_hide_service_id',item_date='$txtDate',item_quantity=$txtQuantity,intake_name=$txtPaymode,intake_name='$txtPayname',updated_by=$login_id,updated_on=NOW() where id=$txt_hide") or die("");
echo"Successfully Updated ...";
}
}else if(isset($_REQUEST['del_id'])){
$del_id=$_REQUEST['del_id'];
$selQ=$db->query("SELECT item_quantity,item_id,in_out_type FROM item_master where id=$del_id") or die("");
$selQ_res=$selQ->fetch(PDO::FETCH_ASSOC);
$par_id=$selQ_res['item_id'];
$selIQ=$db->query("SELECT item_quantity FROM item_detail_master where id=$par_id") or die("");
$selIQ_res=$selIQ->fetch(PDO::FETCH_ASSOC);
$quantity=$selIQ_res['item_quantity'];
if($selQ_res['in_out_type']==1 || $selQ_res['in_out_type']==3){
$quantity=$quantity-$selQ_res['item_quantity'];
} else if($selQ_res['in_out_type']==2) {
$quantity=$quantity+$selQ_res['item_quantity'];
}
$qU=$db->query("update item_detail_master set item_quantity='$quantity',updated_by=$login_id,updated_on=NOW() where id=$par_id") or die("");
$q=$db->query("delete from item_master where id=$del_id") or die("");
echo "Successfully Deleted ...";
}else{
echo"Try Again";	
}		
}else{
header("location:login-page.php");	
}
?>

