<html>
<?php
$file = 'export';

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
	print("<h8>-Connessione SQL eseguita correttamente-</h8><br>");
}




$id_cat=$_POST['select'];

$agente=$_POST['select2'];

//$inizio_data =$_POST['A'];
//$fine_data=$_POST['B'];
$f_data=$_POST['select3'];

$inizio_data = substr($_POST['A'], 0, 4) .''. substr($_POST['A'], 5,2) .''. substr($_POST['A'],8,2);
echo $inizio_data;
$fine_data = substr($_POST['B'], 0, 4) .''. substr($_POST['B'], 5,2) .''. substr($_POST['B'],8,2);
echo $inizio_data;
echo $fine_data;
//echo "$inizio_data";
//echo "$fine_data";










$db = mysql_select_db("agenda");
if(!$db)
{
	print("<h8>-Connessione al DB fallita-</h8>");
	exit;
}
else
{
	print("<br><h8>-Connessione al DB eseguita correttamente-</h8>");
}


$query = mysql_query("SELECT cal_id FROM webcal_entry_categories WHERE cat_id='$id_cat'");

if(!$query)
{
	print("<h8>-quesru fallita-</h8>");
	exit;
}
else
{
	print("<br><h8>-quaery ok-</h8><br><br>");
	
}







echo  "<table border=\"1\" cellpadding=\"10\"> ";
echo  "<tr>";
	
	
echo "<td>NOME AGENTE</td>";
echo "<td>NOME EVENTO</td>";
echo  "<td>DESCRIZIONE</td>";
echo  "<td>DATA</td>";

echo  "</tr>";





while ($temp = mysql_fetch_assoc($query)){
$appoggio=$temp['cal_id'];

// ogni id corrispondente all'id della categoria scelto




if($f_data=='yes'){ //CASO IN CUI VIENE INSERITA LA DATA
	
	if($agente!='NULL'){
	
	   $query3 = mysql_query("SELECT * FROM webcal_entry WHERE cal_id='$appoggio' AND cal_create_by='$agente' AND cal_date between '$inizio_data' and'$fine_data'");
	    $discr=1;
		echo  "<tr>";
		while ($temp3 = mysql_fetch_array($query3)){
	
		$d =$temp2['cal_date'];
    $x = substr($d, 0, 4) .'-'. substr($d, 4,2) .'-'. substr($d,6,2);
	
		echo "<td>" .$temp3['cal_create_by']. "</td>";
		echo "<td>" .$temp3['cal_name']. "</td>";
		echo  "<td>" .$temp3['cal_description']. "</td>";
	      echo  "<td>" .$x. "</td>";
		}
	
}else{


		$query2 = mysql_query("SELECT * FROM webcal_entry WHERE cal_id='$appoggio'  AND cal_date between '$inizio_data' and'$fine_data'");
		 $discr=2;
		echo  "<tr>";
		while ($temp2 = mysql_fetch_array($query2)){
	
		$d =$temp2['cal_date'];
    $x = substr($d, 0, 4) .'-'. substr($d, 4,2) .'-'. substr($d,6,2);
		echo "<td>" .$temp2['cal_create_by']. "</td>";
		echo "<td>" .$temp2['cal_name']. "</td>";
		echo  "<td>" .$temp2['cal_description']. "</td>";
		
          echo  "<td>" .$x. "</td>";
		}
}
	
}else{

//...SE NON VIENE INSERITA LA DATA














if($agente!='NULL'){
	
	   $query3 = mysql_query("SELECT * FROM webcal_entry WHERE cal_id='$appoggio' AND cal_create_by='$agente'");
	    $discr=3;
		echo  "<tr>";
		while ($temp3 = mysql_fetch_array($query3)){
	
		$d =$temp2['cal_date'];
    $x = substr($d, 0, 4) .'-'. substr($d, 4,2) .'-'. substr($d,6,2);
		echo "<td>" .$temp3['cal_create_by']. "</td>";
		echo "<td>" .$temp3['cal_name']. "</td>";
		echo  "<td>" .$temp3['cal_description']. "</td>";
	      echo  "<td>" .$x. "</td>";
		}
	
}else{


		$query2 = mysql_query("SELECT * FROM webcal_entry WHERE cal_id='$appoggio'");
        $discr=4;
//--------------------------------------		


//----------------------------------------------------------

	
		
		
	echo  "<tr>";
		
	while ($temp2 = mysql_fetch_array($query2)){
				
	   $d =$temp2['cal_date'];
       $x = substr($d, 0, 4) .'-'. substr($d, 4,2) .'-'. substr($d,6,2);
    
		echo "<td>" .$temp2['cal_create_by']. "</td>";
		echo "<td>" .$temp2['cal_name']. "</td>";
		echo  "<td>" .$temp2['cal_description']. "</td>";
        echo  "<td>" .$x. "  </td>";
		
		
		
		
		
		}
}
}

echo  "</tr>";


}
echo  "</table><BR>";
		
		 echo "<form action=\"excel.php\" method=\"POST\">";
 echo "<input type=\"submit\" value=\"SCARICA\">";
 echo "<br><br> <input type=\"HIDDEN\" name=\"query_da_fare\"  value=\"SELECT cal_id FROM webcal_entry_categories WHERE cat_id='$id_cat'\"> </input><br><br>";
  echo "<br><br> <input type=\"HIDDEN\" name=\"appoggio\"   value=\"$appoggio\"> </input><br><br>";
    echo "<br><br> <input type=\"HIDDEN\" name=\"discr\"   value=\"$discr\"> </input><br><br>";
 echo "<br><br> <input type=\"HIDDEN\" name=\"cat_id\"  value=\"$id_cat\"> </input><br><br>";
  echo "<br><br> <input type=\"HIDDEN\" name=\"agente\"  value=\"$agente\"> </input><br><br>";
   echo "<br><br> <input type=\"HIDDEN\" name=\"data_in\"  value=\"$inizio_data\"> </input><br><br>";
     echo "<br><br> <input type=\"HIDDEN\" name=\"data_fin\"  value=\"$fine_data\"> </input><br><br>";
 
 
 echo "</form>";

 

//--------------------------------------------






?>   </div>   </div>
</html>