
      <h1><br>Um eine Datei mit einem 'Input File' Formular auf den Server hochzuladen ...</h1>
      <!-- Die Übermittlung von Dateien vom Browser zum Server funktioniert nur mit der 'POST'-Methode                    -->
      <!-- Damit nicht nur der Dateiname sondern auch der Dateninhalt übermittelt werden: 'enctype="multipart/form-data"' -->
      <!-- In der Datei "...\XAMPP\php\php.ini" ist das Hochladen von Dateien Serverseitig definiert: u.a. "file_uploads" -->
      <form method="POST" enctype="multipart/form-data" action="" name="UploadForm">
        Hochzuladende Datei wählen (jpg, mp3, mp4 oder pdf)...
        <input type="file" name="UploadFile" accept="image/jpeg, audio/x-mpeg, video/mpeg, application/pdf"> 
        <button type="submit" name="UploadButton" value=""> Datei hochladen </button>
      </form>

	<?php
		if (isset($_POST['UploadButton']) &&
		//	isset($_FILES['UploadFile']))	// Dies funktioniert nicht, Ergebnis von 'isset' ist hier immer "true" ...
			$_FILES['UploadFile']['error'] == UPLOAD_ERR_OK)	// Stattdessen soll kontrolliert werden, ob die Datei
			{													// in das 'tmp'-Verzeichnis heruntergeladen wurde !
			echo "<br>Informationen zur hochgeladenen Datei...";
			echo "<br> - DateiName: " .   $_FILES['UploadFile']['name'];
			echo "<br> - DateiMime: " .   $_FILES['UploadFile']['type'];
			echo "<br> - TempDatei: " .   $_FILES['UploadFile']['tmp_name'];
			echo "<br> - DateiGrösse: " . $_FILES['UploadFile']['size'];
			echo "<br> - FehlerCode: " .  $_FILES['UploadFile']['error'];

			// Ab hier geht es darum der erhaltenen Datei einige Plausibilisierungstests unterzuziehen.
			// In einer Datenbank haben wir das DBMS, welches sicherstellt, dass die DB konsistent bleibt;
			// für die hochgeladenen Dateien geht es auch darum, die bestmögliche Konsistenz zu erreichen.
			if ($_FILES['UploadFile']['error'] == UPLOAD_ERR_OK)
				$uploadOK = true;		// Wir machen einige Kontrollen und nehmen mal an, dass alles erfolgreich ablaufen wird ...
			else {
				$uploadOK = false;		// Wir müssen abbrechen, da es bereits beim Übermitteln mit 'POST' Probleme gegeben hat !
				echo "<br>Fehler 'Upload' / 'POST_ERROR'";
				}
			if ($uploadOK == true) {
				// Die Dateinamenserweiterung (File Ext) soll geprüft / verglichen werden ...
				$fileExt = pathinfo($_FILES['UploadFile']['name'], PATHINFO_EXTENSION);
				if (!($fileExt == "jpg" || $fileExt == "mp3" ||
				      $fileExt == "mp4" || $fileExt == "pdf")) {
					$uploadOK = false;
					echo "<br>Fehler 'Upload' / 'EXT_CHECK'";
					}
				}
			if ($uploadOK == true) {
				// Der 'Internet Media Type' (File MIME) soll geprüft / verglichen werden ...
				// $fileMime = $_FILES['UploadFile']['type'];
				// obenstehend hängt von der Dateinamenserweiterung ab => nicht zuverlässig !!!
				// untenstehend hängt vom Dateiinhalt ab => zuverlässig, auch wenn Erweiterung verfälscht
				$fileMime = mime_content_type($_FILES['UploadFile']['tmp_name']);
				if (!($fileMime == "image/jpeg" || $fileMime == "audio/x-mpeg" ||
				      $fileMime == "video/mpeg" || $fileMime == "application/pdf")) {
					$uploadOK = false;
					echo "<br>Fehler 'Upload' / 'MIME_CHECK'";
					}
				}
			if ($uploadOK == true) {
				// Ein Quercheck mit 'File-Ext' und 'File-Mime' kann noch durchgeführt werden ...
				if (!(($fileExt == "jpg" && $fileMime == "image/jpeg") ||
				      ($fileExt == "mp3" && $fileMime == "audio/x-mpeg") ||
				      ($fileExt == "mp4" && $fileMime == "video/mpeg") ||
				      ($fileExt == "pdf" && $fileMime == "application/pdf"))) {
					$uploadOK = false;
					echo "<br>Fehler 'Upload' / 'CROSS_CHECK'";
					}
				}
			if ($uploadOK == true) {
				// Die Grösse der Datei kann auch noch kontrolliert werden ...
				if ($_FILES['UploadFile']['size'] > 50000000) {		// 50 MB für z.B. Videos ...
					$uploadOK = false;
					echo "<br>Fehler 'Upload' / 'SIZE_CHECK'";
					}
				}
			if ($uploadOK == true) {
				// Die auf dem Server hochgeladene Datei soll jetzt vom provisorischen Verzeichnis ins definitive Verzeichnis
				// kopiert werden ...   Achtung, falls die Zieldatei bereits existiert, wird sie einfach überschrieben !!!
				$moveFile = move_uploaded_file($_FILES['UploadFile']['tmp_name'],
				                               "../../../rsc/uploadFiles/" . utf8_decode($_FILES['UploadFile']['name']));
				if (!$moveFile) {
					$uploadOK = false;
					echo "<br>Fehler 'Upload' / 'MOVE_ERROR'";
					}
				}
			if ($uploadOK == true)	// '$uploadOK' ist noch 'true', das heisst dass alles erfolgreich abgelaufen ist !
				echo "<br>Die gewählte Datei konnte erfolgreich hochgeladen werden...";
			else					// '$uploadOK' ist nicht mehr 'true', das heisst dass Fehler entdeckt wurden ...
				echo "<br>Leider konnte die gewählte Datei nicht hochgeladen werden...";
			}
	?>
