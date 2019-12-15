<?
    require_once("../functions.php");
    require_once(GetPath() . "BusinessLogic/Repositories/UserRepository.php");

    if(array_key_exists("username", $_GET)){
        $repo = new UserRepository();

        if($repo->IsUsernameAvailable($_GET["username"])){
            echo "1";
        }
        else{
            echo "0";
        }
    }
?>