<?php
    include('./inc/header.php');

    $images = array();
    $handle = opendir('./img/slider/');
    while($read = readdir($handle)) {
        if($read != '..' && $read != '.' && $read != 'index.html') {
            $images[] = $read;
        }
    }
?>
<h1>Home</h1>
<div class="site">
    <div class="slider">
        <div class="pictures">
            <?php
                foreach($images as $index => $img) {
                echo '<div class="slide '.($index == 0 ? 'active' : '').'">';
                echo '<img src="./img/slider/'.$img.'" alt="" />';
                echo '</div>';
        }
    ?>
</div>
    </div>
    <div style="height: 70px;"></div>
    <table style="width: 100%;">
        <tr>
            <td></td>
            <td id="key">Title</td>
            <td id="key" style="text-align: center;">Author</td>
            <td id="key" style="text-align: center;">Comments</td>
            <td id="key" style="text-align: center;">Views</td>
            <td id="key" style="text-align: center;">Date</td>
        </tr>
    <?php
        odbc_exec($mssql, 'USE [WEBSITE_DBF]');
        $count = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_news]');
        if(odbc_result($count, 'count') > 0) {
            $query = odbc_exec($mssql, 'SELECT TOP 10 * FROM [web_news] ORDER BY datetime DESC');
            while($news = odbc_fetch_array($query)) {
                $title = $news['title'];
                if(strlen($title) > 35) {
                    $title = substr($title, 0, 35).'...';
                }
                $comments = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_newscomments] WHERE nid=\''.mssql_escape_string($news['nid']).'\'');
                $category = odbc_exec($mssql, 'SELECT icon FROM [web_newscategories] WHERE ncatid=\''.mssql_escape_string($news['category']).'\'');
                echo '<tr>
                    <td><a href="news.php?cat='.$news['category'].'"><img src="./img/'.odbc_result($category, 'icon').'" alt="" /></a></td>
                    <td><a href="news.php?nid='.$news['nid'].'">'.$title.'</a></td>
                    <td style="text-align: center;">'.$news['author'].'</td>
                    <td style="text-align: center;">'.odbc_result($comments, 'count').'</td>
                    <td style="text-align: center;">'.$news['views'].'</td>
                    <td style="text-align: center;">'.date('Y-m-d', strtotime($news['datetime'])).'</td>';
            }
        } else {
            echo '<div class="fail">No news available!</div>';
        }
    ?>
    </table>
</div>
<script>
var slideIndex = 0;
var slides = document.getElementsByClassName("slide");

window.onload = function() {
  showSlides();
};

function showSlides() {
  var currentSlide = slides[slideIndex];
  var nextSlideIndex = (slideIndex + 1) % slides.length;
  var nextSlide = slides[nextSlideIndex];

  currentSlide.classList.remove("active");
  nextSlide.classList.add("active");

  slideIndex = nextSlideIndex;

  setTimeout(function() {
    showSlides();
  }, 4000);
}
</script>
<?php include_once('./inc/footer.php'); ?>
