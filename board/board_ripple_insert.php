<?php session_start(); ?>
<meta charset="utf-8">
<?php
    if(!isset($_SESSION["id"])) {
?>
    <script>
        alert('로그인 후 이용해 주세요.');
        history.back();
    </script>
    <?php
    }
    $num=$_REQUEST["num"]; 
    $page=$_REQUEST["page"]; 
    $ripple_content=$_REQUEST["ripple_content"];
    require_once("../common/MyDB.php");
    $pdo = db_connect();
    $db_name = db_name();
    
    try{
        $pdo->beginTransaction();   
        $sql = "insert into $db_name.shhan_board_ripple(parent, id, nick, content, regist_day)";
        $sql.= "values(?, ?, ?, ?,now())"; 
        $stmh = $pdo->prepare($sql); 
        $stmh->bindValue(1, $num, PDO::PARAM_STR); 
        $stmh->bindValue(2, $_SESSION["id"], PDO::PARAM_STR);  
        $stmh->bindValue(3, $_SESSION["nick"], PDO::PARAM_STR);
        $stmh->bindValue(4, $ripple_content, PDO::PARAM_STR);
        $stmh->execute();
        $pdo->commit(); 

        ?>
            <script>
               location.href = "./board_view.php?num=<?=$num?>&page=<?=$page?>";               
           </script>
    <?php
    }
    catch (PDOException $Exception) {
        $pdo->rollBack();
        print "오류: ".$Exception->getMessage();
    }
    ?>
