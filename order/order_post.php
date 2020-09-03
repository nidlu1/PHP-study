<?php
    session_start();

    $id = $_SESSION["id"];
    $order_id = date("Ymdhis");
    $nick = $_REQUEST["nick"];
    $tel = $_REQUEST["tel"];
    $email = $_REQUEST["email"];
    $zip1 = $_REQUEST["total"];
    $zip2 = $_REQUEST["zip2"];
    $zip = $zip1."-".$zip2;
    $address1 = $_REQUEST["adress1"];
    $address2 = $_REQUEST["adress2"];
    $memo = $_REQUEST["memo"];
    $registday = time();

    $total = $_REQUEST["total"];
    
    if(isset($_REQUEST["num"])){
        $num = $_REQUEST["num"];
        echo "$num <br>";
    }
/* 1. 장바구니 내용물 제거. shhan_temp delete
 * 2. 구매내역 테이블에 추가.
 * 3. 주문정보 테이블 추가.
 * 4. 사용자 금액 줄어들게.
 * 5. 재고량 감소.
 */
//    echo "$id = $nick = $tel = $email= $zip1= $zip2= $adress1= $adress2= $memo";
    
    

    include_once '../common/MyDB.php';
    $link = dbconn();
        
    try{
        $link->begin_transaction();        
        /*
         * 주문정보테이블 추가.
         */
        $order_query =  "insert into shhan_order(
                            id, order_id, address1, address2, tel, zip, email, memo, regist_day)
                            values ( '$id' , '$order_id' , '$address1' ,'$address2', '$tel', '$zip', '$email', '$memo', now()
                        )";
        mysqli_query($link, $order_query);
        /*
         * 사용자금액감소
         */
        $shhan_cash_down_query = "select cash from shhan_user where id = '$id' ";
        $select_cash = mysqli_query($link, $shhan_cash_down_query);
        $data = mysqli_fetch_array($select_cash);
        $cash_cal = $data[cash]-$total;
        echo "잔액결과:$cash_cal <br>";
        $shhan_cash_update_query = "update shhan_user set cash = $cash_cal";
        mysqli_query($link, $shhan_cash_update_query);
        
        unset($_SESSION["cash"]);
        $_SESSION["cash"] = $cash_cal;

        /*
         * 재고량감소
         */
        if(isset($_REQUEST["num"])){
            $shhan_select_stack_query2 = "select count ,item_name from shhan_temp where num = $num ";
            $result = mysqli_query($link, $shhan_select_stack_query2);
            $data = mysqli_fetch_array($result);
            $item1_stack = $data[count];
            $item1_name = $data[item_name];

            $shhan_select_stack_query1 = "select item_stack from shhan_shopitem where item_name = '$item1_name' ";
            $result = mysqli_query($link, $shhan_select_stack_query1);
            $data = mysqli_fetch_array($result);
            $item1_stack2 = $data[item_stack];

            $stack3 = $item1_stack2 - $item1_stack;
            echo "재고량감소 $item1_stack=$item1_name=$item1_stack2=$stack3<br>";
            $shhan_item_stack_update_query = "update shhan_shopitem set item_stack = $stack3";
            mysqli_query($link, $shhan_item_stack_update_query);
        }
        else{
            $shhan_select_stack_query2 = "select count ,item_name from shhan_temp where id = '$id' ";
            $result = mysqli_query($link, $shhan_select_stack_query2);
            while ($data = mysqli_fetch_array($result)){            
                $item1_stack = $data[count];
                $item1_name = $data[item_name];
                $shhan_select_stack_query1 = "select item_stack from shhan_shopitem where item_name = '$item1_name' ";
                $result2 = mysqli_query($link, $shhan_select_stack_query1);
                $data2 = mysqli_fetch_array($result2);
                $item1_stack2 = $data2[item_stack];

                $stack3 = $item1_stack2 - $item1_stack;
                echo "재고량감소 $item1_stack=$item1_name=$item1_stack2=$stack3<br>";
                $shhan_item_stack_update_query = "update shhan_shopitem set item_stack = $stack3";
                mysqli_query($link, $shhan_item_stack_update_query);
            }

        }



        /*
         *  구매내역테이블 추가, , ,
         */    
        $shhan_buy_select_query = "select * from shhan_temp where id = '$id' ";
        if(isset($_REQUEST["num"])){
            $shhan_buy_select_query = "select * from shhan_temp where num = $num";
        }

        $result = mysqli_query($link, $shhan_buy_select_query);
        while ($data = mysqli_fetch_array($result)){        
            echo "$data[id]=$data[nick]=$data[parent]=$data[count]=$data[price]=$data[money]=$data[item_model]=$data[item_name]=$data[item_img_0] <Br>";
    //        인서트 쿼리문
            $shhan_buy_insert_query=    
            "INSERT INTO shhan_buy( id, order_id, parent, count, price, money, item_model, item_name, item_img_0, regist_day)
            VALUES ('$data[id]', '$order_id', $data[parent],  $data[count], $data[price], $data[money], '$data[item_model]', '$data[item_name]', '$data[item_img_0]', now())";
            mysqli_query($link, $shhan_buy_insert_query);

        }
        

        /*
         * 장바구니 내용물제거.
         */
        if(isset($_REQUEST["num"])){
            $shhan_temp_delete_query = "delete from shhan_temp where num = $num";
            mysqli_query($link, $shhan_temp_delete_query);
        }
        else{
            $shhan_temp_delete_query = "delete from shhan_temp where id = '$id' ";
            mysqli_query($link, $shhan_temp_delete_query);
        }
        
        
        echo '<br> success';
        
        //세션 변경.
        
        mysqli_error($link);
        $link->commit();
    } catch (Exception $ex) {
        $link->rollback();
        $ex->getMessage();
        echo '<br> error.mesessge';
        mysqli_error($link);
    }
    

?>
<script>
    alert("성공적으로 구매되었습니다");
    location.href = "../order/order_list.php";
</script>
