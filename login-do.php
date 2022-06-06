<?php
include("root/db_connection.php");
if(isset($_REQUEST['u_name']) && isset($_REQUEST['u_pass'])){	 
$user_name=str_replace("'","",$_REQUEST['u_name']);
$user_pass=str_replace("'","",$_REQUEST['u_pass']);
$query=$db->query("select * from user_infromation where user_name='$user_name' and user_pass='$user_pass' and delstatus=0") or die("error");	
if($query->rowCount()==0){
echo "err";
} else {
while($result=$query->fetch(PDO::FETCH_ASSOC)) {
if($user_name==$result['user_name'] && $user_pass==$result['user_pass']) {
$admin_id=$result['user_id'];
$expireTime=time()+60*60*24*30;
setcookie("login",$admin_id,$expireTime);
echo "successfully Login";
$loginTimeQ=$db->query("insert into login_status(login_id,login_date_time) values($admin_id,NOW())") or die("");
} else {
echo "err";
}
}
}
} else {
echo "err";
}
?>

