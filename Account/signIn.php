<?
    session_start();

    require_once("../functions.php");
    require_once(GetPath() . "BusinessLogic/User.php");
    require_once(GetPath() . "BusinessLogic/Repositories/UserRepository.php");
    require_once(GetPath() . "configuration.php");

    if(array_key_exists("username", $_POST) && array_key_exists("password", $_POST)){
        $repo = new UserRepository();
        $user = $repo->GetUserByUsername($_POST["username"]);
        if($user->VerifyPassword($_POST["password"])){
            $_SESSION["UserId"] = $user->GetId();
            header("Location: " . GetConfigValue("url"));
        }
        else{
            $username = $_POST["username"];
            header("Location: ". GetConfigValue("url") . "/Account/login.php?username=$username");
        }
    }
    else{
        header("Location: ". GetConfigValue("url") . "/Account/login.php");
    }
?>