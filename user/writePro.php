<?php
    session_start(); 
    if(!isset($_SESSION["id"])){
        header("Location:http://localhost/shhan/index.php");
    }
    
    if(isset($_REQUEST["mode"])){
        $mode=$_REQUEST["mode"];
        $id = $_SESSION["id"];
        $pw = $_REQUEST["pw"];
        $nick = $_REQUEST["nick"];
        $tel = $_REQUEST["tel"];
        $email = $_REQUEST["email"];
        
        require '../common/MyDB.php';
        $pdo = db_connect();
        $db_name = db_name();
        
        try {
            $pdo->beginTransaction();
            $sql = "update $db_name.shhan_user set pw = ?, nick = ?, tel = ? , email = ? where id = ?";
            $stmh = $pdo->prepare($sql);
            $stmh->bindValue(1, $pw, PDO::PARAM_STR);
            $stmh->bindValue(2, $nick, PDO::PARAM_STR);
            $stmh->bindValue(3, $tel, PDO::PARAM_STR);
            $stmh->bindValue(4, $email, PDO::PARAM_STR);
            $stmh->bindValue(5, $id, PDO::PARAM_STR);
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
                alert("회원정보가 수정되었습니다. 다시 로그인 하세요");
                location.href="../index.php";
            </script>
<?php
        } catch (Exception $exc) {
            $pdo->rollBack();
            echo $exc->getTraceAsString();
        }

    }
    else{
        $mode="";
        $id = $_REQUEST["id"];
        $pw = $_REQUEST["pw"];
        $nick = $_REQUEST["nick"];
        $tel = $_REQUEST["tel"];
        $email = $_REQUEST["email"];

        require '../common/MyDB.php';
        $pdo = db_connect();
        $db_name = db_name();

        try {
            $pdo->beginTransaction();

            $sql="insert into $db_name.shhan_user VALUES(?, ?, ?, ?, ?, now(),9, 0 ,0)";

            $stmh = $pdo->prepare($sql);
            $stmh ->bindValue(1, $id, PDO::PARAM_STR);
            $stmh ->bindValue(2, $pw, PDO::PARAM_STR);
            $stmh ->bindValue(3, $nick, PDO::PARAM_STR);
            $stmh ->bindValue(4, $tel, PDO::PARAM_STR);
            $stmh ->bindValue(5, $email, PDO::PARAM_STR);        
            $stmh->execute();

            $pdo->commit();

        } catch (Exception $exc) {
            $pdo->rollBack();
            echo $exc->getTraceAsString();
        }
    } 
?>
           <script>
               location.href = "../index.php";               
           </script>