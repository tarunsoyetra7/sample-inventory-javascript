<?php
if(isset($_COOKIE['login']))
{
	$login_id=$_COOKIE['login'];
	require("root/db_connection.php");
	
	$emp_id=$_REQUEST['emp_id'];
	$auth_values=$_REQUEST['auth_values'];
	
	$query=$db->query("update user_infromation set user_auth='$auth_values' where user_id='$emp_id'") or die("");
	
	echo "Sucessfully Authenticate...!";
		
}
else{
	header("location:login-page.php");	
}
?>