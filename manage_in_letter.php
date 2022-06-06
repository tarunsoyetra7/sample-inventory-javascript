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
                        <h4 align="center"><strong>Aawak Jawak System</strong></h4>                         
					   <hr>
                    </div>
					<div class="col-lg-12">
						<ol class="breadcrumb">
                           <li class="active">
                                <a href="letter_in_out.php"><i class="fa fa-dashboard"></i> Add Aawak Jawak Information</a>
                            </li>
							<li class="active">
                                <a href="manage_in_letter.php"><i class="fa fa-dashboard"></i> View Letter Aawak </a>
                            </li>
							<li class="active">
                                <a href="manage_out_letter.php"><i class="fa fa-dashboard"></i> View Letter Jawak </a>
                            </li>
							<li class="active">
                                <a href="manage_in_file.php"><i class="fa fa-dashboard"></i> View File Aawak </a>
                            </li>
							<li class="active">
                                <a href="manage_out_file.php"><i class="fa fa-dashboard"></i> View File Jawak </a>
                            </li>
                        </ol>
						<br>
					</div>
					<div class="col-lg-4">
					<label>Select Employee: </label>

					<select id="txt_sel_item" name="" class="form-control" >
					<option value='0'>--Select Any Category--</option>
					<?php $list=$db->query("SELECT user_id,user_name FROM user_infromation WHERE delstatus=0") or die("");
						  while($list_res=$list->fetch(PDO::FETCH_ASSOC))
						  { ?>
							  <option value="<?php echo $list_res['user_id']; ?>"><?php echo $list_res['user_name']; ?></option>
					<?php }	?>
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
					<input type="hidden" id="type" name="type" value="1">
					<div class="col-lg-12">
					
					<table id="example1" class="table table-middle dataTable table-bordered table-condensed table-hover">

                        	<thead style="background:#000; color:#fff;">
                            	<tr>
                                	<th>S No</th>
                                    <th>File Number</th>
                                    <th>Sender's Name</th>
                                    <th>Subject</th>
									<th>Address</th>
									<th>Receiver's Name</th>
									<th>Date</th>
									<th>Status</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody id="table_show">
							<?php 
							$q=$db->query("SELECT * FROM letter_in_out,user_infromation WHERE user_id=letter_user AND letter_in_out=1 AND letter_type=1 ORDER BY letter_id DESC") or die("");
							$i=0;
							while($res=$q->fetch(PDO::FETCH_ASSOC)){ $i++;
							?>
                            	<tr>
									<td><?php echo $i; ?></td>
                                	<td><?php echo $res['letter_id']; ?></td>
									<td><?php echo $res['letter_s_name']; ?></td>
									<td><?php echo $res['letter_sub']; ?></td>
									<td><?php echo $res['letter_add']; ?></td>
									<td><?php echo $res['user_name']; ?></td>
									<td><?php echo $res['letter_date']; ?></td>
									<td><?php if($res['flag']==0) { ?>Not Accepted Yet...<?php } else { ?> Accepted ..<?php } ?></td>
                                    <td>
                                     <button type="button" class="btn btn-sm btn-danger btn_delete" id="<?php echo $res['id']; ?>">Delete</button>
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
		url:"search_letter.php",
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
					if(r_data.flag==0){
						v_data="<td>Not Accepted Yet..</td>";
					}
					else{
						v_data="<td>Accepted..</td>";
					}
					var s_data="<tr><td>"+j+"</td><td>"+r_data[i].letter_id+"</td><td>"+r_data[i].letter_s_name+"</td><td>"+r_data[i].letter_sub+"</td><td>"+r_data[i].letter_add+"</td><td>"+r_data[i].user_name+"</td><td>"+r_data[i].letter_date+"</td>"+v_data+"<td><button class='btn btn-sm btn-danger btn_delete'id="+r_data[i].id+">Delete</button></td></tr>";					
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
	window.location.replace("letter_in_out.php?id="+cur_id);
 });
 </script>
 <script>
 $(".btn_delete").on("click",function(e){
	var del_id=$(this).attr("id");
	$.ajax({
		type:"POST",
		data:{del_id:del_id},
		url:"letter_in_out_do.php",
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