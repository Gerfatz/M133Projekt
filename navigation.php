<?
    require_once("partials.php");
    require_once("BusinessLogic/User.php");
    require_once("BusinessLogic/DBContext.php");

    function GetNavigation():string{
        $partialData = array();

        if(isset($_SESSION["UserId"])){
            $datacontext = new DBContext();
            $userId = $_SESSION["UserId"];

            $partialData["AccountControl"] = GetPartial("_accountControl", array(
                "userId" => $userId,
                "username" => $datacontext->GetUserById($userId)->GetUsername()
            ));
        }
        else{
            $partialData["AccountControl"] = GetPartial("_loginOptions");
        }
                
        return GetPartial("_navigation", $partialData);
    }
?>