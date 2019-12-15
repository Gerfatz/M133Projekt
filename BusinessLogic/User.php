<?
    class User{
        private $Id = 0;
        private $username = "";
        private $passwordHash= "";

        public function GetId(): int{
            return $this->Id;
        }

        public function HashPassword(string $password){
            $this->passwordHash = hash("sha256", $password);
        }

        public function VerifyPassword(string $password): bool{
            return $this->passwordHash == hash("sha256", $password);
        }

        public function GetUsername(): string{
            return $this->username;
        }

        public function SetUsername(string $newName){
            $this->username = $newName;
        }

        public function GetPasswordHash(){
            return $this->passwordHash;
        }
    }
?>