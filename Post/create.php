<?
    session_start();

    include_once("../functions.php");
    include_once(GetPath() . "/BusinessLogic/Repositories/PostRepository.php");
    include_once(GetPath() . "security.php");
    include_once(GetPath() . "configuration.php");

    RerouteUnauthenticated();

    if(!isset($_FILES["picture"]) || !isset($_POST["title"]) || !isset($_POST["category"])){
        http_response_code(400);
    }
    else{
        $ext = strtolower(end(explode('.',$_FILES["picture"]["name"])));
        $path = GetPath(). "Images/". com_create_guid() . ".$ext";
        move_uploaded_file($_FILES["picture"]["tmp_name"], $path);
        
        $repo = new PostRepository();
        $model = new PostViewModel();
        $model->CreatorId = $_SESSION["UserId"];
        $model->CategoryId = $_POST["category"];
        $model->Title = $_POST["title"];
        $model->PicturePath = $path;
        $repo->Save($model);

        header("location:" . GetConfigValue("url"));
    }

    
?>