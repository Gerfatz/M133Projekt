<?
    class User{
        private $id;
        private $username;
        private $passwordHash;

        public function __construct($dbRow){
            $id = $dbRow["Id"];
            $username = $dbRow["username"];
            $passwordHash = $dbRow["passwordHash"];
        }

        public function GetId(): int{
            return $id;
        }

        public function HashPassword(string $password){
            $passwordHash = hash("sha256", $password);
        }

        public function VerifyPassword(string $password): boolean{
            return $passwordHash == hash("sha256", $password);
        }

        public function GetUsername(): string{
            return $username;
        }

        public function SetUsername(string $newName){
            $username = $newName;
        }
    }
?>