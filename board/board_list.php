<?php
    session_start();
    require_once '../common/MyDB.php';
    $pdo = db_connect();
    $db_name = db_name();
   
/*
 * 페이징 처리에 필요한 변수.
 */
    $page=null;
    $scale = null;        
    $page_scale = null;
    $first_num = null; // 리스트에 표시되는 게시글의 첫 순번. page=1 일경우 가장 마지막부터 저장된 게시글 $scale개를 불러온다.
    $total_row = null;     //전체 글수
    $total_page = null; // 전체 페이지 블록 수  15/5  = 3번
    $current_page = null; //현재 페이지 블록 위치계산 1번째: [1][2][3] 2번째 [4][5][6], ...
    $start_page = null; //페이지 구분 블럭의 첫 페이지 수 계산
    $end_page = null; //페이지 구분 블럭의 마지막 페이지 수
    $start_num = null; //시작 그룹페이지
      
    $scale = null;       // 한 페이지에 보여질 게시글 수
    $page_scale = null;  // 한 페이지당 표시될 그룹 수
    $first_num = null; // 리스트에 표시되는 게시글의 첫 순번. page=1 일경우 가장 마지막부터 저장된 게시글 $scale개를 불러온다.
   
    
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

    if(isset($_REQUEST["find"])) //컬럼
        $find=$_REQUEST["find"];
    else 
        $find="";
 
    
   
    /*
     * 전체 게시판 리스트 불러오기.
     */
    
    try {
        $scale = 5;       // 한 페이지에 보여질 게시글 수
        $page_scale = 3;  // 한 페이지당 표시될 그룹 수
        $first_num = ($page-1) * $scale; // 리스트에 표시되는 게시글의 첫 순번. page=1 일경우 가장 마지막부터 저장된 게시글 $scale개를 불러온다.
    
        $pdo->beginTransaction();
        
        /*
         * 검색해서 list하는 결과.
         */
        if($mode=="search"){
            if(!$search){
                ?>
                <script>
                    alert('검색할 단어를 입력해 주세요!');
                    history.back();
                </script>
                <?php
            }       
            $sql="select * from $db_name.shhan_board where $find like '%$search%' order by num limit $first_num, $scale";
        }else{
            $sql="select * from $db_name.shhan_board order by group_num desc, ord asc limit $first_num, $scale";
        }
        
        $stmh = $pdo->query($sql);

        
        if($mode=="search")
            $sql2 = "select * from $db_name.shhan_board where $find like '%$search%'";
        else
            $sql2 = "select * from $db_name.shhan_board";  //전체 레코드수를 파악하기 위함.
        
        
        $stmh2 = $pdo->query($sql2);
        
        $total_row = $stmh2->rowCount();     //전체 글수
        $total_page = ceil($total_row / $scale); // 전체 페이지 블록 수  15/5  = 3번
        $current_page = ceil($page/$page_scale); //현재 페이지 블록 위치계산 1번째: [1][2][3] 2번째 [4][5][6], ...
        $start_page = ($current_page - 1) * $page_scale + 1; // 페이지 구분 블럭의 첫 페이지 수 계산 ($start_page)        
        $end_page = $start_page + $page_scale - 1; // 페이지 구분 블럭의 마지막 페이지 수 계산 ($end_page)
 ?>
<!DOCTYPE HTML>
<html>
<head> 
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/common.css" >
    <link rel="stylesheet" type="text/css" href="../css/board.css" >
</head>
<title>자유게시판 목록</title>
<script>
    function del(hrefDel){
        if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
        document.location.href = hrefDel;
        }
    }
</script>
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
                자유게시판 목록.<br>
                <form name="board_form" method="post" action="board_list.php?mode=search">
                    <div id="list_search">
                        <div id="list_search1">▷ 총 <?= $total_row ?> 개의 게시물이 있습니다.</div>
                        <div id="list_search2"><img src="../img/select_search.gif"></div>
                        <div id="list_search3">
                            <!--find 가 검색유형.-->
                            <select name="find">
                                <option value='subject'>제목</option>
                                <option value='content'>내용</option>
                                <option value='nick'>닉네임</option>
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
                        <li id="list_title3"><img src="../img/list_title3.gif"></li>
                        <li id="list_title4"><img src="../img/list_title4.gif"></li>
                        <li id="list_title5"><img src="../img/list_title5.gif"></li>
                    </ul>
                </div> <!-- end of list_top_title -->
                <div>
                </div>
                <div id="list_content">
                    <?php
                    /*
                     * 글목록 출력
                     */
                    if ($page==1)  
                        $start_num=$total_row;    // 페이지당 표시되는 첫번째 글순번
                    else 
                        $start_num=$total_row-($page-1) * $scale;  // 페이지당 표시되는 첫번째 글순번
                    
                    while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
                        $item_num=$row["num"];
                        $item_id=$row["id"];
                        $item_nick=$row["nick"];
                        $item_hit=$row["hit"];
                        $item_date=$row["regist_day"];
                        $item_date=substr($item_date, 0, 10);
                        $item_subject=str_replace(" ", "&nbsp;", $row["subject"]);
                        $item_depth = $row["depth"];  
                        $space = "";
                        for ($j=0; $j<$item_depth; $j++)
                            $space = "&nbsp;&nbsp;".$space;  
                        
                        $sql="select * from $db_name.shhan_board_ripple where parent=$item_num";
                        $stmh1 = $pdo->query($sql); 
                        $num_ripple=$stmh1->rowCount(); 
                    
                    ?>
                    <div id="list_item">
                            <div id="list_item1"><?= $start_num ?></div>
                            <div id="list_item2"><?=$space?><a href="board_view.php?num=<?=$item_num?>&page=<?=$page?>"><?= $item_subject ?></a>
                            <?php
                                            if($num_ripple)
                                                print "[<font color=red><b>$num_ripple</b></font>]";
                            ?>
                            </div>
                            <div id="list_item3"><?= $item_nick ?></div>
                            <div id="list_item4"><?= $item_date ?></div>
                            <div id="list_item5" style="width: 60px; margin-left: 10px">
                                <?= $item_hit ?> &nbsp;
                                <?php
                                if(isset($_SESSION["id"]) && $_SESSION["id"]=="admin"){
                                ?>
                                <a href="javascript:del('board_delete.php?num=<?=$item_num?>')"><img width="30px" height="25px" src="../img/delete.png"></a>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                        $start_num--;
                        }
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }     
                    ?>
                </div> <!-- end of list_content -->

                <div id="page_button">
                    <div id="page_num">
                    <?php
                        if($page!=1 && $page>$page_scale){
                            $prev_page = $page - $page_scale;    
                            // 이전 페이지값은 해당 페이지 수에서 리스트에 표시될 페이지수 만큼 감소
                            if($prev_page <= 0) 
                                $prev_page = 1;  // 만약 감소한 값이 0보다 작거나 같으면 1로 고정
                            if($mode=="search")
                                print "<a href=board_list.php?page=$prev_page&mode=search&search=$search&find=$find>◀ </a>";
                            else
                                print "<a href=board_list.php?page=$prev_page>◀ </a>";
                        }
                        
                        for($i=$start_page; $i<=$end_page && $i<= $total_page; $i++) {        // [1][2][3] 페이지 번호 목록 출력
                            if($page==$i) // 현재 위치한 페이지는 링크 출력을 하지 않도록 설정.
                                print "<font color=red><b>[$i]</b></font>"; 
                            else
                                if($mode=="search")
                                    print "<a href=board_list.php?page=$i&mode=search&search=$search&find=$find>[$i]</a>";
                                else
                                    print "<a href=board_list.php?page=$i>[$i]</a>";
                        }
                        
                        if($page<$total_page){
                            $next_page = $page + $page_scale;
                            if($next_page > $total_page) 
                                $next_page = $total_page; // netx_page 값이 전체 페이지수 보다 크면 맨 뒤 페이지로 이동시킴
                            if($mode=="search")
                                print "<a href=board_list.php?page=$next_page&mode=search&search=$search&find=$find> ▶</a><p>";
                            else
                                print "<a href=board_list.php?page=$next_page> ▶</a><p>";
                        }  
                    ?>
                        <!--[1][2][3]-->
                    </div>
                    <div id="write_button">
                       <a href="board_list.php?&page=<?=$page?>"><img src="../img/list.png"></a>&nbsp;
                        <?php
                            if(isset($_SESSION["id"])){
                        ?>
                            <a href="board_write_form.php"><img src="../img/write.png"></a>
                        <?php
                                    }
                        ?>
                    </div>
                </div>
            </div> <!-- end of col2 -->            
        </div> <!-- end of content -->
    </div> <!-- end of wrap -->
    <p>&nbsp;</p><p>&nbsp;</p>
 </body>
 </html>