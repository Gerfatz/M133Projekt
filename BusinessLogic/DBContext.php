<?
    require_once("User.php");

    class DBContext{
        private $dbo;

        public function __construct(){
            $dbo = new PDO("mysql:host=localhost;dbname=memeio", "dario");
        }

        public function GetUserByName(string $username): User{
            $sql = "SELECT * FROM user WHERE username = $username";
            return new User($dbo->query($sql)[0]);
        }

        public function GetUserById(int $userId):User{
            $sql = "SELECT * FROM user WHERE Id = $userId";
            return new User($dbo->query($sql)[0]);
        }

        public function Query(string $sql){
            return $dbo->query($sql);
        }
    }
?>