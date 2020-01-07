<?
    session_start();

    include_once("../functions.php");
    include_once(GetPath() . "/BusinessLogic/Repositories/PostRepository.php");
    include_once(GetPath() . "/BusinessLogic/Repositories/CategoryRepository.php");
    include_once(GetPath() . "security.php");
    include_once(GetPath() . "configuration.php");

    RerouteUnauthenticated();

    if(!isset($_FILES["picture"]) || !isset($_POST["title"]) || !isset($_POST["category"])){
        http_response_code(400);
    }
    else{
        $categoryRepo = new CategoryRepository();
        $category = $categoryRepo->GetCategoryById($_POST["category"]);
        $ext = strtolower(end(explode('.',$_FILES["picture"]["name"])));
        $filename = GetGUID() . ".$ext";
        $path = GetPath(). "Images/". $category->Name . "/" . $filename;
        move_uploaded_file($_FILES["picture"]["tmp_name"], $path);
        
        $repo = new PostRepository();
        $model = new PostViewModel();
        $model->CreatorId = $_SESSION["UserId"];
        $model->CategoryId = $_POST["category"];
        $model->Title = $_POST["title"];
        $model->FileName = $filename;
        $repo->Save($model);

        header("location:" . GetConfigValue("url"));
    }

    
?>