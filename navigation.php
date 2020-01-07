<?
    require_once(GetPath() . "partials.php");
    require_once(GetPath() . "BusinessLogic/ViewModels/UserViewModel.php");
    require_once(GetPath() . "BusinessLogic/Repositories/UserRepository.php");
    require_once(GetPath() . "configuration.php");

    function GetNavigation(): string{
        $partialData = array(
            "url" => GetConfigValue("url")
        );

        if(isset($_SESSION["UserId"])){
            $repo = new UserRepository();
            $userId = $_SESSION["UserId"];

            $partialData["AccountControl"] = GetPartial("_accountControl", array(
                "userId" => $userId,
                "username" => $repo->GetUserById($userId)->Username,
                "url" => GetConfigValue("url")
            ));
        }
        else{
            $partialData["AccountControl"] = GetPartial("_loginOptions", array("url" => GetConfigValue("url")));
        }
                
        return GetPartial("_navigation", $partialData);
    }
?>