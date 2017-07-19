<?php
require('Application.php');
if(isset($_POST['employeeType']) && $_POST['employeeType'] < 1){
if(!isset($_POST['date_hire']) OR $_POST['date_hire'] == ""){
	$error="You forgot to enter the Date Hired.<br>";
}

if(!isset($_POST['firstnamenew']) OR $_POST['firstnamenew'] == ""){
	$error.="You forgot to enter the First Name of the person.<br>";
}
if(!isset($_POST['lastnamenew']) OR $_POST['lastnamenew'] == "") {
   $error.="You forgot to enter the Last Name of the person.<br>";
}
if(!isset($_POST['addressnew']) OR $_POST['addressnew'] == ""){
	$error.="You forgot to enter the Address of the person.<br>";
}
if(!isset($_POST['citynew']) OR $_POST['citynew'] == ""){
	$error.="You forgot to enter the city of the person.<br>";
}
if(!isset($_POST['statenew']) OR $_POST['statenew'] == ""){
	$error.="You forgot to enter the State of the person.<br>";
}
if(!isset($_POST['zipnew']) OR $_POST['zipnew'] == ""){
	$error.="You forgot to enter the Zip of the person.<br>";
}
if(!isset($_POST['phonenew']) OR $_POST['phonenew'] == ""){
	$error.="You forgot to enter the Phone of the person.<br>";
}
if(!isset($_POST['cellnew']) OR $_POST['cellnew'] == ""){
	$error.="You forgot to enter the Cell of the person.<br>";
}
if(!isset($_POST['emailnew']) OR $_POST['emailnew'] == ""){
	$error.="You forgot to enter the email address of the person.<br>";
}
}
if(!isset($_POST['newusername']) OR $_POST['newusername'] == ""){
	$error.="You forgot to enter the username of the person.<br>";
}
if(!isset($_POST['newpassword']) OR $_POST['newpassword'] == ""){
	$error.= "You forgot to enter the password of the person.<br>";
}

$clockinid=$_POST['clockinid'];
$clockinidcheck=("SELECT \"clockinid\" ".
	"FROM \"employeeDB\" ".
	"WHERE \"clockinid\" = '$clockinid' ");
if(!($clockinidcheckresult=pg_query($connection,$clockinidcheck))){
	print("Failed clockinidcheck: " . pg_last_error($connection));
	exit;
}
while($rowclockinidcheck = pg_fetch_array($clockinidcheckresult)){
	$dataclockinidcheck[]=$rowclockinidcheck;
}
if(count($dataclockinidcheck) > 0){
	$error .= "Someone is already using that clockinid. Please input another<br>";
}
if(!isset($_POST['clockinid']) OR $_POST['clockinid'] == ""){
	$error .= "Clockin ID was left blank. Please input a Clockin ID<br>";
}

if(isset($error)){
	require('error.php');
	exit;
}
 $date_arr = explode('/',$_POST['date_hire']);
/*$monthhired=date("m", mktime(1, 1, 1,$date_arr[0], 1, 2005));
$dayhired=date("d", mktime(1, 1, 1, 1,$date_arr[1], 2005));
$yearhired=date("Y", mktime(1, 1, 1, 1, 1, date("Y")-$date_arr[2]));*/
$firstname1=$_POST['firstnamenew'];
$lastname1=$_POST['lastnamenew'];
$title=$_POST['titlenew'];
$address=$_POST['addressnew'];
$city=$_POST['citynew'];
$state=$_POST['statenew'];
$zip=$_POST['zipnew'];
$phone=$_POST['phonenew'];
$pager=$_POST['pagernew'];
$alphapager=$_POST['alphapagernew'];
$cell=$_POST['cellnew'];
$email=$_POST['emailnew'];
$salary=$_POST['salarynew'];
$region=$_POST['region'];
$wage=$_POST['wagenew'];
$usernamenew=$_POST['newusername'];
$passwordnew=$_POST['newpassword'];
$poppassword=$_POST['newpoppassword'];
$emp_type=$_POST['employeeType'];
$client_Id=$_POST['clientname'];
if(isset($_POST['employeeType']) && $_POST['employeeType'] < 1){
 $date_arr = explode('/',$_POST['date_hire']);   
$datehired= strtotime($date_arr[2].'-'.$date_arr[0].'-'.$date_arr[1]);
//echo $datehired;
}
$check=("SELECT \"username\" ".
		"FROM \"employeeDB\" ".
		"WHERE \"username\" = '$usernamenew' ");
if(!($checkresult=pg_query($connection,$check))){
	print("Failed check: " . pg_last_error($connection));
	exit;
}
while($rowcheck = pg_fetch_array($checkresult)) {
	$datacheck[]=$rowcheck;
}
if(count($datacheck) > 0){
	require('../header.php');
	echo "The username you chose is already in use. Please go back and choose another.<br>";
	echo $datacheck[0]['username'];
	require('../trailer.php');
	exit;
}
if(isset($_POST['employeeType']) && $_POST['employeeType'] == 1){
$sql = "SELECT client FROM \"clientDB\" where \"ID\"=$client_Id;";
if(!($result=pg_query($connection,$sql))){
	print("Failed client query: " . pg_last_error($connection));
	exit;
}
$row = pg_fetch_array($result);
$firstname1 = $row['client'];
pg_free_result($result);
}

$querya="INSERT INTO \"employeeDB\" ".
		 "(\"username\", \"password\", \"salary\", \"poppassword\", \"emp_type\", \"clockinid\"";
		   
		   if($firstname1!="") $querya.=",\"firstname\" ";
		   if($lastname1!="") $querya.=",\"lastname\" ";
		   if($title!="") $querya.=",\"title\" ";
		   if($pager!="") $querya.=",\"pager\" ";
		   if($alphapager!="") $querya.=",\"alphapager\" ";
		   if($address!="") $querya.=",\"address\" ";
		   if($phone!="") $querya.=",\"phone\" ";
		   if($cell!="") $querya.=",\"cell\" ";
		   if($email!="") $querya.=",\"email\" ";
		   if($city!="") $querya.=",\"city\" ";
		   if($state!="") $querya.=",\"state\" ";
		   if($zip!="") $querya.=",\"zip\" ";
		   if($wage!="") $querya.=",\"wage\" ";
		   if($client_Id!="") $querya.=",\"client_Id\" ";
		   if($datehired!="") $querya.=",\"datehired\" ";
		   if($region!="") $querya.=", \"region\" ";
		 $querya.=",\"active\"";
		/* if($employeeType!="")$querya.=", \"employeeType\" ";
		 if($employeeType !="" && $employeeType == 0)$querya.=", employee_type_id ";
		 else if($employeeType !="" && $employeeType == 1)$querya.=", employee_type_id ";*/
		  $querya.=")";
		 $querya.="VALUES ".
		 "('$usernamenew', '$passwordnew', '$salary', '$poppassword', '$emp_type', '$clockinid'";
		  
		   if($firstname1!="")$querya.=", '$firstname1'";
		   if($lastname1!="")$querya.=", '$lastname1'";
		   if($title!="")$querya.=", '$title'";
		   if($pager!="")$querya.=", '$pager'";
		   if($alphapager!="")$querya.=", '$alphapager'";
		   if($address!="")$querya.=", '$address'";
		   if($phone!="")$querya.=", '$phone'";
		   if($cell!="")$querya.=", '$cell'";
		   if($email!="")$querya.=", '$email'";
		   if($city!="")$querya.=", '$city'";
		   if($state!="")$querya.=", '$state'";
		   if($zip!="")$querya.=", '$zip'";
		   if($wage!="")$querya.=", '$wage'";
		   
			/*if($employeeType!="") $querya.=",'$employeeType'";
		if($employeeType !="" && $employeeType == 0) $querya.=",'$vendorName'";
		else if($employeeType !="" && $employeeType == 1) $querya.=",'$clientname'";*/
		if($client_Id!="")$querya.=", '$client_Id'";
		if($datehired!="")$querya.=", '$datehired'";
		if($region!="") $querya.=", '$region'";
		   $querya.=",'yes'";
		$querya.=") ";
if(!($resulta=pg_query($connection,$querya))){
	print("Failed querya: " . pg_last_error($connection));
	exit;
}
require('../header.php');
echo "<form action=\"newemp1.php\" method=\"post\">";
echo "<table width=\"80%\">";
echo "<tr>";
echo "<td colspan=\"5\" bgcolor=\"white\"><b>$firstname1 $lastname1's Permissions</b></td>";
echo "</tr>";
echo "<tr>";
echo "<td><font face=\"arial\" size=\"-1\">Accounting</font></td>";
echo "<td><font face=\"arial\" size=\"-1\">Administration</font></td>";
echo "<td><font face=\"arial\" size=\"-1\">Human Resources</font></td>";
echo "<td><font face=\"arial\" size=\"-1\">Internal Directory</font></td>";
echo "<td><font face=\"arial\" size=\"-1\">Office Calendar</font></td>";
echo "</tr>";
echo "<tr>";
echo "<td><input type=\"Checkbox\" name=\"accounting\"></td>";
echo "<td><input type=\"Checkbox\" name=\"admin\"></td>";
echo "<td><input type=\"Checkbox\" name=\"humanresources\"></td>";
echo "<td><input type=\"Checkbox\" name=\"internaldirectory\"></td>";
echo "<td><input type=\"Checkbox\" name=\"calendar\"></td>";
echo "</tr>";
echo "<tr>";
echo "<td><font face=\"arial\" size=\"-1\">Operations</font></td>";
echo "<td><font face=\"arial\" size=\"-1\">Sales</font></td>";
echo "<td><font face=\"arial\" size=\"-1\">Support</font></td>";
echo "<td><font face=\"arial\" size=\"-1\">Production</font></td>";
echo "<td><font face=\"arial\" size=\"-1\">Purchasing</font></td>";
echo "</tr>";
echo "<tr>";
echo "<td><input type=\"Checkbox\" name=\"operations\"></td>";
echo "<td><input type=\"Checkbox\" name=\"sales\"></td>";
echo "<td><input type=\"Checkbox\" name=\"support\"></td>";
echo "<td><input type=\"Checkbox\" name=\"production\"></td>";
echo "<td><input type=\"Checkbox\" name=\"purchasing\"></td>";
echo "</tr>";
echo "<tr>";
echo "<td><font face=\"arial\" size=\"-1\">External User</font></td>";
echo "<td><font face=\"arial\" size=\"-1\">Edit Employee Timesheet</font></td>";
echo "<td><font face=\"arial\" size=\"-1\">Able to Login</font></td>";
echo "</tr>";
echo "<tr>";
echo "<td><input type=\"Checkbox\" name=\"external\"></td>";
echo "<td><input type=\"Checkbox\" name=\"timesheet\"></td>";
echo "<td><input type=\"Checkbox\" name=\"login\"></td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan=5 align=\"center\">";
echo "<br><br>";
echo "<input type=\"hidden\" name=\"usernamenew\" value=\"$usernamenew\">";
echo "<INPUT TYPE=\"Submit\" VALUE=\"  Enter Employee Permissions   \"></td>";
echo "</tr>";
echo "</table>";
require('../trailer.php');
?>
