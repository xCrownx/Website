<?php include('./inc/header.php'); ?>
<h1>Ranking</h1>
<div class="site">
	<?php
        if(isset($_GET['guild'])) {
            echo '<a href="ranking.php">Character Ranking</a> - <span style="font-weight: bold;">Guild Ranking</span><br /><br />';
            $i = 1;
            odbc_exec($mssql, 'USE [CHARACTER_01_DBF]');
            $check = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [GUILD_TBL]');
            if(odbc_result($check, 'count') > 0) {
                echo '<table style="width: 100%;">
                    <tr>
                        <td id="key">#</td>
                        <td id="key">Guild Name</td>
                        <td id="key" style="text-align: center;">Level</td>
                        <td id="key" style="text-align: center;">Win</td>
                        <td id="key" style="text-align: center;">Lose</td>
                        <td id="key" style="text-align: center;">Leader</td>
                    </tr>';
                $query = odbc_exec($mssql, 'SELECT TOP 100 * FROM [GUILD_TBL] ORDER BY m_nLevel DESC'); 
                while($result = odbc_fetch_array($query)) {
                    $guildId = $result['m_idGuild'];
                    $leadquery = odbc_exec($mssql, "SELECT m_idPlayer FROM [GUILD_MEMBER_TBL] WHERE m_idGuild = '{$guildId}' AND m_nMemberLv = '0'");
                    if ($leadquery) {
                        $leadrow = odbc_fetch_array($leadquery);
                    $leader = odbc_exec($mssql, "SELECT * FROM [CHARACTER_TBL] WHERE m_idPlayer = '{$leadrow['m_idPlayer']}'");
                    if ($leader) {
                        $leadrow = odbc_fetch_array($leader);
                 }
            }
                    $leader = odbc_exec($mssql, 'SELECT * FROM [CHARACTER_TBL] WHERE m_idPlayer=\''.mssql_escape_string(odbc_result($leadquery, 'm_idPlayer')).'\'');
                    $leadrow = odbc_fetch_array($leader);
                    if($leadrow['m_chAuthority'] == 'F') {
                        if($i == 1) {
                            $rank = '<span style="color: #F30000;">'.$i.'</span>';
                        } elseif($i == 2) {
                            $rank = '<span style="color: #F37800;">'.$i.'</span>';
                        } elseif($i == 3) {
                            $rank = '<span style="color: #FFFC00;">'.$i.'</span>';
                        } else {
                            $rank = $i;
                        }
                        echo '<tr>
                            <td>'.$rank.'</td>
                            <td>'.$result['m_szGuild'].'</td>
                            <td style="text-align: center;">'.$result['m_nLevel'].'</td>
                            <td style="text-align: center;">'.$result['m_nWin'].'</td>
                            <td style="text-align: center;">'.$result['m_nLose'].'</td>
                            <td style="text-align: center;">'.$leadrow['m_szName'].'</td>
                        </tr>';
                        $i = $i + 1;
                    }
                }
                echo '</table>';
            } else {
                echo '<div class="fail">Currently no available Guilds!</div>';
            }
        } else {
            echo '<span style="font-weight: bold;">Player Ranking</span> - <a href="ranking.php?guild">Guild Ranking</a><br /><br />';
            echo '<form method="get">
                <select name="job">';
            if(isset($_GET['job']) && !empty($_GET['job'])) {
                echo '<option value="'.$_GET['job'].'">'.getjob($_GET['job']).'</option>';
            }
            echo '	<option value="">Overall</option>
                    <option value="0">Vagrant</option>
                    <option value="1">Mercenary</option>
                    <option value="2">Assist</option>
                    <option value="3">Acrobat</option>
                    <option value="4">Magician</option>
                    <option value="6">Knight</option>
                    <option value="7">Blade</option>
                    <option value="8">Jester</option>
                    <option value="9">Ranger</option>
                    <option value="10">Ringmaster</option>
                    <option value="11">Billposter</option>
                    <option value="12">Psykeeper</option>
                    <option value="13">Elementor</option>
                    <option value="16">Master Knight</option>
                    <option value="17">Master Blade</option>
                    <option value="18">Master Jester</option>
                    <option value="19">Master Ringmaster</option>
                    <option value="20">Master Billposter</option>
                    <option value="21">Master Psykeeper</option>
                    <option value="22">Master Elementor</option>
                    <option value="24">Hero Knight</option>
                    <option value="25">Hero Blade</option>
                    <option value="26">Hero Jester</option>
                    <option value="27">Hero Ranger</option>
                    <option value="28">Hero Ringmaster</option>
                    <option value="29">Hero Billposter</option>
                    <option value="30">Hero Psykeeper</option>
                    <option value="31">Hero Elementor</option>
                    <option value="32">Templer</option>
                    <option value="33">Slayer</option>
                    <option value="34">Harlequin</option>
                    <option value="35">Crackshooter</option>
                    <option value="36">Seraph</option>
                    <option value="37">Force Master</option>
                    <option value="38">Mentalist</option>
                    <option value="39">Arcanist</option>
                </select>
                <input type="submit" value="Go!" />
            </form><br />';
            odbc_exec($mssql, 'USE [CHARACTER_01_DBF]');
            $check = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [CHARACTER_TBL] WHERE m_chAuthority = \'F\'');
            if(odbc_result($check, 'count') > 0) {
                echo '<table style="width: 100%;">
                    <tr>
                        <td id="key">#</td>
                        <td id="key">Character</td>
                        <td id="key" style="text-align: center;">Job Class</td>
                        <td id="key" style="text-align: center;">Level</td>
                        <td id="key" style="text-align: center;">Current Guild</td>
                        <td id="key" style="text-align: center;">Gender</td>
                    </tr>';
                if(!isset($_GET['job']) || empty($_GET['job'])) {
                    $i = 1;
                    $count = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [CHARACTER_TBL] WHERE m_chAuthority = \'F\'');
                    $query = odbc_exec($mssql, 'SELECT * FROM [CHARACTER_TBL] WHERE m_chAuthority = \'F\' ORDER BY m_nLevel DESC');
                    $query1 = odbc_exec($mssql, 'SELECT * FROM [CHARACTER_TBL] WHERE m_chAuthority = \'F\' AND
                    (m_nJob = \'39\' OR m_nJob = \'38\' OR m_nJob = \'37\' OR m_nJob = \'36\' OR m_nJob = \'35\' OR m_nJob = \'34\' OR m_nJob = \'33\' OR m_nJob = \'32\' OR m_nJob = \'31\' OR m_nJob = \'30\' OR m_nJob = \'29\' OR m_nJob = \'28\' OR m_nJob = \'27\' OR m_nJob = \'26\' OR m_nJob = \'25\' OR m_nJob = \'24\' OR m_nJob = \'23\' OR m_nJob = \'22\' OR m_nJob = \'21\' OR m_nJob = \'20\' OR m_nJob = \'19\' OR m_nJob = \'18\' OR m_nJob = \'17\' OR m_nJob = \'16\') ORDER BY m_nLevel DESC'); // 3rd Jobs, Heros, Masters
                    $query2 = odbc_exec($mssql, 'SELECT * FROM [CHARACTER_TBL] WHERE m_chAuthority = \'F\' AND
                    (m_nJob = \'15\' OR m_nJob = \'14\' OR m_nJob = \'13\' OR m_nJob = \'12\' OR m_nJob = \'11\' OR m_nJob = \'10\' OR m_nJob = \'9\' OR m_nJob = \'8\' OR m_nJob = \'7\' OR m_nJob = \'6\' OR m_nJob = \'5\' OR m_nJob = \'4\' OR m_nJob = \'3\' OR m_nJob = \'2\' OR m_nJob = \'1\') ORDER BY m_nLevel DESC'); // Normal Jobs
                    if(odbc_result($count, 'count') > 0) {
                        while($result = odbc_fetch_array($query1)) {
                            if($i <= 100) {
                                $guildquery = odbc_exec($mssql, 'SELECT m_idGuild FROM [GUILD_MEMBER_TBL] WHERE m_idPlayer = \''.mssql_escape_string($result['m_idPlayer']).'\'');
                                $guildname = odbc_exec($mssql, 'SELECT m_szGuild FROM [GUILD_TBL] WHERE m_idGuild = \''.mssql_escape_string(odbc_result($guildquery, 'm_idGuild')).'\'');
                                if($result['m_dwSex'] == 1) {
                                    $sex = '<img src="./img/female.png" />';
                                } else {
                                    $sex = '<img src="./img/male.png" />';
                                }
                                if($i == 1) {
                                    $rank = '<span style="color: #F30000;">'.$i.'</span>';
                                } elseif($i == 2) {
                                    $rank = '<span style="color: #F37800;">'.$i.'</span>';
                                } elseif($i == 3) {
                                    $rank = '<span style="color: #FFFC00;">'.$i.'</span>';
                                } else {
                                    $rank = $i;
                                }
                                echo '<tr>
                                    <td>'.$rank.'</td>
                                    <td>'.$result['m_szName'].'</td>
                                    <td style="text-align: center;">'.getjob($result['m_nJob']).'</td>
                                    <td style="text-align: center;">'.$result['m_nLevel'].'</td>
                                    <td style="text-align: center;">'.odbc_result($guildname, 'm_szGuild').'</td>
                                    <td style="text-align: center;">'.$sex.'</td>
                                </tr>';
                                $i = $i + 1;
                            }
                        }
                        while($result = odbc_fetch_array($query2)) {
                            if($i <= 100) {
                                $guildquery = odbc_exec($mssql, 'SELECT m_idGuild FROM [GUILD_MEMBER_TBL] WHERE m_idPlayer = \''.mssql_escape_string($result['m_idPlayer']).'\'');
                                $guildname = odbc_exec($mssql, 'SELECT * FROM [GUILD_TBL] WHERE m_idGuild = \''.mssql_escape_string(odbc_result($guildquery, 'm_idGuild')).'\'');
                                if($result['m_dwSex'] == 1) {
                                    $sex = '<img src="./img/female.png" />';
                                } else {
                                    $sex = '<img src="./img/male.png" />';
                                }
                                if($i == 1) {
                                    $rank = '<span style="color: #F30000;">'.$i.'</span>';
                                } elseif($i == 2) {
                                    $rank = '<span style="color: #F37800;">'.$i.'</span>';
                                } elseif($i == 3) {
                                    $rank = '<span style="color: #FFFC00;">'.$i.'</span>';
                                } else {
                                    $rank = $i;
                                }
                                echo '<tr>
                                    <td>'.$rank.'</td>
                                    <td>'.$result['m_szName'].'</td>
                                    <td style="text-align: center;">'.getjob($result['m_nJob']).'</td>
                                    <td style="text-align: center;">'.$result['m_nLevel'].'</td>
                                    <td style="text-align: center;">'.odbc_result($guildname, 'm_szGuild').'</td>
                                    <td style="text-align: center;">'.$sex.'</td>
                                </tr>';
                                $i = $i + 1;
                            }
                        }
                    } else {
                        echo '<tr><td colspan="6"><div class="fail">No character available!</div></td></tr>';
                    }
                } else {
                    $i = 1;
                    $count = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [CHARACTER_TBL] WHERE m_chAuthority = \'F\' AND m_nJob=\''.mssql_escape_string($_GET['job']).'\'');
                    $query = odbc_exec($mssql, 'SELECT * FROM [CHARACTER_TBL] WHERE m_chAuthority = \'F\' AND m_nJob=\''.mssql_escape_string($_GET['job']).'\' ORDER BY m_nLevel DESC');
                    if(odbc_result($count, 'count') > 0) {
                        while($result = odbc_fetch_array($query)) {
                            if($i <= 100) {
                                $guildquery = odbc_exec($mssql, 'SELECT m_idGuild FROM [GUILD_MEMBER_TBL] WHERE m_idPlayer = \''.mssql_escape_string($result['m_idPlayer']).'\'');
                                $guildname = odbc_exec($mssql, 'SELECT * FROM [GUILD_TBL] WHERE m_idGuild = \''.mssql_escape_string(odbc_result($guildquery, 'm_idGuild')).'\'');
                                if($result['m_dwSex'] == 1) {
                                    $sex = '<img src="./img/female.png" />';
                                } else {
                                    $sex = '<img src="./img/male.png" />';
                                }
                                if($i == 1) {
                                    $rank = '<span style="color: #F30000;">'.$i.'</span>';
                                } elseif($i == 2) {
                                    $rank = '<span style="color: #F37800;">'.$i.'</span>';
                                } elseif($i == 3) {
                                    $rank = '<span style="color: #FFFC00;">'.$i.'</span>';
                                } else {
                                    $rank = $i;
                                }
                                echo '<tr>
                                    <td>'.$rank.'</td>
                                    <td>'.$result['m_szName'].'</td>
                                    <td style="text-align: center;">'.getjob($result['m_nJob']).'</td>
                                    <td style="text-align: center;">'.$result['m_nLevel'].'</td>
                                    <td style="text-align: center;">'.odbc_result($guildname, 'm_szGuild').'</td>
                                    <td style="text-align: center;">'.$sex.'</td>
                                </tr>';
                                $i = $i + 1;
                            }
                        }
                    } else {
                        echo '<tr><td colspan="6"><div class="fail">Currently no entry!</div></td></tr>';
                    }
                }
                echo '</table>';
            } else {
                echo '<div class="fail">Currently no entry!</div>';
            }
        }
    ?>
</div>
<?php include('./inc/footer.php'); ?>