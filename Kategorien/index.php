<?
    session_start();

    require_once("../functions.php");
    require_once(GetPath() . "BusinessLogic/Category.php");
    require_once(GetPath() . "header.php");
    require_once(GetPath() . "navigation.php");
    require_once(GetPath() . "configuration.php");
?>
<!doctype html>
<html>
    <head>
        <?
            echo GetHeader("Kategorien");
        ?>
    </head>
    <body>
        <?
            echo GetNavigation();
        ?>
        <div class="row d-flex justify-content-center px-2">
            <div class="col-md-8 col-12 my-2">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Kategorien <a class="float-right" href="create.php"><i class="fa fa-plus"></i></a></h2>
                        <p>
                            Im folgenden sind alle Kategorien aufgelistet. Sie können diese Abonnieren und erhalten so die besten Post auf ihre Startseite. Sie können, falls sie keine passende finden, auch selbst eine erstellen.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <ul class="list-group">
            
        </ul>
    </body>
</html>