<?
    require_once(GetPath() . "BusinessLogic/Repositories/DBContext.php");
    require_once(GetPath() . "BusinessLogic/Repositories/RepositoryBase.php");
    require_once(GetPath() . "BusinessLogic/ViewModels/CategoryViewModel.php");
    require_once(GetPath() . "validation.php");

    class CategoryRepository extends RepositoryBase{
        private $baseSQL = "SELECT category.Id AS Id, category.name AS Name, category.description AS Description, ( SELECT 1 FROM subscription WHERE subscription.CategoryId = category.Id AND subscription.UserId = :userId ) AS Subscribed, ( SELECT 1 FROM user WHERE user.Id = :userId AND user.Id = category.ownerId ) AS IsOwner FROM category";

        public function GetAllCategories(int $userId = 0): array
        {
            $sql = str_replace(":userId", $userId, $this->baseSQL);
            $statement = $this->db->Query($sql);
            $statement->setFetchMode(PDO::FETCH_CLASS, "CategoryViewModel");
            return $statement->fetchAll();
        }

        public function GetSubscribedCategories(int $userId):array{
            $sql = "SELECT category.Id as Id, category.Name as Name from category RIGHT JOIN subscription ON category.Id = subscription.CategoryId WHERE subscription.UserId = $userId";
            $statement = $this->db->Query($sql);
            $statement->setFetchMode(PDO::FETCH_CLASS, "CategoryViewModel");
            return $statement->fetchAll();
        }

        public function GetCategoryByName(string $name, int $userId): CategoryViewModel{  
            $sql = str_replace(":userId", $userId, $this->baseSQL) . " WHERE name = '$name'";
            $statement = $this->db->Query($sql);
            $statement->setFetchMode(PDO::FETCH_CLASS, "CategoryViewModel");
            return $statement->fetch();
        }

        public function GetCategoryById(int $id, int $userId = 0): CategoryViewModel{
            $sql = str_replace(":userId", $userId, $this->baseSQL) . " WHERE Id = $id";
            $statement = $this->db->Query($sql);
            $statement->setFetchMode(PDO::FETCH_CLASS, "CategoryViewModel");
            return $statement->fetch();
        }

        public function IsSubscribed(int $userId, int $categoryId): bool{
            $sql = "SELECT * FROM subscription WHERE subscription.UserId = $userId AND subscription.CategoryId = $categoryId";
            $statement = $this->db->Query($sql);
            return $statement->rowCount() != 0;
        }

        public function Subscribe(int $userId, int $categoryId){
            $statement = $this->db->PrepareQuery("INSERT INTO subscription (UserId, CategoryId) VALUES (:userId, :categoryId)");
            $args = array(
                ":userId" => $userId,
                ":categoryId" => $categoryId
            );
            $statement->execute($args);
        }

        public function Unsubscribe(int $userId, int $categoryId){
            $statement = $this->db->PrepareQuery("DELETE FROM subscription WHERE UserId = :userId AND CategoryId = :categoryId");
            $args = array(
                ":userId" => $userId,
                ":categoryId" => $categoryId
            );    
            $statement->execute($args);
        }

        public function CreateNewCategory(string $name, int $userId, string $description = ""): CategoryViewModel
        {
            if($this->db->Exists("category", $name, "name")){
                Validator.AddError("name", "Dieser Name wird bereits benutzt", $name);
            }

            $category = new CategoryViewModel();
            $category->name = $name;
            $category->description = $description;
            $category->ownerId = $userId;

            mkdir(GetPath() . "Images/" . $name);

            $this->Save($category);
            return $this->GetCategoryByName($name, $userId);
        }

        public function Save($category){
            $sql = "";

            $args = array(
                ":name" => $category->name,
                ":description" => $category->description,
                ":creatorId" => $category->ownerId
            );

            if($category->Id == 0){
                $sql = "INSERT INTO category (name, description, ownerId) VALUES (:name, :description, :creatorId)";
            }
            else{
                $sql = "UPDATE user SET name=:name, description=:description creatorId=:creatorId WHERE Id=:id";
                $args[":id"] = $category->Id;
            }
            
            $statement = $this->db->PrepareQuery($sql);

            $statement->execute($args);
        }
    }
?>