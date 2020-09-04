<?php
    function latest_article($table, $loop, $char_limit){
        require_once './common/MyDB.php';
        $pdo= db_connect();
        $db_name = db_name();
        
        try{
            $sql= "select * from $db_name.$table order by num desc limit $loop";
            $stmh=$pdo->query($sql);
            echo ("
                    자유게시판
                    <table border='1' width='70%'>
                        <tr>
                            <td width='70%'>제목</td>
                            <td>등록일</td>    
                        </tr>                 

                ");
            while($row= $stmh->fetch(PDO::FETCH_ASSOC)){
                $num=$row["num"];
                $len_subject= strlen($row["subject"]); //글자수 세기
                $subject = $row["subject"];
                
                if($len_subject>$char_limit){
                    $subject= mb_substr($row["subject"], 0, $char_limit, 'utf-8'); //문자열 일부만 추려낸다.         
                    $subject=$subject."...";
                }
                $regist_day= substr($row["regist_day"], 0, 10);
                
                echo ("
                        <tr>
                            <td width='70%'><a href='./board/board_view.php?num=$num&page=1'>$subject</a></td>
                            <td>$regist_day</td>    
                        </tr> 
                ");
            }
            echo ("
                </table>         

                ");            
                                
        } catch (Exception $ex) {
            print"오류:".$ex->getMessage();
        }        
    }
    
    function latest_article2($table, $loop){
        require_once './common/MyDB.php';
        $link = dbconn();
        $query = "select * from $table order by num desc limit $loop";
        echo ("
                상품
                <table border='1' width='100%'>
                    <tr>
                        <td width='70%'>상품이름</td>
                        <td>등록일</td>    
                    </tr>                 

            ");       
        
        try{
            $result = mysqli_query($link, $query);
            while ($data = mysqli_fetch_array($result)){
                $num = $data["num"];
                $regist_day = $data["item_regist_day"];
                $item_img_0 = $data["item_img_0"];
                
                
                echo ("
                        <tr>
                            <td width='70%'><a href='./shop/shop_view.php?num=$num&page=1'><img width='150px' height='100px' src='./item/$item_img_0'></a></td>
                            <td>$regist_day</td>    
                        </tr> 
                ");              
            }
            echo ("
                </table>         

            ");  
        } catch (Exception $ex) {
            print"오류:".$ex->getMessage();
        }        
    }
   
?>
