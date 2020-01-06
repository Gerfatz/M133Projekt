<?
    session_start();

    $_SESSION = array();

    require_once("../configuration.php");

    header("location:". GetConfigValue("url"));
?>