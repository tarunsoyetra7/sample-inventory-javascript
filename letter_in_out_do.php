<?php
if(isset($_COOKIE['login'])){
$login_id=$_COOKIE['login'];
require("root/db_connection.php");
if(isset($_REQUEST['txt_name'])){
$txt_name=str_replace("'","",$_REQUEST['txt_name']);
$txt_hide=str_replace("'","",$_REQUEST['txt_hide']);
$txt_sub=str_replace("'","",$_REQUEST['txt_sub']);
$txt_add=str_replace("'","",$_REQUEST['txt_add']);
$txt_id=str_replace("'","",$_REQUEST['txt_id']);
$txt_sel_date=str_replace("'","",$_REQUEST['txt_sel_date']);
$txt_sel_emp=str_replace("'","",$_REQUEST['txt_sel_emp']);
$txt_sel_in_out=str_replace("'","",$_REQUEST['txt_sel_in_out']);
$txt_sel_type=str_replace("'","",$_REQUEST['txt_sel_type']);
if($txt_hide=="" || $txt_hide==NULL){
$q=$db->query("insert into letter_in_out(letter_user,letter_s_name,letter_in_out,letter_type,letter_date,letter_id,letter_sub,letter_add,created_by,created_on) values($txt_sel_emp,'$txt_name',$txt_sel_in_out,'$txt_sel_type','$txt_sel_date',$txt_id,'$txt_sub','$txt_add',$login_id,NOW())") or die("");
echo"Successfully Added ...";
}else{
$q=$db->query("update letter_in_out set letter_user=$txt_sel_emp,letter_s_name='$txt_name',letter_in_out=$txt_sel_in_out,letter_type='$txt_sel_type',letter_date='$txt_sel_date',letter_sub='$txt_sub',letter_id=$txt_id,letter_sub='$txt_sub',letter_add='$txt_add',updated_by=$login_id,updated_on=NOW() where id=$txt_hide") or die("");
echo"Successfully Updated ...";
}
}else if(isset($_REQUEST['del_id'])){
$del_id=$_REQUEST['del_id'];
$q=$db->query("delete from letter_in_out where id=$del_id") or die("");
echo "Successfully Deleted ...";
}else{
echo"Try Again";	
}		
}else{
header("location:login-page.php");	
}
?>

