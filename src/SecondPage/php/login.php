

<?php include('../php/DataBase_classes.php')?>


<?php

    $AccessContDB = new AccessContDB ();
    $haveAcc = false;

    if (isset($_POST['login'])) {	

        $acc = $AccessContDB->getUserIdSQL("Vorname", "UserId", "Passwort", "t_user", $_POST['email']);

        while (($dataRecord = $acc->fetchObject()) != false) {
            $psw = $dataRecord->Passwort;
            $haveAcc = true;
            if($psw == $_POST['psw']){
                // Passwort korrekt
                session_start();
                $_SESSION['userId'] = $dataRecord->UserId;
                $_SESSION['name'] = $dataRecord->Vorname;
                header("Location: ../page/UserPage.php");
                
            }else{
                // Passwort falsch
                header("Location: ../../../index.html");
                
            }
        }
        if(! $haveAcc){
            header("Location: ../../../index.html");
        }
    }



?>