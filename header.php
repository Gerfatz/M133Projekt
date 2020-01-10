<?
    require_once(GetPath() . "configuration.php");
    require_once(GetPath() . "validation.php");

    function GetHeader(string $title): string
    {
        return GetPartial("_header", array(
            "title" => $title,
            "url" => GetConfigValue("url"),
            "isLoggedIn" => isset($_SESSION["UserId"]) ? "true" : "false",
            "errors" => Validator::GetJSON()
        ));
    }
?>