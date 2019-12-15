<?
    require_once(GetPath() . "BusinessLogic/User.php");
    require_once(GetPath() . "configuration.php");

    class DBContext{
        private $dbo;

        public function __construct(){
            $this->dbo = new PDO(GetConfigValue("connectionString"), GetConfigValue("mySqlUsername"));
        }

        public function PrepareQuery(string $sql): PDOStatement{
            return $this->dbo->prepare($sql);
        }

        public function Query(string $sql): PDOStatement{
            return $this->dbo->query($sql);
        }
    }
?>