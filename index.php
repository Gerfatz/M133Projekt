<?session_start();
    require_once("partials.php");
    require_once("navigation.php");
?>
<!doctype html>
<html>
    <head>
        <?
            echo GetPartial("_header", array(
                "title" => "Home"
            ));
        ?>
    </head>
    <body>
        <?
            echo GetNavigation();
        ?>
    </body>
</html>
