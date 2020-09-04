<?php
function db_connect(){
    $db_user = "shhan1"; //local: sh, cafe24: 
    $db_pass = "tkdghkdqud2@"; //local: 1234, cafe24: 
    $db_host = "localhost"; //local: localhost, cafe24: localhost
    $db_name = db_name(); 
    $db_type = "mysql";
    $dsn="$db_type:host=$db_host;dbname=$db_name;charset=utf8";

    try {
        $pdo= new PDO($dsn, $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
//        echo 'db접속 <br>';
    } catch (Exception $ex) {
        die('오류 :'.$ex->getMessage());
    }
    
    return $pdo;
}

function db_name(){
    return "shhan1"; //local: localhost, cafe24: shhan1
}


function dbconn(){
//    $connect = mysqli_connect("localhost", "sh", "1234","shhanphp"); //호스트명:포트번호 / 사용자계정 / 계정비밀번호
    $connect = mysqli_connect("localhost", "shhan1", "tkdghkdqud2@","shhan1"); //호스트명:포트번호 / 사용자계정 / 계정비밀번호
    
    return $connect;
}
?>
