<?php
	if(isset($_COOKIE['login']))
	{	
		require("root/db_connection.php");
			$del_id=$_REQUEST['id'];
			$q=$db->query("update letter_in_out set flag=1 where id=$del_id");
			echo "Successfully Accepted ...";
	}
	else
	{
		header("location:login-page.php");
	}
?>