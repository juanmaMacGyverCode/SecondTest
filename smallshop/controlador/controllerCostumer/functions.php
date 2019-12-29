<?php

function showBoxCreateCostumer($name, $surname, $errorName, $errorSurname, $errorUpload) {

    return "<div class=\"row w-100 mt-5\">
            <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                <h1 class=\"mb-0\">CREATE A NEW COSTUMER</h1>
                <hr>
                <div class=\"list-group mt-3\">
                    <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">
                        <div class=\"form-group col-md-6 mx-auto\">
                            <label for=\"inputName\">Name</label>
                            <input type=\"text\" class=\"form-control\" id=\"inputName\" name=\"name\" value=\"" . $name . "\" placeholder=\"Name\">".
                            $errorName
                        . "</div>
                        <div class=\"form-group col-md-6 mx-auto\">
                            <label for=\"inputSurname\">Surname</label>
                            <input type=\"text\" class=\"form-control\" id=\"inputSurname\" name=\"surname\" value=\"" . $surname . "\" placeholder=\"Surname\">".
                            $errorSurname
                        ."</div>
                        <div class=\"form-group mx-auto\">
                            <label for=\"exampleFormControlFile1\">Example file input</label>
                            <input type=\"file\" class=\"form-control-file\" id=\"exampleFormControlFile1\" name=\"uploadImage\">".
                            $errorUpload
                        . "</div>
                        <div class=\"d-flex justify-content-around\">
                            <button type=\"submit\" class=\"btn btn-primary\" name=\"buttonCreateCostumer\">Create</button><a href=\"\" class=\"btn btn-primary\">Return</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>";
}

function uploadFile()
{
    //global $errorUpload;
    $errorUpload = "";
    //$fileExist = false;

    $fileType = $_FILES["uploadImage"]["type"];

    //SI no existe la carpeta, la crea
    $rutaDef = "../uploads/";
    if (!is_dir($rutaDef)) {
        mkdir($rutaDef);
    }

    //Comprueba que el fichero existe para reemplazarlo y no tener que escribir un dato más en datosFichero
    //if (file_exists($rutaDef . $_FILES["ficheroSubido"]['name'])) {
    //    $fileExist = true;
    //}

    //Mueve y reescribe el fichero
    if ($fileType == "image/jpg" || $fileType == "image/jpeg" || $fileType == "image/png" || $fileType == "image/png") {
        if (strlen($_FILES["uploadImage"]['name']) <= 60) {
            if ($_FILES["uploadImage"]['size'] <= 1048576) {
                $fileName = $_FILES["uploadImage"]['name'];
                $folderAddress = "../uploads/";
                move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $folderAddress . $fileName);
            } else {
                $errorUpload = "<p class=\"text-danger\">Max size image 1 MB</p>";
            }
        } else {
            $errorUpload = "<p class=\"text-danger\">Name too huge, change the name.</p>";
        }
        /*if ($_FILES["uploadImage"]['size'] <= 1048576) {
            $fileName = $_FILES["uploadImage"]['name'];
            $folderAddress = "../uploads/";
            move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $folderAddress . $fileName);
        } else {
            $errorUpload = "<p class=\"text-danger\">Max size image 1 MB</p>";
        }*/
        /*$fileName = $_FILES["uploadImage"]['name'];
        $folderAddress = "../uploads/";
        move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $folderAddress . $fileName);*/
    } else {
        $errorUpload = "<p class=\"text-danger\">Only files jpg, jpeg, png and gif</p>";
    }

    return $errorUpload;
}

/*function tableAllCostumers($allCostumers) {

    $dataCostumers = "";
    foreach ($allCostumers as $costumerObject) {
        $userLastModify = "";
        if ($costumerObject->getIdUserLastModify() == null || $costumerObject->getIdUserLastModify() == "") {
            $userLastModify = "EMPTY";   
        } else {
            $userLastModify = $costumerObject->getIdUserLastModify();
        }
        $dataCostumers .=
            "<tr>
                <th scope=\"row\">". $costumerObject->getIdCostumer() . "</th>
                <td>" . decrypt($costumerObject->getNameCostumer(), "1235@") . "</td>
                <td>" . decrypt($costumerObject->getSurname(), "1235@") . "</td>
                <td>" . $costumerObject->getIdUserCreator() . "</td>
                <td>" . $userLastModify . "</td>
            </tr>";
    }

    $dataTable =
        "<div class=\"row mt-5\">
            <div class=\"mx-auto w-75 p-3 text-center opacity-80\">
                <h1 class=\"mb-0\">LIST ALL COSTUMERS</h1>
                <hr>
                <table class=\"table table-striped table-dark\">
                  <thead>
                    <tr>
                      <th scope=\"col\">ID</th>
                      <th scope=\"col\">First name</th>
                      <th scope=\"col\">Surname</th>
                      <th scope=\"col\">ID user creator</th>
                      <th scope=\"col\">ID last user modify</th>
                    </tr>
                  </thead>
                  <tbody>
                  ". $dataCostumers . "
                  </tbody>
                </table>
            </div>
        </div>";

        return $dataTable;
}*/

function showFormNumberRows($numberRows, $errorNumberRows) {

    return "<div class=\"row w-100 mt-5\">
            <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                <h1 class=\"mb-0\">CHOOSE THE NUMBER OF LINES</h1>
                <hr>
                <div class=\"list-group mt-3\">
                    <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">
                        <div class=\"form-group col-md-6 mx-auto\">
                            <label for=\"inputName\">Choose the number of lines to show in the table</label>
                            <input type=\"number\" class=\"form-control\" id=\"numberRows\" name=\"numberRows\" value=\"" . $numberRows . "\" placeholder=\"1\">".
                            $errorNumberRows. "
                        </div>
                        <div class=\"d-flex justify-content-around\">
                            <button type=\"submit\" class=\"btn btn-primary\" name=\"showTable\">Show table</button><a href=\"\" class=\"btn btn-primary\">Return</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>";
}

function showFormFindCostumer($number, $errorNumber) {
    return "<div class=\"row w-100 mt-5\">
            <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                <h1 class=\"mb-0\">GET FULL CUSTOMER INFORMATION</h1>
                <hr>
                <div class=\"list-group mt-3\">
                    <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">
                        <div class=\"form-group col-md-6 mx-auto\">
                            <label for=\"numberId\">Which customer do you want to look for? Only numbers</label>
                            <input type=\"number\" class=\"form-control\" id=\"numberId\" name=\"numberId\" value=\"" . $number . "\" placeholder=\"1\">".
                            $errorNumber. "
                        </div>
                        <div class=\"d-flex justify-content-around\">
                            <button type=\"submit\" class=\"btn btn-primary\" name=\"findCostumerInformation\">Show customer</button><a href=\"\" class=\"btn btn-primary\">Return</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>";
}

function showFormFindCostumerToUpdate($number, $errorNumber) {
    return "<div class=\"row w-100 mt-5\">
            <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                <h1 class=\"mb-0\">UPDATE AN EXISTING CUSTOMER</h1>
                <hr>
                <div class=\"list-group mt-3\">
                    <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">
                        <div class=\"form-group col-md-6 mx-auto\">
                            <label for=\"numberId\">Which customer do you want to look for to update? Only numbers</label>
                            <input type=\"number\" class=\"form-control\" id=\"numberId\" name=\"numberId\" value=\"" . $number . "\" placeholder=\"1\">".
                            $errorNumber. "
                        </div>
                        <div class=\"d-flex justify-content-around\">
                            <button type=\"submit\" class=\"btn btn-primary\" name=\"findCustomerInformationToUpdate\">Show customer</button><a href=\"\" class=\"btn btn-primary\">Return</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>";
}

function showFormUpdateCustomer($customer, $errorIdCustomer, $errorName, $errorSurname, $errorUpload) {

    //$errorName = $errorSurname = $errorUpload = "";

    $image = "";
    if ($customer->getImage() == null || $customer->getImage() == "") {
        $image = "<input type=\"hidden\" class=\"form-control-file\" id=\"customerFile\" name=\"uploadImageHidden\" value=\"\">";
    } else {
        $image = "<input type=\"hidden\" class=\"form-control-file\" id=\"customerFile\" name=\"uploadImageHidden\" value=\"" . decrypt($customer->getImage(), "1235@") . "\">
        <label for=\"checkboxDeleteImage\" class=\"mt-3\">Would you like to delete the customer image?</label>
        <input type=\"checkbox\" class=\"form-control-file\" id=\"checkboxDeleteImage\" name=\"checkboxDeleteImage\" value=\"yes\">";
    }

    //echo "<img src=\"../uploads/" . decrypt($customer->getImage(), "1235@") . "\">";

        return "<div class=\"row w-100 mt-5 mb-5\">
            <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                <h1 class=\"mb-0\">CREATE A NEW COSTUMER</h1>
                <hr>
                <div class=\"list-group mt-3\">
                    <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">
                        <div class=\"form-group col-md-6 mx-auto\">
                            <label for=\"idCustomer\">ID customer</label>
                            <input type=\"hidden\" class=\"form-control\" id=\"idCustomer\" name=\"idCustomerHidden\" value=\"" . $customer->getIdCostumer() . "\" placeholder=\"Name\">
                            <input type=\"text\" class=\"form-control\" id=\"idCustomer\" name=\"idCustomer\" value=\"" . $customer->getIdCostumer() . "\" placeholder=\"Name\">".
                            $errorIdCustomer
                        . "</div>
                        <div class=\"form-group col-md-6 mx-auto\">
                            <label for=\"name\">Name</label>
                            <input type=\"text\" class=\"form-control\" id=\"name\" name=\"name\" value=\"" . decrypt($customer->getNameCostumer(), "1235@") . "\" placeholder=\"Name\">".
                            $errorName
                        . "</div>
                        <div class=\"form-group col-md-6 mx-auto\">
                            <label for=\"surname\">Surname</label>
                            <input type=\"text\" class=\"form-control\" id=\"surname\" name=\"surname\" value=\"" . decrypt($customer->getSurname(), "1235@") . "\" placeholder=\"Surname\">".
                            $errorSurname
                        ."</div>
                        <div class=\"form-group mx-auto\">
                            <label for=\"customerFile\">Choose customer file</label>
                            <input type=\"file\" class=\"form-control-file\" id=\"customerFile\" name=\"uploadImage\">
                            $image".
                            $errorUpload
                        . "</div>
                        <div class=\"d-flex justify-content-around\">
                            <button type=\"submit\" class=\"btn btn-primary\" name=\"buttonUpdateCustomer\">Update</button><a href=\"\" class=\"btn btn-primary\">Return</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>";
}

function thereIsThatID($idCustomer, $allCustomers) 
{
    foreach ($allCustomers as $customerObject) {
        if ($idCustomer == $customerObject->getIdCostumer()) {
            return false;
        }
    }
    return true;
}

function showFormFindCostumerToDelete($idCustomer, $errorIdCustomer) 
{
    return "<div class=\"row w-100 mt-5\">
            <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                <h1 class=\"mb-0\">DELETE A CUSTOMER</h1>
                <hr>
                <div class=\"list-group mt-3\">
                    <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">
                        <div class=\"form-group col-md-6 mx-auto\">
                            <label for=\"idCustomer\">Which customer do you want to look for to delete? Only numbers</label>
                            <input type=\"number\" class=\"form-control\" id=\"idCustomer\" name=\"idCustomer\" value=\"" . $idCustomer . "\" placeholder=\"1\">
                            " . $errorIdCustomer . "
                        </div>
                        <div class=\"d-flex justify-content-around\">
                            <button type=\"submit\" class=\"btn btn-primary\" name=\"findCustomerInformationToDelete\">Delete customer</button><a href=\"\" class=\"btn btn-primary\">Return</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>";
}