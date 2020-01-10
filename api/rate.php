<?
    session_start();

    require_once("../functions.php");
    require_once(GetPath() . "BusinessLogic/Repositories/PostRepository.php");
    require_once(GetPath() . "security.php");

    if(!isset($_SESSION["UserId"])){
        http_response_code(401);
    }

    if((!isset($_GET["postId"]) || !isset($_GET["rating"])) && $_GET["rating"] <= 5 && $_GET["rating"] > 0){
        http_response_code(400);
    }
    else{
        $repo = new PostRepository();
        $repo->SaveRating($_SESSION["UserId"], $_GET["postId"], $_GET["rating"]);
    }
    
?>