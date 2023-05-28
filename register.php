<?php include('./inc/header.php'); ?>
<h1>Registration</h1>
<div class="site">
	<?php
        if(!isset($_POST['reg_username'])) $_POST['reg_username'] = '';
        if(!isset($_POST['reg_email'])) $_POST['reg_email'] = '';
        
        odbc_exec($mssql, 'USE [ACCOUNT_DBF]');
        $checkacc = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [ACCOUNT_TBL] WHERE account=\''.mssql_escape_string($_POST['reg_username']).'\'');
        $errors = array();
        if(empty($_POST['reg_username']) || empty($_POST['reg_password']) || empty($_POST['reg_confirmpw']) || empty($_POST['reg_email']))
            $errors[] = 'You must fill in all fields!';
        if(!empty($_POST['reg_username']) && odbc_result($checkacc, 'count') > 0)
            $errors[] = 'The username already exists!';
        if(!empty($_POST['reg_username']) && (strlen($_POST['reg_username']) > 10 || strlen($_POST['reg_username']) < 4))
            $errors[] = 'Your username must contain 4 - 10 characters!';
        if(!empty($_POST['reg_password']) && (strlen($_POST['reg_password']) > 12 || strlen($_POST['reg_password']) < 6))
            $errors[] = 'Your password must contain 6 - 12 characters!';
        if((!empty($_POST['reg_password']) && !empty($_POST['reg_confirmpw'])) && $_POST['reg_password'] != $_POST['reg_confirmpw'])
            $errors[] = 'Your password repetition is not true!';
        if(!empty($_POST['reg_email']) && !preg_match('/^[a-zA-Z0-9-_.]+@[a-zA-Z0-9-_.]+\.[a-zA-Z]{2,4}$/', $_POST['reg_email']))
            $errors[] = 'The email address is not valid';
        
        if(isset($_POST['reg_submit'])) {
            if(count($errors) > 0) {
                echo '<div class="fail">';
                foreach($errors as $error) {
                    echo $error.'<br/>';
                }
                echo '</div>';
            } else {
                odbc_exec($mssql, 'INSERT INTO [dbo].[ACCOUNT_TBL] (account, password, isuse, member, id_no1, id_no2, realname, reload, OldPassword, TempPassword, cash) VALUES (N\''.mssql_escape_string($_POST['reg_username']).'\', N\''.mssql_escape_string(md5($_CONFIG['pwdsalt'].$_POST['reg_password'])).'\', N\'T\', N\'A\', NULL, 0, N\'P\', NULL, 0, NULL, 0)');
                odbc_exec($mssql, 'INSERT INTO [dbo].[ACCOUNT_TBL_DETAIL] (account, gamecode, tester, m_chLoginAuthority, regdate, BlockTime, EndTime, WebTime, isuse, secession, email) VALUES (N\''.mssql_escape_string($_POST['reg_username']).'\', N\'A000\', N\'1\', N\'F\', \''.mssql_escape_string(date('Ymd H:i:s')).'\', N\'20010101\', N\'20990101\', N\'20050101\', N\'O\', NULL, N\''.mssql_escape_string($_POST['reg_email']).'\')');
                echo '<div class="success">Your account has been successfully created!</div>';
            }
        }
        /*odbc_exec($mssql, 'INSERT INTO [dbo].[ACCOUNT_TBL_DETAIL] (account, gamecode, tester, m_chLoginAuthority, regdate, BlockTime, EndTime, WebTime, isuse, secession, email) VALUES (N\''.mssql_escape_string($_POST['reg_username']).'\', N\'A000\', N\'2\', N\'Z\', \''.mssql_escape_string(date('Ymd H:i:s')).'\', N\'20010101\', N\'20990101\', N\'20050101\', N\'O\', NULL, N\''.mssql_escape_string($_POST['reg_email']).'\')');
        odbc_exec($mssql, 'INSERT INTO [dbo].[ACCOUNT_TBL_DETAIL] (account, gamecode, tester, m_chLoginAuthority, regdate, BlockTime, EndTime, WebTime, isuse, secession, email) VALUES (N\''.mssql_escape_string($_POST['reg_username']).'\', N\'A000\', N\'1\', N\'N\', \''.mssql_escape_string(date('Ymd H:i:s')).'\', N\'20010101\', N\'20990101\', N\'20050101\', N\'O\', NULL, N\''.mssql_escape_string($_POST['reg_email']).'\')');
        Zeile 37 Admin Account erstellung - Zeile 38 GM Account erstellung */
    ?>
    <form method="post">
        <table>
            <tr>
                <td>Username:</td>
                <td><input type="text" name="reg_username" maxlength="10" /></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="reg_password" maxlength="11" /></td>
            </tr>
            <tr>
                <td>Repeat Password:</td>
                <td><input type="password" name="reg_confirmpw" /></td>
            </tr>
            <tr>
                <td>E-Mail:</td>
                <td><input type="text" name="reg_email" /></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="reg_submit" value="Create account" /></td>
            </tr>
        </table>
    </form>
</div>
<?php include('./inc/footer.php'); ?>