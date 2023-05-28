<?php
	include('config.inc.php');
	if(empty($_SESSION['votebox'])) $_SESSION['votebox'] = '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $_CONFIG['webtitle']; ?></title>
        <link rel="stylesheet" type="text/css" href="./css/main.css" />
        <link rel="stylesheet" type="text/css" href="./css/slider.css" />
        <link rel="stylesheet" type="text/css" href="./css/site.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
        <script language="javascript" type="text/javascript" src="./js/jquery.js"></script>
        <script language="javascript" type="text/javascript" src="./js/main.js"></script>
        <script language="javascript" type="text/javascript" src="./js/loadimg.js"></script>
        <script language="javascript" type="text/javascript" src="./js/srvstate.js"></script>
		<script type="text/javascript" language="JavaScript" src="./js/core.js"></script>
        <script type="text/javascript" language="JavaScript" src="./js/events.js"></script>
        <script type="text/javascript" language="JavaScript" src="./js/css.js"></script>
        <script type="text/javascript" language="JavaScript" src="./js/coordinates.js"></script>
        <script type="text/javascript" language="JavaScript" src="./js/drag.js"></script>
        <script type="text/javascript" language="JavaScript" src="./js/dragit.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    </head>
    <body>
    	<div class="head"><a href="index.php"></a></div>
        <div class="navigation">
        	<ul>
            	<li><a href="index.php">Home</a></li>
            	<li><a href="<?php echo $_CONFIG['forumlink']; ?>" target="_blank">Discord</a></li>
            	<li><a href="register.php">Register</a></li>
            	<li><a href="download.php">Download</a></li>
            	<li><a href="ranking.php">Ranking</a></li>
            	<li><a href="shop.php">Shop</a></li>
            	<li><a href="donate.php">Donate</a></li>
            	<li><a href="staff.php">Staff</a></li>
            	<li><a href="faq.php">FAQ</a></li>
            </ul>
        </div>
        <div class="content">
        	<div class="main">