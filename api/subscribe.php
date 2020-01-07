<?
    session_start();

    require_once("../functions.php");
    require_once(GetPath() . "BusinessLogic/Repositories/CategoryRepository.php");

    $data = json_decode(file_get_contents("php://input"), true);

    if(!isset($_SESSION["UserId"])){
        http_response_code(401);
    }
    else if (!isset($data["categoryId"])){
        http_response_code(400);
    }
    else{
        $repo = new CategoryRepository();
        $catId = $data["categoryId"];

        //Falls noch nicht abonniert => Abonnieren
        if(!$repo->IsSubscribed($_SESSION["UserId"], $catId)){
            $repo->Subscribe($_SESSION["UserId"], $catId);
            echo 1;
        }
        //Sonst Deabonnieren
        else{
            $repo->Unsubscribe($_SESSION["UserId"], $catId);
            echo 0;
        }
    }
?>