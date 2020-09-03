<?php
    $num=$_REQUEST["num"];
    $ripple_num=$_REQUEST["ripple_num"];
    $page=$_REQUEST["page"];
        
    require_once("../common/MyDB.php");
    $pdo = db_connect();
    $db_name = db_name();
        
    try{
       $pdo->beginTransaction();
       $sql = "delete from $db_name.shhan_board_ripple where num = ?";   
       $stmh = $pdo->prepare($sql);
       $stmh->bindValue(1,$ripple_num,PDO::PARAM_STR);
       $stmh->execute();   
       $pdo->commit();
                
       header("Location:http://localhost/shhan/board/board_view.php?num=$num&page=$page");
    }
    catch (Exception $ex) {
        $pdo->rollBack();
        print "오류: ".$Exception->getMessage();
    }
?>

