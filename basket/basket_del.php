<?php
    session_start();
    $num = $_REQUEST["num"];
    
    include_once '../common/MyDB.php';
    $link = dbconn();
    $query = "delete from shhan_temp where num = $num";
    mysqli_query($link, $query);
    
    try {
        if(mysqli_query($link, $query))
            echo "successfully";
        else
            echo "<br>sqlError : ". mysql_error($link);
        $link->commit(); 
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
        $link->rollback();
    }
?>
<script>
    alert("성공적으로 장바구니에서 제거되었습니다.");
    location.href = "basket_list.php";
</script>
