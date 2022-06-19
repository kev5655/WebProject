<?php
/* *********************************************** */
/* Programm 'Contacts' / Denis Kjelsberg / 08.2020 */
/* *********************************************** */

	require_once ('./DataBase_classes.php');	// Wir brauchen nur die Hauptklasse 'MySqlContDB'

	class AccessLocality extends MySqlContDB	// Es handelt sich um eine abgeleitete Klasse
	{
		function __construct() {
			error_reporting (0);	// Ist so definiert, damit bei Fehler, die an "AjaxClientScript.js" zurückge-
								// schickte Antwort nicht eine Fehlermeldung beinhaltet sondern einen leeren Text

			parent::__construct();
		}
		function __destruct() {
			parent::__destruct();
		}

		function ReadLocality ($postcode)
		{
			$postcode = (int) $postcode;	// Auch die im HTML mit 'input type="number"' eingelesenen Daten kommen
											// als 'string' daher => Typecasting als 'int' nötig für die DB-Tabelle

			// Die Ortschaft wird aus der Tabelle gelesen
			$sql = "SELECT Ortschaft " .	// Aus der Tabelle lesen (SELECT)
					  "FROM T_Ortschaft " .
					  "WHERE PLZ = :postcodeWhere";
			$prep_state = $this->ContDB->prepare($sql);
			$prep_state->bindParam(':postcodeWhere', $postcode, PDO::PARAM_INT);	// Bindung der Variable an den Platzhalter
			$prep_state->execute();

			if ($prep_state->rowCount() > 0) {
				$dataRecord = $prep_state->fetchObject();
				$locality = $dataRecord->Ortschaft;
			}
			else
				$locality = "Unbekannte PLZ !";

			return $locality;
		}
	}	// end of class 'AccessLocality'


	// Der Hauptteil des Programms beginnt hier ...
	if (isset($_GET['Postcode'])) {		// PLZ angegeben, um Ortschaft zu erhalten
		$Postcode = $_GET['Postcode'];

		$AccessLocality = new AccessLocality ();	// Ein Objekt der Klasse kreieren

		echo $AccessLocality->ReadLocality ($Postcode);
	}
?>
