<?php
if(isset($_COOKIE['login']))
{
	require("root/db_connection.php");
	
	if(isset($_REQUEST['txtName']) && isset($_REQUEST['txtPriority']) && isset($_REQUEST['txtPriority'])){
		
		$txtName=str_replace("'","",$_REQUEST['txtName']);
	$txtHide=str_replace("'","",$_REQUEST['txtHide']);
	$txtUrl=str_replace("'","",$_REQUEST['txtUrl']);	
	$selPar=str_replace("'","",$_REQUEST['selPar']);	
	$txtPriority=str_replace("'","",$_REQUEST['txtPriority']);	
	
	if($txtHide=="" || $txtHide==NULL){
		?>
        <!---start insert--->
       <?php
			   $q=$db->query("insert into authentication(a_field_name,a_field_url,a_priority,parent_id) values('$txtName','$txtUrl',$txtPriority,$selPar)") or die("");
				if($q==TRUE){
					?>
						<script>
							alert("Sucessfully Saved !...");
							window.location.replace("add_web_pages.php");
						</script>
					<?php
				}
				else{
					?>
					<script>
							alert("Try Again !....");
							window.location.replace("add_web_pages.php");
						</script>
					<?php
				}
				?>
        <!---end insert--->
        <?php
	}else {
		?>
        <!---start Update--->
       <?php
			   $q=$db->query("update authentication set a_field_name='$txtName',parent_id=$selPar,a_priority=$txtPriority,a_field_url='$txtUrl' where a_id=$txtHide") or die("");
				if($q==TRUE){
					?>
						<script>
							alert("Sucessfully Updated !...");
							window.location.replace("add_web_pages.php");
						</script>
					<?php
				}
				else{
					?>
					<script>
							alert("Try Again !....");
							window.location.replace("add_web_pages.php");
						</script>
					<?php
				}
				?>
        <!---end Update--->
        <?php
	}
	
	}
	else{
		?>
						<script>
							alert("Try Again !...");
							window.location.replace("add_web_pages.php");
						</script>
					<?php
	}
	
		
}
else
{
	header("location:login-page.php");	
}
?>

