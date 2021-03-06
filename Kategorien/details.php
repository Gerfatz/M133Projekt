<?
    session_start();

    require_once("../functions.php");
    require_once(GetPath() . "BusinessLogic/ViewModels/CategoryViewModel.php");
    require_once(GetPath() . "BusinessLogic/Repositories/CategoryRepository.php");
    require_once(GetPath() . "BusinessLogic/ViewModels/PostViewModel.php");
    require_once(GetPath() . "BusinessLogic/Repositories/PostRepository.php");
    require_once(GetPath() . "header.php");
    require_once(GetPath() . "navigation.php");
    require_once(GetPath() . "configuration.php");
    require_once(GetPath() . "partials.php");

    $category;

    $userId = 0;

    if(isset($_SESSION["UserId"])){
        $userId = $_SESSION["UserId"];
    }

    if(!isset($_GET["categoryId"])){
        header("location:" . GetConfigValue("url") . "/Kategorien");
    }
    else{
        $catRepo = new CategoryRepository();
        $category = $catRepo->GetCategoryById($_GET["categoryId"], $userId);
        $postRepo = new PostRepository();
        $posts = $postRepo->GetAllPostsFromCategory($category->Id, $userId); 
        $categoryJson = json_encode($category);
    }
?>
<!doctype html>
<html>
    <head>
        <?
            echo GetHeader($category->Name);
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
                        <h2 class="card-title" ref="title">
                            <? echo $category->Name?>
                        </h2>
                        <p><?echo $category->Description?></p>
                        <? 
                            echo GetPartial("_createPostModal", array(
                                "url" => GetConfigValue("url"),
                                "categoryId" => $category->Id,
                                "categoryName" => $category->Name 
                            )); 
                        ?>
                        <button ref="create-post" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                        <script>
                            CategoryUI.renderCategory(document.currentScript.parentElement, JSON.parse('<?echo $categoryJson?>'));
                        </script>
                    </div>
                </div>

                <?
                    foreach ($posts as $post) {
                        $args = (array) $post;
                        $args["url"] = GetConfigValue("url");

                        if(!isset($args["Rating"])){
                            $args["Rating"] = 0;
                        }

                        echo GetPartial("_post", $args);
                    }
                ?>
            </div>
    </body>
</html>