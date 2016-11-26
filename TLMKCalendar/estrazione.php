<?php


require("../includes/dbconnect.php");

if (isset($_GET["force_logout"]))			{$force_logout=$_GET["force_logout"];}
	elseif (isset($_POST["force_logout"]))	{$force_logout=$_POST["force_logout"];}
	
$PHP_AUTH_USER=$_SERVER['PHP_AUTH_USER'];
$PHP_AUTH_PW=$_SERVER['PHP_AUTH_PW'];

if ($force_logout)
	{
	if( (strlen($PHP_AUTH_USER)>0) or (strlen($PHP_AUTH_PW)>0) )
		{
		Header("WWW-Authenticate: Basic realm=\"GoAUTODIAL-PROJECTS\"");
		Header("HTTP/1.0 401 Unauthorized");
		}
	echo "You have now logged out. Thank you\n";
	echo "<html><head><title>GoAutoDial - Logout</title><script>function update(){top.location='../index.php';}var refresh=setInterval('update()',1000);</script></head><body onload=refresh></body></html>";
	exit;
	}

#############################################
##### START SYSTEM_SETTINGS LOOKUP #####
$stmt = "SELECT use_non_latin FROM system_settings;";
$rslt=mysql_query($stmt, $link);
if ($DB) {echo "$stmt\n";}
$qm_conf_ct = mysql_num_rows($rslt);
if ($qm_conf_ct > 0)
	{
	$row=mysql_fetch_row($rslt);
	$non_latin =						$row[0];
	}
##### END SETTINGS LOOKUP #####
###########################################

$PHP_AUTH_USER = ereg_replace("[^0-9a-zA-Z]","",$PHP_AUTH_USER);
$PHP_AUTH_PW = ereg_replace("[^0-9a-zA-Z]","",$PHP_AUTH_PW);

$stmt="SELECT count(*) from vicidial_users where user='$PHP_AUTH_USER' and pass='$PHP_AUTH_PW' and user_level > 6 and view_reports='1';";
if ($DB) {echo "|$stmt|\n";}
if ($non_latin > 0) { $rslt=mysql_query("SET NAMES 'UTF8'");}
$rslt=mysql_query($stmt, $link);
$row=mysql_fetch_row($rslt);
$auth=$row[0];

if( (strlen($PHP_AUTH_USER)<2) or (strlen($PHP_AUTH_PW)<2) or (!$auth))
	{
    Header("WWW-Authenticate: Basic realm=\"GoAUTODIAL-PROJECTS\"");
    Header("HTTP/1.0 401 Unauthorized");
    echo "Invalid Username/Password: |$PHP_AUTH_USER|$PHP_AUTH_PW|\n";
	echo "<html><head><title>GoAutoDial - Logout</title><script>function update(){top.location='../index.php';}var refresh=setInterval('update()',1000);</script></head><body onload=refresh></body></html>";
    exit;
	}

$stmt="SELECT user_level from vicidial_users where user='$PHP_AUTH_USER' and pass='$PHP_AUTH_PW';";
if ($DB) {echo "|$stmt|\n";}
if ($non_latin > 0) { $rslt=mysql_query("SET NAMES 'UTF8'");}
$rslt=mysql_query($stmt, $link);
$row=mysql_fetch_row($rslt);
$user_level=$row[0];
	
if 	($user_level>8)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />

<!--<link rel="icon" type="image/gif" href="goautodial/images/g_page_icoa2.gif" >-->


<link rel="stylesheet" type="text/css" media="screen, print, projection"  href="../csslibs/goiframe2.css"></link>
<script type="text/javascript" src="../includes/goiframe2.js"></script>
</head>
<body>
<div id="webtemp18">
<div id="header">
	<div id="gologo"></a></div>
   
    <div id="bannertext">
     <p></p>
    </div>










<?
}
else
{
header('Location: ../goautodial-admin/admin.php');
}
?>









<!--------------------->



<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
ESTRAZIONE DATI
<?php

$connessione=mysql_connect("localhost","root","vicidialnow");
if(!$connessione)
{
	print("<h8>-Connessione SQL fallita-</h8>");
}
else
{
	print("<h8>-Connessione SQL eseguita correttamente-</h8>");
}


























$db = mysql_select_db("agenda");
if(!$db)
{
	print("<h8>-Connessione al DB fallita-</h8>");
	exit;
}
else
{
	print("<h8>-Connessione al DB eseguita correttamente-</h8>");
}





//------------------------------------------------1
$query = mysql_query("SELECT cat_name,cat_id FROM webcal_categories");

if(!$query)
{
	print("<h8>-quesru fallita-</h8>");
	exit;
}
else
{
	print("<h8>-quaery ok-</h8><br><br>");
	
}
//------------------------------------------------2

$query2 = mysql_query("SELECT cal_login FROM webcal_user");

if(!$query2)
{
	print("<h8>-quesrY2 fallita-</h8>");
	exit;
}
else
{
	print("<h8>-quaery2 ok-</h8><br><br>");
	
}

//------------------------------------------------------1
echo "<form action=\"estrazione_dati.php\" method=\"POST\">";
echo "ESITO <select name=\"select\">";
while ($res = mysql_fetch_array($query)){
	
echo "<option value=\"".$res['cat_id']."\">".$res['cat_name']."</option>";
}
echo "</select><br><br>";




//------------------------
echo "FILTRA PER AGENTE <select name=\"select2\">";
echo "<option value=\"NULL\">TUTTI GLI AGENTI</option>";
while ($res2 = mysql_fetch_array($query2)){
	
echo "<option value=\"".$res2['cal_login']."\">".$res2['cal_login']."</option>";
}
echo "</select>";
//--------------------------




	echo "<br><br>FILTRA PER DATA <select name=\"select3\">";
	echo "<option value=\"\"></option>";
echo "<option value=\"yes\">SI</option>";
echo "<option value=\"no\">NO</option>";

echo "</select>";


echo "<br><br> Inizio data <input type=\"TEXT\" name=\"A\" placeholder=\"0000-00-00\"> aaaa-mm-gg</input><br><br>";
echo "<br><br> Fine data <input type=\"TEXT\" name=\"B\" placeholder=\"0000-00-00\"> aaaa-mm-gg</input><br><br>";

//--------------------------



echo "<input type=\"submit\" value=\"ESEGUI\">";

























echo "</form>";



















/*


echo "<select name='esito'>";
while ($temp = mysql_fetch_assoc($query) {
    echo "<option value='".$temp['cat_id']."'>".$temp['cat_name']."</option>";
}
echo "</select>";


*/
?></div></div>
</html>























