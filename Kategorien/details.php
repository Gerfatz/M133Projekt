<?
    session_start();

    require_once("../functions.php");
    require_once(GetPath() . "BusinessLogic/Category.php");
    require_once(GetPath() . "BusinessLogic/Repositories/CategoryRepository.php");
    require_once(GetPath() . "header.php");
    require_once(GetPath() . "navigation.php");
    require_once(GetPath() . "configuration.php");

    $category;

    if(!isset($_GET["categoryId"])){
        header("location:" . GetConfigValue("url") . "/Kategorien");
    }
    else{
        $repo = new CategoryRepository();
        $category = $repo->GetCategoryById($_GET["categoryId"]);
    }
?>
<!doctype html>
<html>
    <head>
        <?
            echo GetHeader($category->GetName());
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
                        <h2 class="card-title">
                            <? echo $category->GetName()?>
                            <? 
                                if(isset($_SESSION["UserId"]) && $category->GetOwnerId() == $_SESSION["UserId"]){
                                    ?>
                                        <a class="float-right" href="<?echo GetConfigValue("url")?>/Kategorien/edit.php?categoryId=<?echo $category->GetId()?>">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    <?
                                }
                            ?>
                        </h2>
                        <p><?echo $category->GetDescription()?></p>
                    </div>
                </div>
            </div>
    </body>
</html>