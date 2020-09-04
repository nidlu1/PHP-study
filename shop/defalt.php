<?php
    session_start();
?>
<!DOCTYPE HTML>
<html>
<head> 
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../css/common.css" >
<link rel="stylesheet" type="text/css" href="../css/shop.css" >
</head>
<title>인덱스화면</title>
<body>
    <!--border:solid 1px #FF0000-->
    <div id="wrap">
        <div id="header">
            <div style="margin-right: 500px"><a href="./index.php"><h1>쇼핑몰 프로젝트</h1></a></div> 
            <div>
                <?php include '../common/top_login.php'; ?>
            </div>
        </div>    
        <div id="content">    
            <div id="col1">
                <?php include '../common/left_menu.php'; ?>
            </div>
            <div id="col2">  
                기본폼
            </div> <!-- end of col2 -->            
        </div> <!-- end of content -->
    </div> <!-- end of wrap -->
    <p>&nbsp;</p><p>&nbsp;</p>
 </body>
 </html>
