<?
    require_once(GetPath() . "functions.php");

    function GetPartial(string $partialName, $arguments = null): string{
        $html = file_get_contents(GetPath(). "partials/" . $partialName . ".html");

        if($arguments != null){
            foreach ($arguments as $arg => $rep) {
                $html = str_replace("%" . $arg . "%", $rep, $html);
            }
        }

        return $html;
    }
?>