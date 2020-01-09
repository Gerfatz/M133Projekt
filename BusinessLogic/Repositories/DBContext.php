<?
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

        public function Exists(string $tableName, $value, string $key = "Id"): bool{
            $statement = $this->PrepareQuery("SELECT COUNT($key) AS count FROM $tableName WHERE $key = :value");
            $args = array(
                ":value" => $value
            );

            $statement->execute($args);
            return $statement->fetch()["count"] != 0;
        }
    }
?>