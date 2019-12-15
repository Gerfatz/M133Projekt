<?session_start();
    require_once("functions.php");
    require_once(GetPath() . "partials.php");
    require_once(GetPath() . "navigation.php");
    require_once(GetPath() . "header.php");
?>
<!doctype html>
<html>
    <head>
        <?
            echo GetHeader("Home");
        ?>
    </head>
    <body>
        <?
            echo GetNavigation();
        ?>
    </body>
</html>
