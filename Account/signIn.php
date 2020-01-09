<?
    session_start();

    require_once("../functions.php");
    require_once(GetPath() . "BusinessLogic/ViewModels/UserViewModel.php");
    require_once(GetPath() . "BusinessLogic/Repositories/UserRepository.php");
    require_once(GetPath() . "configuration.php");
    require_once(GetPath() . "validation.php");

    if(isset($_POST["username"]) && isset($_POST["password"])){
        $repo = new UserRepository();    
        $username = $_POST["username"];
        if(!$repo->IsUsernameAvailable($username)){
            $user = $repo->GetUserByUsername($username);

            if($user->PasswordHash == $repo->HashPassword($_POST["password"])){
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
                Validator::AddError("password", "Das angegebene Passwort ist falsch");
            }
        }
        else{
            Validator::AddError("username", "Es wurde kein Benutzer mit diesem Benutzernamen Gefunden", $username);
        }
    }
    else{
        header("Location: ". GetConfigValue("url") . "/Account/login.php");
    }

    Validator::Result();
?>