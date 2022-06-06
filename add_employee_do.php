<?php
if(isset($_COOKIE['login']))
{	
	require("root/db_connection.php");
	if(isset($_REQUEST['txt_e_name']) && isset($_REQUEST['txt_e_pass'])){			
		$txt_e_name=$_REQUEST['txt_e_name'];
		$txt_e_pass=$_REQUEST['txt_e_pass'];
		$txtImage=$_FILES['txtImage']['name'];
		$imgExt=pathinfo($txtImage,PATHINFO_EXTENSION);


$txtHide=$_REQUEST['txtHide'];
if($txtHide=="" || $txtHide==NULL){
	
	
	
	if($imgExt=="" || $imgExt==NULL || $imgExt=="jpg" || $imgExt=="JPG" ||  $imgExt=="PNG" || $imgExt=="png" || $imgExt=="jpeg" || $imgExt=="JPEG"){

$q=$db->query("insert into user_infromation(user_name,user_pass,profile_ext)
values('$txt_e_name','$txt_e_pass','$imgExt')") or die("error");

$lastID=$db->lastInsertId();
$img_name=$lastID.".".$imgExt;
move_uploaded_file($_FILES['txtImage']['tmp_name'],"employee_profile/".$img_name);


?>
    	<script>
			alert("Successfully Added !....");
			window.location.replace("add_employee.php");
		</script>
    <?php

}
else{
	?>
    	<script>
			alert("Try Again !....");
			window.location.replace("add_employee.php");
		</script>
    <?php
}




}
else{
	
	
	if($imgExt=="jpg" || $imgExt=="JPG" ||  $imgExt=="PNG" || $imgExt=="png" || $imgExt=="jpeg" || $imgExt=="JPEG"){
		
		$updateQ=$db->query("update user_infromation set user_name='$txt_e_name',user_pass='$txt_e_pass',profile_ext='$imgExt' where user_id=$txtHide") or die("");
		
		$img_name=$txtHide.".".$imgExt;
move_uploaded_file($_FILES['txtImage']['tmp_name'],"employee_profile/".$img_name);


?>
	<script>
		alert("Sucessfully Updated !....");
		window.location.replace("add_employee.php?edit_id=<?php echo $txtHide; ?>");
	</script>
<?php


	}
	else{
		
		$updateQ=$db->query("update user_infromation set user_name='$txt_e_name',user_pass='$txt_e_pass' where user_id=$txtHide") or die("");
		
		?>
        	<script>
				alert("Sucessfully Updated !....");
				window.location.replace("add_employee.php?edit_id=<?php echo $txtHide; ?>");
			</script>
        <?php
		
	}
	
	
	
}



 ?>
 <script>
alert('Record Saved Successfully');
window.location.replace('add_employee.php');
</script>
 <?php
	
}
else{
	?>
    <script>

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