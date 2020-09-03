<?php    

    $id = $_REQUEST["id"];
    
    require_once '../common/MyDB.php';        
    $pdo = db_connect();
    $db_name = db_name();
    
    if(isset($_SESSION["id"])){
        try {
            $pdo->beginTransaction();
            $sql = "delete from $db_name.shhan_user where id = ?";
            $stmh = $pdo->prepare($sql);
            $stmh->bindValue(1, $id, PDO::PARAM_STR);
            $stmh->execute();
            $pdo->commit();

            unset($_SESSION["id"]);
            unset($_SESSION["pw"]);
            unset($_SESSION["nick"]);
            unset($_SESSION["tel"]);
            unset($_SESSION["email"]);
            unset($_SESSION["level"]);
            unset($_SESSION["cash"]);
            unset($_SESSION["mileage"]);  
    ?>
        <script>
            alert("성공적으로 탈퇴했습니다.");
            location.href="../index.php";
        </script>
    <?php

        } catch (Exception $exc) {
            $pdo->rollBack();
            echo $exc->getTraceAsString();
        }
      
    } else {
    ?>
        <script>
            alert("로그인 하세요.");
            location.href="../index.php";
        </script>
    <?php
    }
    ?>        

    
   