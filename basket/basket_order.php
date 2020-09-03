<?php
    session_start();
    $id = $_SESSION["id"];
    $nick = $_SESSION["nick"];
    $tel = $_SESSION["tel"];
    $email = $_SESSION["email"];
    $cash = $_SESSION["cash"];
    
    
    include_once '../common/MyDB.php';
    $link = dbconn();
    $query = "select * from shhan_temp where id = '$id' ";
    if(isset($_REQUEST["num"])){
        $num = $_REQUEST["num"];
        $query = "select * from shhan_temp where num = '$num' ";
    }
    $result = mysqli_query($link, $query);

    
?>
<!DOCTYPE HTML>
<html>
<head> 
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../css/common.css" >
</head>

<title>주문처리</title>
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
                주문정보
                <table border='1'>
                    <tr>
                        <td>주문번호</td>
                        <td>상품이미지</td>
                        <td>상품명</td>
                        <td>갯수</td>
                        <td>가격</td>
                    </tr>
                    <?php
                        $total=0;
                        while ($data = mysqli_fetch_array($result)){
                    ?>
                    <tr>
                        <td><?=$data["num"]?></td>
                        <td><img width="50px" height="30px" src="../item/<?=$data['item_img_0']?>"></td>
                        <td><?=$data["item_name"]?></td>
                        <td><?=$data["count"]?></td>
                        <td><?=$data["price"]?></td>
                    </tr>
                    <?php
                        $a = $data["price"];
                        $b = $data["count"];
                        $c = $a*$b;
                        $total += $c;
                        }
                    ?>
                    <tr>
                        <td colspan="4">합계</td>
                        <td><?=$total?></td>
                    </tr>
                </table>
                
                <br>
                주문번호입력<br>
                <?php
                    if(!isset($_REQUEST["num"])){
                ?>
                    <form action="../order/order_post.php?total=<?=$total?>" method="post" name="order_info"">
                <?php
                    }else{
                ?>
                    <form action="../order/order_post.php?num=<?=$num?>&total=<?=$total?>" method="post" name="order_info"">
                    <?php }?>
                        <input type="hidden" name="id" value="<?=id?>" required>
                    <table border="1">
                        <tr>
                            <td>이름</td>
                            <td><input type="text" name="nick" value="<?=$nick?>" required></td>
                        </tr>
                        <tr>
                            <td>전화번호</td>
                            <td><input type="text" name="tel" pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}" value="<?=$tel?>" required></td>
                        </tr>
                        <tr>
                            <td>이메일</td>
                            <td><input type="text" name="email" value="<?=$email?>" required></td>
                        </tr>
                        <tr>
                            <td>우편번호</td>
                            <td>
                                <input type="text" name="zip1" size="3" required> - <input type="text" name="zip2" size="3" required>
                            </td>
                        </tr>
                        <tr>
                            <td>주소</td>
                            <td><input type="text" name="adress1" size="50" required></td>
                        </tr>
                        <tr>
                            <td>상세주소</td>
                            <td><input type="text" name="adress2" size="50" required></td>
                        </tr>
                        <tr>
                            <td>요구사항</td>
                            <td><textarea name="memo" cols="50" rows="3"></textarea> </td>
                        </tr>

                        <tr>
                            <td colspan="2"><input type="submit" value="주문하기" onclick="return pricechk()"></td>
                        </tr>

                    </table>
                </form>
            </div> <!-- end of col2 -->            
        </div> <!-- end of content -->
    </div> <!-- end of wrap -->
    <p>&nbsp;</p><p>&nbsp;</p>
 </body>
 </html>
 <script>
    function pricechk(){
        if(<?=$cash?> >= <?=$total?>){
            return true;
        }
            alert("충전금액이 적습니다. 충전해주세요.");
            return false;
    }
</script>
