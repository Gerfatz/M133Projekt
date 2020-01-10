<?session_start();
    require_once("functions.php");
    require_once(GetPath() . "partials.php");
    require_once(GetPath() . "navigation.php");
    require_once(GetPath() . "header.php");
    require_once(GetPath() . "configuration.php");
    require_once(GetPath() . "BusinessLogic/Repositories/PostRepository.php");
    require_once(GetPath() . "BusinessLogic/ViewModels/PostViewModel.php");

    $repo = new PostRepository();
    $posts = null;

    if(isset($_SESSION["UserId"])){
        $posts = $repo->GetHomePage($_SESSION["UserId"]);
    }
    else{
        $posts = $repo->GetHomePage();
    }
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
        <div class="row d-flex justify-content-center">
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Wilkommen</h2>
                    <p>Dies ist die Startseite. Hier siehst du die angesagtesten Posts deiner Abonnierten Kategorien.</p>
                    <p>Wenn du die Post aller Kategorien sehen willst, kannst du dies jeder Zeit unter <a href="<?echo GetConfigValue("url")?>/Post/index.php">Posts</a> machen.</p>
                </div>
            </div>

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
