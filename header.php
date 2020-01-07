<?
    require_once(GetPath() . "configuration.php");

    function GetHeader(string $title): string
    {
        return GetPartial("_header", array(
            "title" => $title,
            "url" => GetConfigValue("url")
        ));
    }
?>