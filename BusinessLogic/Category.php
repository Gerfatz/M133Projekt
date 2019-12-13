<?
    class Category{
        private $id;
        private $name;
        private $description;
        private $ownerId;
        private $owner;

        public function GetId(): int{
            return $id;
        }

        public function GetOwner(): User{
            if($owner == null){        
                $db = new DBContext();
                $owner = $db->GetUserById($owner);
            }

            return $owner;
        }

        public function SetOwner(User $newOwner){
            $owner = $newOwner;
            $ownerId = $newOwner->GetId();
        }

        public function GetName(): string{
            return $name;
        }

        public function SetName(string $newName){
            $name = $newName;
        }

        public function GetDescription(): string{
            return $description;
        }

        public function SetDescription($newDescription){
            $description = $newDescription;
        }
    }
?>