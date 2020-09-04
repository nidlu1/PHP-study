<?php
    session_start();
    
//    $file_dir = 'C:\xampp\htdocs\shhan\data\\';
    $file_dir = '../data/';

    $num=$_REQUEST["num"];
    $page=$_REQUEST["page"];   //페이지번호
    
    require_once '../common/MyDB.php';
    $pdo = db_connect();
    $db_name = db_name();
    
    try{
        $sql= "select * from $db_name.shhan_board where num = ?";
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(1, $num, PDO::PARAM_STR);
        $stmh->execute();
        
        $row = $stmh->fetch(PDO::FETCH_ASSOC);
        $item_num     = $row["num"];
        $item_id      = $row["id"];    
        $item_nick    = $row["nick"];
        $item_hit     = $row["hit"];

        $image_name[0]   = $row["file_name_0"];
        $image_name[1]   = $row["file_name_1"];
        $image_name[2]   = $row["file_name_2"];

        $image_type[0]   = $row["file_type_0"];
        $image_type[1]   = $row["file_type_1"];
        $image_type[2]   = $row["file_type_2"];
        
        $image_copied[0] = $row["file_copied_0"];
        $image_copied[1] = $row["file_copied_1"];
        $image_copied[2] = $row["file_copied_2"];   

        $item_date    = $row["regist_day"];
        $item_date    = substr($item_date,0,10);
        $item_subject = str_replace(" ", "&nbsp;", $row["subject"]);
        $item_content = $row["content"];
        $is_html      = $row["is_html"];
        
        if($is_html!="y"){
            $item_content = str_replace(" ", "&nbsp;", $item_content);
            $item_content = str_replace("\n", "<br>", $item_content);
        }
        /*
         * 조회수 증가
         */        
        $new_hit = $item_hit + 1;
        try{
            $pdo->beginTransaction();
            $sql2 = "update $db_name.shhan_board set hit=? where num=?";
            $stmh = $pdo->prepare($sql2);  
            $stmh->bindValue(1, $new_hit, PDO::PARAM_STR);      
            $stmh->bindValue(2, $num, PDO::PARAM_STR);           
            $stmh->execute();
            $pdo->commit();
        } catch (Exception $ex) {
            $pdo->rollBack();
            print "오류: ".$Exception->getMessage();
        }

?>
<!DOCTYPE HTML>
<html>
<head> 
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../css/common.css" >
<link rel="stylesheet" type="text/css" href="../css/board.css" >
<script>
    function del(hrefDel){
        if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
        document.location.href = hrefDel;
        }
    }
</script>
</head>
<title>게시판 내용</title>
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
                <div id="view_title">
                    <div id="view_title1"><?= $item_subject ?></div>
                    <div id="view_title2"><?= $item_nick ?> | 조회 : <?= $item_hit ?> | <?= $item_date ?> </div>	
                </div>
                <div id="view_content">
                <?php
                    for($i=0; $i<3; $i++){
                        if($image_copied[$i] && $image_type[$i]=="image/jpeg"){
                            $img_info = getimagesize($file_dir.$image_copied[$i]);
                            $img_width[$i] = $img_info[0];
                            $img_height[$i] = $img_info[1];
                            $img_type[$i] = $img_info[2];
                            $img_name = $image_copied[$i];
                            $img_name = "../data/".$img_name;
                            
                            if($img_width[$i] > 785)
                                $img_width[$i] = 785;
                            if($img_type[$i]==1 || $img_type[$i]==2 || $img_type[$i]==3){
                                print "<img src='$img_name' width='$img_width[$i]'><br><br>";
                            }
                        }
                    }
                ?>
                    <?= $item_content ?>
                    <hr>
                    <div id="download1">
                    <?php
                        for ($i=0; $i<3; $i++){
                            if ($image_copied[$i]) {
                                    $show_name = $image_name[$i];
                                    $real_name = $image_copied[$i];
                                    $real_type = $image_type[$i];
                                    $file_path = $file_dir.$real_name;
                                    $file_size = filesize($file_path);
                                print "▷ 첨부파일 : $show_name ($file_size Byte) &nbsp;&nbsp;"
                                        . "<a href='board_download.php?num=$num&real_name=$real_name&show_name=$show_name&file_type=$real_type'>[다운로드]</a><br>";
                            }
                        }
                    ?>                        
                    </div>
                    
                </div>
                
                <div id="ripple">
                <?php
                    try {
                        $sql = "select * from $db_name.shhan_board_ripple where parent='$item_num'";
                        $stmh2 = $pdo->query($sql);   // ripple PDOStatement 변수명을 다르게
                    } catch (Exception $exc) {
                        echo $exc->getTraceAsString();
                    }
                    
                    while ($row_ripple = $stmh2->fetch(PDO::FETCH_ASSOC)){
                        $ripple_num     = $row_ripple["num"];
                        $ripple_id      = $row_ripple["id"];
                        $ripple_nick    = $row_ripple["nick"];
                        $ripple_content = str_replace("\n", "<br>", $row_ripple["content"]);
                        $ripple_content = str_replace(" ", "&nbsp;", $ripple_content);
                        $ripple_date    = $row_ripple["regist_day"];
                    
                ?>
                    <div id="ripple_writer_title">
                        <ul>
                            <li id="writer_title1"><?=$ripple_nick?></li>
                            <li id="writer_title2"><?=$ripple_date?></li>
                            &nbsp; &nbsp;
                             <?php
                                        if(isset($_SESSION["id"])){
                                            if($_SESSION["id"]=="admin" || $_SESSION["id"]==$ripple_id)
                                                print "<a href=board_ripple_delete.php?num=$item_num&ripple_num=$ripple_num&page=$page>[삭제]</a>"; 
                                        }
                            ?>
                        </ul>
                    </div>
                    <div id="ripple_content"><?=$ripple_content?></div>
                    <div class="hor_line_ripple"></div>
                <?php
                    }
                    
                    if(isset($_SESSION["id"])) {
                        if($_SESSION["id"]==$item_id || $_SESSION["id"]=="admin" || $_SESSION["level"]==1 ){
                        ?>
                            <form name="ripple_form" method="post" action="board_ripple_insert.php?num=<?=$item_num?>&page=<?=$page?>"> 
                                <div id="ripple_box">
                                    <div id="ripple_box1"><img src="../img/title_comment.gif"></div>
                                    <div id="ripple_box2"><textarea rows="5" cols="65" name="ripple_content" required></textarea></div>
                                    <div id="ripple_box3"><input type=image src="../img/ok_ripple.gif"></a></div>
                                </div>
                            </form>                   
                            <a href="board_write_form.php?mode=modify&num=<?=$num?>"><img src="../img/modify.png"></a>&nbsp;
                            <a href="javascript:del('board_delete.php?num=<?=$num?>')"><img src="../img/delete.png"></a>&nbsp;
                        <?php
                        }
                    }    
                ?>
                    <a href="board_write_form.php"><img src="../img/write.png"></a>
                    
                </div> <!-- end of ripple -->
            </div> <!-- end of col2 -->            
        </div> <!-- end of content -->
    </div> <!-- end of wrap -->
    <p>&nbsp;</p><p>&nbsp;</p>
 </body>
 </html>
<?php
        } catch (Exception $ex) {
        echo "$ex->getMessage()";
    } 
?>