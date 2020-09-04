<?php
    session_start();
?>
<!DOCTYPE HTML>
<html>
<head> 
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="./css/common.css" >
</head>
<title>인덱스화면</title>
<body>
    <!--border:solid 1px #FF0000-->
    <div id="wrap">
        <div id="header">
            <div style="margin-right: 500px"><a href="./index.php"><h1>쇼핑몰 프로젝트</h1></a></div> 
            <div>
                <?php include './common/top_login_index.php'; ?>
            </div>
        </div>    
        <div id="content">    
            <div id="col1">
                <?php include './common/left_menu_index.php'; ?>
            </div>
            <div id="col2" style=" height: 600px">  
                <?php include './common/index_fun.php'; ?>
                <div style="display: inline-block;width: 45%;">
                    <?php latest_article("shhan_board", 5, 9); ?>
                </div>
                <div style="display: inline-block;width: 45%;">
                    <?php latest_article2("shhan_shopitem",5); ?>
                </div>
            </div> <!-- end of col2 -->            
        </div> <!-- end of content -->
    </div> <!-- end of wrap -->
    <p>&nbsp;</p><p>&nbsp;</p>
 </body>
 </html>