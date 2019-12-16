<?
    require_once("User.php");
    require_once("DBContext.php");
    
    class Category{
        private $Id = 0;
        private $name = "";
        private $description = "";
        private $ownerId = 0;
        private $owner = null;

        public function GetId(): int{
            return $this->Id;
        }

        public function GetOwner(): User{
            if($this->owner == null){        
                $db = new DBContext();
                $this->owner = $db->GetUserById($owner);
            }

            return $this->owner;
        }

        public function GetOwnerId(): int{
            return $this->ownerId;
        }

        public function SetOwner(int $ownerId){
            $this->ownerId = $ownerId;
        }

        public function GetName(): string{
            return $this->name;
        }

        public function SetName(string $newName){
            $this->name = $newName;
        }

        public function GetDescription(): string{
            return $this->description;
        }

        public function SetDescription($newDescription){
            $this->description = $newDescription;
        }
    }
?>