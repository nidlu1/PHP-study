<?php
    $num=$_REQUEST["num"];
        
    require_once("../common/MyDB.php");
    $pdo = db_connect();
    $db_name = db_name();
        
    try{
       $pdo->beginTransaction();
       $sql = "delete from $db_name.shhan_board where num = ?";   
       $stmh = $pdo->prepare($sql);
       $stmh->bindValue(1,$num,PDO::PARAM_STR);
       $stmh->execute();   
       $pdo->commit();
                
       ?>
            <script>
               location.href = "./board_list.php";               
           </script>
<?php
    }
    catch (Exception $ex) {
        $pdo->rollBack();
        print "오류: ".$Exception->getMessage();
    }
?>