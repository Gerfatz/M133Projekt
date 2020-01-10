<?
    session_start();
    //Add Validation
    
    require_once("../functions.php");
    require_once(GetPath() . "BusinessLogic/ViewModels/UserViewModel.php");
    require_once(GetPath() . "BusinessLogic/Repositories/UserRepository.php");
    require_once(GetPath() . "configuration.php");
    require_once(GetPath() . "navigation.php");
    require_once(GetPath() . "header.php");
    require_once(GetPath() . "validation.php");

    if(array_key_exists("username", $_POST) && array_key_exists("password", $_POST)){
        $repo = new UserRepository();

        $user = $repo->CreateNewUser($_POST["username"], $_POST["password"]);
    
        if($user != null){
            $_SESSION["UserId"] = $user->Id;

            header("Location: " . GetConfigValue("url"));
        }
        Validator::Result();

    }
?>