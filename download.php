<?php include('./inc/header.php'); ?>
<h1>Game Download</h1>
<div class="site">
	<?php
        odbc_exec($mssql, 'USE [WEBSITE_DBF]');
        $check = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_downloads]');
        if(odbc_result($check, 'count') > 0) {
    ?>
    <table style="width: 100%;">
        <tr>
            <td style="width: 30px;"></td>
            <td id="key">Title</td>
            <td id="key">Description</td>
            <td id="key" style="text-align: center;">Date</td>
        </tr>
    <?php
            $query = odbc_exec($mssql, 'SELECT * FROM [web_downloads] ORDER BY datetime DESC');
            while($result = odbc_fetch_array($query)) {
                $description = $result['description'];
                if(strlen($description) > 60) {
                    $description = substr($description, 0, 60).'...';
                }
                echo '<tr>
                    <td><a href="'.$result['link'].'" class="download"></a></td>
                    <td>'.$result['title'].'</td>
                    <td title="'.$result['description'].'">'.$description.'</td>
                    <td style="text-align: center;">'.date('Y-m-d', strtotime($result['datetime'])).'</td>
                </tr>';
            }
    ?>
    </table>
    <?php
        } else {
            echo '<div class="fail">Noch keine Downloads verfügbar!</div>';
        }
    ?>
</div>
<?php include('./inc/footer.php'); ?>