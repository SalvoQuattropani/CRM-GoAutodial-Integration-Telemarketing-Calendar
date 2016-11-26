<?php
############################################################################################
####  Name:             g_ast_start.php                                                 ####
####  Version:          2.0                                                             ####
####  Copyright:        GOAutoDial Inc. - Januarius Manipol <januarius@goautodial.com>  ####
####  License:          AGPLv2                                                          ####
############################################################################################

require("includes/g_authenticate.php");
require("includes/g_hpage.php");

$result = exec('ls /var/run/ | grep asterisk.ctl');

if ($result=='asterisk.ctl')
	{
	echo "<br><br><FONT FACE='VERDANA' COLOR=BLACK SIZE=2>Asterisk telephony is already running in your machine! Start initialization failed!<br />\n";
	}
	else
	{
	$startme = exec('/usr/share/goautodial/goautodialc.pl "/usr/sbin/asterisk .vgggggggggggggggcccc"');		
	$result = exec('ls /var/run/ | grep asterisk.ctl');
 	if ($result=='asterisk.ctl')
 		{
		echo "<br><br><FONT FACE='VERDANA' COLOR=BLACK SIZE=2>Asterisk telephony was successfully started!<br />\n";
		}		
		else
		{	
		echo "<br><br><FONT FACE='VERDANA' COLOR=BLACK SIZE=2>Asterisk telephony start initialization failed! Please contact your dialer administrator!<br />\n";
		}
	}
exit;	
?> 
