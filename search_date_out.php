<?php
include("root/db_connection.php");

if(isset($_REQUEST['startdate']) || isset($_REQUEST['enddate'])){
	$startdate=str_replace("'","",$_REQUEST['startdate']);
	$enddate=str_replace("'","",$_REQUEST['enddate']);
	$type=str_replace("'","",$_REQUEST['type']);
	$item_id=str_replace("'","",$_REQUEST['item_id']);
	
	if($startdate!=null && $enddate!=null && $item_id!=0)
	{
		$condition="AND item_date>='$startdate' AND item_date<='$enddate' AND item_detail_master.id=$item_id ";
	}
	else if($startdate!=null && $item_id!=0)
	{
		$condition="AND item_date>='$startdate' AND item_detail_master.id=$item_id ";
	}
	else if($enddate!=null && $item_id!=0)
	{
		$condition="AND item_date<='$enddate' AND item_detail_master.id=$item_id ";
	}
	else if($item_id!=0){
		$condition="AND item_detail_master.id=$item_id ";
	}
	else if($startdate!=null && $enddate!=null)
	{
		$condition="AND item_date>='$startdate' AND item_date<='$enddate' ";
	}
	else if($startdate!=null)
	{
		$condition="AND item_date>='$startdate'";
	}
	else if($enddate!=null)
	{
		$condition="AND item_date<='$enddate'";
	}
	$q=$db->query("SELECT item_name,item_unit,unit_sym,item_master.id,item_master.item_quantity,item_date,item_master.ward_id FROM item_detail_master,item_master,unit_master WHERE in_out_type=2 AND item_detail_master.id=item_master.item_id AND unit_master.id=item_unit $condition order by id desc") or die("");
							$i=0;
							while($res=$q->fetch(PDO::FETCH_ASSOC)){ $i++;
							$ward_id=$res['ward_id'];
                            	echo("<tr>
                                	<td>".$i."</td>
                                    <td>".$res['item_name']."</td>
									<td>".$res['item_quantity']."  ".$res['unit_sym']."</td>
							<td>");
							$ward_q=$db->query("SELECT ward_name,ward_id FROM ward_master where FIND_IN_SET(id,'$ward_id')") or die("");
							while($ward_res=$ward_q->fetch(PDO::FETCH_ASSOC)){
							echo "Ward No :- ".$ward_res['ward_id']." ".$ward_res['ward_name']; echo "<br>";} 
							echo("</td>
									<td>".$res['item_date']."</td> 
                                    <td><button type='button' class='btn btn-sm btn-info btn_edit' id=".$res['id'].">Edit</button>
                                     <button type='button' class='btn btn-sm btn-danger btn_delete' id=".$res['id'].">Delete</button>
                                    </td>
                                </tr>");
}
}
else {
	echo "Error Found";
}
?>