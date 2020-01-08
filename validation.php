<?
    class Validator{
        private static $ErrorModel;

        public static function AddError(string $name, string $message = "", $value = null){
            if($ErrorModel == null){
                $ErrorModel = array();
            }
            $error = new ErrorModel();
            $error->$name = $name;
            $error->$message = $message;
            $error->$value = $value;

            array_push($ErrorModel, $error);
        }

        public static function GetJSON(): string{
            if(!isset($ErrorModel)){
                return "[]";
            }
            return json_encode($ErrorModel);
        }
    }

    class ErrorModel{
        public $name;
        public $message;
        public $value;
    }
?>