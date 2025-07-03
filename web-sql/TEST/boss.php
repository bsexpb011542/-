<?php include_once('header.php'); ?>
水果資料表
<li><a href="increase_fruit.php">水果新增</a></li>
<li><a href="search_fruit.php">水果查詢</a></li>
<li><a href="delete_frui.php">水果查詢已刪除資料</a></li>
<li><a href="fix_fruit.php">水果修改</a></li>
<li><a href="fruita01.php">可以查詢某一水果在「公司內現有數量」與其「現有價值小計」</a></li>
<li><a href="fruita02.php">可以查詢公司內所有現有數量之水果「現有價值小計」之總和</a></li>
會員資料表
<li><a href="increase_member.php">會員新增</a></li>
<li><a href="search_member.php">會員查詢</a></li>
<li><a href="delete_member.php">會員刪除</a></li>
<li><a href="fix_member.php">會員修改</a></li>
<li><a href="membera01.php">可以統計會員人數、會員平均年齡等資料。</a></li>
靜止會員資料表

<li><a href="search_S_member.php">靜止會員查詢</a></li>
<li><a href="delete_S_member.php">靜止會員復活</a></li>
<li><a href="fix_S_member.php">靜止會員修改</a></li>
<li><a href="S_membera01.php">可以統計會員人數、會員平均年齡等資料</a></li>
供應商資料表
<li><a href="increase_sup.php">供應商新增</a></li>
<li><a href="search_sup.php">供應商查詢</a></li>
<li><a href="delete_supr.php">供應商刪除</a></li>
<li><a href="fix_sup.php">供應商修改</a></li>
<li><a href="supa01.php">可以查詢一共有多少供應商供應水果給東海水果公司</a></li>
<li><a href="supa02.php">可以查詢有幾家供應商的Email是相同的，或負責人是同一人。</a></li>
水果交易資料表
<li><a href="increase_deal.php">交易新增</a></li>
<li><a href="search_deal.php">交易查詢</a></li>
<li><a href="delete_deal.php">交易刪除</a></li>
<li><a href="deala01.php">可以查詢某一位會員所購買某一供應商所供應水果之總金額</a></li>
(3)	可以查詢全體會員購買某一供應商所供應水果之總金額(合併計算已交水果給會員與未交水果給會員兩部分)。
(4)	可以查詢某一位會員購買總金額(不分供應商，也不分是否已交貨給會員)。
(5)	可以查詢全體會員購買總金額(不分供應商，也不分是否已交貨給會員)。
(6)	可以排序各會員購買總金額(分開已交貨與未交貨兩部分)，並可以列印其姓名、Email、電話及兩項購買(已交貨與未交貨)各自總金額。
(7)	可以查詢哪一些水果訂單尚未出貨給會員，並列印其會員姓名、Email、電話及購買數量與總金額。

客戶專用
<li><a href="custom_deal_my.php">查詢我的訂單</a></li>
<li><a href="custom_deal_with.php">下訂單</a></li>
<li><a href="custom_deal_delete.php">刪除訂單</a></li>
<li><a href="custom_change_data.php">修改會員資料</a></li>






<?php include_once('footer.php'); ?>