<?php
if(isset($_COOKIE['login']))
{
	$login_id=$_COOKIE['login'];
	require("root/db_connection.php");

	$emp_id=$_REQUEST['emp_id'];
	$q=$db->query("SELECT
   a_id as auth_id
FROM user_infromation,
  authentication
WHERE user_id =$emp_id
    AND FIND_IN_SET(authentication.a_id,user_auth);") or die("");
	if($q->rowCount()==0)
	{
		echo json_encode("");
	}
	else
	{
		while($res=$q->fetch(PDO::FETCH_ASSOC))
		{
			$resArray[]=$res;
		}
		echo json_encode($resArray);
	}
	
	
}
else{
	header("location:login-page.php");	
}
?>