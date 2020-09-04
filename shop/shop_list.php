<?php
    session_start();
    
    include_once '../common/MyDB.php';
    $link = dbconn();
    
    /*
     * php 모드관련.
     */
    if(isset($_REQUEST["page"])) // $_REQUEST["page"]값이 없을 때에는 1로 지정 
        $page=$_REQUEST["page"];  // 페이지 번호
    else
        $page=1;
    if(isset($_REQUEST["mode"])) // 검색 모드
        $mode=$_REQUEST["mode"];
    else  
        $mode="";

    if(isset($_REQUEST["search"])) //검색단어
        $search=$_REQUEST["search"];
    else 
       $search="";
    
    if($mode=="search"){
        if(!$search){
            ?>
            <script>
                alert('검색할 단어를 입력해 주세요!');
                history.back();
            </script>
            <?php
        }  
    }
    /*
     * 페이징 처리
     */
    $page;
    $scale;   // 한 페이지에 보여질 게시글 수
    $page_scale; // 한 페이지당 표시될 그룹 수
    $first_num; // 리스트에 표시되는 게시글의 첫 순번. page=1 일경우 가장 마지막부터 저장된 게시글 $scale개를 불러온다.
    $total_row;     //전체 글수
    $total_page; // 전체 페이지 블록 수  15/5  = 3번
    $current_page; //현재 페이지 블록 위치계산 1번째: [1][2][3] 2번째 [4][5][6], ...
    $start_page; //페이지 구분 블럭의 첫 페이지 수 계산
    $end_page; //페이지 구분 블럭의 마지막 페이지 수
    $start_num; //시작 그룹페이지
    $prev_page; 
    $next_page;

    
    $scale = 5; 
    $page_scale = 3;
    $first_num = ($page-1) * $scale;
        if($mode=="search")
            $query1 = "select count(*) from shhan_shopitem where item_name like '%$search%' ";
        else
            $query1 = "select count(*) from shhan_shopitem";
        $result1 = mysqli_query($link, $query1);
    $total_row = mysqli_fetch_row($result1)[0]; //전체 행 개수.
    $total_page = ceil($total_row / $scale);
    $current_page = ceil($page/$page_scale);
    $start_page = ($current_page - 1) * $page_scale + 1;
    $end_page = $start_page + $page_scale - 1;
    
    if ($page==1)  
        $start_num=$total_row; 
    else 
        $start_num=$total_row-($page-1) * $scale; 
    $prev_page = $page - $page_scale;   
    $next_page = $page + $page_scale;

    
?>
<!DOCTYPE HTML>
<html>
<head> 
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../css/common.css" >
<link rel="stylesheet" type="text/css" href="../css/board.css" >
</head>
<script>
    function del(href){
        if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
        document.location.href = href;
        }
        
    }
</script>
<title>상품리스트화면</title>
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
                상품리스트 <br>
                <form name="board_form" method="post" action="shop_list.php?mode=search">
                    <div id="list_search">
                        <div id="list_search1">▷ 총 <?=$total_row?>  개의 게시물이 있습니다.</div>
                        <div id="list_search2"><img src="../img/select_search.gif"></div>
                        <div id="list_search3">
                            <!--find 가 검색유형.-->
                            <select name="find">
                                <option value='subject'>제목</option>
                            </select>
                        </div> <!-- end of list_search3 -->
                            <!--search 가 검색단어.-->
                        <div id="list_search4"><input type="text" name="search"></div>
                        <div id="list_search5"><input type="image" src="../img/list_search_button.gif"></div>
                    </div> <!-- end of list_search -->
                </form>
                <div id="list_top_title">
                    <ul>
                        <li id="list_title1"><img src="../img/list_title1.gif"></li>
                        <li id="list_title2"><img src="../img/list_title2.gif"></li>
                        <li id="list_title3"></li>
                        <li id="list_title4"><img src="../img/list_title4.gif"></li>
                        <li id="list_title5"></li>
                    </ul>
                </div> <!-- end of list_top_title -->
                <div>
                </div>
                <div id="list_content">
                    <?php

                        
                        
                        if($mode=="search")
                            $query = "select * from shhan_shopitem where item_name like '%$search%' order by num desc limit $first_num, $scale";
                        else
                            $query = "select * from shhan_shopitem order by num desc limit $first_num, $scale";
                        
                        $result = mysqli_query($link, $query); 
                        while ($data = mysqli_fetch_array($result)){
                    ?>                    
                        <div id="list_item" style="height: 100px">
                            <div id="list_item1"> <?= $data["num"] ?>  </div>
                            <div id="list_item2">  <a href="shop_view.php?num=<?=$data['num']?>"> <img width="200px" height="80px"alt="이미지가 없습니다"  src="../item/<?= $data['item_img_0'] ?>"></a>&nbsp;<br><?= $data['item_name'] ?></div>
                            <div id="list_item3">  </div>
                            <div id="list_item4"> <?= $data["item_regist_day"] ?> </div>
                            <div id="list_item5" style="margin-left: 50px; width: 60px;">
                                <?php
                                if(isset($_SESSION["id"]) && $_SESSION["id"]=="admin"){
                                ?>
                                <a href="javascript:del('shop_delete.php?num=<?= $data["num"] ?>')"><img width="" height="" src="../img/delete.png"></a>  
                                
                                
                                <a href="shop_updateform.php?num=<?= $data['num'] ?>">수정</a>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                </div><!-- end of list_content --> 
                
                
                               <div id="page_button">
                    <div id="page_num">
                    <?php
                        if($page!=1 && $page>$page_scale){
                            if($prev_page <= 0) 
                                $prev_page = 1;  // 만약 감소한 값이 0보다 작거나 같으면 1로 고정
                            if($mode=="search")
                                print "<a href=shop_list.php?page=$prev_page&mode=search&search=$search>◀ </a>";
                            else
                                print "<a href=shop_list.php?page=$prev_page>◀ </a>";
                        }
                        
                        for($i=$start_page; $i<=$end_page && $i<= $total_page; $i++) {        // [1][2][3] 페이지 번호 목록 출력
                            if($page==$i) // 현재 위치한 페이지는 링크 출력을 하지 않도록 설정.
                                print "<font color=red><b>[$i]</b></font>"; 
                            else
                                if($mode=="search")
                                    print "<a href=shop_list.php?page=$i&mode=search&search=$search>[$i]</a>";
                                else
                                    print "<a href=shop_list.php?page=$i>[$i]</a>";
                        }
                        
                        if($page<$total_page){
                            if($next_page > $total_page) 
                                $next_page = $total_page; // netx_page 값이 전체 페이지수 보다 크면 맨 뒤 페이지로 이동시킴
                            if($mode=="search")
                                print "<a href=shop_list.php?page=$next_page&mode=search&search=$search> ▶</a><p>";
                            else
                                print "<a href=shop_list.php?page=$next_page> ▶</a><p>";
                        }  
                    ?>
                        <!--[1][2][3]-->
                    </div>
                
                    <div id="write_button">
                       <!--<a href="shop_list.php?&page=<?=$page?>"><img src="../img/list.png"></a>&nbsp;-->
                        <?php
//                            if(isset($_SESSION["id"])){
                        ?>
                            <!--<a href="board_write_form.php"><img src="../img/write.png"></a>-->
                        <?php
//                                    }
                        ?>
                    </div>
                
            </div> <!-- end of col2 -->            
        </div> <!-- end of content -->
    </div> <!-- end of wrap -->
    <p>&nbsp;</p><p>&nbsp;</p>
 </body>
 </html>
