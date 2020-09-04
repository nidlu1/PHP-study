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
                
            ?>
            <script>
               location.href = "./board_view.php?num=<?=$num?>&page=<?=$page?>";               
           </script>
    <?php
    }
    catch (Exception $ex) {
        $pdo->rollBack();
        print "오류: ".$Exception->getMessage();
    }
?>

