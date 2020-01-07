<?
    session_start();

    require_once("../functions.php");
    require_once(GetPath() . "BusinessLogic/ViewModels/UserViewModel.php");
    require_once(GetPath() . "BusinessLogic/Repositories/UserRepository.php");
    require_once(GetPath() . "configuration.php");

    if(array_key_exists("username", $_POST) && array_key_exists("password", $_POST)){
        $repo = new UserRepository();    
        $username = $_POST["username"];
        if(!$repo->IsUsernameAvailable($username)){
            $user = $repo->GetUserByUsername($username);

            if($user->passwordHash == $repo->HashPassword($_POST["password"])){
                $_SESSION["UserId"] = $user->Id;
                if($_POST["rememberUsername"]){
                    setcookie("Username", $user->Username);
                }
                else{
                    setcookie("Username", "", time()-60);
                }
                header("Location: " . GetConfigValue("url"));
            }
            else{
                header("Location: ". GetConfigValue("url") . "/Account/login.php?username=$username&message=2");
            }
        }
        else{
            header("Location: ". GetConfigValue("url") . "/Account/login.php?message=1");
        }
    }
    else{
        header("Location: ". GetConfigValue("url") . "/Account/login.php");
    }
?>