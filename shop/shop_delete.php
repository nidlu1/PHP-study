<?php
session_start();

$num=$_REQUEST["num"];
require_once '../common/MyDB.php';

$link = dbconn();
$query = "delete from shhan_shopitem where num = $num";
try {
    mysqli_query($link, $query);
    $link->commit();
    mysqli_close($link);
} catch (Exception $exc) {
    $link->rollback();
    echo $exc->getTraceAsString();
}
?>
    <script>
        alert("상품이 삭제되었습니다");
        location.href = "shop_list.php";
    </script>
