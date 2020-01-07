<?
    session_start();

    require_once("../functions.php");
    require_once(GetPath() . "header.php");
    require_once(GetPath() . "navigation.php");
    require_once(GetPath() . "partials.php");
    require_once(GetPath() . "configuration.php");
    require_once(GetPath() . "BusinessLogic/Repositories/UserRepository.php");
    require_once(GetPath() . "BusinessLogic/ViewModels/UserViewModel.php");
    require_once(GetPath() . "BusinessLogic/Repositories/PostRepository.php");
    require_once(GetPath() . "BusinessLogic/ViewModels/PostViewModel.php");


    $userId = 0;
    $viewingUserId = 0;

    if(!isset($_GET["userId"]) && !isset($_SESSION["UserId"])){
        http_response_code(400);
        
    }
    else if (!isset($_GET["userId"])){
        $viewingUserId = $userId = $_SESSION["UserId"];
    }
    else{
        $userId = $_GET["userId"];
        $viewingUserId = $_SESSION["UserId"];
    }

    $repo = new UserRepository();
    $user = $repo->GetUserById($userId);
    $repo = new PostRepository();
    $posts = $repo->GetPostsFromUser($userId, $viewingUserId);
?>
<!doctype html>
<html>
    <head>
        <? echo GetHeader("Account - " . $user->Username); ?>
    </head>
    <body>
        <? echo GetNavigation(); ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-2">
                    <div class="card-body">
                        <h4 class="card-title"><?echo $user->Username?></h4>
                        <small><?echo sizeof($posts)?> Posts</small>
                    </div>
                </div>
            </div>
            <?
                foreach ($posts as $post) {
                    $data = (array)$post;
                    $data["url"] = GetConfigValue("url");
                    echo "<div class=\"col-md-8\">" . GetPartial("_Post", $data) . "</div>";
                }
            ?>
        </div>
    </body>
</html>
