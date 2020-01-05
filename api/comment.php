<?
    session_start();

    require_once("../functions.php");
    require_once(GetPath() . "BusinessLogic/ViewModels/CommentViewModel.php");
    require_once(GetPath() . "BusinessLogic/Repositories/PostRepository.php");
    require_once(GetPath() . "Security.php");

    $repo = new PostRepository();
    $userId = 0;

    if(isset($_SESSION["UserId"])){
        $userId = $_SESSION["UserId"];
    }
    
    switch($_SERVER['REQUEST_METHOD']){
        case "GET":
            
            if(!isset($_GET["postId"])){
                http_response_code(400);
            }
            else{
                $result = $repo->GetComments($_GET["postId"], $userId);
                echo json_encode($result);
            }
            break;
        case "POST":
        case "PUT":
            RerouteUnauthenticated();
            $data = file_get_contents('php://input');
            $model = json_decode($data, true);
            $model["CreatorId"] = $userId;
            $repo->SaveComment($model);
            break;
    }
?>