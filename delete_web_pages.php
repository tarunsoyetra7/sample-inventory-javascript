<?php
if(isset($_COOKIE['login']))
{
require("root/db_connection.php");
if(isset($_REQUEST['del_id'])){
$del_id=str_replace("'","",$_REQUEST['del_id']);
$delQ=$db->query("delete from authentication where a_id=$del_id") or die("");
if($delQ==TRUE){
echo "Sucessfully Deleted";
} else{
echo "Try Again";
}
}else{
echo "Try Again";
}
} else {
header("location:login-page.php");	
}
?>
