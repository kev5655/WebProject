<?php
/* *********************************************** */
/* Programm 'Contacts' / Denis Kjelsberg / 01.2017 */
/* *********************************************** */

	class MySqlContDB		// Es handelt sich um die Basis-Klasse
	{
		// vvvvv Attribute (Eigenschaften) vvvvv
		protected $ContDB = NULL;		// Dieses Attribut (Variable) wird kreiert und vorläufig mit 'NULL' initialisiert

		// vvvvv Methoden (Fähigkeiten) vvvvv
		function __construct()		// In dieser Methode geht es darum die Verbindung zur MySQL-DB herzustellen
		{
//			echo "MySqlContDB / __construct is called ...";

			if ($this->ContDB == NULL) {
				$this->ContDB = new PDO("mysql:host=localhost:3306; dbname=db_webuser; charset=utf8", "root", "");		// Verbindung mit DB herstellen mit u.a. der Angabe der 'utf8'-Kodierung

				$this->ContDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);					// Ab jetzt werden bei Problemen 'Exceptions' erzeugt => als "Fatal Error" gemeldet
																										// oder falls vorhanden, von einem selbstdefinierten 'Exception-Handler' abgefangen.
			}																							// (beim vorigen "new PDO ...", wird bei Problem bereits eine 'Exception' erzeugt !)
		}

		function __destruct()
		{
//			echo "MySqlContDB / __destruct is called ...";

			$this->ContDB = NULL;
		}

	}	// end of class 'MySqlContDB'


	class AccessContDB extends MySqlContDB		// Es handelt sich um die abgeleitete Klasse
	{
		function __construct() {
			parent::__construct();
		}
		function __destruct() {
			parent::__destruct();
		}

		function readDataBase ($searchedName){
			// Alle Freunde werden aus der Tabelle gelesen
			$sql = "SELECT F.ID_Freund, F.Anrede, F.Name, F.Vorname, " .				// Aus den Tabellen lesen (SELECT)
						  "F.Geburtsjahr, F.Infos, F.PLZ AS F_PLZ, O.Ortschaft " .		// bzw. aus 2 Tabellen (mit JOIN)
					  "FROM T_Freund AS F " .
						"LEFT JOIN T_Ortschaft AS O  ON F.PLZ = O.PLZ " .
					  "WHERE F.Name LIKE :nameWhere   ORDER BY F.Name ASC";
			$prep_state = $this->ContDB->prepare($sql);
			$prep_state->bindParam(':nameWhere', $searchedName, PDO::PARAM_STR);		// Bindung der Variable an den Platzhalter
			$prep_state->execute();

			return $prep_state;		// '$prep_state' beinhaltet alle gelesenen Datensätze
		}

		function getUserIdSQL ($what1, $what2, $what3, $table, $where){
			//$sql = 'SELECT UserId FROM t_user WHERE Mail=:mail;';
			$sql = "SELECT $what1, $what2, $what3 FROM $table WHERE Mail=:mail;";
			$prep_state = $this->ContDB->prepare($sql);
			$prep_state->bindParam(':mail', $where, PDO::PARAM_STR);

			$prep_state->execute();

			return $prep_state;		
		}

		function getAllPostFromUser($userId){
			// Alle Freunde werden aus der Tabelle gelesen
			$sql = "SELECT t_user.Vorname, " .
							"t_post.Titel, t_post.Beschrieb, " .
							"t_bild.Bild, " .
							"t_ortschaft.Kanton, t_ortschaft.PLZ " .
						"FROM t_user " . 
							"INNER JOIN t_post " . 
								"ON t_user.UserId = t_post.UserId " . 
							"INNER JOIN t_bild " .
								"ON t_bild.PostId = t_post.PostId " . 
							"INNER JOIN t_ortschaftlink " . 
								"ON t_ortschaftlink.PostId = t_post.PostId " . 
							"INNER JOIN t_ortschaft " . 
								"ON t_ortschaft.PLZ = t_ortschaftlink.PLZ " . 
						"WHERE t_user.UserId=:userId;";
			$prep_state = $this->ContDB->prepare($sql);
			$prep_state->bindParam(':userId', $userId, PDO::PARAM_INT);		// Bindung der Variable an den Platzhalter
			$prep_state->execute();

			$msgs = array();
			while(($incomingSQLMsg = $prep_state->fetchObject()) != false) {
				$tempArr = [
					'name' => $incomingSQLMsg->Vorname,
					'title' => $incomingSQLMsg->Titel,
					'description' => $incomingSQLMsg->Beschrieb,
					'imagePath' => $incomingSQLMsg->Bild,
					'canton' => $incomingSQLMsg->Kanton,
					'plz' => $incomingSQLMsg->PLZ

				];
				array_push($msgs, $tempArr);
			}

			return $msgs;
		}

		function getPost($userId, $postId){
			// Alle Freunde werden aus der Tabelle gelesen
			$sql = "SELECT t_user.Vorname, " .
							"t_post.Titel, t_post.Beschrieb, " .
							"t_bild.Bild, " .
							"t_ortschaft.Kanton, t_ortschaft.PLZ " .
						"FROM t_user " . 
							"INNER JOIN t_post " . 
								"ON t_user.UserId = t_post.UserId " . 
							"INNER JOIN t_bild " .
								"ON t_bild.PostId = t_post.PostId " . 
							"INNER JOIN t_ortschaftlink " . 
								"ON t_ortschaftlink.PostId = t_post.PostId " . 
							"INNER JOIN t_ortschaft " . 
								"ON t_ortschaft.PLZ = t_ortschaftlink.PLZ " . 
						"WHERE t_user.UserId=:userId AND " .
							"t_post.PostId=:postId;";
			$prep_state = $this->ContDB->prepare($sql);
			$prep_state->bindParam(':userId', $userId, PDO::PARAM_INT);		// Bindung der Variable an den Platzhalter
			$prep_state->bindParam(':postId', $postId, PDO::PARAM_INT);	
			$prep_state->execute();

			$msgs = array();
			while(($incomingSQLMsg = $prep_state->fetchObject()) != false) {
				$tempArr = [
					'name' => $incomingSQLMsg->Vorname,
					'title' => $incomingSQLMsg->Titel,
					'description' => $incomingSQLMsg->Beschrieb,
					'imagePath' => $incomingSQLMsg->Bild,
					'canton' => $incomingSQLMsg->Kanton,
					'plz' => $incomingSQLMsg->PLZ

				];
				array_push($msgs, $tempArr);
			}

			return $msgs;
		}

		function isAvailableInTabel($table, $where){
			$sql = "SELECT * FROM $table WHERE Mail=:mail;";
			$prep_state = $this->ContDB->prepare($sql);
			$prep_state->bindParam(':mail', $where, PDO::PARAM_STR);

			$prep_state->execute();
			if($prep_state->rowCount() >= 1){
				return true;
			}

			return false;
		}

		function writePostToDatabase($title, $desc, $userId){
			// Add a User to DataBase
			$sql = "INSERT INTO t_post " .								// In die Tabelle einfügen (INSERT); 'ID_Freund' muss nicht angegeben werden,
			"(Titel, Beschrieb, UserId) " .	// weil das Feld in der DB-Tabelle mit "AutoIncrement (AI)" definiert ist
			"VALUES (:title, :beschreibung, :userId)";
			$prep_state = $this->ContDB->prepare($sql);
			$prep_state->bindParam(':title',     $title, PDO::PARAM_STR);		
			$prep_state->bindParam(':beschreibung',  $desc, PDO::PARAM_STR);		
			$prep_state->bindParam(':userId',  $userId, PDO::PARAM_INT);		

			
			try{
				$prep_state->execute();
				
			}catch (Exception $exception){
				if ($exception->getCode() == 23000)
					return 23000;
				else
					throw $exception;
			}

			$postId = (int)$this->ContDB->lastInsertId();

			return $postId;
		}

		function writeImgToDatabase($imgPath, $metadata, $postId){
			// Add a User to DataBase
			$sql = "INSERT INTO t_bild " .								// In die Tabelle einfügen (INSERT); 'ID_Freund' muss nicht angegeben werden,
			"(Bild, Metadaten, PostId) " .	// weil das Feld in der DB-Tabelle mit "AutoIncrement (AI)" definiert ist
			"VALUES (:imgPath, :metadata, :postId)";
			$prep_state = $this->ContDB->prepare($sql);
			$prep_state->bindParam(':imgPath',     $imgPath, PDO::PARAM_STR);		
			$prep_state->bindParam(':metadata',  $metadata, PDO::PARAM_STR);		
			$prep_state->bindParam(':postId',  $postId, PDO::PARAM_INT);		


			try{
				$prep_state->execute();
				
			}catch (Exception $exception){
				if ($exception->getCode() == 23000)
					return 23000;
				else
					throw $exception;
			}
		}

		function writeLinkLocationToDatabase($postId, $plz){
			// Add a User to DataBase
			$sql = "INSERT INTO t_ortschaftlink " .								// In die Tabelle einfügen (INSERT); 'ID_Freund' muss nicht angegeben werden,
			"(PostId, PLZ) " .	// weil das Feld in der DB-Tabelle mit "AutoIncrement (AI)" definiert ist
			"VALUES (:postId, :plz)";
			$prep_state = $this->ContDB->prepare($sql);
			$prep_state->bindParam(':postId',     $postId, PDO::PARAM_STR);		
			$prep_state->bindParam(':plz',  $plz, PDO::PARAM_STR);				


			try{
				$prep_state->execute();
				
			}catch (Exception $exception){
				if ($exception->getCode() == 23000)
					return 23000;
				else
					throw $exception;
			}

		}

		function writeDataBase ($theNewContact){
			// Add a User to DataBase
			$sql = "INSERT INTO t_user " .								// In die Tabelle einfügen (INSERT); 'ID_Freund' muss nicht angegeben werden,
					"(Mail, Passwort, Vorname, Nachname) " .	// weil das Feld in der DB-Tabelle mit "AutoIncrement (AI)" definiert ist
					"VALUES (:mail, :password, :fistname, :lastname)";
			$prep_state = $this->ContDB->prepare($sql);
			$prep_state->bindParam(':mail',     $theNewContact[0], PDO::PARAM_STR);		// Bindung der Variable an den Platzhalter
			$prep_state->bindParam(':password',  $theNewContact[1], PDO::PARAM_STR);		// Bindung der Variable an den Platzhalter
			$prep_state->bindParam(':fistname',  $theNewContact[2], PDO::PARAM_STR);		// Bindung der Variable an den Platzhalter
			$prep_state->bindParam(':lastname',  $theNewContact[3], PDO::PARAM_STR);		// Bindung der Variable an den Platzhalter
			// Bindung der Variable an den Platzhalter

			try{
				$prep_state->execute();
			}catch (Exception $exception){
				if ($exception->getCode() == 23000)
					return 23000;
				else
					throw $exception;
			}

			return $prep_state->rowCount();		// '$prep_state->rowCount()' liefert die Anzahl eingefügter Datensätze (=> 1, falls 'INSERT' erfolgreich war ...)
			
			// An dieser Stelle wird es nie etwas anders sein als 1, da Fehler bzw. 'Exceptions' beim 'execute' von der vorigen 'try'-/'catch'-Logik abgefangen sind
		}
	}	// end of class 'AccessContDB'
?>
