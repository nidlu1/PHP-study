<?php session_start();
       
    $num=$_REQUEST["num"];
    $item_model=$_REQUEST["item_model"];
    $item_name=$_REQUEST["item_name"];
    $item_memo=$_REQUEST["item_memo"];
    $item_memo = htmlspecialchars($item_memo);
    $item_price=$_REQUEST["item_price"];
    $item_stack=$_REQUEST["item_stack"];    
    $oldimg_0=$_REQUEST["oldimg_0"];    
    $oldimg_1=$_REQUEST["oldimg_1"];    
    $oldimg_2=$_REQUEST["oldimg_2"];    
    

?>

<meta charset="utf-8">

<?php
    if(!isset($_SESSION["id"]) && $_SESSION["id"]!='admin') {
?>
        <script>
            alert('관리자로그인 후 이용해 주세요.');
            history.back();
        </script>
<?php
    }
    
    // 파일수정 
//    print_r($_FILES);
    $item_img_0 = $_FILES['item_img_0']['name'];
    $item_img_1 = $_FILES['item_img_1']['name'];
    $item_img_2 = $_FILES['item_img_2']['name'];
    echo "<br>$item_img_0";
    
if(isset($item_img_0) && $_FILES['item_img_0']['type']=="image/jpeg"){
    unlink ("../item/".$oldimg_0);
    move_uploaded_file ($_FILES['item_img_0']["tmp_name"], "../item/".$item_img_0);
//    $temp_0 = "item_img_0 = '$item_img_0',";
}
else{
    $item_img_0 = "이미지없음";
    ?>
<!--        <script>
            alert('이미지로 넣어주세요');
            history.back();
        </script>-->
<?php
}

if(isset($item_img_1) && $_FILES['item_img_1']['type']=="image/jpeg" ){
    unlink ("../item/".$oldimg_1);
    move_uploaded_file ($_FILES['item_img_1']["tmp_name"], "../item/".$item_img_1);
//    $temp_1 = "item_img_0 = '$item_img_1',";
}
else{
    $item_img_1 = "이미지없음";
?>
<!--        <script>
            alert('이미지로 넣어주세요');
            history.back();
        </script>-->
<?php
}
    
if(isset($item_img_2) && $_FILES['item_img_0']['type']=="image/jpeg"){
    move_uploaded_file ($_FILES['item_img_2']["tmp_name"], "../item/".$item_img_2);
//    $temp_2 = "item_img_0 = '$item_img_2',";
}
else{
    $item_img_2 = "이미지없음";
?>
<!--        <script>
            alert('이미지로 넣어주세요');
            history.back();
        </script>-->
<?php    
}

    
    echo "$num--$item_model--$item_name--$item_memo--$item_memo--$item_price--$item_stack--$item_img_0--$item_img_1--$item_img_2";
    
    
    require_once '../common/MyDB.php';
    $link = dbconn();
    $query = "  update shhan_shopitem set
                item_model='$item_model', item_name='$item_name', item_memo='$item_memo', item_price=$item_price, 
                item_img_0 = '$item_img_0',
                item_img_1 = '$item_img_1',
                item_img_2 = '$item_img_2',  
                item_stack=$item_stack
                where num = $num";

    try {
//        mysqli_query($link, $query);
//        $link->commit();
//        mysqli_close($link);
        
    if(mysqli_query($link, $query))
       echo "update successfully";
      else
       echo "<br>Error:".$query."mesage:".mysqli_error($link);  

    } catch (Exception $exc) {
        $link->rollback();
        echo $exc->getMessage();
    }
        
?>
    <script>
        alert("상품이 수정되었습니다");
        location.href = "shop_list.php";
    </script>