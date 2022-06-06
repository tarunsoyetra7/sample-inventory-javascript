<?php
	if(isset($_COOKIE['login'])){
	
		$login_id= $_COOKIE['login'];
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
</head>
<body>

    <div id="wrapper">
        <?php  include("header.php");  ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
				  <div class="col-lg-12">
                        <h4 align="center"><strong>Storage Management</strong></h4>                         
					   <hr>
                    </div>
					<div class="col-lg-12">
						<ul class="nav nav-tabs">
							<li><a href="add_item.php">Add Item</a></li>
							<li class="active"><a href="item_master.php">Item Entry</a></li>
							<li ><a href="manage_in_item.php">Manage In Item</a></li>
							<li><a href="manage_out_item.php">Manage Out Item</a></li>
							<li><a href="manage_item_record.php">Item Returned</a></li>
							<li><a href="manage_balance_item.php">Balance Sheet</a></li>
							<li ><a href="manage_store.php">Manage Store</a></li>
							<li ><a href="manage_store_in.php">Item In Store</a></li>
						</ul>
						<br>
					</div>
						</div>
<Style>
.cls_ward ,.cls_pay	,.cls_pay_name{
	display:none;
}	

.selExamCatRes p
{
	float:left; margin:2px; padding:3px; background:#ccc;
}
.selExamCatResType p
{
	float:left; margin:2px; padding:3px; background:#ccc;
}

</style>
						<?php if(isset($_REQUEST['id'])){ 
						$edit_id=$_REQUEST['id'];
						$editQ=$db->query("SELECT * FROM item_master where id=$edit_id") or die("");
						$editQ_res=$editQ->fetch(PDO::FETCH_ASSOC);
						if($editQ_res['in_out_type']==1){ 
							$condition="block";
							$condition1="none";
						} else if($editQ_res['in_out_type']==2 || $editQ_res['in_out_type']==3){ 
							$condition="none";
							$condition1="block";
						} ?>
						<div class="col-lg-6">
						<label>Select Item</label>
						<select disabled id="txt_sel_item" class="form-control">
						<option value="0"> Choose Any One </option>
						<?php  
						$par_id=$editQ_res['item_id'];
						$itemQ=$db->query("SELECT * FROM item_detail_master") or die("");
								while($itemQ_res=$itemQ->fetch(PDO::FETCH_ASSOC)){
									if($itemQ_res['item_type']==2){$machine="  (".$itemQ_res['machine_number'].")";} else {$machine="";}
							if($par_id==$itemQ_res['id']) {
						?>
						<option value="<?php echo $itemQ_res['id']; ?>" selected ><?php echo $itemQ_res['item_name'].$machine; ?></option>
							<?php } else { ?>
							<option value="<?php echo $itemQ_res['id'].$machine; ?>"><?php echo $itemQ_res['item_name']; ?></option>
								<?php } }?>
						</select>
						<br>
						<input type="hidden" value="<?php echo $editQ_res['id']; ?>" id="txt_hide">
						</div>
						<div class="col-lg-6">
						<label>Select In/Out Type</label>
						<select disabled id="txt_sel_type" class="form-control">
						<option value="0"> Choose Any One </option>
						<?php if($editQ_res['in_out_type']==1){ ?>
						<option value="1" selected>In</option>
						<option value="2">Out</option>
						<option value="3">Return</option>
						<?php } else if($editQ_res['in_out_type']==2){ ?>
						<option value="1" >In</option>
						<option value="2" selected>Out</option>
						<option value="3" >Return</option>
						<?php } else { ?>
						<option value="1" >In</option>
						<option value="2" >Out</option>
						<option value="3" selected>Return</option>
						<?php } ?>
						</select>
						<br>
						</div>
						<div class="col-lg-6">
						<label>Entry Quantity of Item</label>
						<input type="number" id="txt_quantity" value="<?php echo $editQ_res['item_quantity']; ?>" class="form-control" placeholder="Enter Quantity Here">
						<input type="hidden" value="<?php echo $editQ_res['item_quantity']; ?>" id="txt_hide_quan">
						<br>
						</div>
						<div class="col-lg-6">
						<label>Entry Date</label>
						<input type="date" id="txt_date" value="<?php echo $editQ_res['item_date']; ?>" class="form-control" placeholder="Enter Date Here *">
						<br>
						</div>
						
						<div class="col-lg-12" style="display:<?php echo $condition1; ?>">
<div style="border:1px solid #ccc; height:250px; overflow:auto; padding:10px;">
	 <label>Select Ward :</label>
	 <select class="form-control" id="txt_sel_menu">
		<option value="0"> Choose Any </option>
		<?php 
			$secQ=$db->query("SELECT ward_id,id,ward_name FROM ward_master ORDER BY ward_id ASC") or die("");
while($secQ_Res=$secQ->fetch(PDO::FETCH_ASSOC)){
	
		?>
		<option value="<?php echo $secQ_Res['id']; ?>">
			<?php echo "Ward No:-".$secQ_Res['ward_id']."  ".$secQ_Res['ward_name']; ?>
		</option>
<?php } ?>
	 </select>
                  
<br>

<div class="selExamCatRes">
<?php $exm_cat_id=$editQ_res['ward_id'];
$oldExmQ=$db->query("SELECT ward_id,id,ward_name FROM ward_master where FIND_IN_SET(id,'$exm_cat_id') ORDER BY ward_id ASC");

while($oldExmQ_res=$oldExmQ->fetch(PDO::FETCH_ASSOC)){
 ?>
<p id="exmCat_<?php echo $oldExmQ_res['id']; ?>"><?php echo "Ward No.:-".$oldExmQ_res['ward_id']."  ".$oldExmQ_res['ward_name']; ?>
	<a href="javascript:void(0);" onclick="remove_exam_category('<?php echo $oldExmQ_res['id']; ?>')">
		<i class="fa fa-times"></i>
	</a>
</p>
<?php } ?>
	<!--<p id="">MBA <a href="javascript:void(0);"><i class="fa fa-times"></i></a></p>--->
</div>					  
<div style="clear:both;"></div>
<input type="hidden" name="txt_hide_service_id" id="txt_hide_service_id">
</div>
<br>
<!---end exam category--->
</div>
						
						
						<div class="col-lg-6" style="display:<?php echo $condition ?>">
						<label>Select Payment Type</label>
						<select id="txt_sel_pay_type" class="form-control">
						<option value="0"> Choose Any One </option>
						<?php if($editQ_res['intake_type']==1){ ?>
						<option value="1">Store</option>
						<option value="2" selected>Shop</option>
						<option value="3">Rent</option>
						<?php } else if($editQ_res['intake_type']==2){ ?>
						<option value="1">Store</option>
						<option value="2" selected>Shop</option>
						<option value="3">Rent</option>
						<?php } else { ?>
						<option value="1">Store</option>
						<option value="2">Shop</option>
						<option value="3" selected >Rent</option>
						<?php } ?>
						</select>
						<br>
						</div>
						<div class="col-lg-6" style="display:<?php echo $condition ?>">
						<label>Enter Name</label>
						<input id="txt_name" value="<?php echo $editQ_res['intake_name']; ?>" class="form-control" placeholder="Enter Shop/Store/Rent Name Here *">
						</div>
						<?php } else { ?>
						<div class="col-lg-6">
						<label>Select Item</label>
						<select id="txt_sel_item" class="form-control">
						<option value="0"> Choose Any One </option>
						<?php   $itemQ=$db->query("SELECT * FROM item_detail_master") or die("");
								while($itemQ_res=$itemQ->fetch(PDO::FETCH_ASSOC)){
									if($itemQ_res['item_type']==2){$machine="  (".$itemQ_res['machine_number'].")";} else {$machine="";}
						?>
						<option value="<?php echo $itemQ_res['id']; ?>"><?php echo $itemQ_res['item_name'].$machine; ?></option>
						<?php } ?>
						</select>
						<br>
						<input type="hidden" value="" id="txt_hide">
						</div>
						<div class="col-lg-6">
						<label>Select In/Out Type</label>
						<select  id="txt_sel_type" class="form-control">
						<option value="0"> Choose Any One </option>
						<option value="1">In</option>
						<option value="2">Out</option>
						<option value="3">Return</option>
						</select>
						<br>
						</div>
						<div class="col-lg-6">
						<label>Entry Quantity of Item</label>
						<input type="number" id="txt_quantity" class="form-control" placeholder="Enter Quantity Here">
						<br>
						<input type="hidden" value="0" id="txt_hide_quan">
						</div>
						<div class="col-lg-6">
						<label>Entry Date</label>
						<input type="date" id="txt_date" class="form-control" placeholder="Enter Date Here *">
						<br>
						</div>
						
						<div class="col-lg-12 cls_ward">
<div style="border:1px solid #ccc; height:200px; overflow:auto; padding:10px;">
    <label>Select Ward</label>
    <select class="form-control" id="txt_sel_menu" name="txt_sel_menu">
        <option value="0"> Choose Any </option>
        <?php $m_Q=$db->query("SELECT ward_id,id,ward_name FROM ward_master  ORDER BY ward_id ASC ") or die(""); 
				while($m_Q_res=$m_Q->fetch(PDO::FETCH_ASSOC)){ 

		?>
            <option value="<?php echo $m_Q_res['id']; ?>">
                <?php echo "Ward No.:-".$m_Q_res['ward_id']."  ".$m_Q_res['ward_name']; ?>
            </option>
            <?php } ?>
    </select>

    <div class="selExamCatRes">
	<!--<p id="">MBA <a href="javascript:void(0);"><i class="fa fa-times"></i></a></p>--->
</div>				  
<div style="clear:both;"></div>
<input type="hidden" name="txt_hide_service_id" id="txt_hide_service_id">
</div>
    <br>
    
</div>
						
						
						<div class="col-lg-6 cls_pay">
						<label>Select Payment Type</label>
						<select id="txt_sel_pay_type" class="form-control">
						<option value="0"> Choose Any One </option>
						<option value="1">Store</option>
						<option value="2">Shop</option>
						<option value="3">Rent</option>
						</select>
						<br>
						</div>
						<div class="col-lg-6 cls_pay_name">
						<label>Enter Name</label>
						<input id="txt_name" value="" class="form-control" placeholder="Enter Shop/Store/Rent Name Here *">
						</div>
						<?php } ?>
						<div class="col-lg-12">
						<button type="button" class="btn btn-sm btn-success btn_submit">Submit</button>
						</div>
                    </div>                        
                </div>
            </div>
        </div>
    </div>
 <script src="js/jquery.js"></script>
 <script src="js/bootstrap.min.js"></script>
 <script>
 $("#txt_sel_type").on("change",function(e){
	var sel_id=$("#txt_sel_type option:selected").val();
	if(sel_id==1){
		$(".cls_pay").css("display","block");
		$(".cls_ward").css("display","none");
		$(".cls_pay_name").css("display","block");
	}
	else if(sel_id==2|| sel_id==3){
		$(".cls_pay").css("display","none");
		$(".cls_ward").css("display","block");
		$(".cls_pay_name").css("display","none");
	}
 });
 
 $("#txt_quantity").on("keyup",function(e){
	 var quan=$("#txt_quantity").val();
	 var id=$("#txt_sel_type option:selected").val();
	 var hide_quan=$("#txt_hide_quan").val();
	 var extra=0;
	 if(id==2){
		 var cur_id=$("#txt_sel_item option:selected").val();
		 var diff=0;
		 $.ajax({
			 type:"POST",
			 url:"search_quantity.php",
			 data:{cur_id:cur_id},
			 success:function(s_data){
				 var extra=parseFloat(hide_quan)+parseFloat(s_data);
				 if(extra-quan<0){
					 alert("You Only Have "+extra+" kg Left");
					 $(".btn_submit").attr("disabled",true);	
				 }
				 else {
					 $(".btn_submit").attr("disabled",false);	
				 }
			 },
			 error:function(err){
			 }
		 });
	 }
 });
 </script>
 <script>
 $(".btn_submit").on("click",function(e){
	 if($("#txt_sel_item option:selected").val()==0){
		 alert("Please Select Item");
		 $("#txt_sel_item").focus(); 
	 }
	 else if($("#txt_sel_type option:selected").val()==0){
		 alert("Please Select In/Out Type");
		 $("#txt_sel_type").focus(); 
	 } 
 	 else if($("#txt_quantity").val()=="" || $("#txt_quantity").val()==null ||  $("#txt_quantity").val()==0){
		 $("#txt_quantity").focus(); 
	 }
	 else if($("#txt_date").val()=="" || $("#txt_date").val()==null){
		 $("#txt_date").focus(); 
	 } 
	else if($("#txt_sel_type option:selected").val()==1 && $("#txt_sel_pay_type option:selected").val()==0 ){
			 alert("Please Select Payment Mode");
			 $("#txt_sel_pay_type").focus();
	 }  
	 else if($("#txt_sel_type option:selected").val()==1  && $("#txt_name").val()=="" || $("#txt_name").val()==null){
			 $("#txt_name").focus();
	 }  
	 else if($("#txt_sel_type option:selected").val()==2 && $("#txt_sel_ward option:selected").val()==0){
			 alert("Please Select Ward"); 
			 $("#txt_sel_type option:selected").focus();
	 }
	else if($("#txt_sel_type option:selected").val()==3 && $("#txt_sel_ward option:selected").val()==0){
			 alert("Please Select Ward"); 
			 $("#txt_sel_type option:selected").focus();
	 }	 
	 else{
		 
		 var empty_sel_exm="";
		for(i=0; i<$(".selExamCatRes p").length; i++){
			empty_sel_exm=empty_sel_exm+$(".selExamCatRes p:eq("+i+")").attr('id');
			empty_sel_exm=empty_sel_exm+",";
		}
		empty_sel_exm=empty_sel_exm.replace(/exmCat_/g,'');
		empty_sel_exm=empty_sel_exm.slice(0,-1);
		//alert(empty_sel_exm);
			 $("#txt_hide_service_id").val(empty_sel_exm);
			 var txt_hide_service_id=$("#txt_hide_service_id").val();
			 //alert(txt_hide_service_id);
			 var txtItem=$("#txt_sel_item option:selected").val();
			 var txtType=$("#txt_sel_type option:selected").val();
			 var txtQuantity=$("#txt_quantity").val();
			 var txtDate=$("#txt_date").val();
			 var txtPaymode=$("#txt_sel_pay_type option:selected").val();
			 var txtPayname=$("#txt_name").val();
			 var txtWard=$("#txt_sel_ward option:selected").val();
			 var txt_hide=$("#txt_hide").val();
			$.ajax({
					type:"POST",
					url:"item_master_do.php",
					data:{txtItem:txtItem,txtType:txtType,txtQuantity:txtQuantity,txtDate:txtDate,txtPaymode:txtPaymode,txtPayname:txtPayname,txt_hide:txt_hide,txt_hide_service_id:txt_hide_service_id},
					success:function(r_data){
						alert(r_data);
						window.location.replace("item_master.php");
					},
					error:function(err){
					}
			});
	 }
 });
 </script>
 <script>
$("#txt_sel_menu").on("change",function(e){
	var e_sel_exm="";
	for(k=0; k<$(".selExamCatRes p").length; k++){
		e_sel_exm=e_sel_exm+$(".selExamCatRes p:eq("+k+")").attr('id');
		e_sel_exm=e_sel_exm+",";
	}
	e_sel_exm=e_sel_exm.replace(/exmCat_/g,'');
	e_sel_exm=e_sel_exm.slice(0,-1);
	var old_Exm_cat=e_sel_exm.split(',');
	
	//alert(old_Exm_cat);
	var selected_val_exm=$("#txt_sel_menu option:selected").val();
	if($("#txt_sel_menu option:selected").val()==0){
		alert("Please Select  Category !...");
	}
	else if(jQuery.inArray(selected_val_exm,old_Exm_cat)!=-1){
		alert("This category is Already Selected!...");		
	}	
	else {
		var cur_id=$("#txt_sel_menu option:selected").val();
		var cur_val=$("#txt_sel_menu option:selected").html();
		var rCurId="'"+cur_id+"'";
		//alert(rCurId);
		var on_click='onClick="remove_exam_category('+rCurId+')"';
		var struct="<p id='exmCat_"+cur_id+"'>"+cur_val+" <a href='javascript:void(0);'"+on_click+" ><i class='fa fa-times'></i></a></p>";		
		$(".selExamCatRes").append(struct);		
	}	
});

function remove_exam_category(id){
	//alert(id);
	$("#exmCat_"+id).remove();
}
</script>
</body>
</html>
<?php
}
else
{
	header("location:login-page.php");	
}
?>