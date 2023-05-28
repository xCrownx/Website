<?php
	session_start();
	
	// SQL Data
	define('MSSQL_HOST', 'CROWN\CROWN');	// MsSQL Host
	define('MSSQL_USER', 'sa');	// MsSQL Username
	define('MSSQL_PASS', '123456');	// MsSQL Password
	
	// Connecting to MsSQL (ODBC)
	$mssql = odbc_connect('Driver={SQL Server};Server='.MSSQL_HOST.';', MSSQL_USER, MSSQL_PASS);
	
	// Including Files
	include('functions.inc.php');
	
	// Config
	$_CONFIG['webtitle'] = getConfigValue('webtitle', 'Madness-Flyff');
	$_CONFIG['forumlink'] = getConfigValue('forumlink', 'https://discord.gg/t35Pa2h9QK');
	$_CONFIG['pwdsalt'] = getConfigValue('pwdsalt', 'kikugalanet');
	$_CONFIG['noreply'] = getConfigValue('noreplymail', '');
	$_CONFIG['ppemail'] = getConfigValue('ppemail', '');
	
	// PaySafeCard: Euro => Points
	$psc_values = array('10,00' => '1000', '25,00' => '2500', '50,00' => '5250', '100,00' => '11000');
	

	// Pass the $mssql variable to the global scope so it can be accessed in other scripts
	$GLOBALS['mssql'] = $mssql;
?>