<?php
include 'constrings.php';
$db = new Database();
	
	$db->connect();
echo 	$_GET['querytype']=="shiftid";
 if($_GET['querytype']=="shiftid")
{
	echo "karim";
	$sql="SELECT * FROM `shifts` ";
	$db->sql($sql);

$result = $db->getResult();
 
if (!empty($result)) {
			  foreach($result as $row) {
			  echo "shiftcode:".$row["shiftcode"].";"."<br>";
				  echo var_dump($result);
			  }
}
}
else if($_GET['querytype']=="shiftdetails")
	{
		//$shiftcode=$_POST['shiftcodepost'];
	$sql="SELECT * FROM `shifts` WHERE shiftcode='".$_GET['shiftcodepost']."' ";
	$db->sql($sql);

$result = $db->getResult();

if (!empty($result)) {
			  foreach($result as $row) {
			  echo "|shiftname:".$row["shiftname"]."|timefrom:".$row["hourfrom"]."|timeto:".$row["hourto"]."|hours:".$row["hours"].";"."<br>";
			  }
}
}
else if($_GET['querytype']=="updateshifts")
	{

	$sql="UPDATE `shifts` SET `shiftname`='".$_POST['shiftdescriptionpost']."',`hourfrom`='".$_POST['hourfrompost']."',`minutefrom`='".$_POST['minutefrompost']."',`hourto`='".$_POST['hourtopost']."',`minuteto`='".$_POST['minutetopost']."',`hours`='".$_POST['shifthrspost']."' WHERE `shiftcode`='".$_POST['shiftcodepost']."'";
	$db->sql($sql);

$result = $db->getResult();


}
else if($_GET['querytype']=="shiftconverter")
	{
		//$shiftcode=$_POST['shiftcodepost'];
	$sql="SELECT *  FROM `shifts` WHERE `hourfrom`>='".$_POST['hourfrompost']."' AND `hourto`<='".$_POST['hourtopost']."'  AND `hours`<='".$_POST['shifthrspost']."'" ;
	$db->sql($sql);

$result = $db->getResult();

if (!empty($result)) {
	
			  foreach($result as $row) {
			  echo "|shiftname:".$row["shiftcode"].";"."<br>";
			  
			  }
}
}
else if($_GET['querytype']=="shiftconvertercount")
	{
		//$shiftcode=$_POST['shiftcodepost'];
	$sql="SELECT count(*) as counti FROM `shifts` WHERE `hourfrom`>='".$_POST['hourfrompost']."' AND `hourto`<='".$_POST['hourtopost']."'  AND `hours` <='".$_POST['shifthrspost']."'" ;
	$db->sql($sql);

$result = $db->getResult();

if (!empty($result)) {
			  foreach($result as $row) {
			  echo "|countshift:".$row["counti"].";"."<br>";
			  }
}
}

//Load All LoginData as Username,UserCode,BloodCentre,Department
else if($_GET['querytype']=="logindataload")
	{
		//$shiftcode=$_POST['shiftcodepost'];
	$sql="SELECT `username`, `fullname`,`empcode`,`centre`,bloodcentres.name as centrename,`password`,`dept`,depts.deptname as dptname,`title` FROM ((`users` 
INNER JOIN depts ON users.dept=depts.id)
INNER JOIN bloodcentres ON users.centre=bloodcentres.id)
WHERE username='".$_POST['usernamecode']."' and password='".$_POST['passpost']."';" ;
	$db->sql($sql);

$result = $db->getResult();

if (!empty($result)) {
			  foreach($result as $row) {
			  echo "|usrnamer:".$row["username"]."|empcoder:".$row["empcode"]."|passwordr:".$row["password"]."|fullnamer:".$row["fullname"]."|centreid:".$row["centre"]."|centrenamer:".$row["centrename"]."|deptid:".$row["dept"]."|deptr:".$row["dptname"]."|titler:".$row["title"].";"."<br>";
			  }
}
else if(empty($result)){
	echo "no username";
}
}
else if($_GET['querytype']=="checkbanned")
	{
		//$shiftcode=$_POST['shiftcodepost'];
	$sql="SELECT `usercode`,`username`,`reason` FROM `bannedusers` WHERE `username`='".$_POST['usernamepost']."';" ;
	$db->sql($sql);

$result = $db->getResult();

if (!empty($result)) {
			  foreach($result as $row) {
			  echo "banned";
			  }
}
else if(empty($result)){
	echo "free";
}
	}
	
else if($_GET['querytype']=="loadcentres")
	{
		//$shiftcode=$_POST['shiftcodepost'];
	$sql="SELECT * FROM `bloodcentres`" ;
	$db->sql($sql);

$result = $db->getResult();

if (!empty($result)) {
			  foreach($result as $row) {
			  echo "|id:".$row["id"]."|centrename:".$row["name"].";"."<br>";
			  }
}
}
else if($_GET['querytype']=="loaddepts")
	{
		//$shiftcode=$_POST['shiftcodepost'];
	$sql="SELECT * FROM `depts`" ;
	$db->sql($sql);

$result = $db->getResult();

if (!empty($result)) {
			  foreach($result as $row) {
			  echo "|id:".$row["id"]."|deptname:".$row["deptname"].";"."<br>";
			  }
}
}
else if($_GET['querytype']=="dpt")
	{
		//$shiftcode=$_POST['shiftcodepost'];
	$sql="SELECT * FROM `depts` WHERE `deptname`='".$_POST['item_value']."'" ;
	$db->sql($sql);

$result = $db->getResult();

if (!empty($result)) {
			  foreach($result as $row)
			  {
			  echo "|deptid:".$row["id"].";"."<br>";
			  }
}
}
else if($_GET['querytype']=="ctr")
	{
		//$shiftcode=$_POST['shiftcodepost'];
	$sql="SELECT * FROM `bloodcentres` WHERE `name`='".$_POST['item_value']."'" ;
	$db->sql($sql);

$result = $db->getResult();

if (!empty($result)) {
			  foreach($result as $row)
			  {
			  echo "|deptid:".$row["id"].";"."<br>";
			  }
}
}

else if($_GET['querytype']=="addemp")
	{
		//$shiftcode=$_POST['shiftcodepost'];
	$sql="INSERT INTO `users`( `fullname`, `empcode`, `username`, `password`, `centre`, `dept`, `title`) VALUES ('".$_POST['fullname']."','".$_POST['empcode']."','".$_POST['username']."','".$_POST['password']."','".$_POST['centre']."','".$_POST['dept']."','".isset($_POST['title'])."')" ;
	$db->sql($sql);

$result = $db->getResult();

if (empty($result)) {
			  
			  echo "added";
			  }
}

?>
