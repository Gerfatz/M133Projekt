<?
    require_once(GetPath() .  "BusinessLogic/Repositories/DBContext.php");

    abstract class RepositoryBase{
        protected $db;

        public function __construct(){
            $this->db = new DBContext();
        }

        public function EscapeString(&$obj){
            //parse passed in argument to an array
            $temp;

            if(gettype($obj) == "object"){
                $temp = (array)$obj;
            }
            else if(gettype($obj) == "string"){
                $temp = array($obj);
            }
            else if(gettype($obj) == "array"){
                $temp = $obj;
            }
            else{
                throw new InvalidArgumentException();
            }

            //Search for string values or recurse in case of objects and strings
            foreach($temp as $key => $var){
                if(gettype($var) == "string"){
                    $var = htmlspecialchars($var);
                }
                else if(gettype($var) == "object" || gettype($var) == "array"){
                    $this->EscapeString($var);
                }
                $temp[$key] = $var;
            }

            //parse back
            if(gettype($obj) == "object"){
                $obj = (object)$temp;
            }
            else if(gettype($obj) == "string"){
                $obj = $temp[0];
            }
            else if(gettype($obj) == "array"){
                $obj = $temp;
            }
        }

        public abstract function Save($instance);
    }
?>