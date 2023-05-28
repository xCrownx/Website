<?php include('./inc/header.php'); ?>
<h1>Frequently asked questions</h1>
<div class="site">
	<?php
        odbc_exec($mssql, 'USE [WEBSITE_DBF]');
        $check = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_faq]');
        if(odbc_result($check, 'count') > 0) {
            $query = odbc_exec($mssql, 'SELECT * FROM [web_faq] ORDER BY faqid DESC');
            while($result = odbc_fetch_array($query)) {
                echo '<span style="font-weight: bold;">'.$result['question'].'</span><br />';
                echo '<span style="font-style: italic;">'.$result['answer'].'</span><br /><br />';
            }
        } else {
            echo '<div class="fail">Sorry, no entries available!</div>';
        }
    ?>
</div>
<?php include('./inc/footer.php'); ?>