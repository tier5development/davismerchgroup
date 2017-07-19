<?php
require 'Application.php';
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'name';
$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
$query = isset($_POST['query']) ? $_POST['query'] : false;
$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : false;
$ret = array();
$ret['error']= '';
$ret['out'] = '';

$status = 1;
$client_sql = '';
if($is_client){
    $client_sql = ' AND c."ID"='.$client_id;
}
if(isset($_GET['close']) && $_GET['close'] == 1)
{
	$status = 0;
        $checkbox = ' disabled="disabled" checked="checked" ';
}

function runSQL($rsql) {
global $connection, $ret;
     if(!($result=pg_query($connection,$rsql))){
        $ret['error'] = "Failed to get project: " . pg_last_error($connection);
        echo json_encode($ret);
        return false;
    }
 return $result;
}

function countRec($fname,$tname) {
	$sql = "SELECT count($fname) FROM $tname ";
	$result = runSQL($sql);
	while ($row = pg_fetch_array($result)) {
		return $row[0];
	}
}

$sort = "ORDER BY $sortname $sortorder";
$start = (($page-1) * $rp);

$limit = "OFFSET $start LIMIT $rp";

$where = " WHERE  prj.status =". $status;  //$client_sql";
if ($query) $where .= " AND $qtype LIKE '%".  pg_escape_string($query)."%' ";

if(isset($_GET['date_from'])&&$_GET['date_from']!="")
{
     $date_arr = explode('/',$_GET['date_from']);
    $from_date = strtotime($date_arr[2].'-'.$date_arr[0].'-'.$date_arr[1]);

 $where.=' AND m.due_date>='.$from_date;   
}
if(isset($_GET['date_to'])&&$_GET['date_to']!="")
{
      $date_arr = explode('/',$_GET['date_to']);
    $to_date = strtotime($date_arr[2].'-'.$date_arr[0].'-'.$date_arr[1]);
 $where.=' AND m.due_date<='.$to_date;   
}




$sql = 'SELECT distinct prj.pid, prj.prj_name from "prj_merchants" as m left join projects as prj on prj.pid = (select mer.pid from prj_merchants as mer where mer.pid = m.pid  limit 1 )    ';
$sql .= " $where $sort $limit";

//echo $sql;

$result = runSQL($sql);
while($out = pg_fetch_array($result)){
    $rows[] = $out;
}
$total =count($rows);//countRec("prj.prj_name","projects as prj inner join \"clientDB\" as c on c.\"ID\" = prj.cid $where");
///print_r($rows);
header("Content-type: application/json");
$jsonData = array('page'=>$page,'total'=>$total,'rows'=>array());
if(count($rows)>0)
{
foreach($rows AS $row){
	//If cell's elements have named keys, they must match column names
	//Only cell's with named keys and matching columns are order independent.    
	$entry = array('id'=>$row['pid'],
		'cell'=>array(
			'prj.prj_name'=>$row['prj_name'],			
                        'edit'=>'<img src="'.$mydirectory.'/images/edit.png" class="hand" alt="Edit" title="Edit: '.$row['prj_name'].'" onclick="show_project('.$row['pid'].')" />',
'copy'=>'<img src="'.$mydirectory.'/images/save.png" class="hand" alt="Copy" title="Copy: '.$row['prj_name'].'" onclick="copy_project('.$row['pid'].')" />',
'complete'=> '<span style="background-color: #69C73D; padding:1px; margin-top:-2px;"><input type="checkbox" class="green" name="complete" value="'.$row['pid'].'"'.$checkbox.' onclick="javascript: if(confirm(\'Are you sure want to close the project\')) { close_project('.$row['pid'].'); } else { return false; }"></span>',

						'email'=>'<a style="cursor:hand;cursor:pointer;"  onclick="send_email(' . $row['pid'] . ');"><img src="'.$mydirectory.'/images/email.png"  title="Email:" /></a>'

		),
	);
	$jsonData['rows'][] = $entry;
}
}
echo json_encode($jsonData);