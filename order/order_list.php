<?php
    session_start();
    $id= $_SESSION["id"];

    include_once '../common/MyDB.php';
    $link = dbconn();

?>
<!DOCTYPE HTML>
<html>
<head> 
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../css/common.css" >
<link rel="stylesheet" type="text/css" href="../css/shop.css" >
</head>
<title>구입내역</title>
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
                <h5>배송화면</h5>
                <form>
                    <table border="1" width="90%">
                        <tr>
                            <td>
                                주문번호
                            </td>
                            <td>
                                주문자
                            </td>
                            <td>
                                이메일
                            </td>
                            <td>
                                연락처
                            </td>
                            <td>
                                주문날짜
                            </td>
                            <td>
                                배송장소
                            </td>
                            <td>
                                특이사항
                            </td>
                        </tr>
                    <?php
                    $total=0;
                    $query=" select * from shhan_order where id = '$id' ";
                    $result = mysqli_query($link, $query); 
                    while ($data = mysqli_fetch_array($result) ){
                    ?>
                        <tr>
                            <td>
                                <?=$data["order_id"]?>
                            </td>
                            <td>
                                <?=$data["id"]?>
                            </td>
                            <td>
                                <?=$data["email"]?>
                            </td>
                            <td>
                                <?=$data["tel"]?>
                            </td>
                            <td>
                                <?=$data["regist_day"]?><br>
                            </td>
                            <td>
                                <?=$data["zip"]?><br>
                                <?=$data["address1"]?><br>
                                <?=$data["address2"]?>
                            </td>
                            <td>
                                <?=$data["memo"]?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>

                    </table>
                </form>
            </div> <!-- end of col2 -->            
        </div> <!-- end of content -->
    </div> <!-- end of wrap -->
    <p>&nbsp;</p><p>&nbsp;</p>
 </body>
 </html>
