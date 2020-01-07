<?
    session_start();

    require_once("../functions.php");
    require_once(GetPath() . "BusinessLogic/ViewModels/CategoryViewModel.php");
    require_once(GetPath() . "BusinessLogic/Repositories/CategoryRepository.php");
    require_once(GetPath() . "header.php");
    require_once(GetPath() . "navigation.php");
    require_once(GetPath() . "configuration.php");
    require_once(GetPath() . "partials.php");


    $repo = new CategoryRepository();
    $userId = 0;

    if(isset($_SESSION["UserId"])){
        $userId = $_SESSION["UserId"];
    }

    $categories = $repo->GetAllCategories($userId);
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
        <div class="row d-flex justify-content-center px-2 m-0">
            <div class="col-md-8 col-12 my-2">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Kategorien <a class="float-right" href="create.php"><i class="fa fa-plus"></i></a></h2>
                        <p>
                            Im folgenden sind alle Kategorien aufgelistet. Sie können diese Abonnieren und erhalten so die besten Post auf ihre Startseite. Sie können, falls sie keine passende finden, auch selbst eine erstellen.
                        </p>
                    </div>
                    <ul class="list-group">
                        <?
                            $url = GetConfigValue("url"); 
                            foreach ($categories as $category){
                            ?>
                                <li class="list-group-item list-group-item-action" >
                                    <h4 ref="title">
                                        <?echo $category->Name?>    
                                    </h4>
                                    <p>
                                        <?echo $category->Description?>
                                    </p>
                                    <script>
                                        CategoryUI.renderCategory(document.currentScript.parentElement, JSON.parse('<?echo json_encode($category)?>'), true);
                                    </script>
                                </li>
                            <?
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>