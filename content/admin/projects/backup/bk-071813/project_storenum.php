<?php
require('Application.php');

extract($_POST);


$sql="select * from \"tbl_chainmanagement\"  where sto_name =".$chain;
//echo $sql;
if(!($result=pg_query($connection,$sql))){
	print("Failed query: " . pg_last_error($connection));
	exit;
}
	echo '<option value="">---Select---</option>';
	while($row=pg_fetch_array($result))
	{
		
		echo '<option value="'.$row['chain_id'].'">'.$row['sto_num'].'</option>';
	}
	pg_free_result($result);


?>