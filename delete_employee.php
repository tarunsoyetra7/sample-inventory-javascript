<?php
	if(isset($_COOKIE['login']))
	{	
		require("root/db_connection.php");
			$del_id=$_REQUEST['del_id'];
			$q=$db->query("update  user_infromation set delstatus=1 where user_id=$del_id");
			echo "successfully deleted";
	}
	else
	{
		header("location:login-page.php");
	}
?>