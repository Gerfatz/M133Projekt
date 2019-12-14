<?
    require_once("User.php");
    require_once("Category.php");
    require_once("DBContext.php");

    class Post{
        private $id;
        private $creatorId;
        private $creator;
        private $categoryId;
        private $category;
        private $parentId;
        private $uploadDate;
        private $title;
        private $text;
        private $picturePath;

        public function GetId()
        {
            return $id;
        }

        public function GetCreator(): User{
            if($creator == null){
                $db = new DBContext();
                $creator = $db->GetUserById($creatorId);
            }
            return $creator;
        }

        public function GetUploadDate(){
            return $uploadDate;
        }

        public function SetUploadDate($date){
            $uploadDate = $date;
        }

        public function GetTitle(){
            return $title;
        }

        public function SetTitle($newTitle){
            $title = $newTitle;
        }

        public function GetText(){
            return $text;
        }

        public function SetText($newText){
            $text = $newText;
        }

        public function GetPicturePath(){
            return $picturePath;
        }

        public function SetPicturePath($path){
            if(file_exists($path)){
                $picturePath = $path;
            }
        }
    }
?>