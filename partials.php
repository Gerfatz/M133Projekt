<?
    function GetPartial(string $partialName, $arguments = null): string{
        $html = file_get_contents("partials/" . $partialName . ".html");

        if($arguments != null){
            foreach ($arguments as $arg => $rep) {
                $html = str_replace("%" . $arg . "%", $rep, $html);
            }
        }

        return $html;
    }
?>