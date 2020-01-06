<?session_start();
    require_once("../functions.php");
    require_once(GetPath() . "partials.php");
    require_once(GetPath() . "header.php");
    require_once(GetPath() . "navigation.php");

    $username = "";

    if(isset($_GET["Username"])){
        $username = $_GET["Username"];
    }
    
    if(isset($_COOKIE["Username"])){
        $username = $_COOKIE["Username"];
    }


?>
<!doctype html>
<html>
    <head>
        <?
            echo GetHeader("Login");
        ?>
    </head>
    <body>
        <?
            echo GetNavigation();
        ?>

        <script>
            var login = new Login();
        </script>

        <div class="row d-flex justify-content-center mt-2">
            <div class="col-6">
                <?
                    if(isset($_GET["message"])){
                        ?>
                            <span class="alert alert-warning">
                        <?
                        if($_GET["message"] == 1)
                        {
                            echo "Es wurde kein Benutzer mit diesem Benutzername gefunden";
                        }
                        else if ($_GET["message"] == 2)
                        {
                            echo "Das angegebene Passwort ist falsch";
                        }
                        ?>
                            </span>
                        <?
                    }
                ?>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Login</h4>

                        <form action="signIn.php" method="post" id="loginform">
                            <div class="form-control-group">
                                <label for="username">Benutzername</label>
                                <input class="form-control mb-2" type="text"<?
                                        echo "value=\"$username\"";
                                ?> name="username" id="username" ref="username"/>
                            </div>
                            

                            <div class="form-control-group"> 
                                <label for="password">Passwort</label>
                                <input class="form-control mb-2" type="password" id="password" name="password" ref="password"/>
                            </div>

                            <div class="form-check mb-2">                                    
                                <input class="form-check-input" type="checkbox" name="rememberUsername" id="remember-username"/>
                                <label class="form-check-label" for="remember-username">Benutzername merken</label>
                            </div>

                            <button class="btn btn-primary" onclick="login.ValidateForm(document.getElementById('loginform'))">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>