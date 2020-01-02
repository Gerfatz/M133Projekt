<?
    session_start();

    require_once("../functions.php");
    require_once(GetPath() . "BusinessLogic/Repositories/CategoryRepository.php");
    require_once(GetPath() . "BusinessLogic/ViewModels/CategoryViewModel.php");
    require_once(GetPath() . "header.php");
    require_once(GetPath() . "navigation.php");
    require_once(GetPath() . "security.php");
    require_once(GetPath() . "configuration.php");

    RerouteUnauthenticated();

    if(array_key_exists("name", $_POST) && array_key_exists("description", $_POST) && isset($_SESSION["UserId"])){
        $repo = new CategoryRepository();
        $category = $repo->CreateNewCategory($_POST["name"], $_SESSION["UserId"], $_POST["description"]);
        header("location:" . GetConfigValue("url") . "/Kategorien/details.php?categoryId=". $category->Id);
    }
?>
<!doctype html>
<html>
    <head>
        <?
            echo GetHeader("Neue Kategorie");
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
                        <h2 class="card-title">Neue Kategorie erstellen</h2>
                        <form action="create.php" method="POST">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" type="text" name="name" id="name"/>
                            </div>
                            <div class="form-group">
                                <label for="description">Beschreibung</label>
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                            <button class="btn btn-primary">Erstellen</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>