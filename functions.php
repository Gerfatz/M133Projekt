<?
    function GetDirectoryFromPath(string $filepath): string{
        $beginOfFileName = strripos($filepath, "\\");
        return substr($filepath, 0, $beginOfFileName);
    }
?>