<?php
	include('./inc/config.inc.php');
	// Überprüfen, ob der Parameter 'dlid' in der URL vorhanden ist, andernfalls leeren Wert setzen
	if(!isset($_GET['dlid'])) $_GET['dlid'] = '';
	
	// Datenbank auswählen
	odbc_exec($mssql, 'USE [WEBSITE_DBF]');
	
	// Überprüfen, ob ein Download mit der gegebenen 'dlid' existiert
	$check = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_downloads] WHERE dlid=\''.mssql_escape_string($_GET['dlid']).'\'');
	
	if(odbc_result($check, 'count') > 0) {
		// Den Link zum Download abrufen
		$link = odbc_exec($mssql, 'SELECT link FROM [web_downloads] WHERE dlid=\''.mssql_escape_string($_GET['dlid']).'\'');
		
		// HTTP-Header setzen, um den Download zu initiieren
		header("Cache-control: private");
		header('Content-Type: '.detect_mime(odbc_result($link, 'link')));
		header("Content-Length: ".filesize(odbc_result($link, 'link')));
		header('Content-Disposition: attachment; filename="'.substr(strrchr(odbc_result($link, 'link'), '/'), 1).'"');
		header("Content-Transfer-Encoding: binary");
		
		// Datei ausgeben
		readfile(odbc_result($link, 'link'));
		
		// Aktualisieren der Klickanzahl für den Download
		odbc_exec($mssql, 'UPDATE [web_downloads] SET clicks=clicks+1 WHERE dlid=\''.mssql_escape_string($_GET['dlid']).'\'');
	}
?>
