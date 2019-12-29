<?php

//include("..\\database\\databaseOperations.php");
include("..\\modelo\\costumer.php");
//include("..\\controlador\\commomFunctions.php");
include("functions.php");
/*session_name("sesionUsuario");
session_start();*/

$showBoxWarning = "";

if (isset($_SESSION["username"])) {
    $showBoxWarning =
        "<div class=\"row mt-5\">
            <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                <h1 class=\"mb-0\">WELCOME TO SMALLSHOP</h1>
                <hr>
                <p class=\"mb-0\">Choose an option</p>
                <div class=\"list-group mt-3\">
                    <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"listAllCostumers\">List all costumers</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"getCostumerInformation\">Get full costumer information</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"createCostumer\">Create a new costumer</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"updateCostumer\">Update an existing costumer</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"deleteCostumer\">Delete an existing costumer</button>
                    </form>
                </div>
            </div>
        </div>";
} else {
    $showBoxWarning =
        "<div class=\"row mt-5\">
            <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                <p class=\"mb-0\"><span class=\"font-weight-bold\">Sign up</span> and <span class=\"font-weight-bold\">login</span> to use the application.<br>If you have an account, <span class=\"font-weight-bold\">please login</span></p>
            </div>
        </div>";
}

$allCostumers = listAllCostumers();
$allUsers = createAllUsers();
//echo count($allCostumers);

$showBoxProgram = "";
$showLastNewCostumer = "";
$showTableDataCostumers = "";
$showFormNumberRows = "";
$showFormFindCostumer = "";
$showFormUpdateCustomer = "";
$showUpdateCustomer = "";

$name = $surname = $fileUpload = $numberRows = $number = $checkboxDeleteImage = $idCustomer = "";
$errorName = $errorSurname = $errorUpload = $errorNumberRows = $errorNumber = $errorIdCustomer = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["registerForm"])) {
        $showBoxWarning = "";
    }

    if (isset($_POST["signin"])) {
        if (!(!empty($username) && !empty($password) && !empty($fullname) && !empty($email))) {
            //registrarUsuario($username, $password, $fullname, $email);
            $showBoxWarning = "";
        }
    }

    if (isset($_POST["listAllCostumers"])) {
        $showBoxWarning = "";

        //$showTableDataCostumers = tableAllCostumers($allCostumers);
        //$showTableDataCostumers = leerTodosPaginacionConBoton(0);
        $showFormNumberRows = showFormNumberRows($numberRows, $errorNumberRows);
    }

    if (isset($_POST["showTable"])) {

        if (empty($_POST["numberRows"])) {
            $errorNumberRows = "<p class=\"text-danger\">Campo requerido</p>";
        } else {
            if (strlen($_POST["numberRows"]) > 3) {
                $errorNumberRows = "<p class=\"text-danger\">Max 3 characters</p>";
            } else {
                if (!preg_match("/^[0-9]*$/", $_POST["numberRows"])) {
                    $errorNumberRows = "<p class=\"text-danger\">Formato no correcto. Solo números sin espacios</p>";
                } else {
                    if (strlen(strip_tags($_POST["numberRows"])) != strlen($_POST["numberRows"])) {
                        $errorNumberRows = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        if ($_POST["numberRows"] > 0 && $_POST["numberRows"] <= 300) {
                            $numberRows = test_input($_POST["numberRows"]);
                        } else {
                            $errorNumberRows = "<p class=\"text-danger\">Minimun of lines 1, maximun of lines 300</p>";
                        }
                    }
                }
            }
        }

        if (!empty($numberRows)) {
            $showBoxWarning = "";
            $showTableDataCostumers = leerTodosPaginacionConBoton(0, $numberRows);
        } else {
            $showBoxWarning = "";
            $showFormNumberRows = showFormNumberRows($numberRows, $errorNumberRows);
        }

        //$showBoxWarning = "";
        //$showTableDataCostumers = leerTodosPaginacionConBoton(0);
    }

    if (isset($_POST["paginacionAnterior"])) {
        $showBoxWarning = "";
        $showTableDataCostumers = leerTodosPaginacionConBoton($_POST["anterior"], $_POST["numberRows"]);
    }

    if (isset($_POST["paginacionPosterior"])) {
        $showBoxWarning = "";
        $showTableDataCostumers = leerTodosPaginacionConBoton($_POST["posterior"], $_POST["numberRows"]);
    }

    if (isset($_POST["getCostumerInformation"])) {
        $showBoxWarning = "";

        $showFormFindCostumer = showFormFindCostumer($number, $errorNumber);
    }

    if (isset($_POST["findCostumerInformation"])) {
        $showBoxWarning = "";

        if (empty($_POST["numberId"])) {
            $errorNumber = "<p class=\"text-danger\">Campo requerido</p>";
        } else {
            if (!preg_match("/^[0-9]*$/", $_POST["numberId"])) {
                $errorNumber = "<p class=\"text-danger\">Formato no correcto. Solo números sin espacios</p>";
            } else {
                if (strlen(strip_tags($_POST["numberId"])) != strlen($_POST["numberId"])) {
                    $errorNumber = "<p class=\"text-danger\">Incorrect characters</p>";
                } else {
                    if ($_POST["numberId"] > 0) {
                        $number = test_input($_POST["numberId"]);
                    } else {
                        $errorNumber = "<p class=\"text-danger\">Minimun of lines 1</p>";
                    }
                }
            }
        }

        if (!empty($number)) {
            $allDataSheetsCostumer = "";
            foreach ($allCostumers as $costumerObject) {
                if ($number == $costumerObject->getIdCostumer()) {
                    $allDataSheetsCostumer = $costumerObject->dataSheetCostumer($allUsers);
                    break;
                } else {
                    $allDataSheetsCostumer = "<p class=\"text-danger\">Error: The data was not found</p>";
                }
                //$allDataSheetsCostumer = $costumerObject->dataSheetCostumer($allUsers);
            }

            $showBoxProgram =
                "<div class=\"row mt-5\">
                    <div class=\"mx-auto w-75 p-3 text-center opacity-80\">
                        <h1 class=\"mb-0\">GET FULL CUSTOMER INFORMATION</h1>
                        <hr>
                        " . $allDataSheetsCostumer . "
                        <div class=\"d-flex justify-content-around mt-3\">
                            <a href=\"\" class=\"btn btn-primary\">Return</a>
                        </div>
                    </div>
                </div>";
        } else {
            $showBoxWarning = "";
            $showFormFindCostumer = showFormFindCostumer($number, $errorNumber);
        }
    }

    if (isset($_POST["createCostumer"])) {
        $showBoxWarning = "";
        $showBoxProgram = showBoxCreateCostumer($name, $surname, $errorName, $errorSurname, $errorUpload);
    }

    if (isset($_POST["buttonCreateCostumer"])) {

        if (empty($_POST["name"])) {
            $errorName = "<p class=\"text-danger\">Campo requerido</p>";
        } else {
            if (strlen($_POST["name"]) > 20) {
                $errorName = "<p class=\"text-danger\">Max 20 characters</p>";
            } else {
                if (!preg_match("/^[a-zA-Z ]*$/", $_POST["name"])) {
                    $errorName = "<p class=\"text-danger\">Formato no correcto. Solo letras con espacios</p>";
                } else {
                    if (strlen(strip_tags($_POST["name"])) != strlen($_POST["name"])) {
                        $errorName = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        $name = test_input($_POST["name"]);
                    }
                }
            }
        }

        if (empty($_POST["surname"])) {
            $errorSurname = "<p class=\"text-danger\">Campo requerido</p>";
        } else {
            if (strlen($_POST["surname"]) > 20) {
                $errorSurname = "<p class=\"text-danger\">Max 20 characters</p>";
            } else {
                if (!preg_match("/^[a-zA-Z ]*$/", $_POST["surname"])) {
                    $errorSurname = "<p class=\"text-danger\">Formato no correcto. Solo letras con espacios</p>";
                } else {
                    if (strlen(strip_tags($_POST["surname"])) != strlen($_POST["surname"])) {
                        $errorSurname = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        $surname = test_input($_POST["surname"]);
                    }
                }
            }
        }

        if (!empty($_FILES["uploadImage"]["name"])) {
            if (strlen(strip_tags($_FILES["uploadImage"]["name"])) != strlen($_FILES["uploadImage"]["name"])) {
                $errorUpload = "<p class=\"text-danger\">Incorrect characters</p>";
            } else {
                $errorUpload = uploadFile();
                //$fileUpload = "<img src='../uploads/" . $_FILES["uploadImage"]["name"] . "'>";
                $fileUpload = $_FILES["uploadImage"]["name"];
            }
        }

        //echo $ficheroSubido;

        if (!empty($name) && !empty($surname) && empty($errorUpload)) {
            createNewCostumer($name, $surname, $fileUpload, $_SESSION["idUser"]);
            $allCostumers = listAllCostumers();
            //$showLastNewCostumer = $allCostumers[count($allCostumers)-1]->dataSheetCostumer($allUsers);
            //registrarUsuario($username, $password, $fullname, $email);

            //echo "<pre>".print_r($ficheroSubido)."</pre>";

            //$showCostumerInfo = showCostumerInfo($idCostumer, $name, $surname, );
            $showBoxWarning = "";
            //$showBoxProgram = showBoxCreateCostumer($name, $surname, $errorName, $errorSurname, $errorUpload);
            $showLastNewCostumer = "<div class=\"row mt-5\">
            <div class=\"mx-auto w-75 p-3 text-center opacity-80\">
            <h1 class=\"mb-0\">NEW COSTUMER</h1>"
                . $allCostumers[count($allCostumers) - 1]->dataSheetCostumer($allUsers) .
                "<a href=\"\" class=\"btn btn-primary\">Return</a>
            </div>
            </div>";
        } else {
            $showBoxWarning = "";
            $showBoxProgram = showBoxCreateCostumer($name, $surname, $errorName, $errorSurname, $errorUpload);
            //$registerForm = registerForm($errorUsername, $errorPassword, $errorFullname, $errorEmail, $username, $password, $fullname, $email);
        }
    }

    if (isset($_POST["updateCostumer"])) {
        $showBoxWarning = "";
        $showFormFindCostumer = showFormFindCostumerToUpdate($number, $errorNumber);
    }

    if (isset($_POST["findCustomerInformationToUpdate"])) {
        $showBoxWarning = "";

        if (empty($_POST["numberId"])) {
            $errorNumber = "<p class=\"text-danger\">Campo requerido</p>";
        } else {
            if (!preg_match("/^[0-9]*$/", $_POST["numberId"])) {
                $errorNumber = "<p class=\"text-danger\">Formato no correcto. Solo números sin espacios</p>";
            } else {
                if (strlen(strip_tags($_POST["numberId"])) != strlen($_POST["numberId"])) {
                    $errorNumber = "<p class=\"text-danger\">Incorrect characters</p>";
                } else {
                    if ($_POST["numberId"] > 0) {
                        $number = test_input($_POST["numberId"]);
                    } else {
                        $errorNumber = "<p class=\"text-danger\">Minimun of lines 1</p>";
                    }
                }
            }
        }

        if (!empty($number)) {
            $customer = "";
            foreach ($allCostumers as $customerObject) {
                if ($number == $customerObject->getIdCostumer()) {
                    $customer = $customerObject;
                    break;
                } else {
                    $errorNumber = "<p class=\"text-danger\">Error: The data was not found</p>";
                }
                //$allDataSheetsCostumer = $costumerObject->dataSheetCostumer($allUsers);
            }

            if (!empty($customer)) {

                $showFormUpdateCustomer = showFormUpdateCustomer($customer, $errorIdCustomer, $errorName, $errorSurname, $errorUpload);
                /*$showBoxProgram =
                    "<div class=\"row mt-5\">
                    <div class=\"mx-auto w-75 p-3 text-center opacity-80\">
                        <h1 class=\"mb-0\">GET FULL CUSTOMER INFORMATION</h1>
                        <hr>
                        " . $allDataSheetsCostumer . "
                        <div class=\"d-flex justify-content-around mt-3\">
                            <a href=\"\" class=\"btn btn-primary\">Return</a>
                        </div>
                    </div>
                </div>";*/
            } else {
                $showBoxWarning = "";
                $showFormFindCostumer = showFormFindCostumerToUpdate($number, $errorNumber);
            }
        } else {
            $showBoxWarning = "";
            $showFormFindCostumer = showFormFindCostumerToUpdate($number, $errorNumber);
        }
    }

    if (isset($_POST["buttonUpdateCustomer"])) {

        $idCustomerHidden = $_POST["idCustomerHidden"];

        if (empty($_POST["idCustomer"])) {
            $errorIdCustomer = "<p class=\"text-danger\">Campo requerido</p>";
        } else {
            if (!preg_match("/^[0-9]*$/", $_POST["idCustomer"])) {
                $errorIdCustomer = "<p class=\"text-danger\">Formato no correcto. Solo números sin espacios</p>";
            } else {
                if (strlen(strip_tags($_POST["idCustomer"])) != strlen($_POST["idCustomer"])) {
                    $errorIdCustomer = "<p class=\"text-danger\">Incorrect characters</p>";
                } else {
                    if ($_POST["idCustomer"] > 0) {
                        if ($idCustomerHidden == $_POST["idCustomer"] || thereIsThatID($_POST["idCustomer"], $allCostumers)) {
                            $idCustomer = test_input($_POST["idCustomer"]);
                        } else {
                            $errorIdCustomer = "<p class=\"text-danger\">There is that ID customer, choose any other</p>";
                        }
                        //$idCustomer = test_input($_POST["idCustomer"]);
                    } else {
                        $errorIdCustomer = "<p class=\"text-danger\">Minimun ID is 1</p>";
                    }
                }
            }
        }

        if (empty($_POST["name"])) {
            $errorName = "<p class=\"text-danger\">Campo requerido</p>";
        } else {
            if (strlen($_POST["name"]) > 20) {
                $errorName = "<p class=\"text-danger\">Max 20 characters</p>";
            } else {
                if (!preg_match("/^[a-zA-Z ]*$/", $_POST["name"])) {
                    $errorName = "<p class=\"text-danger\">Formato no correcto. Solo letras con espacios</p>";
                } else {
                    if (strlen(strip_tags($_POST["name"])) != strlen($_POST["name"])) {
                        $errorName = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        $name = test_input($_POST["name"]);
                    }
                }
            }
        }

        if (empty($_POST["surname"])) {
            $errorSurname = "<p class=\"text-danger\">Campo requerido</p>";
        } else {
            if (strlen($_POST["surname"]) > 20) {
                $errorSurname = "<p class=\"text-danger\">Max 20 characters</p>";
            } else {
                if (!preg_match("/^[a-zA-Z ]*$/", $_POST["surname"])) {
                    $errorSurname = "<p class=\"text-danger\">Formato no correcto. Solo letras con espacios</p>";
                } else {
                    if (strlen(strip_tags($_POST["surname"])) != strlen($_POST["surname"])) {
                        $errorSurname = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        $surname = test_input($_POST["surname"]);
                    }
                }
            }
        }

        if (isset($_POST["checkboxDeleteImage"])) {
            $checkboxDeleteImage = true;
        } else {
            $checkboxDeleteImage = false;
        }

        if (!$checkboxDeleteImage && !empty($_FILES["uploadImage"]["name"])) {
            if (strlen(strip_tags($_FILES["uploadImage"]["name"])) != strlen($_FILES["uploadImage"]["name"])) {
                $errorUpload = "<p class=\"text-danger\">Incorrect characters</p>";
            } else {
                $errorUpload = uploadFile();
                //$fileUpload = "<img src='../uploads/" . $_FILES["uploadImage"]["name"] . "'>";
                $fileUpload = $_FILES["uploadImage"]["name"];
            }
        }

        //echo $_FILES["uploadImage"]["name"];
        //echo $_POST["uploadImageHidden"];
        /*if (isset($_POST["checkboxDeleteImage"])) {
            $checkboxDeleteImage = $_POST["checkboxDeleteImage"];
        } else {

        }*/
        
        $imageHidden = $_POST["uploadImageHidden"];
        $idCustomerHidden = $_POST["idCustomerHidden"];


        if ((!empty($idCustomer) && !empty($name) && !empty($surname)) || !empty($fileUpload) || !empty($checkboxDeleteImage)) {
            updateCustomer($idCustomerHidden, $idCustomer, $name, $surname, $fileUpload, $checkboxDeleteImage, $_SESSION["idUser"]);

            $allCustomers = listAllCostumers();
            $allCostumers = $allCustomers;

            $customer = "";
            foreach ($allCustomers as $customerObject) {
                if ($customerObject->getIdCostumer() == $idCustomer) {
                    $customer = $customerObject;
                }
            }

            $showBoxWarning = "";
            $showUpdateCustomer = "<div class=\"row mt-5\">
            <div class=\"mx-auto w-75 p-3 text-center opacity-80\">
            <h1 class=\"mb-0\">UPDATE CUSTOMER</h1>"
                . $customer->dataSheetCostumer($allUsers) .
                "<a href=\"\" class=\"btn btn-primary\">Return</a>
            </div>
            </div>";
        } else {
            $customer = "";
            foreach ($allCostumers as $customerObject) {
                if ($customerObject->getIdCostumer() == $idCustomerHidden) {
                    $customer = $customerObject;
                }
            }
            $showBoxWarning = "";
            $showFormFindCostumer = showFormUpdateCustomer($customer, $errorIdCustomer, $errorName, $errorSurname, $errorUpload);
        }
    }

    if (isset($_POST["deleteCostumer"])) {
        $showBoxWarning = "";
        $showFormFindCostumer = showFormFindCostumerToDelete($idCustomer, $errorIdCustomer);
    }

    if (isset($_POST["findCustomerInformationToDelete"])) {
        if (empty($_POST["idCustomer"])) {
            $errorIdCustomer = "<p class=\"text-danger\">Campo requerido</p>";
        } else {
            if (!preg_match("/^[0-9]*$/", $_POST["idCustomer"])) {
                $errorIdCustomer = "<p class=\"text-danger\">Formato no correcto. Solo números sin espacios</p>";
            } else {
                if (strlen(strip_tags($_POST["idCustomer"])) != strlen($_POST["idCustomer"])) {
                    $errorIdCustomer = "<p class=\"text-danger\">Incorrect characters</p>";
                } else {
                    if ($_POST["idCustomer"] > 0) {
                        if (!thereIsThatID($_POST["idCustomer"], $allCostumers)) {
                            $idCustomer = test_input($_POST["idCustomer"]);
                        } else {
                            $errorIdCustomer = "<p class=\"text-danger\">There isn´t that ID customer, choose any other</p>";
                        }
                        //$idCustomer = test_input($_POST["idCustomer"]);
                    } else {
                        $errorIdCustomer = "<p class=\"text-danger\">Minimun ID is 1</p>";
                    }
                }
            }
        }

        if (!empty($idCustomer)) {
            deleteCustomer($idCustomer);

            $allCustomers = listAllCostumers();
            $allCostumers = $allCustomers;
        } else {
            $showBoxWarning = "";
            $showFormFindCostumer = showFormFindCostumerToDelete($idCustomer, $errorIdCustomer);
        }
    }
}
