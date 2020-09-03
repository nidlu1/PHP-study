<?php session_start();
$id = $_SESSION["id"];

$item_model = $_REQUEST["item_model"];
$item_name = $_REQUEST["item_name"];
$item_price = $_REQUEST["item_price"];
$item_stack = $_REQUEST["item_stack"];
$item_memo = $_REQUEST["item_memo"];
$item_memo = htmlspecialchars($item_memo);

print_r($_FILES);
$item_img_0 = $_FILES['item_img_0']['name'];
$item_img_1 = $_FILES['item_img_1']['name'];
$item_img_2 = $_FILES['item_img_2']['name'];



if(isset($item_img_0) && $_FILES['item_img_0']['type']=="image/jpeg")
    move_uploaded_file ($_FILES['item_img_0']["tmp_name"], "../item/".$item_img_0);
else{
    $item_img_0 = "이미지없음";
    ?>
<!--        <script>
            alert('이미지로 넣어주세요');
            history.back();
        </script>-->
<?php
}

if(isset($item_img_1) && $_FILES['item_img_1']['type']=="image/jpeg" )
    move_uploaded_file ($_FILES['item_img_1']["tmp_name"], "../item/".$item_img_1);
else{
    $item_img_1 = "이미지없음";
?>
<!--        <script>
            alert('이미지로 넣어주세요');
            history.back();
        </script>-->
<?php
}
    
if(isset($item_img_2) && $_FILES['item_img_0']['type']=="image/jpeg")
    move_uploaded_file ($_FILES['item_img_2']["tmp_name"], "../item/".$item_img_2);
else{
    $item_img_2 = "이미지없음";
?>
<!--        <script>
            alert('이미지로 넣어주세요');
            history.back();
        </script>-->
<?php    
}
    

?>
<meta charset="utf-8">
<?php
    if($id!="admin") {
?>
        <script>
            alert('관리자로 로그인 후 접속해주세요.');
            history.back();
        </script>
<?php
    }
    include_once '../common/MyDB.php';
    
    $connect = dbconn();
    try {
        $query = "insert into shhan_shopitem(item_model,item_name,item_memo,item_price,item_stack,item_regist_day,item_img_0,item_img_1,item_img_2)"
                . "values ('$item_model','$item_name','$item_memo','$item_price','$item_stack',now(),'$item_img_0','$item_img_1','$item_img_2')";
        mysqli_query($connect,$query);
        $connect->commit();
        mysqli_close($connect);
    
    } catch (Exception $exc) {
        $connect->rollback();
        echo $exc->getTraceAsString();
    }

?>
    <script>
        location.href = "shop_list.php";
    </script>
        
