<?
    class Validator{
        public static function AddError(string $name, string $message = "", $value = null){
            if(!isset($_SESSION["Error"])){
                $_SESSION["Error"] = array();
            }
            $error = new ErrorModel();
            $error->name = $name;
            $error->message = $message;
            $error->value = $value;

            array_push($_SESSION["Error"], $error);
        }

        public static function HasErrors(): bool{
            return isset($_SESSION["Error"]) && sizeof($_SESSION["Error"]) != 0;
        }

        public static function GetJSON(): string{
            if(!isset($_SESSION["Error"])){
                return "[]";
            }
            $res = json_encode($_SESSION["Error"]);
            $_SESSION["Error"] = null;
            return $res;
        }

        public static function Result(){
            $headers = getallheaders();

            if(Validator::HasErrors() && isset($headers["Referer"])){
                header("location:". $headers["Referer"]);
            }
        }
    }

    class ErrorModel{
        public $name;
        public $message;
        public $value;
    }
?>