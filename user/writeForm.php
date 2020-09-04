<?php
   session_start();
    if(isset($_REQUEST["mode"]))  //수정 버튼을 클릭해서 호출했는지 체크
        $mode=$_REQUEST["mode"];
    else
        $mode="";
    
    if(isset($_REQUEST["id"])) 
        $id=$_REQUEST["id"];
    else
        $id="";
    
    if($mode=="modify"){
        try {
            require_once '../common/MyDB.php';
            $pdo = db_connect();
            $db_name = db_name();
            
            $sql = "select * from $db_name.shhan_user where id = ?";
            $stmh = $pdo->prepare($sql);
            $stmh->bindValue(1, $id, PDO::PARAM_STR);
            $stmh->execute();
            $count = $stmh->rowCount();
            
            if($count<1){
                print "검색결과가 없습니다.<br>";
            } else {
                $row = $stmh->fetch(PDO::FETCH_ASSOC);
                $id = $row["id"];
                $pw = $row["pw"];
                $nick = $row["nick"];
                $tel = $row["tel"];
                $email = $row["email"];                
            }            
        }
        catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }        
    }
 ?>
<!DOCTYPE HTML>
<html>
<head> 
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/common.css" >
</head>
<title>회원화면</title>
<script>
    var id_check = n;
    var nick_check = n;
    
    function reset_form(){
        document.shhan_user.id.value = "";
        document.shhan_user.pw.value = "";
        document.shhan_user.pw_confirm.value = "";
        document.shhan_user.nick.value = "";
        document.shhan_user.tel.value = "";
        document.shhan_user.email.value = "";
        document.shhan_user.id.focus();
        return;
    }
    function check_id(){
        if($mode!="modify"){
        window.open("check_id.php?id="+document.shhan_user.id.value,"IDcheck", "left=200,top=200,width=200,height=60,scrollbars=no,resizable=yes");
        }
        id_check = "y";
    } 
    function check_nick(){
        window.open("check_nick.php?nick="+document.shhan_user.nick.value, "NICKcheck", "left=200,top=200,width=200,height=60, scrollbars=no, resizable=yes");
        nick_check = "y";
    }
    function check_input() {
        
        if(document.shhan_user.pw.value != document.shhan_user.pw_confirm.value){
          alert("비밀번호가 일치하지 않습니다.\n다시 입력해주세요."); 
          document.shhan_user.pass.focus();
          document.shhan_user.pass.select();
          return;
        }
        if(document.shhan_user.pw.value == ""){
          alert("비밀번호를 입력하세요."); 
          return;
        }
        if(document.shhan_user.id.value == ""){
          alert("아이디를 입력하세요."); 
          return;
        }
        if(document.shhan_user.nick.value == ""){
          alert("닉네임을 입력하세요."); 
          return;
        }
        if(document.shhan_user.tel.value == ""){
          alert("전화번호를 입력하세요."); 
          return;
        }
        if(document.shhan_user.email.value == ""){
          alert("이메일을 입력하세요."); 
          return;
        }               
        if(id_check != "y"){
          alert("아이디 중복을 확인하세요"); 
          return;
        }               
        if(nick_check != "y"){
          alert("닉네임 중복을 확인하세요"); 
          return;
        }               
        document.shhan_user.submit();
   }
</script>
<body>
    <!--border:solid 1px #FF0000-->
    <div id="wrap">
        <div id="header">
            <div style="margin-right: 500px"><a href="http://localhost/shhan/index.php"><h1>쇼핑몰 프로젝트</h1></a></div> 
            <div>
                <?php include '../common/top_login.php'; ?>
            </div>
        </div>    
        <div id="content">    
            <div id="col1">
                <?php include '../common/left_menu.php'; ?>
            </div>
            <div id="col2">
<?php       
                if($mode=="modify"){                    
?>
                 <form name="shhan_user" method="post" action="writePro.php?mode=modify&id=<?=$id?>">
                    회원 내용 수정
<?php
                } else {
?>
                <form name="shhan_user" method="post" action="writePro.php"> 
                    회원 내용 입력
<?php              
                }
?>
                    <table>
                        <tr>
                            <td><br></td>
                        </tr>
                        <tr>
                            <td>아이디</td>
                            <td><input type="" name="id" required="" placeholder="아이디 입력하세요" <?php if($mode=="modify"){?> value="<?=$id?>" disabled=""<?php } ?>></td>
                            <td><?php if($mode!="modify"){?><a href="#"><img src="../img/check_id.gif" onclick="check_id()"></a> 4~12자의 영문 소문자,      숫자와 특수기호(_)만 사용할 수 있습니다. <?php } ?></td>
                        </tr>
                        <tr>
                            <td>비밀번호</td>
                            <td><input type="password" name="pw" required=""></td>                            
                        </tr>
                        <tr>
                            <td>비밀번호 확인</td>
                            <td><input type="password" name="pw_confirm" required=""></td>                            
                        </tr>
                        <tr>
                            <td>닉네임</td>
                            <td><input type="text" name="nick" required="" placeholder="닉네임 입력하세요" <?php if($mode=="modify"){?> value="<?=$nick?>"<?php } ?>"></td>
                            <td><a href="#"><img src="../img/check_id.gif" onclick="check_nick()"></a></td>                          
                        </tr>
                        <tr>
                            <td>전화번호</td>
                            <td><input type="tel"name="tel" required="" placeholder="123-4512-6178" pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}" <?php if($mode=="modify"){?> value="<?=$tel?>"<?php } ?>></td>                   
                            <td></td>
                        </tr>
                        <tr>
                            <td>이메일</td>
                            <td><input type="text" name="email" required="" placeholder="이메일 입력하세요" <?php if($mode=="modify"){?> value="<?=$email?>"<?php } ?>></td>   
                        </tr>   
                    </table>
                    <br>
                    ~전부 필수 입력사항입니다.~
                    <div>
                        <a href="#"><img src="../img/button_save.gif" onclick="check_input()"></a>&nbsp;&nbsp;
                        <a href="#"><img src="../img/button_reset.gif" onclick="reset_form()"></a>
                    </div>
               </form>
            </div> <!-- end of col2 -->            
        </div> <!-- end of content -->
    </div> <!-- end of wrap -->
    <p>&nbsp;</p><p>&nbsp;</p>
 </body>
 </html>