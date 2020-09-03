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
<title>장바구니화면</title>
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
                <h5>장바구니 화면</h5>
                <form>
                    <table border="1" width="90%">
                        <tr>
                            <td>
                                주문번호
                            </td>
                            <td width="40%">
                                상품
                            </td>
                            <td>
                                지불금액
                            </td>
                            <td>
                                구매
                            </td>
                            <td>
                                장바구니 제거
                            </td>
                        </tr>
                    <?php
                    $total=0;
                    $query=" select * from shhan_temp where id = '$id' ";
                    $result = mysqli_query($link, $query); 
                    while ($data = mysqli_fetch_array($result) ){
                    ?>
                        <tr>
                            <td>
                                <!--<input type="checkbox" name="<?=$data["num"]?>">-->
                                <?=$data["num"]?>
                            </td>
                            <td width="40%">
                                <img width="90px" height="50px" src="../item/<?=$data["item_img_0"]?>">
                                &nbsp;&nbsp; <?=$data["item_name"]?>
                            </td>
                            <td>
                                \<?=$data["money"]?>
                            </td>
                            <td>
                                <a href="basket_order.php?num=<?=$data["num"]?>">상품 구매</a>
                            </td>
                            <td>
                                <a href="basket_del.php?num=<?=$data["num"]?>" onclick="return confirm('정말 삭제할까요?')">장바구니 제거</a>
                            </td>
                        </tr>
                    <?php
                    $total += $data["money"];
                    }
                    ?>
                        <?php
                        if($total!=0){
                        ?>
                        <tr>
                            <td colspan="2">합계</td>
                            <td>\<?=$total?></td>
                            <td>
                                <a href="basket_order.php?">일괄 구매</a>                                
                            </td>
                            <td>일괄제거</td>
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