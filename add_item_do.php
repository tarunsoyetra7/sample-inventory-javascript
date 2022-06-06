<?php
if(isset($_COOKIE['login'])){
$login_id=$_COOKIE['login'];
require("root/db_connection.php");
if(isset($_REQUEST['txt_name'])){
$txt_name=str_replace("'","",$_REQUEST['txt_name']);
$txt_hide=str_replace("'","",$_REQUEST['txt_hide']);
$txt_unit=str_replace("'","",$_REQUEST['txt_unit']);
$txt_machine=str_replace("'","",$_REQUEST['txt_machine']);
$txt_sel_type=str_replace("'","",$_REQUEST['txt_sel_type']);
if($txt_hide=="" || $txt_hide==NULL){
$q=$db->query("insert into item_detail_master(item_name,item_unit,machine_number,item_type,created_by,created_on) values('$txt_name',$txt_unit,'$txt_machine',$txt_sel_type,$login_id,NOW())") or die("");
echo"Successfully Added ...";
}else{
$q=$db->query("update item_detail_master set item_name='$txt_name',item_unit=$txt_unit,item_type=$txt_sel_type,machine_number='$txt_machine',updated_by=$login_id,updated_on=NOW() where id=$txt_hide") or die("");
echo"Successfully Updated ...";
}
}else if(isset($_REQUEST['del_id'])){
$del_id=$_REQUEST['del_id'];
$q=$db->query("delete from item_detail_master where id=$del_id") or die("");
echo "Successfully Deleted ...";
}else{
echo"Try Again";	
}		
}else{
header("location:login-page.php");	
}
?>

