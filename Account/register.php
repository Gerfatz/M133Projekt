<?session_start();

    require_once("../functions.php");
    require_once(GetPath() . "partials.php");
    require_once(GetPath() . "header.php");
    require_once(GetPath() . "navigation.php");
?>
<!doctype html>
<html>
    <head>
        <?
            echo GetHeader("Registrieren");
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
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Als neuer Benutzer registrieren</h4>

                        <form action="createUser.php" method="post" id="loginform">
                            <div class="form-control-group">
                                <label for="username">Benutzername</label>
                                <input class="form-control mb-2" type="text" name="username" ref="username" onkeyup="login.ValidateUsername(document.getElementById('loginform').find('username'))"/>
                            </div>
                            

                            <div class="form-control-group"> 
                                <label for="password">Passwort</label>
                                <input class="form-control mb-2" type="password" name="password" ref="password"/>
                            </div>

                            <button class="btn btn-primary" onclick="login.ValidateForm(document.getElementById('loginform'))">Registrieren</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>