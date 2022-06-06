<?php
if(isset($_COOKIE['login']))
{
	header( 'Content-Type: text/html; charset=utf-8' ); 
	require("root/db_connection.php");

	if(isset($_REQUEST['txtHide']) && isset($_REQUEST['txt_e_pass'])){
	
	$txtHide=$_REQUEST['txtHide'];
 
		$txtImage=$_FILES['txtImage']['name'];
		$imgExt=pathinfo($txtImage,PATHINFO_EXTENSION);
 	$txt_e_pass=$_REQUEST['txt_e_pass'];
 if($imgExt=="jpg" || $imgExt=="JPG" ||  $imgExt=="PNG" || $imgExt=="png" || $imgExt=="jpeg" || $imgExt=="JPEG"){
		$img_name=$txtHide.".".$imgExt;
move_uploaded_file($_FILES['txtImage']['tmp_name'],"employee_profile/".$img_name);


		$updateQ=$db->query("update user_infromation set user_pass='$txt_e_pass',profile_ext='$imgExt' where user_id=$txtHide") or die("");
		
?>
	<script>
		alert("Sucessfully Updated !....");
		window.location.replace("edit_employee.php?edit_id=<?php echo $txtHide; ?>");
	</script>
<?php


	}
	}

else{
	?>
    <script>
alert("Try Again !....");
window.location.replace('add_employee.php');
</script>
    <?php
}

 
?>


<?php
}

else
{

	header("location:login-page.php");	
}

?>