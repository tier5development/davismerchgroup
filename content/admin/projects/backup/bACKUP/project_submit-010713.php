<?php

require 'Application.php';
$message = '';
$ret     = array();
$ret['error'] = '';
$ret['msg']   = '';


extract($_POST);
$ret['pid'] = $form_pid;
$pid=$form_pid;
if(!isset($pid)||$pid=="")
    $pid=0;

if (!isset($prj_name) || $prj_name == '')
    $message .= 'Project Name missing! ';


$sql          = '';
if ($pid == 0)
{
 $sql    = "select count(prj_name)as count from projects where prj_name='$prj_name' and status=1";
    if (!($result = pg_query($connection, $sql)))
    {
        $ret['error'] = "Failed check project name: " . pg_last_error($connection);
        echo json_encode($ret);
        return;
    }
    $row = pg_fetch_array($result);
    pg_free_result($result);
    if (isset($row['count']) && $row['count'] > 0)
    {
        $ret['error'] = 'Project name already exist.!';
        echo json_encode($ret);
        return;
    }

    $sql = "insert into projects (prj_name,cid,status";
    
    if(isset($img)&&$img!='')
       $sql .=",img_file"; 
    $sql .=")values(";
   
    $sql .= "'" . pg_escape_string($prj_name) . "'";
 
    $sql .= ",1,1";
     if(isset($img)&&$img!='')
       $sql .=",".$img;
   $sql .=");";
}
else if ($pid > 0)
{
    $sql = "Update projects set status = 1 ";
  
    $sql .= ", prj_name = '" . pg_escape_string($prj_name) . "'";
   if(isset($img)&&$img!='')
        $sql .= ", img_file = '" . pg_escape_string($img) . "'";
    $sql .= " Where pid = $pid";
}
if ($sql != '')
{
    if (!($result = pg_query($connection, $sql)))
    {
        $ret['error'] = "Failed to add / edit project: " . pg_last_error($connection);
        echo json_encode($ret);
        return;
    }
    $sql = '';
    pg_free_result($result);
    
    
    
    
    
}   
    
  

 if ($pid == 0)
    {
        $sql    = "select max(pid) as max_pid from projects ";
        if (!($result = pg_query($connection, $sql)))
        {
            $ret['error'] = "Failed check project name: " . pg_last_error($connection);
            echo json_encode($ret);
            return;
        }
        $row          = pg_fetch_array($result);
        pg_free_result($result);
        $sql = '';
        if (isset($row['max_pid']) && $row['max_pid'] > 0)
        {
            $ret['pid'] = $row['max_pid'];
            $pid=$row['max_pid'];
        }
    }
    


    
  if(isset($pid)&&$pid!=""&&isset($merch_1)&&$merch_1!=0)
    {
      
                  
   $sql ='insert into  prj_merchants(pid,cid,merch';   
   
    $sql_add="";
  if(isset($location)&&$location!="")
      $sql_add.=',location';
    if(isset($due_date)&&$due_date!="")
    {
        
      $sql_add.=',due_date';
    }
     if(isset($notes)&&$notes!="")
      $sql_add.=',notes';
	  
	  if(isset($address) && $address!="")
	   $sql_add.=',address';
	   
	   if(isset($phone) && $phone!="")
	   $sql_add.=',phone';
	   
	   if(isset($city) && $city!="")
	    $sql_add.=',city';
	  if(isset($zip) && $zip!="")
	    $sql_add.=',zip';
     
     if(isset($st_time)&&$st_time!="")
      $sql_add.=',st_time';
     
       if(isset($store_num)&&$store_num!="")
      $sql_add.=',store_num';
  $sql.=$sql_add.")values(".$pid.",".$cid.",".$merch_1;
        
  
  $sql_add="";
  if(isset($location)&&$location!="")
      $sql_add.=",'".$location."'";
    if(isset($due_date)&&$due_date!="")
    {
        $date_arr = explode('/',$due_date);
    $due_date = strtotime($date_arr[2].'-'.$date_arr[0].'-'.$date_arr[1]);
         $sql_add.=",".$due_date;
    }
     
     if(isset($notes)&&$notes!="")
      $sql_add.=",'".$notes."'";
	  
	  if(isset($address)&&$address!="")
      $sql_add.=",'".$address."'";
	  
	  if(isset($phone)&&$phone!="")
      $sql_add.=",'".$phone."'";
	  
	  if(isset($city) && $city!="")
	  $sql_add.=",'".$city."'";
	  
	  if(isset($zip) && $zip!="")
	  $sql_add.=",'".$zip."'";
      
     if(isset($st_time)&&$st_time!="")
         $sql_add.=",'".$st_time."'";
     
      if(isset($store_num)&&$store_num!="")
          $sql_add.=",'".$store_num."'";
          
      $sql.=$sql_add.")";         

    
    }  
 

if ($sql != '')
{
    if (!($result = pg_query($connection, $sql)))
    {
        $ret['error'] = "Failed to add / edit project: " . pg_last_error($connection);
        echo json_encode($ret);
        return;
    }
    $sql = '';
    pg_free_result($result);    
    $ret['msg']= "Successfuly saved the project details.";    
}   
echo json_encode($ret);
return;
?>