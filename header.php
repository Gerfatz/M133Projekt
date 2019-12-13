<?
    require_once("configuration.php");

    function GetHeader(): string
    {
        $url = GetConfigValue("url");

        return GetPartial("_header", array(
            "title" => $url,
            "url" => $url
        ));
    }
?>