<?
    require_once(GetPath() . "functions.php");
    require_once(GetPath() . "BusinessLogic/Repositories/DBContext.php");
    require_once(GetPath() . "BusinessLogic/ViewModels/UserViewModel.php");
    require_once(GetPath() . "BusinessLogic/Repositories/RepositoryBase.php");
    require_once(GetPath() . "validation.php");

    class UserRepository extends RepositoryBase{

        public function CreateNewUser(string $username, string $password){
            $user = new UserViewModel();

            if($this->IsUsernameAvailable($username)){
                $user->Username = $username;
                $user->PasswordHash = $this->HashPassword($password);
    
                $this->Save($user);
    
                return $this->GetUserByUsername($username);
            }
            else{
                Validator::AddError("username", "Dieser Benutzername ist bereits vergeben", $username);
            }

        }

        public function HashPassword(string $password): string{
            return hash("sha256", $password);
        }

        public function GetUserByUsername(string $username): UserViewModel{
            $this->EscapeString($username);
            $statement = $this->db->PrepareQuery("SELECT Id AS Id, username AS Username, passwordHash AS PasswordHash FROM user WHERE username = :username");
            $statement->execute(array(":username" => $username));
            return $this->CreateUserFromStatement($statement);
        }

        public function GetUserById(int $id): UserViewModel{
            $statement = $this->db->Query("SELECT Id AS Id, username AS Username, passwordHash AS PasswordHash FROM user WHERE Id = $id");
            return $this->CreateUserFromStatement($statement);
        }

        public Function IsUsernameAvailable($username): bool{
            $this->EscapeString($username);
            return !$this->db->Exists("user", $username, "username");
        }

        public function CreateUserFromStatement(PDOStatement $statement): UserViewModel
        {
            $statement->setFetchMode(PDO::FETCH_CLASS, "UserViewModel");
            return $statement->fetch();
        }

        public function Save($user){
            $sql = "";

            $this->EscapeString($user);

            $args = array(
                ":username" => $user->Username,
                ":passwordHash" => $user->PasswordHash
            );

            //Create new or Update existing
            if($user->Id == 0){
                $sql = "INSERT INTO user (username, passwordHash) VALUES (:username, :passwordHash)";
            }
            else{
                $sql = "UPDATE user SET username=:username, passwordHash=:passwordHash WHERE Id=:id";
                $args[":id"] = $user->Id;
            }
            
            $statement = $this->db->PrepareQuery($sql);

            $statement->execute($args);
        }
    }
?>