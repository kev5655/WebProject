<!-- *********************************************** -->
<!-- Programm 'Contacts' / Denis Kjelsberg / 01.2020 -->
<!-- *********************************************** -->

<!DOCTYPE html>
<html>
  <head>
    <meta content="text/html; charset=utf-8" http-equiv="content-type">
    <title>Contacts</title>

    <!-- Untenstehend, Einstellung damit die Webpage 'responsive' reagiert -->
    <meta name="viewport" content="width=device-width, initial-scale=0.7">

	<style>
	  div { padding: 5px; border: 2px solid #DDDDDD; margin-right: 5px; margin-bottom: 5px }
	  table { border: 2px solid #DDDDDD; border-collapse: collapse }
	  th { padding: 5px; text-align: left; background-color: #DDDDDD }
	  td { padding-left: 5px; border-bottom: 1px solid #DDDDDD }
	</style>

	<script src="./AjaxClientScript.js"></script>
  </head>
  <body>
    <h1>Kontakte</h1>

	<?php
		require_once ('./OwnLogging_class.php');
		$OwnLogging = new OwnLogging ();		// Ein Objekt der Klasse kreieren
	?>

	<?php
		require_once ('./DataBase_classes.php');

	// INIT: Untenstehend wird die Verbindung zur MySQL-Datenbank hergestellt
	// vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
		$AccessContDB = new AccessContDB ();	// Ein Objekt der Klasse kreieren

		$Infos = array ( 1 => "Ist Sportler",				 2 => "Ist Raucher",			// it's an associative array
						 4 => "Ist verheiratet",			 8 => "Ist zu Fuss unterwegs",
						16 => "Ist mit dem ÖV unterwegs",	32 => "Hat ein Elektrofahrrad",
						64 => "Hat den Auto-Führerschein");
	?>

	<?php
	// WRITE: Untenstehend wird ein neu eingegebener Eintrag als neuen Datensatz in der Haupt-Tabelle (DB) gespeichert
	// vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
		if (isset($_POST['ContactButton'])) {		// Button gedrückt, um "Kontakt zu erfassen"
			// Untenstehend werden die durch die Checkboxes gesetzten Bits zusammengefügt, indem sie zusammen addiert werden
			$infosCheckboxes = $_POST['InfosCheckbox1'] + $_POST['InfosCheckbox2'] + $_POST['InfosCheckbox3'] + $_POST['InfosCheckbox4'] +
							   $_POST['InfosCheckbox5'] + $_POST['InfosCheckbox6'] + $_POST['InfosCheckbox7'];

			// Untenstehend wird der neue Kontakt als Array vorbereitet
			$newContact = array ($_POST['AnredeRadiobutton'], $_POST['NameTextfield'], $_POST['VornameTextfield'],
								 $_POST['PlzNumberfield'], $_POST['GeburtsjahrDropdown'], $infosCheckboxes);

			// Untenstehend werden alle HTML- und PHP-Tags aus den eingelesenen
			// Strings entfernt, um 'Cross-Site Scripting' ('CSS') zu verhindern !
			for ($i=0; $i < count($newContact); $i++)
				if (is_string ($newContact[$i]))
					$newContact[$i] = strip_tags ($newContact[$i]);

			$returnStatus = $AccessContDB->writeDataBase ($newContact);

			if ($returnStatus == 1)				// "1" entspricht der Anzahl eingefügter Kontakte, wenn alles i.O. lief
				echo "<p style='color:green'><strong><em> Der neue Kontakt wurde erfolgreich hinzugefügt ... </em></strong></p>";
			else {	// Dieses 'else' kommt nur bei Eingabe ungültiger PLZ zum Tragen; andere
					// Fehler beim Aufruf von 'writeDataBase' erzeugen einen Programmabbruch
				if ($returnStatus == 23000)		// "23000" entspricht dem Fehlercode, falls angegebene PLZ ungültig ist
					echo "<p style='color:red'><em> Die angegebene PLZ ist ungültig bzw. existiert nicht ... </em></p>";
				echo "<p style='color:red'><strong><em> Der neue Kontakt konnte nicht hinzugefügt werden ! </em></strong></p>";
			}
		}
	?>

  <div style="width: 80%; min-width: 550px">
    <h2>Liste aller Kontakte ...</h2>
	<table>
	  <tr> <th>ID</th> <th>Anrede</th> <th>Name</th> <th>Vorname</th> <th>PLZ</th> <th>Ortschaft</th> <th>Geburtsjahr</th> <th>Infos</th> </tr>
	<?php
	// READ: Untenstehend werden alle in der Haupt-Tabelle (DB) gespeicherten Datensätze in einer Schleife ausgegeben
	// vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
		$dataHandle = $AccessContDB->readDataBase ("%");

		while (($dataRecord = $dataHandle->fetchObject()) != false) {	// In dieser Schleife werden alle Datensätze der Tabelle behandelt ...
			// Untenstehend wird geschaut, ob das entsprechende Bit gesetzt ist und ggf. wird der Text ($infosTextlist) erweitert
			$infosTextlist = "";
	/*		if (($dataRecord->Infos & 1) != 0)   $infosTextlist = $infosTextlist . "Ist Sportler / ";
			if (($dataRecord->Infos & 2) != 0)   $infosTextlist = $infosTextlist . "Ist Raucher / ";
			if (($dataRecord->Infos & 4) != 0)   $infosTextlist = $infosTextlist . "Ist verheiratet / ";
			if (($dataRecord->Infos & 8) != 0)   $infosTextlist = $infosTextlist . "Ist zu Fuss unterwegs / ";
			if (($dataRecord->Infos & 16) != 0)  $infosTextlist = $infosTextlist . "Ist mit dem ÖV unterwegs / ";
			if (($dataRecord->Infos & 32) != 0)  $infosTextlist = $infosTextlist . "Hat ein Elektrofahrrad / ";
			if (($dataRecord->Infos & 64) != 0)  $infosTextlist = $infosTextlist . "Hat den Auto-Führerschein / "; */

			foreach ($Infos as $bitValue => $infoText)	// hier eine optimierte Logik, welche die obenstehende Logik ersetzt ...
				if (($dataRecord->Infos & $bitValue) != 0)  $infosTextlist = $infosTextlist . $infoText." / ";

			// Untenstehend werden alle Elemente des Kontakts als Tabelleninhalt <td> ausgegeben; <th> wurde bereits ausgegeben
			echo "<tr> <td><em>".$dataRecord->ID_Freund."</em></td>" . "<td style='text-align: center'>".$dataRecord->Anrede."</td>" .
			          "<td>".$dataRecord->Name."</td>" . "<td>".$dataRecord->Vorname."</td>" . "<td>".$dataRecord->F_PLZ."</td>" .
			          "<td>".$dataRecord->Ortschaft."</td>" . "<td>".$dataRecord->Geburtsjahr."</td>" . "<td>".$infosTextlist."</td> </tr>";
		}
	?>
	</table>
  </div><br>

  <div style="width: 80%; min-width: 330px">
    <h2>Ein neuer Kontakt erfassen ...</h2>
    <form method="POST" action="" name="ContactForm">
	  <div style="width: 100px; float: left">
	    <strong> Anrede: </strong> <br>
	    <!-- Der 1.Eintrag dient dazu, etwas über "POST" zu erhalten ('isset'), auch falls der Radiobutton nicht gewählt wurde -->
	    <input type="radio" name="AnredeRadiobutton" value="??" style="display:none" checked>
	    <input type="radio" name="AnredeRadiobutton" value="Fr."> Frau<br>
	    <input type="radio" name="AnredeRadiobutton" value="Hr."> Herr<br>
	  </div>

	  <div style="width: 200px; float: left">
	    <strong> Name:    </strong> <br> <input type="text" name="NameTextfield"    required> <br>
	    <strong> Vorname: </strong> <br> <input type="text" name="VornameTextfield" required> <br><br>

	    <strong> Geburtsjahr: </strong> <br>
	    <select name="GeburtsjahrDropdown">
	      <option value="" selected>  ???? </option>
	      <option value="1920-1939"> 1920-1939 </option>
	      <option value="1940-1959"> 1940-1959 </option>
	      <option value="1960-1979"> 1960-1979 </option>
	      <option value="1980-1999"> 1980-1999 </option>
	      <option value="2000-2019"> 2000-2019 </option>
	      <option value="2020-2039"> 2020-2039 </option>
	    </select> <br>
	  </div>

	  <div style="width: 200px; float: left">
	    <strong> PLZ:       </strong> <br> <input type="number" name="PlzNumberfield" oninput="getLocality(this.value)"> <br>
	    <strong> Ortschaft: </strong> <br> <input type="text" id="OrtschaftTextfield" value="wird automatisch ergänzt ..." style="width:198px; color:grey" readonly> <br>
	  </div>

	  <div style="width: 200px; float: left">
	    <strong> Infos: </strong> <br>
	    <!-- Das "hidden" dient dazu, einen Wert über "POST" zu erhalten ('isset'), auch wenn die Checkbox nicht gewählt wurde -->
<!--    <input type="hidden"   name="InfosCheckbox1" value="0" />
	    <input type="checkbox" name="InfosCheckbox1" value="1"> Ist Sportler<br>
	    <input type="hidden"   name="InfosCheckbox2" value="0" />
	    <input type="checkbox" name="InfosCheckbox2" value="2"> Ist Raucher<br>
	    <input type="hidden"   name="InfosCheckbox3" value="0" />
	    <input type="checkbox" name="InfosCheckbox3" value="4"> Ist verheiratet<br>
	    <input type="hidden"   name="InfosCheckbox4" value="0" />
	    <input type="checkbox" name="InfosCheckbox4" value="8"> Ist zu Fuss unterwegs<br>
	    <input type="hidden"   name="InfosCheckbox5" value="0" />
	    <input type="checkbox" name="InfosCheckbox5" value="16"> Ist mit dem ÖV unterwegs<br>
	    <input type="hidden"   name="InfosCheckbox6" value="0" />
	    <input type="checkbox" name="InfosCheckbox6" value="32"> Hat ein Elektrofahrrad<br>
	    <input type="hidden"   name="InfosCheckbox7" value="0" />
	    <input type="checkbox" name="InfosCheckbox7" value="64"> Hat den Auto-Führerschein<br> -->

	<?php	// hier eine optimierte Logik, welche die obenstehende Logik ersetzt ...
		$checkboxNr = 1;
		foreach ($Infos as $bitValue => $infoText) {
	?>
	    <input type="hidden"   name="InfosCheckbox<?php echo $checkboxNr ?>" value="0" />
	    <input type="checkbox" name="InfosCheckbox<?php echo $checkboxNr ?>" value="<?php echo $bitValue ?>"> <?php echo $infoText ?><br>
	<?php
		$checkboxNr++;
		}
	?>
	  </div>

	  <br style="clear: left" />	<!-- Das "clear: left" dient dazu, das vorige "float: left" (<div>) wieder zu deaktivieren -->
      <button type="submit" name="ContactButton" value=""> Kontakt erfassen </button>
    </form>
  </div><br>

  <footer>
    <p> <br> © 2020 / Denis Kjelsberg / <a href="mailto:kjede@gmx.ch"> kjede@gmx.ch</a> / All rights reserved</p>
  </footer>
  </body>
</html>
