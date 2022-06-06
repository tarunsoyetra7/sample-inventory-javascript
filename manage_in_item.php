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
	<link rel="stylesheet" href="css/buttons.dataTables.min.css">

  <link rel="stylesheet" href="css/jquery.dataTables.min.css">

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
							<li><a href="item_master.php">Item Entry</a></li>
							<li class="active"><a href="manage_in_item.php">Manage In Item</a></li>
							<li><a href="manage_out_item.php">Manage Out Item</a></li>
							<li><a href="manage_item_record.php">Item Returned</a></li>
							<li><a href="manage_balance_item.php">Balance Sheet</a></li>
							<li ><a href="manage_store.php">Manage Store</a></li>
							<li ><a href="manage_store_in.php">Item In Store</a></li>
						</ul>
						<br>
					</div>
					<div style="clear:both"></div>
					<div class="col-lg-4">
					<label>Select Item: </label>

					<select id="txt_sel_item" name="" class="form-control" >
					<option value='0'>--Select Any Category--</option>
					<?php $list=$db->query("SELECT id,item_name FROM item_detail_master") or die("");
						  while($list_res=$list->fetch(PDO::FETCH_ASSOC))
						  { ?>
							  <option value="<?php echo $list_res['id']; ?>"><?php echo $list_res['item_name']; ?></option>
					<?php	  }	
					?>
					</select>
					
					</div>
					<div class="col-lg-4">
					<label> Select Date From : </label>
					<input type='date' name='startdate'class="form-control"  id="startdate">
					</div>
					<div class="col-lg-4">
					<label> Select Date To : </label>
					<input type='date' name='enddate'class="form-control" id="enddate">
					<br>
					</div>
					
					<div class="col-lg-12">
					
					<table id="example1" class="table table-middle dataTable table-bordered table-condensed table-hover">

                        	<thead style="background:#000; color:#fff;">
                            	<tr>
                                	<th>S No</th>
                                    <th>Item Name</th>
                                    <th>Item Quantity</th>
                                    <th>Detail</th>
									<th>Date</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody id="table_show">
							<?php $q=$db->query("SELECT item_name,item_master.id,item_master.item_quantity,unit_sym,item_unit,flag,item_date,intake_type,intake_name FROM item_detail_master,item_master,unit_master WHERE in_out_type=1 AND item_detail_master.id=item_master.item_id AND item_unit=unit_master.id order by id desc") or die("");
							$i=0;
							while($res=$q->fetch(PDO::FETCH_ASSOC)){ $i++;
							if($res['intake_type']==3 && $res['flag']==0){
								$condition='style="background-color:red; color:white"';
							}
							else {
								$condition="";
							}
							?>
                            	<tr <?php echo $condition; ?>>
                                	<td><?php echo $i; ?></td>
                                    <td><?php echo $res['item_name']; ?></td>
									<td><?php echo $res['item_quantity']." ".$res['unit_sym']; ?></td>
							<td><strong> Purchase Type :- </strong><?php if($res['intake_type']==1){ ?> Store <?php } else if($res['intake_type']==2){ ?> Shop <?php } else if($res['intake_type']==3) { ?> Rent <?php } ?><br>
									<strong> Sender's Name :- </strong><?php echo $res['intake_name']; ?></td>
									<td><?php echo $res['item_date']; ?></td> 
                                    <td><button type="button" class="btn btn-sm btn-info btn_edit" id="<?php echo $res['id']; ?>">Edit</button>
                                     <button type="button" class="btn btn-sm btn-danger btn_delete" id="<?php echo $res['id']; ?>">Delete</button>
                                    </td>
									
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
					<input type="hidden" id="type" name="type" value="1">
					</div>
                    </div>                        
                </div>
            </div>
        </div>
    </div>
 <script src="js/jquery.js"></script>
 <script src="js/bootstrap.min.js"></script>
 
  <script src="js/jquery.dataTables.min.js"></script>
 <script type="text/javascript">    
	$(function () {
	  
		$('#example1').DataTable({
		  "paging": true,
		  "lengthChange": true,
		  "searching": true,
		  "ordering": true,
		  "info": true,
		  "autoWidth": false,
		   dom: 'Bfrtip',
        buttons: [
             'excel', 'pdf', 'print'
        ]
		});
	  });
 </script>
 
<script>
 function check_date(){
	var item_id=$("#txt_sel_item option:selected").val();
	var startdate=$("#startdate").val();
	var enddate=$("#enddate").val();
	var type=$("#type").val();
   
	$.ajax({
		type:"POST",
		data:{startdate:startdate,enddate:enddate,type:type,item_id:item_id},
		dataType:"json",
		cache:false,
		url:"search_date.php",
		success:function(r_data){
			var empty_res="";
			
			$("#table_show").css("visibility","visibile");
			$("#table_show").html("");
			if(r_data.length==0){
				//alert("No Data Found !...");
				$("#table_show").html("No Data Found !...");	
			}
			else{
				var j=1;
				for(i=0; i<r_data.length; i++){
					if(r_data[i].intake_type==3 && r_data[i].flag==0){
						var data="style='background:red; color:#fff;'";
					}
					else{
						var data="";
					}	
					if(r_data[i].intake_type==3){
						var t_data="Rent";
					}
					else if(r_data[i].intake_type==2){
						var t_data="Shop";
					}
					else{
						var t_data="Store";
					}
					var s_data="<tr "+data+"><td>"+j+"</td><td>"+r_data[i].item_name+"</td><td>"+r_data[i].item_quantity+"  "+r_data[i].unit_sym+"</td><td><label>Purchase Type :-</label>"+t_data+"<br><label>Sender's Name:-</label>"+r_data[i].intake_name+"</td><td>"+r_data[i].item_date+"</td><td><button class='btn btn-sm btn-info btn_edit' id="+r_data[i].i_id+">Edit</button>&nbsp;<button class='btn btn-sm btn-danger btn_delete'id="+r_data[i].i_id+">Delete</button></td></tr>";					
					empty_res=empty_res+s_data;
					j++;
				}
				$("#table_show").html(empty_res);
							
			}
		},error:function(err){
		 $("#table_show").html("No Data Found !...");		
		}
	}); 
 }
 $("#startdate").on("change",function(e){
	 check_date();
 });
 </script> 
 <script>
 $("#txt_sel_item").on("change",function(e){
	check_date();
 });
 </script>
  <script>
 $("#enddate").on("change",function(e){
	check_date(); 
 });
 </script>
 
 
 <script>
 $(".btn_edit").on("click",function(e){
	var cur_id=$(this).attr("id");
	window.location.replace("item_master.php?id="+cur_id);
 });
 </script>
 <script>
 $(".btn_delete").on("click",function(e){
	var del_id=$(this).attr("id");
	$.ajax({
		type:"POST",
		data:{del_id:del_id},
		url:"item_master_do.php",
		success:function(r_data){
			alert(r_data);
			location.reload();
		},error:function(err){
		}
	});
 });
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