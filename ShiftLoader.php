<?php    
include 'constrs.php';
$db = new Database();
	
	$db->connect();
 if($_GET['querytype']=="test"){
	 
	 echo "karim";
 }

 if($_GET['querytype']=="shiftid")
{
	
	$sql="SELECT * FROM `shifts` ";
	$db->sql($sql);

$result = $db->getResult();
 
if (!empty($result)) {
			  foreach($result as $row) {
			  echo "shiftcode:".$row["shiftcode"].";"."<br>";
				
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
$govid="";
else if($_GET['querytype']=="loadgovid")
	{	
		$jsondata = "php://input";
$phpjsonstring = file_get_contents( $jsondata ); // Get content of posted JSON String
$data = json_decode( $phpjsonstring, true ); // Decoding content of posted JSON String
$govid = $data["governomentID"];
}
else if($_GET['querytype']=="loadhospitals")
	{	
		//$shiftcode=$_POST['shiftcodepost'];
	$sql="SELECT * FROM `hospitals` Where governomentID=$govid" ;
	$db->sql($sql);
$result = $db->getResult();
 $myObj= new stdClass();
if (!empty($result)) {
 foreach($result as $row) {
  $Out=json_encode($result);
// echo $myJSON;
  }
  echo $Out;
}
}	
	else if($_GET['querytype']=="loadgovs")
	{
		//$shiftcode=$_POST['shiftcodepost'];
	$sql="SELECT * FROM governorates" ;
	$db->sql($sql);
$result = $db->getResult();
 $myObj= new stdClass();
if (!empty($result)) {
 foreach($result as $row) {				 
 $Out=json_encode($result,JSON_UNESCAPED_UNICODE);
// echo $myJSON;
			  }
 echo $Out;
}
}

else if($_GET['querytype']=="loadcentres")
	{
		//$shiftcode=$_POST['shiftcodepost'];
	$sql="SELECT * FROM bloodcentres" ;
	$db->sql($sql);
$result = $db->getResult();
 $myObj= new stdClass();
if (!empty($result)) {
			 foreach($result as $row) {
				
				 
				  $Out=json_encode($result,JSON_UNESCAPED_UNICODE);
				 // echo $myJSON;
				
			  }
			    echo $Out;
}
}



?>
