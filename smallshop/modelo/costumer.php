<?php

class Costumer
{
    private $idCostumer;
    private $nameCostumer;
    private $surname;
    private $image;
    private $idUserCreator;
    private $idUserLastModify;

    public function __construct($idCostumer, $nameCostumer, $surname, $image, $idUserCreator, $idUserLastModify)
    {
        $this->idCostumer = $idCostumer;
        $this->nameCostumer = $nameCostumer;
        $this->surname = $surname;
        $this->image = $image;
        $this->idUserCreator = $idUserCreator;
        $this->idUserLastModify = $idUserLastModify;
    }

    /* Getters */
    public function getIdCostumer()
    {
        return $this->idCostumer;
    }
    public function getNameCostumer()
    {
        return $this->nameCostumer;
    }
    public function getSurname()
    {
        return $this->surname;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function getIdUserCreator()
    {
        return $this->idUserCreator;
    }
    public function getIdUserLastModify()
    {
        return $this->idUserLastModify;
    }

    /* Setters */
    public function setIdCostumer($idCostumer)
    {
        $this->idCostumer = $idCostumer;
    }
    public function setNameCostumer($nameCostumer)
    {
        $this->nameCostumer = $nameCostumer;
    }
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }
    public function setImage($image)
    {
        $this->image = $image;
    }
    public function setIdUserCreator($idUserCreator)
    {
        $this->idUserCreator = $idUserCreator;
    }
    public function setIdUserLastModify($idUserLastModify)
    {
        $this->idUserLastModify = $idUserLastModify;
    }

    //Other functions
    public function dataSheetCostumer($allUsers)
    {
        $userCreator = null;
        $userLastModify = null;
        foreach ($allUsers as $userObject) {
            if ($userObject->getIdUser() == $this->idUserCreator) {
                $userCreator = $userObject;
            }
            if ($userObject->getIdUser() == $this->idUserLastModify) {
                $userLastModify = $userObject;
            }
        }

        $cardLastModify = "";
        if ($userLastModify != null) {
            $cardLastModify = "<p class=\"card-text\"><span class=\"font-weight-bold\">ID user update:</span> " . $this->idUserCreator . ". <span class=\"font-weight-bold\">Username:</span> " . decrypt($userLastModify->getUsername(), "1235@") . "</p>";
        } else {
            $cardLastModify = "<p class=\"card-text\"><span class=\"font-weight-bold\">ID user update:</span> EMPTY. <span class=\"font-weight-bold\">Username:</span> EMPTY. </p>";
        }

        $image = "";
        if (strlen($this->image) > 1) {
            $image = "\"..\\uploads\\" . decrypt($this->image, "1235@") . "\"";
        }

        $dataSheet =
            "<div class=\"card mb-3 mt-3 mx-auto w-100 text-left\">
              <div class=\"row no-gutters\">
                <div class=\"col-md-4\">
                  <img src=" . $image . " class=\"card-img\" alt=\"File Not Found\">
                </div>
                <div class=\"col-md-8\">
                  <div class=\"card-header\">
                    <h5 class=\"card-title\">Id: " . $this->idCostumer . "</h5>
                  </div>
                  <div class=\"card-body\">
                    <h5 class=\"card-title\">Surname: " . decrypt($this->surname, "1235@") . "</h5>
                    <h5 class=\"card-title\">Name: " . decrypt($this->nameCostumer, "1235@") . "</h5>
                    <hr>
                    <p class=\"card-text\"><span class=\"font-weight-bold\">ID user creator:</span> " . $this->idUserCreator . ". <span class=\"font-weight-bold\">Username:</span> " . decrypt($userCreator->getUsername(), "1235@") . "</p>
                    " . $cardLastModify . "
                  </div>
                </div>
              </div>
            </div>";

        return $dataSheet;
    }

    /*public function dataAllCostumers()
    {
        $cardLastModify = "";
        if ($this->idUserLastModify != null) {
            //$cardLastModify = "<p class=\"card-text\"><span class=\"font-weight-bold\">ID user creator:</span> " . $this->idUserCreator . ". <span class=\"font-weight-bold\">Username:</span> " . decrypt($userLastModify->getUsername(), "1235@") . "</p>";
        } else {
            //$cardLastModify = "<p class=\"card-text\"><span class=\"font-weight-bold\">ID user creator:</span> EMPTY. <span class=\"font-weight-bold\">Username:</span> EMPTY. </p>";
        }

        /*$image = "";
        if (strlen($this->image) > 1) {
            $image = "\"..\\uploads\\" . decrypt($this->image, "1235@") . "\"";
        }*/

        /*$dataTable =
            "<table class=\"table table-striped\">
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
          </tbody>
        </table>";*/

        /*$dataSheet =
            "<div class=\"card mb-3 mt-3 mx-auto w-100 text-left\">
              <div class=\"row no-gutters\">
                <div class=\"col-md-4\">
                  <img src=" . $image . " class=\"card-img\" alt=\"File Not Found\">
                </div>
                <div class=\"col-md-8\">
                  <div class=\"card-header\">
                    <h5 class=\"card-title\">Id: " . $this->idCostumer . "</h5>
                  </div>
                  <div class=\"card-body\">
                    <h5 class=\"card-title\">Surname: " . decrypt($this->surname, "1235@") . "</h5>
                    <h5 class=\"card-title\">Name: " . decrypt($this->nameCostumer, "1235@") . "</h5>
                    <hr>
                    <p class=\"card-text\"><span class=\"font-weight-bold\">ID user creator:</span> " . $this->idUserCreator . ". <span class=\"font-weight-bold\">Username:</span> " . decrypt($userCreator->getUsername(), "1235@") . "</p>
                    " . $cardLastModify . "
                  </div>
                </div>
              </div>
            </div>";*/

        /*return $dataSheet;
    }*/

    /*public function showFormUpdateCustomer() {
        return "<div class=\"row w-100 mt-5\">
            <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                <h1 class=\"mb-0\">CREATE A NEW COSTUMER</h1>
                <hr>
                <div class=\"list-group mt-3\">
                    <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">
                        <div class=\"form-group col-md-6 mx-auto\">
                            <label for=\"idCustomer\">ID customer</label>
                            <input type=\"text\" class=\"form-control\" id=\"idCustomer\" name=\"idCustomer\" value=\"" . $name . "\" placeholder=\"Name\">".
                            $errorName
                        . "</div>
                        <div class=\"form-group col-md-6 mx-auto\">
                            <label for=\"name\">Name</label>
                            <input type=\"text\" class=\"form-control\" id=\"name\" name=\"name\" value=\"" . $name . "\" placeholder=\"Name\">".
                            $errorName
                        . "</div>
                        <div class=\"form-group col-md-6 mx-auto\">
                            <label for=\"surname\">Surname</label>
                            <input type=\"text\" class=\"form-control\" id=\"surname\" name=\"surname\" value=\"" . $surname . "\" placeholder=\"Surname\">".
                            $errorSurname
                        ."</div>
                        <div class=\"form-group mx-auto\">
                            <label for=\"customerFile\">Choose customer file</label>
                            <input type=\"file\" class=\"form-control-file\" id=\"customerFile\" name=\"uploadImage\">".
                            $errorUpload
                        . "</div>
                        <div class=\"d-flex justify-content-around\">
                            <button type=\"submit\" class=\"btn btn-primary\" name=\"buttonCreateCostumer\">Create</button><a href=\"\" class=\"btn btn-primary\">Return</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>";
    }*/
}
