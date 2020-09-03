		<div id="sub_title">
 			shhan 메뉴
		</div>
                <div id="left_menu">
                    <ul>
                        <li><a href="../board/board_list.php">자유게시판</a></li>
                        <li><a href="../shop/shop_list.php">상품보기</a></li>
<?php
                        if(isset($_SESSION["id"])){
                            $idc = $_SESSION["id"];
?>
                        <?php
                            if($_SESSION["id"]!="admin"){
                        ?>                        
                                <br>
                                <li><a href="../basket/basket_list.php">장바구니 보기</a></li>
                                <li><a href="../basket/basket_list_buy.php">구매내역 보기</a></li>
                                <li><a href="../order/order_list.php">배송현황 보기</a></li>
                                <li><a href="../cash/cash.php">캐쉬충전하기</a></li>
                                <li><a href="../user/delete.php?id=<?=$idc?>" onclick="return confirm('정말 탈퇴할까요?')">회원탈퇴하기</a></li>

                        <?php
                            }else{                                
                        ?>
                                <li><a href="../shop/shop_writeform.php">상품등록하기</a></li>
<?php
                            }                        
                        }
?>
                    </ul>
                </div>