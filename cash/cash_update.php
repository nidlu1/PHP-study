<?php
    session_start();
    $cash_add = $_REQUEST["cash_add"];
    $cash = $_SESSION["cash"];
    $id = $_SESSION["id"];
    
    $sum = $cash+$cash_add;
    
    
    require_once '../common/MyDB.php';
    $pdo = db_connect();
    $db_name = db_name();
    
    try {
        $pdo->beginTransaction();
        $sql = "update $db_name.shhan_user set cash = ? where id = ?";
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(1, $sum, PDO::PARAM_STR);
        $stmh->bindValue(2, $id, PDO::PARAM_STR);
        $stmh->execute();
        $pdo->commit();
        
        try {
            
            $sql2 = "select cash from $db_name.shhan_user where id = ?";
            $stmh2 = $pdo->prepare($sql2);
            $stmh2->bindValue(1, $id, PDO::PARAM_STR);
            $stmh2->execute();
            
            $row = $stmh2->fetch(PDO::FETCH_ASSOC);
            
            unset($_SESSION["cash"]);
            $_SESSION["cash"] = $row["cash"];
            $updaterow = $row["cash"];

        } catch (Exception $exc) {            
            echo $exc->getTraceAsString();
        }
        
        ?>
        <script>
            alert("금액이 <?= $cash_add?>만큼 충전되었습니다.\n메인화면으로 돌아갑니다.");
            location.href="../index.php";
        </script>
        <?php
        
    } catch (Exception $exc) {
        $pdo->rollBack();
        echo $exc->getTraceAsString();
    }
 ?>