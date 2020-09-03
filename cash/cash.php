<?php
   session_start();

 ?>
<!DOCTYPE HTML>
<html>
<head> 
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/common.css" >
</head>
<title>캐쉬 충전</title>
<script>
  
</script>
<body>
    <!--border:solid 1px #FF0000-->
    <div id="wrap">
        <div id="header">
            <div style="margin-right: 500px"><a href="http://localhost/shhan/index.php"><h1>쇼핑몰 프로젝트</h1></a></div> 
            <div>
                <?php include '../common/top_login.php'; ?>
            </div>
        </div>    
        <div id="content">    
            <div id="col1">
                <?php include '../common/left_menu.php'; ?>
            </div>
            <div id="col2">
                <div>현재 당신의 충전금액은 <?=$_SESSION["cash"]?> 원입니다.</div><br>
                <div style="margin-left: 100px">
                    충전하고 싶은 금액을 설정하십시오.
                    <form method="get" action="cash_update.php">
                        <input type="text" name="cash_add">
                        <input type="submit" value="충전">
                    </form>
                </div>
            </div> <!-- end of col2 -->            
        </div> <!-- end of content -->
    </div> <!-- end of wrap -->
    <p>&nbsp;</p><p>&nbsp;</p>
 </body>
 </html>