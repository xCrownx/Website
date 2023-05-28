<?php include('./inc/header.php'); ?>
<h1>Item Shop</h1>
<div class="site">
	<?php
        if(empty($_GET['cat'])) $_GET['cat'] = '';
        
        odbc_exec($mssql, 'USE [WEBSITE_DBF]');
        
        if(isset($_GET['addbasket']) && isset($_SESSION['user'])) {
            $item = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_mall] WHERE mid=\''.mssql_escape_string($_GET['addbasket']).'\'');
            if(odbc_result($item, 'count') > 0) {
                odbc_exec($mssql, 'INSERT INTO [web_mallbasket] (account, item) VALUES(\''.mssql_escape_string($_SESSION['user']).'\', \''.mssql_escape_string($_GET['addbasket']).'\')');
                echo '<div class="success">The item was successfully added to the cart!</div>';
            }
        }
        
        if(isset($_POST['buyitm']) && isset($_SESSION['user']) && !empty($_POST['char'])) {
            $item = odbc_exec($mssql, 'SELECT * FROM [web_mall] WHERE mid=\''.mssql_escape_string($_POST['mid']).'\'');
            $itm = odbc_fetch_array($item);
            odbc_exec($mssql, 'USE [ACCOUNT_DBF]');
            $mycash = odbc_exec($mssql, 'SELECT cash FROM [ACCOUNT_TBL] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\'');
            if($itm['price'] > odbc_result($mycash, 'cash')) {
                echo '<div class="fail">You dont have enough points to buy this item.</div>';
            } else {
                // Send Item
                send_item($_POST['char'], $itm['itemid'], $itm['count']);
                odbc_exec($mssql, 'USE [ACCOUNT_DBF]');
                odbc_exec($mssql, 'UPDATE [ACCOUNT_TBL] SET cash=cash-\''.mssql_escape_string($itm['price']).'\' WHERE account=\''.mssql_escape_string($_SESSION['user']).'\'');
                odbc_exec($mssql, 'USE [WEBSITE_DBF]');
                odbc_exec($mssql, 'INSERT INTO [web_buylogs] (item, account, datetime) VALUES(\''.mssql_escape_string($itm['mid']).'\', \''.mssql_escape_string($_SESSION['user']).'\', \''.date('d.m.Y H:i:s').'\')');
                echo '<div class="success">The item was successfully purchased.</div>';
            }
            echo '<br/>';
        }
        
        if(isset($_POST['giftitm']) && isset($_SESSION['user']) && !empty($_POST['giftchar'])) {
            odbc_exec($mssql, 'USE [ACCOUNT_DBF]');
            $mycash = odbc_exec($mssql, 'SELECT cash FROM [ACCOUNT_TBL] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\'');
            odbc_exec($mssql, 'USE [WEBSITE_DBF]');
            $item = odbc_exec($mssql, 'SELECT * FROM [web_mall] WHERE mid=\''.mssql_escape_string($_POST['mid']).'\'');
            $itm = odbc_fetch_array($item);
            if($itm['price'] > odbc_result($mycash, 'cash')) {
                echo '<div class="fail">You dont have enough points to give away this item.</div>';
            } else {
                odbc_exec($mssql, 'USE [CHARACTER_01_DBF]');
                $charcheck = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [CHARACTER_TBL] WHERE m_szName=\''.mssql_escape_string($_POST['giftchar']).'\'');
                $char = odbc_exec($mssql, 'SELECT m_idPlayer FROM [CHARACTER_TBL] WHERE m_szName=\''.mssql_escape_string($_POST['giftchar']).'\'');
                if(odbc_result($charcheck, 'count') > 0) {
                    $accofchar = odbc_exec($mssql, 'SELECT account FROM [CHARACTER_TBL] WHERE m_idPlayer=\''.mssql_escape_string(odbc_result($char, 'm_idPlayer')).'\'');
                    // Send Item
                    send_item(odbc_result($char, 'm_idPlayer'), $itm['itemid'], $itm['count']);
                    
                    odbc_exec($mssql, 'USE [ACCOUNT_DBF]');
                    odbc_exec($mssql, 'UPDATE [ACCOUNT_TBL] SET cash=cash-\''.mssql_escape_string($itm['price']).'\' WHERE account=\''.mssql_escape_string($_SESSION['user']).'\'');
                    odbc_exec($mssql, 'USE [WEBSITE_DBF]');
                    odbc_exec($mssql, 'INSERT INTO [web_giftlogs] (item, accfrom, accto, charto, datetime) VALUES(\''.mssql_escape_string($itm['mid']).'\', \''.mssql_escape_string($_SESSION['user']).'\', \''.mssql_escape_string(odbc_result($accofchar, 'account')).'\', \''.mssql_escape_string($_POST['giftchar']).'\', \''.mssql_escape_string(date('d.m.Y H:i:s')).'\')');
                    echo '<div class="success">The item was successfully given away.</div>';
                } else {
                    echo '<div class="fail">This player does not exist.</div>';
                }
            }
            echo '<br/>';
        }
        
        // Search Form
        echo '<form method="post">
            Search: <input type="text" name="itmsearch_keyword" id="txtbig" />
            <input type="submit" name="itmsearch_sbm" value="Search" />
        </form><br/>';
        
        // Caption
        echo '<table>
            <tr>
                <td><b>Legend:</b></td>
                <td><img src="img/price.png" /></td>
                <td>Price</td>
                <td><img src="img/count.png" /></td>
                <td>Count</td>
            </tr>
        </table><br />';
        
        odbc_exec($mssql, 'USE [WEBSITE_DBF]');
        $categories = odbc_exec($mssql, 'SELECT * FROM [web_mallcategories]');
        $catlist = '';
        while($category = odbc_fetch_array($categories)) {
            if($category['mcatid'] == $_GET['cat']) {
                $catlist .= '<span style="font-weight: bold;">'.$category['category'].'</span> | ';
            } else {
                $catlist .= '<a href="shop.php?cat='.$category['mcatid'].'">'.$category['category'].'</a> | ';
            }
        }
        if(!empty($catlist)) {
            echo 'Categories: '.substr($catlist, 0, strlen($catlist)-3);
            echo '<br /><br />';
            if(isset($_GET['detail'])) {
                $count = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_mall] WHERE mid=\''.mssql_escape_string($_GET['detail']).'\'');
                if(odbc_result($count, 'count') > 0) {
                    $detailselect = odbc_exec($mssql, 'SELECT * FROM [web_mall] WHERE mid=\''.mssql_escape_string($_GET['detail']).'\'');
                    $detail = odbc_fetch_array($detailselect);
                    $catname = odbc_exec($mssql, 'SELECT category FROM [web_mallcategories] WHERE mcatid=\''.mssql_escape_string($detail['category']).'\'');
                    echo '<div class="shop_itmdetail">
                        <div class="head">Item Detail: <b>'.$detail['name'].'</b></div>
                        <div class="details">
                            <div id="icon"><img src="img/mall/'.$detail['icon'].'" /></div>
                            <div id="quickinfo">
                                <span style="font-weight: bold;">Price:</span> <span style="color: #f00;">'.$detail['price'].'</span> dPoints<br/>
                                <span style="font-weight: bold;">Quantity:</span> '.$detail['count'].'<br/>
                                <span style="font-weight: bold;">Category:</span> '.odbc_result($catname, 'category').'<br/>
                            </div>
                            <b>Description:</b> '.$detail['description'].'<br/>';
                    if(isset($_SESSION['user'])) {
                        odbc_exec($mssql, 'USE [CHARACTER_01_DBF]');
                        $chars = odbc_exec($mssql, 'SELECT * FROM [CHARACTER_TBL] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\' AND isblock=\'F\'');
                        echo '<br />
                        <a href="shop.php?cat='.$detail['category'].'&addbasket='.$detail['mid'].'"><img src="img/addbasket.png" /></a><br /><br />
                        <div style="margin-bottom: -8px;">
                            <form method="post">
                                <input type="hidden" name="cat" value="'.$detail['category'].'" />
                                <input type="hidden" name="mid" value="'.$detail['mid'].'" />
                                <select name="char">';
                            while($char = odbc_fetch_array($chars)) {
                                echo '<option value="'.$char['m_idPlayer'].'">'.$char['m_szName'].'</option>';
                            }
                            echo '</select>
                                <input type="submit" name="buyitm" value="" style="width: 60px; height: 25px; background: url(\'./img/buy.png\');" />
                                <div style="float: right;">
                                    <input type="text" name="giftchar" value="Character" />
                                    <input type="submit" name="giftitm" value="" style="width: 60px; height: 25px; background: url(\'./img/gift.png\');" />
                                </div>
                            </form>
                        </div><br style="clear: both;" />';
                    }
                    echo '</div>
                    </div><br />';
                } else {
                    echo '<div class="fail">This item does not exist!</div>';
                }
            }
            
            odbc_exec($mssql, 'USE [WEBSITE_DBF]');
            
            if(isset($_GET['basket'])) {
                if(isset($_SESSION['user'])) {
                    if(isset($_GET['removebasket'])) {
                        odbc_exec($mssql, 'DELETE FROM [web_mallbasket] WHERE mbid=\''.mssql_escape_string($_GET['removebasket']).'\'');
                        echo '<div class="success">The item was successfully removed from your cart!</div>';
                    }
                    if(isset($_GET['removebasketall'])) {
                        odbc_exec($mssql, 'DELETE FROM [web_mallbasket] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\'');
                        echo '<div class="success">The items have been successfully removed from your cart!</div>';
                    }
                    if(isset($_POST['basketbuy_sbm'])) {
                        $priceall = 0;
                        odbc_exec($mssql, 'USE [ACCOUNT_DBF]');
                        $mycash = odbc_exec($mssql, 'SELECT cash FROM [ACCOUNT_TBL] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\'');
                        odbc_exec($mssql, 'USE [WEBSITE_DBF]');
                        $itemlist = odbc_exec($mssql, 'SELECT * FROM [web_mallbasket] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\'');
                        while($item = odbc_fetch_array($itemlist)) {
                            $pricequery = odbc_exec($mssql, 'SELECT price FROM [web_mall] WHERE mid=\''.mssql_escape_string($item['item']).'\'');
                            $priceall += odbc_result($pricequery, 'price');
                        }
                        $itemlist = odbc_exec($mssql, 'SELECT * FROM [web_mallbasket] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\'');
                        if($priceall > odbc_result($mycash, 'cash')) {
                            echo '<div class="fail">You dont have enough points to buy the items in your cart.</div>';
                        } else {
                            $itemIdList = array();
                            $itemCountList = array();
                            $charID;
                            while($item = odbc_fetch_array($itemlist)) {
                                $detailquery = odbc_exec($mssql, 'SELECT * FROM [web_mall] WHERE mid=\''.mssql_escape_string($item['item']).'\'');
                                $detail = odbc_fetch_array($detailquery);
                                $charID = $_POST['char'];
                                array_push($itemIdList, $detail['itemid']);
                                array_push($itemCountList, $detail['count']);
                                odbc_exec($mssql, 'USE [ACCOUNT_DBF]');
                                odbc_exec($mssql, 'UPDATE [ACCOUNT_TBL] SET cash=cash-\''.mssql_escape_string($detail['price']).'\' WHERE account=\''.mssql_escape_string($_SESSION['user']).'\'');
                                odbc_exec($mssql, 'USE [WEBSITE_DBF]');
                                odbc_exec($mssql, 'INSERT INTO [web_buylogs] (item, account, datetime) VALUES(\''.mssql_escape_string($detail['mid']).'\', \''.mssql_escape_string($_SESSION['user']).'\', \''.date('d.m.Y H:i:s').'\')');
                            }
                            
                            send_item_list($charID, $itemIdList, $itemCountList);
                            echo '<div class="success">The items were successfully purchased.</div>';
                                odbc_exec($mssql, 'USE [WEBSITE_DBF]');
                            odbc_exec($mssql, 'DELETE FROM [web_mallbasket] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\'');
                        }
                    }
                    odbc_exec($mssql, 'USE [WEBSITE_DBF]');
                    echo 'Shopping cart from <b>'.$_SESSION['user'].'</b>.<br/><br />';
                    $cost = 0;
                    $itemlist = odbc_exec($mssql, 'SELECT * FROM [web_mallbasket] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\' ORDER BY mbid DESC');
                    while($items = odbc_fetch_array($itemlist)) {
                        $pricequery = odbc_exec($mssql, 'SELECT price FROM [web_mall] WHERE mid=\''.mssql_escape_string($items['item']).'\'');
                        $cost += odbc_result($pricequery, 'price');
                    }
                    $itemlistcount = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_mallbasket] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\'');
                    $itemlist = odbc_exec($mssql, 'SELECT * FROM [web_mallbasket] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\' ORDER BY mbid DESC');
                    if(odbc_result($itemlistcount, 'count') > 0) {
                        odbc_exec($mssql, 'USE [CHARACTER_01_DBF]');
                        $chars = odbc_exec($mssql, 'SELECT * FROM [CHARACTER_TBL] WHERE account=\''.mssql_escape_string($_SESSION['user']).'\' AND isblock=\'F\'');
                        echo '<div id="basketinfo">
                        Total cost: <span style="color: #f00;">'.$cost.'</span> dPoints
                            <form method="post" action="shop.php?basket">(<input type="submit" name="basketbuy_sbm" id="nostyle" value="Buy all" /> | <a href="shop.php?basket&removebasketall">Delete all</a> )<br /><br />
                            <select name="char">';
                        while($char = odbc_fetch_array($chars)) {
                            echo '<option value="'.$char['m_idPlayer'].'">'.$char['m_szName'].'</option>';
                        }
                        echo '</select></form></div><br />
                        </span>';
                        echo '<div class="shop_list">';
                        odbc_exec($mssql, 'USE [WEBSITE_DBF]');
                        while($item = odbc_fetch_array($itemlist)) {
                            $detailquery = odbc_exec($mssql, 'SELECT * FROM [web_mall] WHERE mid=\''.mssql_escape_string($item['item']).'\'');
                            $detail = odbc_fetch_array($detailquery);
                            $cost += $detail['price'];
                            echo '<a href="shop.php?cat='.$detail['category'].'&detail='.$detail['mid'].'"><div class="item" id="item-'.$item['mbid'].'">
                                <a href="shop.php?basket&removebasket='.$item['mbid'].'">
                                    <img src="./img/delete.png" style="float: right; padding-right: 5px;padding-top:5px;" />
                                </a>
                                <img src="./img/mall/'.$detail['icon'].'" id="icon" />
                                <h3>'.$detail['name'].'</h3>
                                <table><tr><td><img src="img/price.png" /></td><td> '.$detail['price'].' DP</td></tr>
                                <tr><td><img src="img/count.png" /></td><td> '.$detail['count'].'</td></tr></table>
                            </div></a>';
                        }
                        echo '</div><br style="clear: both;" />';
                    } else {
                        echo '<div class="fail">No items in the shopping cart.</div>';
                    }
                } else {
                    echo '<div class="fail">You must be logged in to see your shopping cart.</div>';
                }
            } else if(isset($_POST['itmsearch_sbm'])) {
                if($_POST['itmsearch_keyword'] == '') {
                    echo '<div class="fail">You have to enter keywords.</div>';
                } else {
                    $search = odbc_exec($mssql, 'SELECT * FROM [web_mall] WHERE name LIKE \'%'.mssql_escape_string($_POST['itmsearch_keyword']).'%\' ORDER BY mid DESC');
                    echo 'Stichworte: <span style="font-weight: bold;">'.htmlentities($_POST['itmsearch_keyword']).'</span><br/><br/>';
                    if(odbc_num_rows($search) < 1) {
                        echo '<div class="fail">Sorry, no items found!</div>';
                    } else {
                        echo '<div class="shop_list">';
                        while($result = odbc_fetch_array($search)) {
                            echo '<a href="shop.php?cat='.$result['category'].'&detail='.$result['mid'].'"><div class="item" id="item-'.$result['mid'].'">
                                <img src="./img/mall/'.$result['icon'].'" id="icon" />
                                <h3>'.$result['name'].'</h3>
                                <table><tr><td><img src="img/price.png" /></td><td> '.$result['price'].' DP</td></tr>
                                <tr><td><img src="img/count.png" /></td><td> '.$result['count'].'</td></tr></table>
                            </div></a>';
                        }
                        echo '</div><br style="clear: both;" />';
                    }
                }
            } else if(isset($_GET['cat']) && $_GET['cat'] != '') {
                $itemlistcount = odbc_exec($mssql, 'SELECT COUNT(*) as count FROM [web_mall] WHERE category=\''.mssql_escape_string($_GET['cat']).'\'');
                $itemlist = odbc_exec($mssql, 'SELECT * FROM [web_mall] WHERE category=\''.mssql_escape_string($_GET['cat']).'\' ORDER BY mid DESC');
                if(odbc_result($itemlistcount, 'count') > 0) {
                    echo '<div class="shop_list">';
                    while($item = odbc_fetch_array($itemlist)) {
                        echo '<a href="shop.php?cat='.$item['category'].'&detail='.$item['mid'].'"><div class="item" id="item-'.$item['mid'].'">
                            <img src="./img/mall/'.$item['icon'].'" id="icon" />
                            <h3>'.$item['name'].'</h3>
                            <table><tr><td><img src="img/price.png" /></td><td> '.$item['price'].' DP</td></tr>
                            <tr><td><img src="img/count.png" /></td><td> '.$item['count'].'</td></tr></table>
                        </div></a>';
                    }
                    echo '</div><br style="clear: both;" />';
                } else {
                    echo '<div class="fail">There are no items in this category!</div>';
                }
            } else {
                echo '<div class="fail">Please choose a category!</div>';
            }
        } else {
            echo '<div class="fail">No categories available!</div>';
        }
    ?>
</div>
<?php include('./inc/footer.php'); ?>