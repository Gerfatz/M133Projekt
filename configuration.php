<?
    require_once("functions.php");

    function GetConfigValue(string $key){
        $json = json_decode(file_get_contents(GetPath() . "config.json"), true);
        return $json[$key];
    }
?>