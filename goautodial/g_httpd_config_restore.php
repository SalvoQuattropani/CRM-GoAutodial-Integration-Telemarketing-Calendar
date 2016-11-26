<?php
############################################################################################
####  Name:             g_httpd_config_restore.php                                      ####
####  Version:          2.0                                                             ####
####  Copyright:        GOAutoDial Inc. - Januarius Manipol <januarius@goautodial.com>  ####
####  License:          AGPLv2                                                          ####
############################################################################################

require("includes/g_authenticate.php");
require("includes/g_hpage.php");

$startme = exec('/usr/share/goautodial/goautodialc.pl "/usr/share/goautodial/go_httpd_conf_restore.pl"');
if (preg_match("/FAILED/i", "$startme")) 
	{
		echo "<br><FONT style='font-family: Verdana, Helvetica, sans-serif; font-size: 12px;' COLOR=BLACK>&nbsp;&nbsp;&nbsp;Folder Access restoration failed! Please contact your systems administrator!<br />\n";
	} 
	else 
	{ 
		echo "<br><FONT style='font-family: Verdana, Helvetica, sans-serif; font-size: 12px;' COLOR=BLACK>&nbsp;&nbsp;&nbsp;Folder Access is successfully restored!<br />\n";
	}   
exit;	
?>
