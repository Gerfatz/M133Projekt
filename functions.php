<?
    function GetDirectoryFromPath(string $filepath): string{
        $beginOfFileName = strripos($filepath, "\\");
        return substr($filepath, 0, $beginOfFileName);
    }

    function GetPath(): string{
        return $_SERVER["DOCUMENT_ROOT"] . "/MemeIo/";
    }
?>