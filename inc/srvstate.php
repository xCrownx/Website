<?php
	if(@fsockopen('127.0.0.1', 4000, $errno, $errstr, 1)) {
		echo '1';
	} else {
		echo '0';
	}
?>