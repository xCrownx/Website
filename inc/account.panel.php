<h1>User Account Panel</h1>
<div class="panel">
	<?php
    include_once('./inc/config.inc.php');
    include_once('./inc/pingback.php');
    // Wähler-IP abrufen
    $voterIP = $_SERVER['REMOTE_ADDR'];
    // Übergebe $voterIP an die pingback-Funktion
    pingback($voterIP);
        if(isset($_SESSION['user'])) {
            odbc_exec($mssql, 'USE [ACCOUNT_DBF]');
            $cash = odbc_exec($mssql, 'SELECT cash FROM [ACCOUNT_TBL] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\'');
            $auth = odbc_exec($mssql, 'SELECT m_chLoginAuthority FROM [ACCOUNT_TBL_DETAIL] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\'');
            echo 'Welcome back, <b>'.$_SESSION['user'].'</b>.<br />';
            echo '<img src="./img/price.png" /> <span id="accpanel_dpcount">'.odbc_result($cash, 'cash').'</span> dP<br /><br />';
            echo '&raquo; <a href="account.php">Account management</a><br />';
            echo '&raquo; <a href="donate.php">Donate</a><br />';
            $voteUrl = 'https://gtop100.com/topsites/Flyff/sitedetails/Madness-Flyff-100376?vote=1' . urlencode($_SESSION['user']);
            echo '&raquo; <a href="javascript:void(0);" onclick="openVotePopup(\'' . $voteUrl . '\')">Vote</a><br />';
            echo '&raquo; <a href="shop.php">Item Shop</a><br />';
            echo '&raquo; <a href="shop.php?basket">Shopping cart</a><br /><br />';
            if(authgroup(odbc_result($auth, 'm_chLoginAuthority')) == 'Administrator') {
                echo '&raquo; <a href="./admin">Administration</a><br />';
            }
            echo '&raquo; <a href="account.php?logout">Logout</a>';
        } else {
    ?>
    <form action="account.php" method="post">
        <table>
            <tr>
                <td>Login:</td>
                <td><input type="text" name="login_username" /></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="login_password" /></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="login_submit" value="Login" /></td>
            </tr>
        </table>
    </form>
    <?php
        }
    ?>
</div>
<script src="js/scripts.js"></script>
