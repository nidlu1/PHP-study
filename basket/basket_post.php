<?php
    session_start();
    $id= $_SESSION["id"];
    $nick= $_SESSION["nick"];
    $num= $_REQUEST["num"];
    $count= $_REQUEST["count"];

        
    
    include_once '../common/MyDB.php';
    $link = dbconn();
    $query="select * from shhan_shopitem where num = $num";
    $result = mysqli_query($link, $query); 
    $data = mysqli_fetch_array($result);
    
    $parent = $data["num"];
    $price = $data["item_price"];
    $money = $price*$count;    
    $item_model = $data["item_model"];
    $item_name = $data["item_name"];
    $item_img_0 = $data["item_img_0"];
    $regist_day;
   

    echo "<br> id=$id , num=$num, parent=$parent, count=$count, price=$price, money=$money, item_model=$item_model, item_name=$item_name, item_img_0=$item_img_0 ";
    
    $query1= "  insert into shhan_temp(
                id, nick, parent, count, price, money, item_model, item_name ,item_img_0, regist_day )
                values (
                '$id', '$nick', $parent, $count, $price, $money, '$item_model', '$item_name', '$item_img_0', now()
                )
        ";
    try{
            if(mysqli_query($link, $query1))
                echo "update successfully";
            else
                echo "<br>Error:".$query."<br>mesage:".mysqli_error($link);  
    } catch (Exception $ex) {
        $link->rollback();
        $ex->getMessage();
        echo '메세지:'.mysqli_errno($link);
    }
    
?>
<script>
    alert("성공적으로 장바구니에 저장되었습니다.");
    location.href = "basket_list.php";
</script>