<?php
    session_start();
    
    $num = $_REQUEST["num"];
    
    include_once '../common/MyDB.php';
    $link = dbconn();
    $query="select * from shhan_shopitem where num = $num";
    $result = mysqli_query($link, $query); 
    $data = mysqli_fetch_array($result);
    
    $img = "$data[item_img_0]";
    
?>
<!DOCTYPE HTML>
<html>
<head> 
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../css/common.css" >
<link rel="stylesheet" type="text/css" href="../css/board.css" >
</head>
<title>상품보기</title>
<body>
    <!--border:solid 1px #FF0000-->
    <div id="wrap">
        <div id="header">
            <div style="margin-right: 500px"><a href="../index.php"><h1>쇼핑몰 프로젝트</h1></a></div> 
            <div>
                <?php include '../common/top_login.php'; ?>
            </div>
        </div>    
        <div id="content">    
            <div id="col1">
                <?php include '../common/left_menu.php'; ?>
            </div>
            <div id="col2">  
                <form action="../basket/basket_post.php?" method="post">
                    <input type="hidden" name="num" value="<?=$num?>">
<!--                    <input type="hidden" name="item_model" value="<?=$num?>">
                    <input type="hidden" name="item_name" value="<?=$num?>">-->
                    <input type="hidden" name="price" value="<?=$data["item_price"]?>">
                    
                    <table width='90%' style="border: 1px solid #444444; height: 600px">
                        <tr>
                            <td>
                                <img width="300px" height="400px" src="../item/<?=$img?>">
                            </td>
                            <td>
                                <b>종류: <?=$data["item_model"]?> </b><br>
                                상품이름: <?=$data["item_name"]?> <br>
                                상품가격: \ <?=$data["item_price"]?> 원 <br>                                
                                수량:<select name="count">
                                    <option value="1">1개</option>
                                    <option value="2">2개</option>
                                    <option value="3">3개</option>
                                    <option value="4">4개</option>
                                    <option value="5">5개</option>
                                    <option value="6">6개</option>
                                    <option value="7">7개</option>
                                    <option value="8">8개</option>
                                    <option value="9">9개</option>
                                    <option value="10">10개</option>
                                </select>
                                상품재고: <?=$data["item_stack"]?> 개 <br>
                                <input type="submit" value="장바구니담기">
                            </td>
                        </tr>
                        <tr >
                            <td style="height: 200px" colspan="2"><?=$data["item_memo"]?></td>
                        </tr>
                    </table>                
                </form>
            </div> <!-- end of col2 -->            
        </div> <!-- end of content -->
    </div> <!-- end of wrap -->
    <p>&nbsp;</p><p>&nbsp;</p>
 </body>
 </html>
