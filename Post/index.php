<?session_start();
    require_once("../functions.php");
    require_once(GetPath() . "partials.php");
    require_once(GetPath() . "navigation.php");
    require_once(GetPath() . "header.php");
    require_once(GetPath() . "configuration.php");
    require_once(GetPath() . "BusinessLogic/Repositories/PostRepository.php");
    require_once(GetPath() . "BusinessLogic/ViewModels/PostViewModel.php");

    $userId = 0;

    if(isset($_SESSION["UserId"])){
        $userId = $_SESSION["UserId"];
    }

    $repo = new PostRepository();
    $posts = null;

    if(isset($_GET["query"])){
        $posts = $repo->GetPostPage($userId, $_GET["query"]);
    }
    else{
        $posts = $repo->GetPostPage($userId);
    }

?>
<!doctype html>
<html>
    <head>
        <?
            echo GetHeader("Posts");
        ?>
    </head>
    <body>
        <?
            echo GetNavigation();
        ?>
        <div class="row d-flex justify-content-center">
        <div class="col-md-8 col-12">
            <?
                foreach ($posts as $post) {
                    $args = (array)$post;
                    $args["url"] = GetConfigValue("url");
                    echo GetPartial("_post", $args);
                }
            ?>
        </div>
    </div>
    </body>
</html>