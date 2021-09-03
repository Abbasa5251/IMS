<?php
    session_start(); 

    $page = explode("/",$_SERVER["PHP_SELF"]);
    $page = $page[count($page)-1];
    $page = explode(".",$page)[0];

    if($page == "login"){
        if(isset($_SESSION["user"])){
            header("Location: index.php");
        }
    }
    else{
        if(!isset($_SESSION["user"])){
            header("Location: login.php");
        }
    }
?>