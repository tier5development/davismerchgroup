<?php
require('Application.php');

//$arr=array(array(1,'Smiths'),array(2, 'Smiths'));
$arr=array();
for($k=1454;$k<=1827;$k++)
{
$arr[]=array($k,'CVS');	
}
$ch_ar=array();
$sql="";
for($i=0;$i<count($arr);$i++)
{
	$flag=0;
for($j=0;$j<count($ch_ar);$j++)
{
	if(isset($ch_ar[$j][0])&& $ch_ar[$j][0]==$arr[$i][1])
	{
$flag=1;
	}
}

if($flag==0)
{
	$sql.=';insert into tbl_chain (chain,status) values(\''.$arr[$i][1].'\',1)';	
$ch_ar[]=array($arr[$i][1]);
}
$sql.=';update tbl_chainmanagement  set sto_name=(select ch_id from tbl_chain where chain=\''.$arr[$i][1].'\' limit 1) where chain_id='.$arr[$i][0];	
	
	}
	
	
echo $sql;	


     if (!($result = pg_query($connection, $sql))) {
            print("Failed query1: " . pg_last_error($connection));
            exit;
      
  
     }else echo "Success";     
        pg_free_result($result);

?>
