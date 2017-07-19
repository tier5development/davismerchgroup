<?php
require('Application.php');
require($JSONLIB.'jsonwrapper.php');
$error = "";
$msg = "";
$return_arr = array();
$return_arr['msg'] = "";
$return_arr['error'] = "";
$return_arr['name']="";
$return_arr['file_name']="";
$return_arr['index'] = "";
$return_arr['type'] = "";
extract($_POST);
$return_arr['type'] =  $_POST['type'];
$fileElementName = $_POST['fileId'];
$return_arr['index'] = $_POST['index'];
if(!empty($_FILES[$fileElementName]['error']))
{
	switch($_FILES[$fileElementName]['error'])
	{

		case '1':
			$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
			break;
		case '2':
			$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
			break;
		case '3':
			$error = 'The uploaded file was only partially uploaded';
			break;
		case '4':
			$error = 'No file was uploaded.';
			break;

		case '6':
			$error = 'Missing a temporary folder';
			break;
		case '7':
			$error = 'Failed to write file to disk';
			break;
		case '8':
			$error = 'File upload stopped by extension';
			break;
		case '999':
		default:
			$error = 'No error code avaiable';
	}
}
else if(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none')
{
	$error = 'No file was uploaded..!';
}
else 
{
	$file_type = $_FILES[$fileElementName]['type'];
	$file_name = $_FILES[$fileElementName]['name'];	
  
	$file_size = $_FILES[$fileElementName]['size'];			
	$file_tmp  = $_FILES[$fileElementName]['tmp_name'];
	$filePath_fileName = $img_glry_dir.$file_name;			
	$fileName = $file_name;
	$return_arr['file_name'] = $fileName;	
	$fileName = date('U')."-".$file_name;
	$filePath_fileName = $img_glry_dir.$fileName;	
       // echo "f".$filePath_fileName;
$sql="";
       $disp_name = $_FILES[$fileElementName]['name'];
      // $file_name = substr($disp_name, 0, abs(strlen($disp_name) - (strlen($ext)+1))) . '_' . date('U') . '.' . $ext;
		if((strripos("I".$file_type,"image/") != FALSE)) // upload only image
		{
                   
			$filePath_fileName = "$img_glry_dir$fileName";	
			if(file_exists($filePath_fileName)) {
				@ unlink($filePath_fileName);
			}		
			copy( $file_tmp, $filePath_fileName );
			@ chmod($filePath_fileName,0777);
			$fileElementType="image";
			$return_arr["msg"]= "Requested image file uploaded sucessfully";
			$return_arr['name'] =$fileName;
                        $pid=$_POST['pid'];
                        $form_type=$_POST['form_type'];
         $sql = "INSERT INTO sign_off_files(file_type,file_name,pid, disp_name,form_type,form_id) VALUES (".
                    " 'I', '".pg_escape_string ($fileName)."',".$pid.", '".pg_escape_string ($disp_name)."','".$form_type."',".$form_id.");";     
         
        //  echo $sql;
                 
		}
		else if((strripos("I".$file_type,"image/")== FALSE ))
		{	
                     $error="Upload only image files...";
                        $return_arr["error"] = $error;
			echo json_encode($return_arr);
			return;
                
                   
		}
		else
		{
			if(file_exists($fileElementName))		
			@unlink($fileElementName);
			@unlink($_FILES[$fileElementName]);
			$error="File Upload Error : Not a valid file type !";
			$return_arr["error"] = $error;
			echo json_encode($return_arr);
			return;
		}
                
                
     if($sql != '')
    {
        if (!($result = pg_query($connection, $sql)))
        {
            $error = "Failed to store information to database! ";
        }
        $sql = '';
        if($result)
            pg_free_result($result);
        
  $query="select bulb_stat from projects where pid=".$pid;
 $r = pg_query($connection, $query);
$row=  pg_fetch_array($r);
$bulb_stat='img';
if($row['bulb_stat']=='both') $bulb_stat='both';
else if($row['bulb_stat']=='sign') $bulb_stat='both';

$query="update projects set bulb_stat='".$bulb_stat."' where pid=".$pid;
//echo $query;
pg_query($connection, $query);      
        
    }              
	}
//for security reason, we force to remove all uploaded file	
if(file_exists($fileElementName))		
	@unlink($fileElementName);	
$msg .= " File Name: " . $_FILES[$fileElementName]['name'] . ", ";
$msg .= " File Size: " . @filesize($_FILES[$fileElementName]['size']);
//for security reason, we force to remove all uploaded file
@unlink($_FILES[$fileElementName]);
if($error != "")
	$return_arr["error"] = $error;




require 'signoff_view_imgs.php';

echo "{";
echo "error: '" . $error . "',\n";
echo "msg: '" . str_replace("'","\'",$msg)  . "',\n";
echo "pid: '" . $pid . "',\n";
echo "html: '".  str_replace("'","\'",$html). "'\n";
echo "}";
?>
