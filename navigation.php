<?
    require_once(GetPath() . "partials.php");
    require_once(GetPath() . "BusinessLogic/User.php");
    require_once(GetPath() . "BusinessLogic/Repositories/UserRepository.php");

    function GetNavigation(): string{
        $partialData = array(
            "url" => GetConfigValue("url")
        );

        if(isset($_SESSION["UserId"])){
            $repo = new UserRepository();
            $userId = $_SESSION["UserId"];

            $partialData["AccountControl"] = GetPartial("_accountControl", array(
                "userId" => $userId,
                "username" => $repo->GetUserById($userId)->GetUsername()
            ));
        }
        else{
            $partialData["AccountControl"] = GetPartial("_loginOptions");
        }
                
        return GetPartial("_navigation", $partialData);
    }
?>