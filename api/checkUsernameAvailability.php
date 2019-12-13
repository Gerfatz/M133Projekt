<?
    require_once("../BusinessLogic/DBContext.php");

    if(array_key_exists("username", $_GET)){
        $db = new DBContext();

        if($db->Query("SELECT COUNT(username) as count FROM user WHERE username = " . $_GET["username"])["count"] == 0){
            echo "1";
        }
        else{
            echo "0";
        }
    }
?>