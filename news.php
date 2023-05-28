<?php include('./inc/header.php'); ?>
<div class="news-site">
    <?php
        odbc_exec($mssql, 'USE [WEBSITE_DBF]');
        if(!empty($_GET['nid'])) {
            $check = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_news] WHERE nid=\''.mssql_escape_string($_GET['nid']).'\'');
            if(odbc_result($check, 'count') == 1) {
                $query = odbc_exec($mssql, 'SELECT * FROM [web_news] WHERE nid=\''.mssql_escape_string($_GET['nid']).'\'');
                $result = odbc_fetch_array($query);
                odbc_exec($mssql, 'UPDATE [web_news] SET views=views+1 WHERE nid=\''.mssql_escape_string($result['nid']).'\'');
                $category = odbc_exec($mssql, 'SELECT title FROM [web_newscategories] WHERE ncatid=\''.mssql_escape_string($result['category']).'\'');
                echo '<h1 id="news-heading">'.$result['title'].'</h1>';
                if(isset($_POST['cmt_submit'])) {
                    if(empty($_POST['cmt_comment']) || empty($_POST['cmt_captcha']) || empty($_POST['cmt_nid'])) {
                        echo '<div class="fail">You must fill in all fields!</div>';
                    } else {
                        if(strlen($_POST['cmt_comment']) < 10) {
                            echo '<div class="fail">Your comment must contain at least 10 characters!</div>';
                        } else {
                            if (odbc_exec($mssql, "INSERT INTO [web_newscomments] (nid, author, content, ip, datetime) VALUES ('" . mssql_escape_string($_POST['cmt_nid']) . "', '" . mssql_escape_string($_SESSION['user']) . "', '" . mssql_escape_string($_POST['cmt_comment']) . "', '" . mssql_escape_string($_SERVER['REMOTE_ADDR']) . "', '" . mssql_escape_string(date_format(date_create(), 'Y-m-d H:i:s')) . "')")) {
                                echo '<div class="success">Your comment was successfully saved!</div>';
                            } else {
                                echo '<div class="fail">There was an error! Please try again.</div>';
                            }
                        }
                    }
                }
                $comments = odbc_exec($mssql, 'SELECT * FROM [web_newscomments] WHERE nid=\''.mssql_escape_string($result['nid']).'\' ORDER BY datetime DESC');
                $countcomments = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_newscomments] WHERE nid=\''.mssql_escape_string($result['nid']).'\'');
                echo 'Category: <a href="news.php?cat='.$result['category'].'">'.odbc_result($category, 'title').'</a><br />';
                echo 'Author: '.$result['author'].'<br />';
                echo 'Views: '.$result['views'].'<br />';
                echo 'Comments: <a href="#comments">'.odbc_result($countcomments, 'count').'</a><br /><br />';
                echo $result['text'].'<br /><br /><br />';
                if (isset($_SESSION['user'])) {
                    echo '<form method="post" action="captcha_check.php">'; 
                    echo '<textarea name="cmt_comment"></textarea>';
                    echo '<table>';
                    echo '<tr>';
                    echo '<td><div class="g-recaptcha" data-sitekey="6LchqEQmAAAAAGX5ter7ukB-CVjYaa65nlb4_0tP"></div></td>'; // Hier fügst du deinen reCAPTCHA-Key ein
                    echo '</tr>';
                    echo '</table>';
                    echo '<input type="hidden" name="cmt_nid" id="cmt_nid" value="'.$_GET['nid'].'" />';
                    echo '<input type="submit" name="cmt_submit" id="cmt_submit" value="Add Comment" />';
                    echo '</form><br />';
                }
                echo '<div id="comments"><h2>Comments</h2></div>';
                if(odbc_result($countcomments, 'count') > 0) {
                    while($comment = odbc_fetch_array($comments)) {
                        echo '<b>'.$comment['author'].'</b> wrote ('.date('Y-m-d H:i', strtotime($comment['datetime'])).'):<br />'.$comment['content'].'<br/><br/>';
                    }
                } else {
                    echo '<div class="fail">No comments available</div>';
                }
            } else {
                echo '<div class="fail">This news does not exist!</div>';
            }
            
        } elseif(!empty($_GET['cat'])) {
            $check = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_newscategories] WHERE ncatid=\''.mssql_escape_string($_GET['cat']).'\'');
            if(odbc_result($check, 'count') > 0) {
                $catname = odbc_exec($mssql, 'SELECT title FROM [web_newscategories] WHERE ncatid=\''.mssql_escape_string($_GET['cat']).'\'');
                echo '<h1>Alle '.odbc_result($catname, 'title').'</h1>';
                echo '<table>
                    <tr style="font-weight: bold;">
                        <td style="width: 60px;"></td>
                        <td style="width: 250px;">Title</td>
                        <td style="width: 80px;text-align: center;">Author</td>
                        <td style="width: 80px;text-align: center;">Comments</td>
                        <td style="width: 80px;text-align: center;">Views</td>
                        <td style="text-align: center;">Date</td>
                    </tr>';
                $query = odbc_exec($mssql, 'SELECT * FROM [web_news] WHERE category=\''.mssql_escape_string($_GET['cat']).'\' ORDER BY datetime DESC');
                while($result = odbc_fetch_array($query)) {
                    $category = odbc_exec($mssql, 'SELECT icon FROM [web_newscategories] WHERE ncatid=\''.mssql_escape_string($result['category']).'\'');
                    $comments = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_newscomments] WHERE nid=\''.mssql_escape_string($result['nid']).'\'');
                    $title = $result['title'];
                    if(strlen($title) > 35) {
                        $title = substr($title,0,35).'...';
                    }
                    echo '<tr>
                        <td><a href="news.php?cat='.$result['category'].'"><img src="../img/icons/'.odbc_result($category, 'icon').'" /></a></td>
                        <td><a href="news.php?nid='.$result['nid'].'">'.$title.'</a></td>
                        <td style="text-align: center;">'.$result['author'].'</td>
                        <td style="text-align: center;">'.odbc_result($comments, 'count').'</td>
                        <td style="text-align: center;">'.$result['views'].'</td>
                        <td style="text-align: center;">'.date('Y-m-d', strtotime($result['datetime'])).'</td>
                    </tr>';
                }
                echo '</table>';
            } else {
                echo '<div class="fail">This category does not exist!</div>';
            }
        } else {
            $check = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_news]');
            if(odbc_result($check, 'count') > 0) {
                $all = odbc_exec($mssql, 'SELECT * FROM [web_newscategories]');
                $headline = '';
                while($category = odbc_fetch_array($all)) {
                    $headline .= $category['title'].', ';
                }
                $headline = substr($headline, 0, strlen($headline)-2);
                echo '<h1>'.$headline.'</h1>';
                echo '<table>
                    <tr style="font-weight: bold;">
                        <td style="width: 60px;"></td>
                        <td style="width: 250px;">Title</td>
                        <td style="width: 80px;text-align: center;">Author</td>
                        <td style="width: 80px;text-align: center;">Comments</td>
                        <td style="width: 80px;text-align: center;">Views</td>
                        <td style="text-align: center;">Date</td>
                    </tr>';
                $query = odbc_exec($mssql, 'SELECT * FROM [web_news] ORDER BY datetime DESC');
                while($result = odbc_fetch_array($query)) {
                    $category = odbc_exec($mssql, 'SELECT icon FROM [web_newscategories] WHERE ncatid=\''.mssql_escape_string($result['category']).'\'');
                    $comments = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_newscomments] WHERE nid=\''.mssql_escape_string($result['nid']).'\'');
                    $title = $result['title'];
                    if(strlen($title) > 35) {
                        $title = substr($title,0,35).'...';
                    }
                    echo '<tr>
                        <td><a onclick="news.php?cat='.$result['category'].'"><img src="./img/'.odbc_result($category, 'icon').'" /></a></td>
                        <td><a href="news.php?nid='.$result['nid'].'">'.$title.'</a></td>
                        <td style="text-align: center;">'.$result['author'].'</td>
                        <td style="text-align: center;">'.odbc_result($comments, 'count').'</td>
                        <td style="text-align: center;">'.$result['views'].'</td>
                        <td style="text-align: center;">'.date('Y-m-d', strtotime($result['datetime'])).'</td>
                    </tr>';
                }
                echo '</table>';
            } else {
                echo '<div class="fail">Sorry, no news available!</div>';
            }
        }
    ?>
</div>
<?php include('./inc/footer.php'); ?>