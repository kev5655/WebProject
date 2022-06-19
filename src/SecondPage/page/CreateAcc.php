<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../../../build/stylesheets/index.css">

</head>

<?php include('../php/DataBase_classes.php') ?>

<body>

  <div class="form_wrapper">
    <div class="form_container">
      <div class="title_container">
        <h2>Sign Up</h2>
      </div>
      <div class="row clearfix">
        <div class="">
          <form method="POST" action="" name="signUp">
            <div class="input_field"> <span><i aria-hidden="true" class="fa fa-envelope"></i></span>
              <input type="email" name="email" placeholder="Email" required value="admin@admin.ch" />
            </div>
            <div class="input_field"> <span><i aria-hidden="true" class="fa fa-lock"></i></span>
              <input type="password" name="password" placeholder="Password" required value="1234" />
            </div>
            <div class="input_field"> <span><i aria-hidden="true" class="fa fa-lock"></i></span>
              <input type="password" name="password" placeholder="Re-type Password" required value="1234" />
            </div>
            <div class="row clearfix">
              <div class="col_half">
                <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                  <input type="text" name="firstname" placeholder="First Name" value="adminName" />
                </div>
              </div>
              <div class="col_half">
                <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                  <input type="text" name="lastname" placeholder="Last Name" required value="adminLastName" />
                </div>
              </div>
            </div>
            <input class="button" type="submit" value="Register" name="signUp" />
          </form>
        </div>
      </div>
    </div>
  </div>
  <p class="credit">Developed by <a href="http://www.designtheway.com" target="_blank">Design the way</a></p>

</body>

</html>

<?php
session_start();

$AccessContDB = new AccessContDB();

if (isset($_POST['signUp'])) {

  if (!($AccessContDB->isAvailableInTabel("t_user", $_POST['email']))) {
    $newContact = array($_POST['email'], $_POST['password'], $_POST['firstname'], $_POST['lastname']);

    for ($i = 0; $i < count($newContact); $i++)
      if (is_string($newContact[$i]))
        $newContact[$i] = strip_tags($newContact[$i]);

    $returnStatus = $AccessContDB->writeDataBase($newContact);

    if ($returnStatus == 1)
      echo "<p style='color:green'><strong><em> Der neue Kontakt wurde erfolgreich hinzugefügt ... </em></strong></p>";
    else {
      if ($returnStatus == 23000)
        echo "<p style='color:red'><em> Die angegebene PLZ ist ungültig bzw. existiert nicht ... </em></p>";
      echo "<p style='color:red'><strong><em> Der neue Kontakt konnte nicht hinzugefügt werden ! </em></strong></p>";
    }

    $id = $AccessContDB->getUserIdSQL("Vorname", "UserId", "Passwort", "t_user", $_POST['email']);
    $userId;
    while (($dataRecord = $id->fetchObject()) != false) {
      $userId = (int)$dataRecord->UserId;
    }

    $_SESSION['userId'] = $userId;
    $_SESSION['name'] = $_POST['firstname'];

    header("Location: ../page/UserPage.php");
  }else{
    echo "Account ist schon vorhanden";
  }
}
?>