<?php if(isset($_COOKIE['login']))
{	
	require("root/db_connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
	
	
</head>
<body>
    <div id="wrapper">
		<?php     	include("header.php");      	?>
        <div id="page-wrapper">
			<div class="container-fluid">
				<div class="row">
                    <div class="col-lg-12">
						<h4 align="center"><strong>Add Dashboard Pages</strong></h4><hr>
						
						
						 <ol class="breadcrumb">
                           <li class="active">
                                <a href="add_web_pages.php"><i class="fa fa-dashboard"></i> Add Web Page</a>
                            </li>
						
							
                        </ol>
						<br>
					</div>	
						
                    <?php if(isset($_REQUEST['edit_id'])){
						$id=str_replace("'","",$_REQUEST['edit_id']);
						$e_q=$db->query("select a_id,a_priority,parent_id,a_field_name,a_field_url from authentication where a_id=$id") or die("");
						$e_q_res=$e_q->fetch(PDO::FETCH_ASSOC);
						
						?>
                        <form name="" action="add_web_pages_do.php" method="post" enctype="multipart/form-data">
                        <div class="col-lg-3">
                        	<label>Page Name</label>
                            <input name="txtName" value="<?php echo $e_q_res['a_field_name'] ?>" type="text" autofocus class="form-control" placeholder="Enter Page Name" required>
                            <input type="hidden" name="txtHide" value="<?php echo $e_q_res['a_id'] ?>">
                            <br>
                            </div>  

<div class="col-lg-4">

<label>Select parent</label>
                            <select class="form-control" id="selPar" name="selPar">
							
							

                                <option value="0">---Select Parent---</option>
                               <?php $newQ=$db->query("SELECT
node.a_id,
    node.parent_id,
    CONCAT(IFNULL(up3.a_field_name, ''), IFNULL(CONCAT(up2.a_field_name, ' --> '), ''), IFNULL(CONCAT(up1.a_field_name, ' --> '), ''), node.a_field_name) AS a_field_name
FROM authentication AS node
LEFT OUTER JOIN authentication AS up1
ON up1.a_id = node.parent_id
LEFT OUTER JOIN authentication AS up2
ON up2.a_id = up1.parent_id
LEFT OUTER JOIN authentication AS up3
ON up3.a_id = up2.parent_id
WHERE node.flag = 'true' 
ORDER BY node.a_id DESC ") or die("");
														while($newQ_res=$newQ->fetch(PDO::FETCH_ASSOC)){
														
															if($e_q_res['a_id']==$newQ_res['a_id']){
																?>
                                                                <option selected value="<?php echo $e_q_res['parent_id']; ?>"><?php echo $newQ_res['a_field_name']; ?></option>
                                                                <?php
															}else{
															 ?>
                            				<option value="<?php echo $newQ_res['a_id']; ?>"><?php echo $newQ_res['a_field_name']; ?></option>				
                        								<?php  } ?>
  <?php } ?>
                            </select>
							

</div>
<div class="col-lg-2">
                        	<label>Page Priority</label>
                            <input value="<?php echo $e_q_res['a_priority']; ?>" name="txtPriority" type="number"  class="form-control" placeholder="Enter Priority" required>
                            
                            <br>
                            </div> 

							
                            <div class="col-lg-3">
                        	<label>Page URL</label>
                            <input value="<?php echo $e_q_res['a_field_url'] ?>" type="text" name="txtUrl" class="form-control" placeholder="Enter Page URL"  required><br>
                            </div>                            
                            <div class="col-lg-12">
                            	<input type="submit" class="btn btn-success btn-sm pull-right">
                            </div>                            
                        </form>
                        <?php	}
						else{							
						?>   
                        <form name="" action="add_web_pages_do.php" method="post" enctype="multipart/form-data">
                        <div class="col-lg-3">
                        	<label>Page Name</label>
                            <input name="txtName" type="text" autofocus class="form-control" placeholder="Enter Page Name" required>
                            <input type="hidden" name="txtHide">
                            <br>
                            </div> 

							<div class="col-lg-4">
							
							<label>Select parent</label>
                            <select class="form-control" id="selPar" name="selPar">
                                <option value="0">---Select Parent---</option>
                               <?php $newQ=$db->query("SELECT
node.a_id,
    node.parent_id,
    CONCAT(IFNULL(up3.a_field_name, ''), IFNULL(CONCAT(up2.a_field_name, ' --> '), ''), IFNULL(CONCAT(up1.a_field_name, ' --> '), ''), node.a_field_name) AS a_field_name
FROM authentication AS node
LEFT OUTER JOIN authentication AS up1
ON up1.a_id = node.parent_id
LEFT OUTER JOIN authentication AS up2
ON up2.a_id = up1.parent_id
LEFT OUTER JOIN authentication AS up3
ON up3.a_id = up2.parent_id
WHERE node.flag = 'true' 
ORDER BY node.a_id DESC ") or die("");
														while($newQ_res=$newQ->fetch(PDO::FETCH_ASSOC)){
														
															 ?>
                            				<option value="<?php echo $newQ_res['a_id']; ?>"><?php echo $newQ_res['a_field_name']; ?></option>				
                        								<?php }  ?>
                            </select>
							
							
							</div>
<div class="col-lg-2">
                        	<label>Page Priority</label>
                            <input name="txtPriority" type="number"  class="form-control" placeholder="Enter Priority" required>
                            
                            <br>
                            </div> 


							
                            <div class="col-lg-3">
                        	<label>Page URL</label>
                            <input type="text" name="txtUrl" class="form-control" placeholder="Enter Page URL"  required><br>
                            </div>                            
                            <div class="col-lg-12">
                            	<input type="submit" class="btn btn-success btn-sm pull-right">
                            </div>                            
                        </form>
                       <?php } ?> 
      				<div style="clear:both;"></div>
                    <div class="col-lg-12"><br>
                    	
 <table class="table table-middle dataTable table-bordered table-condensed table-hover">

                        	<thead style="background:#000; color:#fff;">
                            	<tr>
                                	<th>S No</th>
                                    <th>Detail</th>
									<th>Page Priority</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $q=$db->query("SELECT
node.a_id,node.a_priority,
    node.a_field_url,node.parent_id,
    CONCAT(IFNULL(up3.a_field_name, ''), IFNULL(CONCAT(up2.a_field_name, ' --> '), ''), IFNULL(CONCAT(up1.a_field_name, ' --> '), ''), node.a_field_name) AS a_field_name
FROM authentication AS node
LEFT OUTER JOIN authentication AS up1
ON up1.a_id = node.parent_id
LEFT OUTER JOIN authentication AS up2
ON up2.a_id = up1.parent_id
LEFT OUTER JOIN authentication AS up3
ON up3.a_id = up2.parent_id
WHERE node.flag = 'true' 
ORDER BY node.a_priority") or die("");
							$i=0;
							while($res=$q->fetch(PDO::FETCH_ASSOC)){ $i++; ?>
                            	<tr>
                                	<td><?php echo $i; ?></td>
                                    <td><strong>Page Name : </strong><?php echo $res['a_field_name']; ?><br>
                                    <strong>Page URL : </strong> <?php echo $res['a_field_url']; ?></td>
									<td><?php echo $res['a_priority']; ?></td> 
                                    <td><button type="button" class="btn btn-sm btn-info btn_edit" id="<?php echo $res['a_id']; ?>">Edit</button>
                                     <button type="button" class="btn btn-sm btn-danger btn_delete" id="<?php echo $res['a_id']; ?>">Delete</button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>	
                    </div>                    
				</div>
			</div>
		</div>
</div> 
<script>
$(".btn_edit").on("click",function(e){
	var edit_id=$(this).attr("id");
	window.location.replace("add_web_pages.php?edit_id="+edit_id);
});

$(".btn_delete").on("click",function(e){
    var del_id=$(this).attr("id");
	$.ajax({
		type:"POST",
		url:"delete_web_pages.php",
		data:{del_id:del_id},
		success:function(r_data){
			alert(r_data);
			location.reload();
		},error:function(error){
			alert("Error");
			location.reload();
		}
	});
});
</script>
</body>
</html>
<?php } else{
	header("location:login-page.php");	
}
?>