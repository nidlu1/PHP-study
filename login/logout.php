<?php
    session_start();
    unset($_SESSION["id"]);
    unset($_SESSION["pw"]);
    unset($_SESSION["nick"]);
    unset($_SESSION["tel"]);
    unset($_SESSION["email"]);
    unset($_SESSION["level"]);
    unset($_SESSION["cash"]);
    unset($_SESSION["mileage"]);  
    
    header("Location:http://localhost/shhan/index.php");
?>