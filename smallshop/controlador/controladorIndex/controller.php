<?php

//include("..\\controlador\\conexion.php");
//include("..\\controlador\\conexionPDO.php");
//include("..\\modelo\\usuario.php");
//include("consultasBaseDatos.php");
include("..\\database\\databaseOperations.php");
include("..\\modelo\\user.php");
include("..\\controlador\\commomFunctions.php");
include("functions.php");
session_name("sesionUsuario");
session_start();

//$todosUsuariosPaginacion = leerTodosLosUsuarios();


//////////////////////

$showMenuLogin = "";
$showMenuAdministrator = "";
$showBoxWarning = "";         

//echo $_SESSION["username"];

if (isset($_SESSION["username"])) {
    $showMenuLogin = showLoginRegisterLogout($_SESSION["username"]);
    $showMenuAdministrator = showMenuAdministrator($_SESSION["username"]);
    /*$showBoxWarning =
        "<div class=\"row mt-5\">
            <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                <h1 class=\"mb-0\">BIENVENIDO.</h1>
                <hr>
                <p class=\"mb-0\">¿Qué desea hacer?</p>
                <div class=\"list-group mt-3\">
                    <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">
                        <button type=\"button\" class=\"list-group-item list-group-item-action\" name=\"listAllCostumers\">List all costumers</button>
                        <button type=\"button\" class=\"list-group-item list-group-item-action\" name=\"getCostumberInformation\">Get full costumer information</button>
                        <button type=\"button\" class=\"list-group-item list-group-item-action\" name=\"createCostumer\">Create a new costumer</button>
                        <button type=\"button\" class=\"list-group-item list-group-item-action\" name=\"updateCostumer\">Update an existing costumer</button>
                        <button type=\"button\" class=\"list-group-item list-group-item-action\" name=\"deleteCostumer\">Delete an existing costumer</button>
                    </form>
                </div>
            </div>
        </div>";*/
    
} else {
    $showMenuLogin = showLoginRegisterLogout(null);
    $showMenuAdministrator = showMenuAdministrator(null);
    /*$showBoxWarning =
        "<div class=\"row mt-5\">
        <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                <p class=\"mb-0\">Registrese y haga login para usar la aplicación.</p>
        </div>
    </div>";*/
}

$allUsers = createAllUsers();


//$showMenuAdministrator = "";

/*if (isset($_SESSION["usuario"])) {
    $showMenuAdministrator = showMenuAdministrator($_SESSION["usuario"]);
} else {
    $showMenuAdministrator = showMenuAdministrator(null);
}*/

$registerForm = "";

$username = $password = $fullname = $email = "";
$errorUsername = $errorPassword = $errorFullname = $errorEmail = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["registerForm"])) {
        $registerForm = registerForm($errorUsername, $errorPassword, $errorFullname, $errorEmail, $username, $password, $fullname, $email);
    }

    if (isset($_POST["signin"])) {

        if (empty($_POST["username"])) {
            $errorUsername = "Campo requerido.";
        } else {
            if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["username"])) {
                $errorUsername = "<p class=\"text-danger\">Formato no correcto. Solo números y letras sin espacios</p>";
            } else {
                $username = test_input($_POST["username"]);
            }
        }

        if (empty($_POST["password"])) {
            $errorPassword = "Campo requerido.";
        } else {
            if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["password"])) {
                $errorPassword = "Formato no correcto. Solo números y letras sin espacios.";
            } else {
                $password = test_input($_POST["password"]);
            }
        }

        if (empty($_POST["fullname"])) {
            $errorFullname = "Campo requerido.";
        } else {
            if (!preg_match("/^[a-zA-Z ]*$/", $_POST["fullname"])) {
                $errorFullname = "Formato no correcto. Solo letras y espacios si los hubiera.";
            } else {
                $fullname = test_input($_POST["fullname"]);
            }
        }

        if (empty($_POST["email"])) {
            $errorEmail = "Campo requerido.";
        } else {
            $email = test_input($_POST["email"]);
        }

        if (!empty($username) && !empty($password) && !empty($fullname) && !empty($email)) {
            registrarUsuario($username, $password, $fullname, $email);
        } else {
            $registerForm = registerForm($errorUsername, $errorPassword, $errorFullname, $errorEmail, $username, $password, $fullname, $email);
        }
    }

    if (isset($_POST["login"])) {

        if (empty($_POST["usernameLogin"])) {
            $errorUsername = "Campo requerido.";
        } else {
            if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["usernameLogin"])) {
                $errorUsername = "<p class=\"text-danger\">Formato no correcto. Solo números y letras sin espacios</p>";
            } else {
                $username = test_input($_POST["usernameLogin"]);
            }
        }

        if (empty($_POST["passwordLogin"])) {
            $errorPassword = "Campo requerido.";
        } else {
            if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["passwordLogin"])) {
                $errorPassword = "Formato no correcto. Solo números y letras sin espacios.";
            } else {
                $password = test_input($_POST["passwordLogin"]);
            }
        }

        if (!empty($username) && !empty($password)) {
            loginUser($username, $password, $allUsers);
            header("Location: index.php");
        } else {
            //$registerForm = registerForm($errorUsername, $errorPassword, $errorFullname, $errorEmail, $username, $password, $fullname, $email);
        }
    }

    if (isset($_POST["logout"])) {
        sessionDestroy();
    }

    /*if (isset($_POST[""])) {

    }*/

    /*if (isset($_POST["registrar"])) {
        if (empty($_POST["usuario"])) {
            $errorUsuario = "Campo requerido.";
        } else {
            if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["usuario"])) {
                $errorUsuario = "Formato no correcto. Solo números y letras sin espacios.";
            } else {
                $usuario = test_input($_POST["usuario"]);
            }
        }

        if (empty($_POST["contrasenna"])) {
            $errorContrasenna = "Campo requerido";
        } else {
            if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["contrasenna"])) {
                $errorContrasenna = "Formato no correcto. Solo números y letras sin espacios.";
            } else {
                $contrasenna = test_input($_POST["contrasenna"]);
            }
        }

        $administrador = test_input($_POST["administrador"]);

        if (empty($_POST["email"])) {
            $errorEmail = "Campo requerido";
        } else {
            $email = test_input($_POST["email"]);
        }

        if (!empty($usuario) && !empty($contrasenna) && !empty($administrador) && !empty($email)) {
            crearUsuario($usuario, $contrasenna, $administrador, $email);
            header("Location: index.php");
        }
    }

    if (isset($_POST["login"])) {
        if (empty($_POST["email"])) {
            $errorUsuario = "No ha introducido el email";
        } else {
            $email = test_input($_POST["email"]);
        }

        if (empty($_POST["contrasenna"])) {
            $errorContrasenna = "Campo requerido";
        } else {
            if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["contrasenna"])) {
                $errorContrasenna = "Formato no correcto. Solo números y letras sin espacios.";
            } else {
                $contrasenna = test_input($_POST["contrasenna"]);
            }
        }

        if (!empty($email) && !empty($contrasenna)) {
            cargarUsuario($email, $contrasenna, $arrayUsuarios);
            header("Location: index.php");
        }
    }

    if (isset($_POST["logout"])) {
        destruirSession();
        header("Location: index.php");
    }

    if (isset($_POST["modificarDatos"])) {

        if (empty($_POST["emailModificar"])) {
            $errorEmailModificar = "Campo requerido";
        } else {
            $emailModificar = test_input($_POST["emailModificar"]);
        }

        if (empty($_POST["usuario"])) {
            $errorUsuario = "Campo requerido.";
        } else {
            if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["usuario"])) {
                $errorUsuario = "Formato no correcto. Solo números y letras sin espacios.";
            } else {
                $usuario = test_input($_POST["usuario"]);
            }
        }

        if (empty($_POST["contrasenna"])) {
            $errorContrasenna = "Campo requerido";
        } else {
            if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["contrasenna"])) {
                $errorContrasenna = "Formato no correcto. Solo números y letras sin espacios.";
            } else {
                $contrasenna = test_input($_POST["contrasenna"]);
            }
        }

        $administrador = test_input($_POST["administrador"]);

        if (empty($_POST["email"])) {
            $errorEmail = "Campo requerido";
        } else {
            $email = test_input($_POST["email"]);
        }

        if (!empty($usuario) && !empty($contrasenna) && !empty($administrador) && !empty($email) && !empty($emailModificar)) {
            modificarUsuario($emailModificar, $usuario, $contrasenna, $administrador, $email);
        }
    }*/
}

/*function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}*/

/*function cargarTodosLosUsuarios()
{
    $arrayObjetosUsuarios = array();

    $mysqli = conexion();
    $consulta = "SELECT * FROM usuarios";
    if ($resultado = $mysqli->query($consulta)) {
        while ($fila = $resultado->fetch_assoc()) {
            $usuario = new Usuario($fila["usuario"], $fila["contrasena"], $fila["administrador"], $fila["email"]);
            array_push($arrayObjetosUsuarios, $usuario);
        }
    }

    return $arrayObjetosUsuarios;
}

function crearUsuario($usuario, $contrasenna, $administrador, $email)
{
    $mysqli = conexion();

    $usuario = $mysqli->real_escape_string($usuario);
    $contrasenna = $mysqli->real_escape_string($contrasenna);
    $administrador = $mysqli->real_escape_string($administrador);
    $email = $mysqli->real_escape_string($email);
    $conexion = $mysqli->stmt_init();
    $conexion->prepare("INSERT INTO usuarios VALUES (?, ?, ?, ?)");
    $conexion->bind_param("ssss", $usuario, $contrasenna, $administrador, $email);
    if ($conexion->execute()) {
        echo "Usuario creado";
    } else {
        echo "Error en el registro";
    }
    //$conexion->execute();   //Es boolean
    $conexion->close();

    $mysqli->close();
}

function cargarUsuario($email, $contrasenna, $arrayUsuarios)
{
    foreach ($arrayUsuarios as $user) {
        if ($user->getEmail() == $email && $user->getContrasenna() == $contrasenna) {
            $usuarioObjeto = $user;
        }
    }

    crearSession($usuarioObjeto);
}

function crearSession($usuarioObjeto)
{
    $_SESSION["usuario"] = $usuarioObjeto->getUsuario();
    $_SESSION["contrasenna"] = $usuarioObjeto->getContrasenna();
    $_SESSION["administrador"] = $usuarioObjeto->getAdministrador();
    $_SESSION["email"] = $usuarioObjeto->getEmail();
    //header("Location: index.php");
}

function destruirSession()
{
    $_SESSION["administrador"] = "no";
    unset($_SESSION);
    setcookie(session_name(), '', time() - 3600);
    session_destroy();
    //header("Location: index.php");
}*/
