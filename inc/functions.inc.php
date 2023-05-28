<?php
	function mssql_escape_string($string) {
		$replaced_string = str_replace("'", "''", $string);
		return $replaced_string;
	}

	function getConfigValue($key, $default='') {
		global $mssql;
		odbc_exec($mssql, 'USE [WEBSITE_DBF]');
		$query = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_config] WHERE col=\''.mssql_escape_string($key).'\'');
		if(odbc_result($query, 'count') > 0) {
			$get = odbc_exec($mssql, 'SELECT value FROM [web_config] WHERE col=\''.mssql_escape_string($key).'\'');
			return odbc_result($get, 'value');
		} else {
			return $default;
		}
	}
	
	function setConfigValue($key, $value='') {
		global $mssql;
		odbc_exec($mssql, 'USE [WEBSITE_DBF]');
		$query = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_config] WHERE col=\''.mssql_escape_string($key).'\'');
		if(odbc_result($query, 'count') > 0) {
			return odbc_exec($mssql, 'UPDATE [web_config] SET value=\''.mssql_escape_string($value).'\' WHERE col=\''.mssql_escape_string($key).'\'');
		} else {
			return odbc_exec($mssql, 'INSERT INTO [web_config](col, value) VALUES(\''.mssql_escape_string($key).'\', \''.mssql_escape_string($value).'\')');
		}
	}
	
	function diff($time) {
		$diff = strtotime(date('Y-m-d H:i:s')) - strtotime($time);
		$minutes = $diff / 60;
		if($minutes >= 60) {
			$hours = $minutes / 60;
			$minutes = $minutes % 60;
		} else {
			$hours = 0;
		}
		return array('hours' => floor($hours), 'minutes' => $minutes);
	}
	
	function send_item($playerid, $itemid, $quantity) {
		global $mssql;
		odbc_exec($mssql, 'USE [CHARACTER_01_DBF]');
		odbc_exec($mssql, 'INSERT INTO [ITEM_SEND_TBL](
		m_idPlayer, serverindex, Item_Name, Item_count, idSender
		) VALUES(
		\''.mssql_escape_string($playerid).'\',
		\'01\',
		\''.mssql_escape_string($itemid).'\',
		\''.mssql_escape_string($quantity).'\',
		\'0000000\')');
	}
	
	function send_item_list($playerid, $itemidArray, $quantityArray) {
		global $mssql;
		for($i = 0;$i < count($itemidArray);$i++)
		{
			odbc_exec($mssql, 'USE [CHARACTER_01_DBF]');
			odbc_exec($mssql, 'INSERT INTO [ITEM_SEND_TBL](
			m_idPlayer, serverindex, Item_Name, Item_count, idSender
			) VALUES(
			\''.mssql_escape_string($playerid).'\',
			\'01\',
			\''.mssql_escape_string($itemidArray[$i]).'\',
			\''.mssql_escape_string($quantityArray[$i]).'\',
			\'0000000\')');
		}
	}
	
	function authgroup($index) {
		switch($index) {
			case 'F': $group = 'User'; break;
			case 'M': $group = 'GameMaster'; break;
			case 'N': $group = 'GameMaster'; break;
			case 'L': $group = 'GameMaster'; break;
			case 'P': $group = 'Administrator'; break;
			case 'Z': $group = 'Administrator'; break;
			default: $group = 'User'; break;
		}
		return $group;
	}
	
	function getjob($jobid) {
		switch($jobid) {
			case 0: $jobname = 'Vagrant'; break;
			case 1: $jobname = 'Mercenary'; break;
			case 2: $jobname = 'Assist'; break;
			case 3: $jobname = 'Acrobat'; break;
			case 4: $jobname = 'Magician'; break;
			case 5: $jobname = 'Puppeter'; break;
			case 6: $jobname = 'Knight'; break;
			case 7: $jobname = 'Blade'; break;
			case 8: $jobname = 'Jester'; break;
			case 9: $jobname = 'Ranger'; break;
			case 10: $jobname = 'Ringmaster'; break;
			case 11: $jobname = 'Billposter'; break;
			case 12: $jobname = 'Psykeeper'; break;
			case 13: $jobname = 'Elementor'; break;
			case 14: $jobname = 'Gatekeeper'; break;
			case 15: $jobname = 'Doppler'; break;
			case 16: $jobname = 'Master Knight'; break;
			case 17: $jobname = 'Master Blade'; break;
			case 18: $jobname = 'Master Jester'; break;
			case 19: $jobname = 'Master Ranger'; break;
			case 20: $jobname = 'Master Ringmaster'; break;
			case 21: $jobname = 'Master Billposter'; break;
			case 22: $jobname = 'Master Psykeeper'; break;
			case 23: $jobname = 'Master Elementor'; break;
			case 24: $jobname = 'Hero Knight'; break;
			case 25: $jobname = 'Hero Blade'; break;
			case 26: $jobname = 'Hero Jester'; break;
			case 27: $jobname = 'Hero Ranger'; break;
			case 28: $jobname = 'Hero Ringmaster'; break;
			case 29: $jobname = 'Hero Billposter'; break;
			case 30: $jobname = 'Hero Psykeeper'; break;
			case 31: $jobname = 'Hero Elementor'; break;
			case 32: $jobname = 'Lord Templer'; break;
			case 33: $jobname = 'Storm Blade'; break;
			case 34: $jobname = 'Wind Lurker'; break;
			case 35: $jobname = 'Crack Shooter'; break;
			case 36: $jobname = 'Florist'; break;
			case 37: $jobname = 'Force Master'; break;
			case 38: $jobname = 'Mentalist'; break;
			case 39: $jobname = 'Arcanist'; break;
			default: $jobname = 'n/a'; break;
		}
		
		return $jobname;
	}
	
	function detect_mime($filename) {
		$filetype = strrchr($filename, ".");

		switch ($filetype) {
			case ".rar": $mime="application/x-rar-compressed"; break;
			case ".zip": $mime="application/zip"; break;
			case ".ez":  $mime="application/andrew-inset"; break;
			case ".hqx": $mime="application/mac-binhex40"; break;
			case ".cpt": $mime="application/mac-compactpro"; break;
			case ".doc": $mime="application/msword"; break;
			case ".bin": $mime="application/octet-stream"; break;
			case ".dms": $mime="application/octet-stream"; break;
			case ".lha": $mime="application/octet-stream"; break;
			case ".lzh": $mime="application/octet-stream"; break;
			case ".exe": $mime="application/octet-stream"; break;
			case ".class": $mime="application/octet-stream"; break;
			case ".so":  $mime="application/octet-stream"; break;
			case ".dll": $mime="application/octet-stream"; break;
			case ".oda": $mime="application/oda"; break;
			case ".pdf": $mime="application/pdf"; break;
			case ".ai":  $mime="application/postscript"; break;
			case ".eps": $mime="application/postscript"; break;
			case ".ps":  $mime="application/postscript"; break;
			case ".smi": $mime="application/smil"; break;
			case ".smil": $mime="application/smil"; break;
			case ".xls": $mime="application/vnd.ms-excel"; break;
			case ".ppt": $mime="application/vnd.ms-powerpoint"; break;
			case ".wbxml": $mime="application/vnd.wap.wbxml"; break;
			case ".wmlc": $mime="application/vnd.wap.wmlc"; break;
			case ".wmlsc": $mime="application/vnd.wap.wmlscriptc"; break;
			case ".bcpio": $mime="application/x-bcpio"; break;
			case ".vcd": $mime="application/x-cdlink"; break;
			case ".pgn": $mime="application/x-chess-pgn"; break;
			case ".cpio": $mime="application/x-cpio"; break;
			case ".csh": $mime="application/x-csh"; break;
			case ".dcr": $mime="application/x-director"; break;
			case ".dir": $mime="application/x-director"; break;
			case ".dxr": $mime="application/x-director"; break;
			case ".dvi": $mime="application/x-dvi"; break;
			case ".spl": $mime="application/x-futuresplash"; break;
			case ".gtar": $mime="application/x-gtar"; break;
			case ".hdf": $mime="application/x-hdf"; break;
			case ".js":  $mime="application/x-javascript"; break;
			case ".skp": $mime="application/x-koan"; break;
			case ".skd": $mime="application/x-koan"; break;
			case ".skt": $mime="application/x-koan"; break;
			case ".skm": $mime="application/x-koan"; break;
			case ".latex": $mime="application/x-latex"; break;
			case ".nc":  $mime="application/x-netcdf"; break;
			case ".cdf": $mime="application/x-netcdf"; break;
			case ".sh":  $mime="application/x-sh"; break;
			case ".shar": $mime="application/x-shar"; break;
			case ".swf": $mime="application/x-shockwave-flash"; break;
			case ".sit": $mime="application/x-stuffit"; break;
			case ".sv4cpio": $mime="application/x-sv4cpio"; break;
			case ".sv4crc": $mime="application/x-sv4crc"; break;
			case ".tar": $mime="application/x-tar"; break;
			case ".tcl": $mime="application/x-tcl"; break;
			case ".tex": $mime="application/x-tex"; break;
			case ".texinfo": $mime="application/x-texinfo"; break;
			case ".texi": $mime="application/x-texinfo"; break;
			case ".t":   $mime="application/x-troff"; break;
			case ".tr":  $mime="application/x-troff"; break;
			case ".roff": $mime="application/x-troff"; break;
			case ".man": $mime="application/x-troff-man"; break;
			case ".me":  $mime="application/x-troff-me"; break;
			case ".ms":  $mime="application/x-troff-ms"; break;
			case ".ustar": $mime="application/x-ustar"; break;
			case ".src": $mime="application/x-wais-source"; break;
			case ".xhtml": $mime="application/xhtml+xml"; break;
			case ".xht": $mime="application/xhtml+xml"; break;
			case ".zip": $mime="application/zip"; break;
			case ".php": $mime="application/x-httpd-php"; break;
			case ".au":  $mime="audio/basic"; break;
			case ".snd": $mime="audio/basic"; break;
			case ".mid": $mime="audio/midi"; break;
			case ".midi": $mime="audio/midi"; break;
			case ".kar": $mime="audio/midi"; break;
			case ".mpga": $mime="audio/mpeg"; break;
			case ".mp2": $mime="audio/mpeg"; break;
			case ".mp3": $mime="audio/mpeg"; break;
			case ".aif": $mime="audio/x-aiff"; break;
			case ".aiff": $mime="audio/x-aiff"; break;
			case ".aifc": $mime="audio/x-aiff"; break;
			case ".m3u": $mime="audio/x-mpegurl"; break;
			case ".ram": $mime="audio/x-pn-realaudio"; break;
			case ".rm":  $mime="audio/x-pn-realaudio"; break;
			case ".rpm": $mime="audio/x-pn-realaudio-plugin"; break;
			case ".ra":  $mime="audio/x-realaudio"; break;
			case ".wav": $mime="audio/x-wav"; break;
			case ".pdb": $mime="chemical/x-pdb"; break;
			case ".xyz": $mime="chemical/x-xyz"; break;
			case ".bmp": $mime="image/bmp"; break;
			case ".gif": $mime="image/gif"; break;
			case ".ief": $mime="image/ief"; break;
			case ".jpeg": $mime="image/jpeg"; break;
			case ".jpg": $mime="image/jpeg"; break;
			case ".jpe": $mime="image/jpeg"; break;
			case ".png": $mime="image/png"; break;
			case ".tiff": $mime="image/tiff"; break;
			case ".tif": $mime="image/tiff"; break;
			case ".djvu": $mime="image/vnd.djvu"; break;
			case ".djv": $mime="image/vnd.djvu"; break;
			case ".wbmp": $mime="image/vnd.wap.wbmp"; break;
			case ".ras": $mime="image/x-cmu-raster"; break;
			case ".pnm": $mime="image/x-portable-anymap"; break;
			case ".pbm": $mime="image/x-portable-bitmap"; break;
			case ".pgm": $mime="image/x-portable-graymap"; break;
			case ".ppm": $mime="image/x-portable-pixmap"; break;
			case ".rgb": $mime="image/x-rgb"; break;
			case ".xbm": $mime="image/x-xbitmap"; break;
			case ".xpm": $mime="image/x-xpixmap"; break;
			case ".xwd": $mime="image/x-xwindowdump"; break;
			case ".igs": $mime="model/iges"; break;
			case ".iges": $mime="model/iges"; break;
			case ".msh": $mime="model/mesh"; break;
			case ".mesh": $mime="model/mesh"; break;
			case ".silo": $mime="model/mesh"; break;
			case ".wrl": $mime="model/vrml"; break;
			case ".vrml": $mime="model/vrml"; break;
			case ".css": $mime="text/css"; break;
			case ".html": $mime="text/html"; break;
			case ".htm": $mime="text/html"; break;
			case ".asc": $mime="text/plain"; break;
			case ".txt": $mime="text/plain"; break;
			case ".rtx": $mime="text/richtext"; break;
			case ".rtf": $mime="text/rtf"; break;
			case ".sgml": $mime="text/sgml"; break;
			case ".sgm": $mime="text/sgml"; break;
			case ".tsv": $mime="text/tab-separated-values"; break;
			case ".wml": $mime="text/vnd.wap.wml"; break;
			case ".wmls": $mime="text/vnd.wap.wmlscript"; break;
			case ".etx": $mime="text/x-setext"; break;
			case ".xml": $mime="text/xml"; break;
			case ".xsl": $mime="text/xml"; break;
			case ".mpeg": $mime="video/mpeg"; break;
			case ".mpg": $mime="video/mpeg"; break;
			case ".mpe": $mime="video/mpeg"; break;
			case ".qt":  $mime="video/quicktime"; break;
			case ".mov": $mime="video/quicktime"; break;
			case ".mxu": $mime="video/vnd.mpegurl"; break;
			case ".avi": $mime="video/x-msvideo"; break;
			case ".movie": $mime="video/x-sgi-movie"; break;
			case ".asf": $mime="video/x-ms-asf"; break;
			case ".asx": $mime="video/x-ms-asf"; break;
			case ".wm":  $mime="video/x-ms-wm"; break;
			case ".wmv": $mime="video/x-ms-wmv"; break;
			case ".wvx": $mime="video/x-ms-wvx"; break;
			case ".ice": $mime="x-conference/x-cooltalk"; break;
			default: $mime=$filetype; break;
		}
		
		return $mime;
	}
?>
