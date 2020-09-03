<?php
    session_start();
    
    $id = $_REQUEST["id"];
    $pw = $_REQUEST["pw"];
    
    require_once '../common/MyDB.php';
    $pdo = db_connect();
    $db_name = db_name();
       
    try {
        $sql = "select * from shhan_user where id = ?";
        
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(1, $id, PDO::PARAM_STR);
        $stmh->execute();
        
        $userCount = $stmh->rowCount(); //셀렉트된 행 갯수.
        
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
    
    $row = $stmh ->fetch(PDO::FETCH_ASSOC); //가장 마지막에 실행된 행을 배열로 변수에 담기.
    if($userCount < 1){ // 일치하는 아이디가 없는 경우
?>
        <script>
            alert("아이디가 틀립니다.");
            history.back();
        </script>
<?php        
    } elseif($pw!=$row["pw"]) {
?>
        <script>
            alert("비밀번호가 틀립니다.");
            history.back();
        </script>        
<?php        
    }else{
        
        $_SESSION["id"] = $row["id"];
        $_SESSION["nick"] = $row["nick"];
        $_SESSION["tel"] = $row["tel"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["level"] = $row["level"];
        $_SESSION["cash"] = $row["cash"];
        $_SESSION["mileage"] = $row["mileage"];

//        header("Location:http://localhost/shhan/index.php");
    }
?>
    <script>
            history.back();
    </script> 
