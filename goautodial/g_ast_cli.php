<?php
############################################################################################
####  Name:             g_ast_cli.php                                                   ####
####  Version:          2.0                                                             ####
####  Copyright:        GOAutoDial Inc. - Januarius Manipol <januarius@goautodial.com>  ####
####  License:          AGPLv2                                                          ####
############################################################################################

require("includes/g_authenticate.php");

$stmt = "SELECT ASTmgrUSERNAME,ASTmgrSECRET,telnet_port FROM servers;";
$rslt=mysql_query($stmt, $link);
if ($DB) {echo "$stmt\n";}
$m_ct = mysql_num_rows($rslt);
if ($m_ct > 0)
	{
	$row=mysql_fetch_row($rslt);
	$m_user = $row[0];
	$m_pass	= $row[1];
	$m_port = $row[2];
	}

function validateIpAddress($ip_addr)
{
  if(preg_match("/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/",$ip_addr))
  {
    $parts=explode(".",$ip_addr);
    foreach($parts as $ip_parts)
    {
      if(intval($ip_parts)>255 || intval($ip_parts)<0)
      return false; 
    }
    return true;
  }
  else
    return false; 
}

$hostp = $_SERVER['SERVER_ADDR'];
$hostn = $_SERVER['SERVER_NAME'];

if (validateIpAddress($hostn))
{
$hostn = exec('hostname');
}
ob_start();
 if (!empty($_GET['cmd'])){
 $ffo= $_GET['cmd'];
 $token = md5 (uniqid (rand()));
 $errno=0 ;
 $errstr=0 ;
 $fp = fsockopen ("localhost", $m_port, &$errno, &$errstr, 20);
 if (!$fp) 
 	{
   		echo "$errstr ($errno)<br>\n"; 
 	} 
 	else 
 	{
   		fputs ($fp, "Action: login\r\n");
   		fputs ($fp, "Username: $m_user\r\n");
   		fputs ($fp, "Secret: $m_pass\r\n");
   		fputs ($fp, "Events: off\r\n\r\n");
   		fputs ($fp, "Action: COMMAND\r\n");
   		fputs ($fp, "command: $ffo\r\n");
   		fputs ($fp, "ActionID: $token\r\n\r\n");
   		sleep(1);
		$results = fread ($fp, 38000); 
		fclose ($fp);
  		$result=strpos($results);
 	} 
 echo $results;
 }
 else 
 {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>gasteriskCLI v1 by JanuariusTM :) ©   | GOAutoDial Inc.</title>
<link href="csslib/gadi_content.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="javascript">
if(self.location==top.location)self.location="../";
var CommHis=new Array();
var HisP;
var hname='<?php echo $hostn; echo '*CLI>'; ?>';
function doReq(_1,_2,_3)
{
var HR=false;
	if(window.XMLHttpRequest)
	{
		HR=new XMLHttpRequest();if(HR.overrideMimeType){HR.overrideMimeType("text/xml");}
	}
	else
	{
		if(window.ActiveXObject)
			{
				try{HR=new ActiveXObject("Msxml2.XMLHTTP");}catch(e)
				{
					try{HR=new ActiveXObject("Microsoft.XMLHTTP");}catch(e)
				{
				}
				}
			}
	}	
	if(!HR)
	{
		return false;
	}	
	HR.onreadystatechange=function()
	{
		if(HR.readyState==4)
			{
				if(HR.status==200){if(_3){eval(_2+"(HR.responseXML)");}else{eval(_2+"(HR.responseText)");}}
			}
	};
	HR.open("GET",_1,true);HR.send(null);
}
function pR(rS)
{
	var _6=document.getElementById("outt");
	var _7=rS.split("\n\n");
	var _8=document.getElementById("cmd").value;
	_6.appendChild(document.createTextNode(_8));
	_6.appendChild(document.createElement("br"));	
	for(var _9 in _7)
		{
			var _a=document.createElement("pre");
			_a.style.display="inline";
			line=document.createTextNode(_7[_9]);
			_a.appendChild(line);_6.appendChild(_a);
			_6.appendChild(document.createElement("br"));
		}
	_6.appendChild(document.createTextNode(hname ));
	_6.scrollTop=_6.scrollHeight;
	document.getElementById("cmd").value="";
}
function keyE(_b)
{
switch(_b.keyCode)
{
case 13:
	var _c=document.getElementById("cmd").value;
	if(_c)
	{
		CommHis[CommHis.length]=_c;
		HisP=CommHis.length;
		var _d=document.location.href+"?cmd="+escape(_c);
		doReq(_d,"pR");
	}
break;
case 38:
	if(HisP>0)
	{
		HisP--;document.getElementById("cmd").value=CommHis[HisP];
	}
	break;
case 40:
	if(HisP<CommHis.length-1)
	{
		HisP++;document.getElementById("cmd").value=CommHis[HisP];
	}
	break;
default:
break;
}
}
</script>
</head>
<body>
<span id="webtemp19">
<?require("g_menu.php");?>
</span>
<br>
<span id="webtemp20">
</span>
<br>

<?echo "<div style='font-size: 14px; font-family: Arial, Helvetica, Sans-serif;'><b>gasteriskCLI v1.0 by <a href=\"\" onclick=\"javascript:window.open('http://sourceforge.net/projects/goaddons/', '_blank');\">JanuariusTM</a> :)<br>Server Name&nbsp;: </b> $hostn <br><b>Server IP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b>$hostp</div><br>\n";?>

<span>
<form onsubmit="return false" style="font-size: 14px; color:#3F0;background:#000;position:relative;min-height:465px;max-height:500px;width:100%;max-width:930px;font-family:Arial, Helvetica, Sans-serif;">
<div id="outt" style="font-size: 14px; overflow:auto;padding:-1px;min-height:465px;max-height:500px;width:100%;max-width:930px;font-family:Arial, Helvetica, Sans-serif;"><? echo $hostn; echo '*CLI>'; ?></div>
<input tabindex="1" onkeyup="keyE(event)" style="font-size: 14px; color:#3F0;background:#000;width:100%;max-width:925px;font-family:Arial, Helvetica, Sans-serif;" id="cmd" type="text" />
</form>
</span>

</body>
</html>
<?echo "<br><br><div style='font-size: 14px; font-family: Arial, Helvetica, Sans-serif;'>gasteriskCLI v1.0 © 2010 <a href=\"\" onclick=\"javascript:window.open('http://sourceforge.net/projects/goaddons/', '_blank');\"></a> | <a href=\"\" onclick=\"javascript:window.open('http://www.goautodial.com/', '_blank');\">GOAutoDial Inc.</a> by <a href=\"\" onclick=\"javascript:window.open('http://sourceforge.net/projects/goaddons/', '_blank');\">JanuariusTM</a> :)</div><br><br>\n";?>
<?php } ?>