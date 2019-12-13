<?session_start();
    require_once("partials.php");
    require_once("navigation.php");
    require_once("header.php");
?>
<!doctype html>
<html>
    <head>
        <?
            echo GetHeader()
        ?>
    </head>
    <body>
        <?
            echo GetNavigation();
        ?>
    </body>
</html>
