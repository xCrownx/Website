<?php
	odbc_exec($mssql, 'USE [ACCOUNT_DBF]');
	$online = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [ACCOUNT_TBL] WHERE isuse = \'J\'');
	odbc_exec($mssql, 'USE [LOGGING_01_DBF]');
	$peak = odbc_exec($mssql, 'SELECT TOP 1 number FROM [LOG_USER_CNT_TBL] ORDER BY [number] DESC');
?>
<h1>Server Information</h1>
<div class="panel">
    <table>
        <tr>
            <td>Server Time:</td>
            <td id="srvtime"></td>
        </tr>
        <tr>
            <td>Server Date:</td>
            <td><?php echo date('d.m.Y'); ?></td>
        </tr>
        <tr>
            <td colspan="2"><br /></td>
        </tr>
        <tr>
            <td>Server Status:</td>
            <td><div id="srvworld"><img src="./img/load.gif" alt="" /></div></td>
        </tr>
        <tr>
            <td>Server Peak:</td>
            <td><?php echo odbc_result($peak, 'number'); ?></td>
        </tr>
        <tr>
            <td>Online User:</td>
            <td><?php echo odbc_result($online, 'count'); ?></td>
        </tr>
        <tr>
            <td colspan="2"><br /></td>
        </tr>
        <tr>
            <td><b>Normal Mode:</b></td>
            <td></td>
        </tr>
        <tr>
            <td>EXP Rate:</td>
            <td>50x</td>
        </tr>
        <tr>
            <td>Drop Rate:</td>
            <td>Custom</td>
        </tr>
        <tr>
            <td>Penya Rate:</td>
            <td>100</td>
        </tr>
        <tr>
            <td><b>Hardcore Mode:</b></td>
            <td></td>
        </tr>
        <tr>
            <td>EXP Rate:</td>
            <td>5x</td>
        </tr>
        <tr>
            <td>Drop Rate:</td>
            <td>Luckydrop +1</td>
        </tr>
        <tr>
            <td>Penya Rate:</td>
            <td>200</td>
        </tr>
        <tr>
            <td colspan="2"><br /></td>
        </tr>
    </table>
</div>