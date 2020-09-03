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
<title>상품등록화면</title>
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
                상품등록 <br>
                <form method="post" name="item_form" action="shop_writepro.php" enctype="multipart/form-data">
                    <div id="write_form">
                        <div id="write_row1">
                            <div class="col1">작성자</div>
                            <div class="col2">admin?</div>                            
                        </div>
                        <div id="write_row2">
                            <div class="col1">제품 종류</div>
                            <div class="col2">
                                <select name="item_model">
                                    <option value="의류" >의류</option>
                                    <option value="식품" >식품</option>
                                    <option value="도서" >도서</option>
                                    <option value="잡화" >잡화</option>
                                </select>
                            </div>                            
                        </div>
                        <div id="write_row3">
                            <div class="col1">제품 이름</div>
                            <div class="col2"> <input type="text" name="item_name" required=""> </div>                            
                        </div>
                        <div id="write_row4">
                            <div class="col1">제품 가격</div>
                            <div class="col2"> <input type="text" name="item_price" required=""> </div>                            
                        </div>
                        <div id="write_row5">
                            <div class="col1">제품 수량</div>
                            <div class="col2"> <input type="text" name="item_stack" required=""> </div>                            
                        </div>
                        <div id="write_row6">
                            <div class="col1" id="row6_col1">제품 설명</div>
                            <div class="col2"> <textarea rows="15" cols="79" name="item_memo" required></textarea> </div>                            
                        </div>
                        <div id="write_row7">
                            <div class="col1">제품 이미지</div>
                            <div class="col2"> <input type="file" name="item_img_0" > </div>                            
                        </div>
                        <div id="write_row8">
                            <div class="col1">제품 이미지</div>
                            <div class="col2"> <input type="file" name="item_img_1" > </div>                            
                        </div>
                        <div id="write_row9">
                            <div class="col1">제품 이미지</div>
                            <div class="col2"> <input type="file" name="item_img_2" > </div>                            
                        </div>
                        <div>
                        <br><br><br><br><br><br>
                        <div id="write_button">
                            <input type="image" src="../img/ok.png">
                        </div>
                </form>
            </div> <!-- end of col2 -->            
        </div> <!-- end of content -->
    </div> <!-- end of wrap -->
    <p>&nbsp;</p><p>&nbsp;</p>
 </body>
 </html>
