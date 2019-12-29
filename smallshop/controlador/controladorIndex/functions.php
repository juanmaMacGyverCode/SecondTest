<?php

//include("..\\controlador\\conexion.php");
//include("..\\modelo\\usuario.php");
//include("..\\controlador\\conexionPDO.php");

/*function leerTodosLosUsuarios()
{

    $conexionPDO = conexionPDO();
    $inicio = 0;
    if (isset($_REQUEST['pos'])) {
        $inicio = $_REQUEST['pos'];
    }
    $impresos = 0;
    $consultaToda = "";

    $sql = "SELECT * FROM usuarios limit $inicio,5";
    $resultado = $conexionPDO->query($sql);
    if ($resultado) {
        $fila = $resultado->fetch();
        $consultaToda .= "<table class=\"table\">";
        $consultaToda .= "<tr><th scope=\"col\">Nombre de usuario</th><th scope=\"col\">Contraseña</th><th scope=\"col\">Email</th><th scope=\"col\">Administrador</th></tr>";
        while ($fila != null) {
            $impresos++;
            $consultaToda .= "<tr><td>" . $fila['usuario'] . "</td>";
            $consultaToda .= "<td>" . $fila['contrasena'] . "</td>";
            $consultaToda .= "<td>" . $fila['email'] . "</td>";
            $consultaToda .= "<td>" . $fila['administrador'] . "</td></<tr>";
            $fila = $resultado->fetch();
        }
        $consultaToda .= "</table>";
    }
    $conexionPDO = null;
    $consultaToda .= "<br>";
    if ($inicio == 0) {
        $consultaToda .= "anteriores ";
    } else {
        $anterior = $inicio - 5;
        $consultaToda .= "<a href=\"formularioUsuarios.php?pos=$anterior\">Anteriores </a>" . " -- ";
    }
    if ($impresos == 5) {
        $proximo = $inicio + 5;
        $consultaToda .= "<a href=\"formularioUsuarios.php?pos=$proximo\">Siguientes</a>";
    } else {
        $consultaToda .= "siguientes";
    }

    return $consultaToda;
}

function modificarUsuario($emailModificar, $usuario, $contrasenna, $administrador, $email)
{
    $mysqli = conexion();

    $emailModificar = $mysqli->real_escape_string($emailModificar);
    $usuario = $mysqli->real_escape_string($usuario);
    $contrasenna = $mysqli->real_escape_string($contrasenna);
    $administrador = $mysqli->real_escape_string($administrador);
    $email = $mysqli->real_escape_string($email);

    $conexion = $mysqli->stmt_init();
    $conexion->prepare("UPDATE usuarios SET usuario=?, contrasena=?, administrador=?, email=? WHERE email = ?");
    $conexion->bind_param("sssss", $usuario, $contrasenna, $administrador, $email, $emailModificar);
    if ($conexion->execute()) {
        echo "Usuario creado";
    } else {
        echo "Error en el registro";
    }
    //$conexion->execute();   //Es boolean
    $conexion->close();

    $mysqli->close();
}*/

function showLoginRegisterLogout($user)
{
    $showMenuLogin = "";
    if (isset($user)) {
        $showMenuLogin = "<span class=\"nav-item text-white mr-sm-2\">Bienvenido " . decrypt($user, "1235@") . "</span>
        <input class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\" name=\"logout\" aria-label=\"Logout\" value=\"Logout\">";
    } else {
        $showMenuLogin = "<input class=\"form-control mr-sm-2\" type=\"text\" name=\"usernameLogin\" placeholder=\"Username\" aria-label=\"Search\">
                <input class=\"form-control mr-sm-2\" type=\"text\" name=\"passwordLogin\" placeholder=\"Password\" aria-label=\"Search\">
                <input class=\"btn btn-outline-success my-2 my-sm-0 mr-sm-2\" type=\"submit\" name=\"login\" aria-label=\"Login\" value=\"Login\">
                <input class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\" name=\"registerForm\" aria-label=\"Sign in\" value=\"Sign in\">";
    }
    return $showMenuLogin;
}

function showMenuAdministrator($administrator)
{

    $showMenuAdministrator = "";

    if (isset($administrator)) {
        /*$showMenuAdministrator =
            "<li class=\"nav-item dropdown\">
                <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                        Configuración
                </a>
                <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">
                    <a class=\"dropdown-item\" href=\"formularioAvion.php\">Configuración de aviones</a>
                    <a class=\"dropdown-item\" href=\"formularioRutaAerea.php\">Configuración de rutas aéreas</a>
                    <a class=\"dropdown-item\" href=\"formularioVisualizacionVuelos.php\">Visualizar los vuelos</a>
                    <a class=\"dropdown-item\" href=\"formularioModificarPasajero.php\">Modificación y borrado de pasajeros</a>
                    <div class=\"dropdown-divider\"></div>
                    <a class=\"dropdown-item\" href=\"formularioUsuarios.php\">Configuración de usuarios</a>
                </div>
            </li>";*/

        $showMenuAdministrator =
            "<li class=\"nav-item active dropdown\">
                <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                        Manage smallShop
                </a>
                <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">
                    <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">
                        <button type=\"submit\" class=\"dropdown-item list-group-item-action\" name=\"listAllCostumers\">List all costumers</button>
                        <button type=\"submit\" class=\"dropdown-item list-group-item-action\" name=\"getCostumberInformation\">Get full costumer information</button>
                        <button type=\"submit\" class=\"dropdown-item list-group-item-action\" name=\"createCostumer\">Create a new costumer</button>
                        <button type=\"submit\" class=\"dropdown-item list-group-item-action\" name=\"updateCostumer\">Update an existing costumer</button>
                        <button type=\"submit\" class=\"dropdown-item list-group-item-action\" name=\"deleteCostumer\">Delete an existing costumer</button>
                        <div class=\"dropdown-divider\"></div>
                        <button type=\"submit\" class=\"dropdown-item list-group-item-action\" name=\"deleteCostumer\">Update your user account</button>
                    </form>
                </div>
            </li>";
    } else {
        $showMenuAdministrator = "";
    }

    return $showMenuAdministrator;
}

function registerForm($errorUsername, $errorPassword, $errorFullname, $errorEmail, $username, $password, $fullname, $email) {
    $registerForm =
        "<div class=\"row w-100 mt-5 mb-5\">
        <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
        <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\" novalidate>
            <h1>FORMULARIO DE REGISTRO</h1>
            <div class=\"form-group\">
                <label for=\"username\">Username</label>
                <input type=\"text\" class=\"form-control\" name=\"username\" value=\"$username\" placeholder=\"Username\" required>
                <div class=\"valid-feedback\">
                    Looks good!
                </div>
                <div class=\"invalid-feedback\">
                    Please, complete the field! Only letters and numbers without spaces
                </div>
                $errorUsername
            </div>
            <div class=\"form-group\">
                <label for=\"password\">Password</label>
                <input type=\"password\" class=\"form-control\" name=\"password\" value=\"$password\" placeholder=\"Password\" required>
                <div class=\"valid-feedback\">
                    Looks good!
                </div>
                <div class=\"invalid-feedback\">
                    Please, complete the field! Only letters and numbers without spaces
                </div>
                $errorPassword
            </div>
            <div class=\"form-group\">
                <label for=\"fullname\">Full name</label>
                <input type=\"fullname\" class=\"form-control\" name=\"fullname\" value=\"$fullname\" placeholder=\"Full name\" required>
                <div class=\"valid-feedback\">
                    Looks good!
                </div>
                <div class=\"invalid-feedback\">
                    Please, complete the field! Only letters and spaces
                </div>
                $errorFullname
            </div>
            <div class=\"form-group\">
                <label for=\"email\">Email</label>
                <input type=\"email\" class=\"form-control\" name=\"email\" value=\"$email\" placeholder=\"Email\" required>
                <div class=\"valid-feedback\">
                    Looks good!
                </div>
                <div class=\"invalid-feedback\">
                    Please, complete the field!
                </div>
                $errorEmail
            </div>
            <div class=\"d-flex justify-content-around\">
                <button type=\"submit\" class=\"btn btn-primary\" name=\"signin\">Sign in</button><a href=\"\" class=\"btn btn-primary\">Return</a>
            </div>
        </form>
        </div>
        </div>";

        return $registerForm;
}

/*$key = "1235@";
$string = "la casa azul";

$encryptado = encrypt($string, $key);
echo $encryptado;
echo "<hr>";
echo decrypt($encryptado, $key);*/

function encrypt($data, $key)
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, "aes-256-cbc", $key, 0, $iv);
    return base64_encode($encrypted . "::" . $iv);
}

function decrypt($data, $key)
{
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}

function loginUser($username, $password, $allUsers)
{
    foreach ($allUsers as $user) {
        if ($username == decrypt($user->getUsername(), "1235@") && $password == decrypt($user->getPassword(), "1235@")) {
            newSession($user->getIdUser(), $user->getUsername(), $user->getPassword(), $user->getFullName(), $user->getEmail());
            return true;
        }
    }

    return false;
}

function newSession($idUser ,$userEncrypt, $passwordEncrypt, $fullNameEncrypt, $emailEncrypt) {
    $_SESSION["idUser"] = $idUser;
    $_SESSION["username"] = $userEncrypt;
    $_SESSION["password"] = $passwordEncrypt;
    $_SESSION["fullName"] = $fullNameEncrypt;
    $_SESSION["email"] = $emailEncrypt;
}

function sessionDestroy()
{
    unset($_SESSION);
    setcookie(session_name(), '', time() - 3600);
    session_destroy();
    header("Location: index.php");
}