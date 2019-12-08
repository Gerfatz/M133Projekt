<?
    require "stdHtml.php";
?>
<!doctype html>
<html>
    <head>
        <?echo GetPartial("_header", array(
            "title" => "Home"
        ))?>
    </head>
    <body>
        <?echo GetPartial("_navigation")?>
    </body>
</html>
