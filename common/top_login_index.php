<div id="top_login">
<?php
    if(!isset($_SESSION["id"]))	{
?>
        <br><br><br>
        <form method="post" name="loginForm" action="login/loginPro.php">
                    <input name="id" type="text" required placeholder="아이디를 입력하세요">
                    <br>
                    <input name="pw" type="password" required placeholder="비밀번호를 입력하세요">
                    <input type="submit" value="로그인하기">
        </form>    
        <a href="./user/writeForm.php">회원가입</a>
        <br>
        관리자정보: id:admin pw:1
<?php
    }else{
?>
	<?=$_SESSION["nick"]?> (level:<?=$_SESSION["level"]?>) | 
        <a href="./login/logout.php">로그아웃</a> | <a href="./user/writeForm.php?mode=modify&id=<?=$_SESSION["id"]?>">정보수정</a><br>
        <p>충전금액 : <?=$_SESSION["cash"]?> 원</p>
<?php
	}
?>
</div>
