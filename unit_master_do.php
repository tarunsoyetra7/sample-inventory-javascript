<?php
if(isset($_COOKIE['login'])){
$login_id=$_COOKIE['login'];
require("root/db_connection.php");
if(isset($_REQUEST['txt_name'])){
$txt_name=str_replace("'","",$_REQUEST['txt_name']);
$txt_hide=str_replace("'","",$_REQUEST['txt_hide']);
if($txt_hide=="" || $txt_hide==NULL){
$q=$db->query("insert into unit_master(unit_sym,created_by,created_on) values('$txt_name',$login_id,NOW())") or die("");
echo"Successfully Saved ...";
}else{
$q=$db->query("update unit_master set unit_sym='$txt_name',updated_by=$login_id,updated_on=NOW() where id=$txt_hide") or die("");
echo"Successfully Updated ...";
}
}else if(isset($_REQUEST['del_id'])){
$del_id=$_REQUEST['del_id'];
$q=$db->query("delete from unit_master where id=$del_id") or die("");
echo "Successfully Deleted ...";
}else{
echo"Try Again";	
}		
}else{
header("location:login-page.php");	
}
?>

