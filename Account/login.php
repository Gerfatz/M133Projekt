<?session_start();

    require_once("partials.php");
    require_once("navigation.php");
?>
<!doctype html>
<html>
    <head>
        <?
            echo GetPartial("_header", array(
                "title" => "Home"
            ));
        ?>
    </head>
    <body>
        <?
            echo GetNavigation();
        ?>

        <script>
            var login = new Login();
        </script>

        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Als neuer Benutzer registrieren</h4>

                        <form action="Account/createUser.php" method="post" id="loginform">
                            <input class="form-control" type="text" name="username" id="username"/>
                            <input class="form-control" type="password" name="password" id="password"/>

                            <button class="btn btn-primary" onclick="login.ValidateForm(document.getElementById('loginform'))">Registrieren</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>