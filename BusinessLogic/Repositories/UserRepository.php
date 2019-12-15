<?
    require_once(GetPath() . "functions.php");
    require_once(GetPath() . "BusinessLogic/DBContext.php");
    require_once(GetPath() . "BusinessLogic/User.php");
    require_once(GetPath() . "BusinessLogic/Repositories/RepositoryBase.php");

    class UserRepository extends RepositoryBase{

        public function CreateNewUser(string $username, string $password): User{
            $user = new User();

            if($this->IsUsernameAvailable($username)){
                $user->SetUsername($username);
                $user->HashPassword($password);
    
                $this->Save($user);
    
                return $this->GetUserByUsername($username);
            }
            else{
                return null;
            }

        }

        public function GetUserByUsername(string $username): User{
            $statement = $this->db->Query("SELECT * FROM user WHERE username = '$username'");
            return $this->CreateUserFromStatement($statement);
        }

        public function GetUserById(int $id): User{
            $statement = $this->db->Query("SELECT * FROM user WHERE Id = $id");
            return $this->CreateUserFromStatement($statement);
        }

        public Function IsUsernameAvailable($username): bool{
            $statement = $this->db->PrepareQuery("SELECT username FROM user WHERE username = :username");
            $statement->bindValue(":username", $username, PDO::PARAM_STR);
            $res = $statement->fetchAll();
            var_dump($res);
            return count($statement->fetchAll()) == 0;
        }

        public function CreateUserFromStatement(PDOStatement $statement): User
        {
            $statement->setFetchMode(PDO::FETCH_CLASS, "User");
            return $statement->fetch();
        }

        public function Save($user){
            $sql = "";

            $args = array(
                ":username" => $user->GetUsername(),
                ":passwordHash" => $user->GetPasswordHash()
            );

            if($user->GetId() == 0){
                $sql = "INSERT INTO user (username, passwordHash) VALUES (:username, :passwordHash)";
            }
            else{
                $sql = "UPDATE user SET username=:username, passwordHash=:passwordHash WHERE Id=:id";
                $args[":id"] = $user->GetId();
            }
            
            $statement = $this->db->PrepareQuery($sql);

            $statement->execute($args);
        }
    }
?>