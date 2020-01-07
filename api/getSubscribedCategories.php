<?
    session_start();

    include_once("../functions.php");
    include_once(GetPath() . "BusinessLogic/Repositories/CategoryRepository.php");
    include_once(GetPath() . "BusinessLogic/ViewModels/CategoryViewModel.php");

    if(!isset($_SESSION["UserId"])){
        http_response_code(401);
    }
    else{
        $repo = new CategoryRepository();
        $categories = $repo->GetSubscribedCategories($_SESSION["UserId"]);
        echo json_encode($categories);
    }
?>