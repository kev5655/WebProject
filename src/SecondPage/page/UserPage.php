<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/userStyles.css">
    <script src="../js/AjaxClientScript.js"></script>

</head>

<?php
    session_start();
    include('../php/DataBase_classes.php');
?>


<body>
    <?php 
        echo '<h1 id="username">Hallo ' . $_SESSION['name'] ."</h1>";
    ?>

    

    <form  method="POST" enctype="multipart/form-data" action="" name="UploadForm">
        <label>Titel</label>
        <input class="input" type="text" id="title" name="title" required>
        <label>Beschreibung</label>
        <input class="input" type="text" id="description" name="beschrieb" required>
        <input type="file" name="UploadFile" accept="image/jpeg, audio/x-mpeg, video/mpeg, application/pdf"> 
        <input type="number" name="plzNumberfield" oninput="getLocality(this.value)" required>
        <input type="text" id="OrtschaftTextfield" value="wird automatisch ergänzt ..." style="width:198px; color:grey" readonly>
        <input class="btn" id="addNewPost" type="submit" name="UploadButton" value="add new Post">
    </form>
	<!--
    <div class="post">
        <p id="title">Title</p>
        <p id=description>Beschreibung</p>
		<img src="../../../rsc/uploadFiles/berge.jpg" alt="postImage" width="500" height="600">
		<p id="location"> Loaction </p>
	</div> -->

    <?php
        $AccessContDB = new AccessContDB();
        $msgs = $AccessContDB->getAllPostFromUser($_SESSION['userId']);
		addPostToWebsite($msgs);

		function addPostToWebsite($msgs){
			foreach($msgs as &$msg){
				echo "
				<div class='post'>
					<p id='title'>" . $msg['title'] . "</p>
					<p id=description> " . $msg['description'] . " </p>
					<img src='" . $msg['imagePath'] . "' alt='postImage' width='500' height='600'>
					<p id='location'> "  . $msg['name'] . "          "  . $msg['canton'] . "          "  . $msg['plz'] . "</p>
				</div>
				";
			}
		}

    ?>


    <?php
    
        function sendPost($imgPath, $imgSize, $title, $desc, $plz){
            $AccessContDB = new AccessContDB();
            $postId = $AccessContDB->writePostToDatabase($title, $desc, $_SESSION['userId']);
            
            $AccessContDB->writeImgToDatabase($imgPath, $imgSize, $postId);
            $AccessContDB->writeLinkLocationToDatabase($postId, $plz);
			$msgs = $AccessContDB->getPost($_SESSION['userId'], $postId);
			addPostToWebsite($msgs);
        }
    ?>

	<?php
		if (isset($_POST['UploadButton']) &&
		//	isset($_FILES['UploadFile']))	// Dies funktioniert nicht, Ergebnis von 'isset' ist hier immer "true" ...
			$_FILES['UploadFile']['error'] == UPLOAD_ERR_OK)	// Stattdessen soll kontrolliert werden, ob die Datei
			{													// in das 'tmp'-Verzeichnis heruntergeladen wurde !
			//echo "<br>Informationen zur hochgeladenen Datei...";
			//echo "<br> - DateiName: " .   $_FILES['UploadFile']['name'];
			//echo "<br> - DateiMime: " .   $_FILES['UploadFile']['type'];
			//echo "<br> - TempDatei: " .   $_FILES['UploadFile']['tmp_name'];
			//echo "<br> - DateiGrösse: " . $_FILES['UploadFile']['size'];
			//echo "<br> - FehlerCode: " .  $_FILES['UploadFile']['error'];

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
				$imgPath = "../../../rsc/uploadFiles/";
                $moveFile = move_uploaded_file($_FILES['UploadFile']['tmp_name'],
                                                $imgPath . utf8_decode($_FILES['UploadFile']['name']));
				if (!$moveFile) {
					$uploadOK = false;
					echo "<br>Fehler 'Upload' / 'MOVE_ERROR'";
                }else{
                    sendPost($imgPath . $_FILES['UploadFile']['name'],
                            $_FILES['UploadFile']['size'],
                            $_POST['title'],
                            $_POST['beschrieb'],
                            $_POST['plzNumberfield']);
                }
            }
			if ($uploadOK == true)	// '$uploadOK' ist noch 'true', das heisst dass alles erfolgreich abgelaufen ist !
				echo "<p>Post wurde erzeugt</p>";
			else					// '$uploadOK' ist nicht mehr 'true', das heisst dass Fehler entdeckt wurden ...
				echo "<br>Leider konnte die gewählte Datei nicht hochgeladen werden...";
			}

            

	?>
    
</body>
</html>