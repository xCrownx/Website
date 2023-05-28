<?php include('./inc/header.php'); ?>
<h1>Account Panel</h1>
<div class="site">
	<?php
        if(!isset($_GET['a']) || empty($_GET['a'])) $_GET['a'] = '';
        
        if(isset($_SESSION['user'])) {
            odbc_exec($mssql, 'USE [ACCOUNT_DBF]');
            $accountselect = odbc_exec($mssql, 'SELECT * FROM [ACCOUNT_TBL] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\'');
            $accountselect2 = odbc_exec($mssql, 'SELECT * FROM [ACCOUNT_TBL_DETAIL] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\'');
            $account = odbc_fetch_array($accountselect);
            $account2 = odbc_fetch_array($accountselect2);
            odbc_exec($mssql, 'USE [CHARACTER_01_DBF]');
            $charcount = odbc_exec($mssql, 'SELECT COUNT(*) AS count FROM [CHARACTER_TBL] WHERE account=\''.mssql_escape_string($account['account']).'\' AND isblock=\'F\'');
            $characters = odbc_exec($mssql, 'SELECT * FROM [CHARACTER_TBL] WHERE account=\''.mssql_escape_string($account['account']).'\' AND isblock=\'F\'');
            if($_GET['a'] == 'changemail') {
                if(empty($_POST['chgmail_oldmail'])) $_POST['chgmail_oldmail'] = '';
                if(empty($_POST['chgmail_newmail'])) $_POST['chgmail_newmail'] = '';
                if(empty($_POST['chgmail_confirmmail'])) $_POST['chgmail_confirmmail'] = '';
                
                odbc_exec($mssql, 'USE [ACCOUNT_DBF]');
                $check1 = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [ACCOUNT_TBL_DETAIL] WHERE email=\''.mssql_escape_string($_POST['chgmail_newmail']).'\'');
                $errors = array();
                if(empty($_POST['chgmail_oldmail']) || empty($_POST['chgmail_newmail']) || empty($_POST['chgmail_confirmmail']))
                    $errors[] = 'You must fill in all fields!';
                if(!empty($_POST['chgmail_oldmail']) && $_POST['chgmail_oldmail'] != $account2['email'])
                    $errors[] = 'Your old email address is not correct!';
                if(!empty($_POST['chgmail_newmail']) && odbc_result($check1, 'count') > 0)
                    $errors[] = 'Your new email address already exists!';
                if(!empty($_POST['chgmail_newmail']) && !preg_match('/^[a-zA-Z0-9-_.]+@[a-zA-Z0-9-_.]+\.[a-zA-Z]{2,4}$/', $_POST['chgmail_newmail']))
                    $errors[] = 'The new e-mail address is not valid!';
                if((!empty($_POST['chgmail_newmail']) && !empty($_POST['chgmail_confirmmail'])) && $_POST['chgmail_newmail'] != $_POST['chgmail_confirmmail'])
                    $errors[] = 'The repetition of the e-mail address is not correct!';
                    
                if(isset($_POST['chgmail_submit'])) {
                    if(count($errors) > 0) {
                        echo '<div class="fail">';
                        foreach($errors as $error) {
                            echo $error.'<br/>';
                        }
                        echo '</div>';
                    } else {
                        if(odbc_exec($mssql, 'UPDATE [ACCOUNT_TBL_DETAIL] SET email=\''.mssql_escape_string($_POST['chgmail_newmail']).'\' WHERE account=\''.mssql_escape_string($account['account']).'\'')) {
                            echo '<div class="success">Your email address was successfully changed!</div>';
                        }
                    }
                }
                echo '<h3>Change email</h3>';
                echo '<form method="post">
                    <table>
                        <tr>
                            <td>Old email:</td>
                            <td><input type="text" name="chgmail_oldmail" />
                        </tr>
                        <tr>
                            <td>New email:</td>
                            <td><input type="text" name="chgmail_newmail" />
                        </tr>
                        <tr>
                            <td>Repeat email:</td>
                            <td><input type="text" name="chgmail_confirmmail" />
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" name="chgmail_submit" value="Safe" />
                        </tr>
                    </table>
                </form>';
            } else if($_GET['a'] == 'changepw') {
                if(empty($_POST['chgmail_oldmail'])) $_POST['chgmail_oldmail'] = '';
                if(empty($_POST['chgmail_newmail'])) $_POST['chgmail_newmail'] = '';
                if(empty($_POST['chgmail_confirmmail'])) $_POST['chgmail_confirmmail'] = '';
                
                odbc_exec($mssql, 'USE [ACCOUNT_DBF]');
                $errors = array();
                if(empty($_POST['chgpw_oldpw']) || empty($_POST['chgpw_newpw']) || empty($_POST['chgpw_confirmpw']))
                    $errors[] = 'You must fill in all fields!';
                if(!empty($_POST['chgpw_oldpw']) && md5($_CONFIG['pwdsalt'].$_POST['chgpw_oldpw']) != $account['password'])
                    $errors[] = 'Your old password is not correct!';
                if(!empty($_POST['chgpw_newpw']) && (strlen($_POST['chgpw_newpw']) < 6 || strlen($_POST['chgpw_newpw']) > 12))
                    $errors[] = 'Your password must contain 6 - 12 characters!';
                if((!empty($_POST['chgpw_newpw']) && !empty($_POST['chgpw_confirmpw'])) && $_POST['chgpw_newpw'] != $_POST['chgpw_confirmpw'])
                    $errors[] = 'The password repetition is not true!';
                    
                if(isset($_POST['chgpw_submit'])) {
                    if(count($errors) > 0) {
                        echo '<div class="fail">';
                        foreach($errors as $error) {
                            echo $error.'<br/>';
                        }
                        echo '</div>';
                    } else {
                        if(odbc_exec($mssql, 'UPDATE [ACCOUNT_TBL] SET password=\''.mssql_escape_string(md5($_CONFIG['pwdsalt'].$_POST['chgpw_newpw'])).'\' WHERE account=\''.mssql_escape_string($account['account']).'\'')) {
                            echo '<div class="success">Your password has been successfully changed!</div>';
                        }
                    }
                }
                echo '<h3>Change password</h3>';
                echo '<form method="post">
                    <table>
                        <tr>
                            <td>Old password:</td>
                            <td><input type="password" name="chgpw_oldpw" />
                        </tr>
                        <tr>
                            <td>New password:</td>
                            <td><input type="password" name="chgpw_newpw" />
                        </tr>
                        <tr>
                            <td>Repeat password:</td>
                            <td><input type="password" name="chgpw_confirmpw" />
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" name="chgpw_submit" value="Safe" />
                        </tr>
                    </table>
                </form>';
            } else if ($_GET['a'] == 'guildrejoin') {
                if(isset($_POST['guildrejoin_submit'])) {
                    odbc_exec($mssql, 'USE [CHARACTER_01_DBF]');
                    $check = odbc_exec($mssql, 'SELECT COUNT(*) AS count FROM [CHARACTER_TBl] WHERE m_szName=\''.mssql_escape_string($_POST['guildrejoin_char']).'\' AND account=\''.mssql_escape_string($_SESSION['user']).'\'');
                    if(odbc_result($check, 'count') > 0) {
                        if(odbc_exec($mssql, 'UPDATE [CHARACTER_TBL] SET m_tGuildMember=\'20080808000000\' WHERE m_szName=\''.mssql_escape_string($_POST['guildrejoin_char']).'\'')) {
                            echo '<div class="success">Your guild rejoin time has been successfully reset!</div>';
                        }
                    } else {
                        echo '<div class="fail">Your guild rejoin time could not be reset!</div>';
                    }
                }
                echo '<h3>Guild rejoin time</h3>';
                echo '<form method="post">
                    <table>
                        <tr>
                            <td>Character:</td>
                            <td><input type="text" name="guildrejoin_char" />
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" name="guildrejoin_submit" value="Reset" />
                        </tr>
                    </table>
                </form>';
            } else if($_GET['a'] == 'donationlogs') {
                odbc_exec($mssql, 'USE [WEBSITE_DBF]');
                $count = odbc_exec($mssql, 'SELECT COUNT(*) AS count FROM [web_psclogs] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\'');
                $psclogs = odbc_exec($mssql, 'SELECT * FROM [web_psclogs] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\' ORDER BY datetime DESC');
                echo '<h3>Donation Logs</h3>';
                if(odbc_result($count, 'count') > 0) {
                    echo '<table style="width: 100%; text-align: center;">
                        <tr style="font-weight: bold;">
                            <td id="key">ID</td>
                            <td id="key">Account</td>
                            <td id="key">Value</td>
                            <td id="key">Typ</td>
                            <td id="key">Date</td>
                            <td id="key">Time</td>
                        </tr>';
                    while($paysafe = odbc_fetch_array($psclogs)) {
                        echo '<tr>
                            <td>'.$paysafe['pscid'].'</td>
                            <td>'.$paysafe['account'].'</td>
                            <td>'.$paysafe['worth'].' &euro;</td>
                            <td>PaySafeCard</td>
                            <td>'.date('Y-m-d', strtotime($paysafe['datetime'])).'</td>
                            <td>'.date('H:i', strtotime($paysafe['datetime'])).'</td>
                        </tr>';
                    }
                    echo '</table>';
                } else {
                    echo '<div class="fail">No Donation Logs available!</div>';
                }
            } else if($_GET['a'] == 'buylogs') {
                odbc_exec($mssql, 'USE [WEBSITE_DBF]');
                $count = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_buylogs] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\'');
                $buyinglogs = odbc_exec($mssql, 'SELECT * FROM [web_buylogs] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\' ORDER BY datetime DESC');
                echo '<h3>Buying Logs</h3>';
                if(odbc_result($count, 'count') > 0) {
                    echo '<table style="width: 100%; text-align: center;">
                        <tr>
                            <td id="key">ID</td>
                            <td id="key">Item</td>
                            <td id="key">Quantity</td>
                            <td id="key">Date</td>
                            <td id="key">Time</td>
                        </tr>';
                    while($buying = odbc_fetch_array($buyinglogs)) {
                        $mall = odbc_exec($mssql, 'SELECT * FROM [web_mall] WHERE mid=\''.mssql_escape_string($buying['item']).'\'');
                        $item = odbc_fetch_array($mall);
                        echo '<tr>
                            <td>'.$buying['bid'].'</td>
                            <td>'.$item['name'].'</td>
                            <td>'.$item['count'].'</td>
                            <td>'.date('Y-m-d', strtotime($buying['datetime'])).'</td>
                            <td>'.date('H:i', strtotime($buying['datetime'])).'</td>
                        </tr>';
                    }
                    echo '</table>';
                } else {
                    echo '<div class="fail">No buying logs available!</div>';
                }
            } else if($_GET['a'] == 'giftlogs') {
                odbc_exec($mssql, 'USE [WEBSITE_DBF]');
                $count = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_giftlogs] WHERE accfrom=\''.mssql_escape_string($_SESSION['user']).'\'');
                $giftinglogs = odbc_exec($mssql, 'SELECT * FROM [web_giftlogs] WHERE accfrom=\''.mssql_escape_string($_SESSION['user']).'\' ORDER BY datetime DESC');
                echo '<h3>Gift Logs</h3>';
                if(odbc_result($count, 'count') > 0) {
                    echo '<table style="width: 100%; text-align: center;">
                        <tr>
                            <td id="key">ID</td>
                            <td id="key">Item</td>
                            <td id="key">Quantity</td>
                            <td id="key">Account (To)</td>
                            <td id="key">Character (To)</td>
                            <td id="key">Date / Time</td>
                        </tr>';
                    while($gifting = odbc_fetch_array($giftinglogs)) {
                        $mall = odbc_exec($mssql, 'SELECT * FROM [web_mall] WHERE mid=\''.mssql_escape_string($gifting['item']).'\'');
                        $item = odbc_fetch_array($mall);
                        echo '<tr>
                            <td>'.$gifting['giftid'].'</td>
                            <td>'.$item['name'].'</td>
                            <td>'.$item['count'].'</td>
                            <td>'.$gifting['accto'].'</td>
                            <td>'.$gifting['charto'].'</td>
                            <td>'.date('Y-m-d H:i', strtotime($gifting['datetime'])).'</td>
                        </tr>';
                    }
                    echo '</table>';
                } else {
                    echo '<div class="fail">No gift logs available!</div>';
                }
                
            } else if(isset($_GET['logout'])) {
                session_destroy();
                echo '<div class="success">You have been logged out successfully!</div>';
                echo '<script type="text/javascript">location.href="index.php";</script>';
            } else {
                $status = 'Normal';
                if($account2['BlockTime'] > date('Ymd')) {
                    $status = 'Gebannt ('.substr($account2['BlockTime'],0,4).'-'.substr($account2['BlockTime'],5,6).'-'.substr($account2['BlockTime'],6,7).')';
                }
                echo 'You are logged in as "<b>'.$account['account'].'</b>".<br /><br />';
                echo '<div style="float: left; margin-right: 30px;"><h3>Account Info:</h3>';
                echo '<table>
                    <tr>
                        <td id="key">Status:</td>
                        <td id="value">'.$status.'</td>
                    </tr>
                    <tr>
                        <td id="key">Groupe:</td>
                        <td id="value">'.authgroup($account2['m_chLoginAuthority']).'</td>
                    </tr>
                    <tr>
                        <td id="key">E-Mail:</td>
                        <td id="value">'.$account2['email'].'</td>
                    </tr>
                    <tr>
                        <td id="key">Cash:</td>
                        <td id="value">'.$account['cash'].' <a href="donate.php"><img src="./img/dpadd.png" /></a></td>
                    </tr>
                </table></div>';
                echo '<div style="float: left; margin-right: 30px;"><h3>Account Options:</h3>';
                echo '<ul>
                    <li><a href="account.php?a=changemail">Change email</a></li>
                    <li><a href="account.php?a=changepw">Change password</a></li>
                    <li><a href="account.php?a=guildrejoin">Reset guilds rejoin</a></li>
                    <li><a href="account.php?a=donationlogs">Show Donation Logs</a></li>
                    <li><a href="account.php?a=buylogs">Show Buying Logs</a></li>
                    <li><a href="account.php?a=giftlogs">Show Gift Logs</a></li>';
                echo '</ul></div>';
                if(authgroup($account2['m_chLoginAuthority']) == 'GameMaster') {
                    echo '<div style="float: left;"><h2>GameMaster Optionen:</h2>';
                    echo '<ul>
                        <li>-</li>
                    </ul></div>';
                }
                echo '<br style="clear: both;" /><br /><h2>Characters:</h2>';
                if(odbc_result($charcount, 'count') > 0) {
                    while($char = odbc_fetch_array($characters)) {
                        switch($char['m_dwSex']) {
                            case 0: $sex = 'male'; break;
                            case 1: $sex = 'female'; break;
                            default: $sex = 'male'; break;
                        }
                        $guildquery = odbc_exec($mssql, 'SELECT m_idGuild FROM [GUILD_MEMBER_TBL] WHERE m_idPlayer = \''.mssql_escape_string($char['m_idPlayer']).'\'');
                        $guildname = odbc_exec($mssql, 'SELECT m_szGuild FROM [GUILD_TBL] WHERE m_idGuild = \''.mssql_escape_string(odbc_result($guildquery, 'm_idGuild')).'\'');
                        echo '<table style="border: 1px solid #fff; padding: 5px; width: 100%;">
                            <tr>
                                <td id="key">Name</td>
                                <td id="value" style="width: 150px;">'.$char['m_szName'].'</td>
                                <td id="key">STR</td>
                                <td id="value" style="width: 150px;">'.$char['m_nStr'].'</td>
                                <td id="key">Penya</td>
                                <td id="value">'.$char['m_dwGold'].'</td>
                            </tr>
                            <tr>
                                <td id="key">Sex</td>
                                <td id="value"><img src="./img/'.$sex.'.png" /></td>
                                <td id="key">STA</td>
                                <td id="value">'.$char['m_nSta'].'</td>
                                <td id="key">Guild</td>
                                <td id="value">'.odbc_result($guildname, 'm_szGuild').'</td>
                            </tr>
                            <tr>
                                <td id="key">Class</td>
                                <td id="value">'.getjob($char['m_nJob'],$char['m_nLevel']).'</td>
                                <td id="key">DEX</td>
                                <td id="value">'.$char['m_nDex'].'</td>
                                <td id="key"></td>
                                <td id="value"></td>
                            </tr>
                            <tr>
                                <td id="key">Level</td>
                                <td id="value">'.$char['m_nLevel'].'</td>
                                <td id="key">INT</td>
                                <td id="value">'.$char['m_nInt'].'</td>
                                <td id="key"></td>
                                <td id="value"></td>
                            </tr>
                        </table><br />';
                    }
                } else {
                    echo '<div class="fail">Sorry, you dont have any characters right now!</div>';
                }
            }
        } else {
            if(isset($_POST['login_submit'])) {
                odbc_exec($mssql, 'USE [ACCOUNT_DBF]');
                $check = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [ACCOUNT_TBL] WHERE account=\''.mssql_escape_string($_POST['login_username']).'\'');
                if(odbc_result($check, 'count') > 0) {
                    $password = odbc_exec($mssql, 'SELECT password FROM [ACCOUNT_TBL] WHERE account=\''.mssql_escape_string($_POST['login_username']).'\'');
                    if(odbc_result($password, 'password') == md5($_CONFIG['pwdsalt'].$_POST['login_password'])) {
                        $_SESSION['user'] = $_POST['login_username'];
                        echo '<div class="success">You have been logged in successfully!</div>';
                        echo '<script type="text/javascript">location.href="account.php";</script>';
                    } else {
                        echo '<div class="fail">Your password is not correct!</div>';
                    }
                } else {
                    echo '<div class="fail">This account does not exist!</div>';
                }
            }
        }
    ?>
</div>
<?php include('./inc/footer.php'); ?>