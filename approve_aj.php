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
                        <h4 align="center"><strong>Notification</strong></h4>                         
					   <hr>
                    </div>
					<div class="col-lg-12">
						<ol class="breadcrumb">
                           <li class="active">
                                <a href="approve_aj.php"><i class="fa fa-dashboard"></i> Accept Letter / File</a>
                            </li>
                        </ol>
						<br>
					</div>
					<div class="col-lg-12">
					
					<table id="example1" class="table table-middle dataTable table-bordered table-condensed table-hover">

                        	<thead style="background:#000; color:#fff;">
                            	<tr>
                                	<th>S No</th>
                                    <th>File Number</th>
                                    <th>Sender's Name</th>
                                    <th>Subject</th>
									<th>Address</th>
									<th>Date</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody id="table_show">
							<?php 
							$q=$db->query("SELECT * FROM letter_in_out WHERE letter_user=$login_id AND letter_in_out=1 AND flag=0 ORDER BY letter_id DESC") or die("");
							$i=0;
							while($res=$q->fetch(PDO::FETCH_ASSOC)){ $i++;
							?>
                            	<tr>
									<td><?php echo $i; ?></td>
                                	<td><?php echo $res['letter_id']; ?></td>
									<td><?php echo $res['letter_s_name']; ?></td>
									<td><?php echo $res['letter_sub']; ?></td>
									<td><?php echo $res['letter_add']; ?></td>
									<td><?php echo $res['letter_date']; ?></td>
                                    <td><button type="button" class="btn btn-sm btn-info btn_accept" id="<?php echo $res['id']; ?>">Accept</button>
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
 $(".btn_accept").on("click",function(e){
	 var id=$(this).attr("id");
	 $.ajax({
		 type:"POST",
		 data:{id:id},
		 url:"accept_aj.php",
		 success:function(r_data){
			 alert(r_data);
			 location.reload();
		 },
		 error:function(err){
			 alert("Try Again ...");
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