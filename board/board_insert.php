<?php session_start(); ?>
<meta charset="utf-8">
<?php
    if(!isset($_SESSION["id"])) {
?>
        <script>
            alert('로그인 후 이용해 주세요.');
            history.back();
        </script>
<?php
    }
    /*
     *  매개변수 받기.
     */
    if(isset($_REQUEST["mode"]))  //modify_form에서 호출할 경우
        $mode=$_REQUEST["mode"];
    else 
        $mode="";

    if(isset($_REQUEST["num"]))
        $num=$_REQUEST["num"];
    else 
        $num="";

    if(isset($_REQUEST["html_ok"]))  //checkbox는 체크해야 변수명 전달됨.
        $html_ok=$_REQUEST["html_ok"];
    else
        $html_ok="";

    $subject=$_REQUEST["subject"];
    $content=$_REQUEST["content"];
    
    /*
     * 디렉토리에 파일을 업로드함.
     */
        $files = $_FILES["upfile"];    //첨부파일	
        $count = count($files["name"]); 
        $upload_dir = 'C:\xampp\htdocs\shhan\data\\';   //물리적 저장위치. 윈도우는   '를 \'로 해야 인식함.  
//        $upload_dir = '"../data/"';   //물리적 저장위치      //물리적 저장위치. 윈도우는   '를 \'로 해야 인식함.  
        for ($i=0; $i<$count; $i++){
            $upfile_name[$i]     = $files["name"][$i];         //교재 190페이지 참조
            $upfile_tmp_name[$i] = $files["tmp_name"][$i];
            $upfile_type[$i]     = $files["type"][$i];
            $upfile_size[$i]     = $files["size"][$i];
            $upfile_error[$i]    = $files["error"][$i];
            $file = explode(".", $upfile_name[$i]); //.을 기준으로 쪼갬 abc.jpg -> abc  jpg 로 분리
            $file_name = $file[0];
            $file_ext  = $file[1];

            if (!$upfile_error[$i]){// 에러가 발생하지 않음 -> 부정 -> 참.
                $new_file_name = date("Y_m_d_H_i_s");
                $new_file_name = $new_file_name."_".$i;
                $copied_file_name[$i] = $new_file_name.".".$file_ext;

                $uploaded_file[$i] = $upload_dir.$copied_file_name[$i];

                if( $upfile_size[$i]  > 5000000 ) {                
                    print("
                        <script>
                            alert('업로드 파일 크기가 지정된 용량(5MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
                            history.back();
                        </script>
                       ");
                       exit;
                }

//                if ( ($upfile_type[$i] != "image/gif") && ($upfile_type[$i] != "image/jpeg")){
//                    print(" <script>
//                                 alert('JPG와 GIF 이미지 파일만 업로드 가능합니다!');
//                                 history.back();
//                               </script>");
//                        exit;
//                        }

                if (!move_uploaded_file($upfile_tmp_name[$i], $uploaded_file[$i]) ){
                    print("
                        <script>
                            alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
                            history.back();
                        </script>");
                        exit;
               }
            }
        }        
    
    
    
    require_once '../common/MyDB.php';
    $pdo = db_connect();
    $db_name = db_name();
    
    if($mode=="modify"){ // delete checked item 및 수정.
        $num_checked = count($_REQUEST['del_file']);
        $position = $_REQUEST['del_file'];
        
        for($i=0; $i<$num_checked;$i++){
            $index = $position[$i];
            $del_ok[$index] = "y";
        }
        try{
            $sql = "select * from $db_name.shhan_board where num = ?";  // get target record
            $stmh = $pdo->prepare($sql); 
            $stmh->bindValue(1,$num,PDO::PARAM_STR); 
            $stmh->execute(); 
            $row = $stmh->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $Exception) {
            $pdo->rollBack();
            print "오류: ".$Exception->getMessage();
        }
        for ($i=0; $i<$count; $i++){
            $field_org_name = "file_name_".$i;
            $field_real_name = "file_copied_".$i;
            $org_name_value = $upfile_name[$i];
            $org_real_value = $copied_file_name[$i];
            if ($del_ok[$i] == "y"){
                $delete_field = "file_copied_".$i;
                $delete_name = $row[$delete_field];

                $delete_path = $upload_dir.$delete_name;
                unlink($delete_path);

                try{
                    $pdo->beginTransaction(); 
                    $sql = "update $db_name.shhan_board set $field_org_name = ?, $field_real_name = ?  where num=?";
                    $stmh = $pdo->prepare($sql); 
                    $stmh->bindValue(1, $org_name_value, PDO::PARAM_STR); 
                    $stmh->bindValue(2, $org_real_value, PDO::PARAM_STR);  
                    $stmh->bindValue(3, $num, PDO::PARAM_STR);     
                    $stmh->execute();
                    $pdo->commit(); 
                } catch (PDOException $Exception) {
                    $pdo->rollBack();
                    print "오류: ".$Exception->getMessage();
                }             
            }
            else  {
                if (!$upfile_error[$i]){
                    try{
                        $pdo->beginTransaction(); 
                        $sql = "update $db_name.shhan_board set $field_org_name = ?, $field_real_name = ?  where num=?";
                        $stmh = $pdo->prepare($sql); 
                        $stmh->bindValue(1, $org_name_value, PDO::PARAM_STR);  
                        $stmh->bindValue(2, $org_real_value, PDO::PARAM_STR);  
                        $stmh->bindValue(3, $num, PDO::PARAM_STR);     
                        $stmh->execute();
                        $pdo->commit(); 
                    } catch (PDOException $Exception) {
                        $pdo->rollBack();
                        print "오류: ".$Exception->getMessage();
                    }      					
                }
            }
        }
        
        
        /*
         * 내용수정.
         */        
        try{
            $pdo->beginTransaction();   
            $sql = "update $db_name.shhan_board set subject=?, content=?, is_html=? where num=?";
            $stmh = $pdo->prepare($sql); 
            $stmh->bindValue(1, $subject, PDO::PARAM_STR);  
            $stmh->bindValue(2, $content, PDO::PARAM_STR);  
            $stmh->bindValue(3, $html_ok, PDO::PARAM_STR);     
            $stmh->bindValue(4, $num, PDO::PARAM_STR);   
            $stmh->execute();
            $pdo->commit(); 
        }
        catch (PDOException $Exception) {
            $pdo->rollBack();
            print "오류: ".$Exception->getMessage();
        }

    } else { //신규 생성.
        $depth = 0;   // depth, ord 를 0으로 초기화
        $ord = 0;
        $hit = 0;
        
        if ($html_ok =="y"){
            $is_html = "y";
        } else {
            $is_html = "";
            $content = htmlspecialchars($content); //htmlspecialchars()= 특수문자를 html에 맞게 시켜준다.
        }
        try{
            $pdo->beginTransaction();
            $sql =   "insert into $db_name.shhan_board";
            $sql .=  "( depth, ord, id, nick, subject, content, regist_day, hit, is_html, ";
            $sql .=  "file_name_0,file_name_1,file_name_2, file_type_0,  file_type_1, file_type_2, file_copied_0, file_copied_1, file_copied_2 ) ";
            $sql .=  "values (?,?,?, ?,?,?, now(),?,?, ?,?,?, ?,?,?, ?,?,? )" ;
            $stmh = $pdo->prepare($sql); 
            $stmh->bindValue(1, $depth, PDO::PARAM_STR);  
            $stmh->bindValue(2, $ord, PDO::PARAM_STR);  
            $stmh->bindValue(3, $_SESSION["id"], PDO::PARAM_STR);   
            $stmh->bindValue(4, $_SESSION["nick"], PDO::PARAM_STR);  
            $stmh->bindValue(5, $subject, PDO::PARAM_STR);  
            $stmh->bindValue(6, $content, PDO::PARAM_STR);            
//            $stmh->bindValue(7, $regist_day, PDO::PARAM_STR);            
            $stmh->bindValue(7, $hit, PDO::PARAM_STR);    
            $stmh->bindValue(8, $is_html, PDO::PARAM_STR);
            
            $stmh->bindValue(9, $upfile_name[0], PDO::PARAM_STR);  
            $stmh->bindValue(10, $upfile_name[1], PDO::PARAM_STR);  
            $stmh->bindValue(11, $upfile_name[2], PDO::PARAM_STR);   
            $stmh->bindValue(12, $upfile_type[0], PDO::PARAM_STR);  
            $stmh->bindValue(13, $upfile_type[1], PDO::PARAM_STR); 
            $stmh->bindValue(14, $upfile_type[2], PDO::PARAM_STR);       
            $stmh->bindValue(15, $copied_file_name[0], PDO::PARAM_STR);  
            $stmh->bindValue(16, $copied_file_name[1], PDO::PARAM_STR);  
            $stmh->bindValue(17, $copied_file_name[2], PDO::PARAM_STR);        
            $stmh->execute();
            //group_num 을 얻기 위해.
            $lastId = $pdo->lastInsertId();   //PHP 7.0 수정됨. Auto_Increment num필드값 (최신값.)
            $pdo->commit(); 
            
            /*
             * group_num넣기.
             */
            $pdo->beginTransaction();   
            $sql = "update $db_name.shhan_board set group_num = ? where num=?";
            $stmh1 = $pdo->prepare($sql); 
            $stmh1->bindValue(1, $lastId, PDO::PARAM_STR);  
            $stmh1->bindValue(2, $lastId, PDO::PARAM_STR);  
            $stmh1->execute();
            $pdo->commit(); 
        }
        catch (PDOException $Exception) {
            $pdo->rollBack();
                       
            print "오류: ".$Exception->getMessage();
        } 
//        header("Location:http://localhost/shhan/board/board_list.php");
        ?>
            <script>
               location.href = "./board_list.php";               
           </script>
    <?php
    }
    