<?
    require_once(GetPath() . "BusinessLogic/DBContext.php");
    require_once(GetPath() . "BusinessLogic/Category.php");
    require_once(GetPath() . "BusinessLogic/Repositories/RepositoryBase.php");

    class CategoryRepository extends RepositoryBase{
        public function GetAllCategories(): array
        {
            $statement = $this->db->Query("SELECT * FROM category");
            $statement->setFetchMode(PDO::FETCH_CLASS, "Category");
            return $statement->fetchAll();
        }

        public function GetCategoryByName($name): Category{
            $statement = $this->db->Query("SELECT * FROM category WHERE name='$name'");
            $statement->setFetchMode(PDO::FETCH_CLASS, "Category");
            return $statement->fetch();
        }

        public function CreateNewCategory(string $name, string $description = "", int $userId = $_SESSION["UserId"]): Category
        {
            $category = new Category();
            $category->SetName($name);
            $category->SetDescription($description);
            $category->SetOwner($userId);
            $this->Save($category);
            return $category;
        }

        public function Save(&$category){
            $sql = "";

            $args = array(
                ":name" => $category->GetName(),
                ":description" => $category->GetDescription(),
                ":creatorId" => $category->GetOwnerId()
            );

            if($category->GetId() == 0){
                $sql = "INSERT INTO category (name, description, ownerId) VALUES (:name, :description, :creatorId)";
            }
            else{
                $sql = "UPDATE user SET name=:name, description=:description creatorId=:creatorId WHERE Id=:id";
                $args[":id"] = $category->GetId();
            }
            
            $statement = $this->db->PrepareQuery($sql);

            $statement->execute($args);

            $category = $this->GetCategoryByName($name);
        }
    }
?>