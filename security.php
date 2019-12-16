<?
    require_once(GetPath() . "configuration.php");

    function RerouteUnauthenticated(){
        if(!array_key_exists("UserId", $_SESSION)){
            header("location:" . GetConfigValue("url") . "/Account/login.php");
        }
    }
?>