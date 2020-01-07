<?
    session_start();
    //Add Validation
    
    require_once("../functions.php");
    require_once(GetPath() . "BusinessLogic/ViewModels/UserViewModel.php");
    require_once(GetPath() . "BusinessLogic/Repositories/UserRepository.php");
    require_once(GetPath() . "configuration.php");
    require_once(GetPath() . "navigation.php");
    require_once(GetPath() . "header.php");

    if(array_key_exists("username", $_POST) && array_key_exists("password", $_POST)){
        $repo = new UserRepository();

        $user = $repo->CreateNewUser($_POST["username"], $_POST["password"]);
        
        if($user == null){
            echo GetHeader("Benutzername nicht Verfügbar");
            echo GetNavigation();

            ?>
                <h4>Der gewünschte Benutzername ist leider nicht mehr verfügbar</h4>
                <a class="btn btn-primary" href="register.php">Zurück zur Registrierung</a>;
            <?
        }
        else{
            $_SESSION["UserId"] = $user->Id;

            header("Location: " . GetConfigValue("url"));
        }
    }
?>