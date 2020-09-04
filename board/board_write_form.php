<?php
    session_start();
    
    if(isset($_REQUEST["mode"]))  //수정 버튼을 클릭해서 호출했는지 체크
        $mode=$_REQUEST["mode"];
    else
        $mode="";

    if(isset($_REQUEST["num"]))  //수정 버튼을 클릭해서 호출했는지 체크
        $num=$_REQUEST["num"];
    else
        $num="";

    if ($mode=="modify"){
        try{
            require_once '../common/MyDB.php';
            $pdo = db_connect();
            $db_name = db_name();
            
            $sql = "select * from $db_name.shhan_board where num = ? ";
            $stmh = $pdo->prepare($sql); 
            $stmh->bindValue(1,$num,PDO::PARAM_STR); 
            $stmh->execute();
            $count = $stmh->rowCount();
            
            if($count<1){
                print "검색결과가 없습니다.<br>";
            }else{
                $row = $stmh->fetch(PDO::FETCH_ASSOC);
                $item_subject = $row["subject"];
                $item_content = $row["content"];
                $item_file_0 = $row["file_name_0"];
                $item_file_1 = $row["file_name_1"];
                $item_file_2 = $row["file_name_2"];
                $item_type_0 = $row["file_type_0"];
                $item_type_1 = $row["file_type_1"];
                $item_type_2 = $row["file_type_2"];
                $copied_file_0 = $row["file_copied_0"];
                $copied_file_1 = $row["file_copied_1"];
                $copied_file_2 = $row["file_copied_2"];
            }
        }catch (PDOException $Exception) {
            print "오류: ".$Exception->getMessage();
        }
    }

?>
<!DOCTYPE HTML>
<html>
<head> 
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../css/common.css" >
<link rel="stylesheet" type="text/css" href="../css/board.css" >
</head>
<title>게시판 글쓰기</title>
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
                게시판 글쓰기<br>
                <?php
                    if($mode=="modify"){
                ?>
                        <form  name="board_form" method="post" action="board_insert.php?mode=modify&num=<?=$num?>" enctype="multipart/form-data">
                <?php
                    }else{
                ?>
                        <form  name="board_form" method="post" action="board_insert.php" enctype="multipart/form-data">
                <?php
                    }
                ?>
                    <div id="write_form">
                        <div class="write_line"></div>
                             <div id="write_row1">
                                <div class="col1"> 작성자 </div>
                                <div class="col2"><?=$_SESSION["nick"]?></div>
                                <div class="col3"><input type="checkbox" name="html_ok" value="y"> HTML 쓰기</div>
                             </div>
                            <div class="write_line"></div>
                            <div id="write_row2">
                                <div class="col1"> 제목   </div>
                                <div class="col2"><input type="text" name="subject" required  <?php if($mode=="modify"){ ?> value="<?=$item_subject?>" <?php } ?> > </div>                                
                            </div>
                            <div class="write_line"></div>
                            <div id="write_row3">
                                <div class="col1"> 내용   </div>
                                <div class="col2"><textarea rows="15" cols="79" name="content" required><?php if($mode=="modify") print $item_content; ?></textarea></div>
                            </div>
                            <div class="write_line"></div>      
                            <br><br>
                            <div id="write_row4">
                                <div class="col1"> 이미지파일1   </div>
                                <div class="col2"><input type="file" name="upfile[]"></div>
                            </div>
                            
                            <?php
                            if ($mode=="modify" && $item_file_0){
                            ?>
                                <div class="delete_ok">
                                    <?=$item_file_0?> 파일이 등록되어 있습니다. 
                                    <input type="checkbox" name="del_file[]" value="0"> 삭제
                                </div>
                                <div class="clear"></div>
                            <?php                      
                            }
                            ?>
                            
                            
                            <div class="write_line"></div>
                            <div id="write_row5">
                                <div class="col1"> 이미지파일2</div>
                                <div class="col2"><input type="file" name="upfile[]"></div>
                            </div>
                            
                            <?php                      
                            if ($mode=="modify" && $item_file_1){
                            ?>
                                <div class="delete_ok">
                                    <?=$item_file_1?> 파일이 등록되어 있습니다. 
                                    <input type="checkbox" name="del_file[]" value="1"> 삭제
                                </div>
                                <div class="clear"></div>
                            <?php  	
                            } 
                            ?>
                            
                            
                            <div class="write_line"></div>
                            <div id="write_row6">
                                <div class="col1"> 이미지파일3 </div>
                                <div class="col2"><input type="file" name="upfile[]"></div>
                            </div>
                            
                            <?php      
                            if ($mode=="modify" && $item_file_2){
                            ?>
                                <div class="delete_ok">
                                    <?=$item_file_2?> 파일이 등록되어 있습니다. 
                                    <input type="checkbox" name="del_file[]" value="2"> 삭제
                                </div>
                                <div class="clear"></div>
                            <?php  
                                }
                            ?>
                            
                            <div id="write_button">
                                <input type="image" src="../img/ok.png">&nbsp;
                                <a href="board_list.php"><img src="../img/list.png"></a>
                            </div>
                    </div>
                </form>
            </div> <!-- end of col2 -->            
        </div> <!-- end of content -->
    </div> <!-- end of wrap -->
    <p>&nbsp;</p><p>&nbsp;</p>
 </body>
 </html>