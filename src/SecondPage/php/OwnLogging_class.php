<?php
/* ************************************************ */
/* Project 'Collection' / Denis Kjelsberg / 01.2017 */
/* ************************************************ */

	class OwnLogging
		{
	// TIPPS & TRICKS   "Basis-Klasse für das Logging":
	// ===============================================
	// In dieser Klasse werden sowohl die konventionellen 'Errors', Warnings' und 'Notices'
	// wie auch die 'Exceptions' (für PDO oder allgemein für OOP) aufgefangen und behandelt.
	// Solche Ereignisse werden am Bildschirm ausgegeben und in einer Datei festgehalten.

		// vvvvv Attribute (Eigenschaften) vvvvv
//		private $xyz;

	//	const OPERATING_MODE = "Production";		// Produktionsphase (restriktiver)
		const OPERATING_MODE = "Development";		// Entwicklungsphase

		// vvvvv Methoden (Fähigkeiten) vvvvv
		function __construct()		// In dieser Methode geht es darum Sachen zu initialisieren
			{
//			echo "OwnLogging / __construct is called ...";

			// Wir lassen uns alle Fehler melden und abhängig vom 'OPERATING_MODE' und von der Fehlerkategorie,
			// werden sie entweder angezeigt (Bildschirm) und protokolliert (Datei) oder nur protokolliert ...
			ini_set ('display_startup_errors', '1');
			ini_set ('display_errors', '1');
			error_reporting (E_ALL);

			// Beim Definieren eines eigenen Error-Handlers ('set_error_handler') ohne Angabe der aufzufangenden Fehlertypen
			// (wie untenstehend, ohne 2.Argument) gilt, dass dieser Error-Handler für alle Fehlertypen aufgerufen wird, ohne
			// Rücksicht auf das gesetzte 'error_reporting'-Level; obenstehendes "error_reporting(E_ALL)" ist also wirkungslos.
			set_error_handler (array ($this, 'ownErrorHandler'));

			// Das Definieren eines eigenen Exception-Handlers ('set_exception_handler') bringt ab PHP-7 noch folgenden Vorteil:
			// Bei einigen Fehlertypen, die vom eigenen Error-Handler nicht aufgefangen werden (u.a. "E_ERROR"), wird neuerdings
			// oft noch eine Ausnahme erzeugt (exception thrown), was dazu führt, dass dieser Exception-Handler aufgerufen wird.
			set_exception_handler (array ($this, 'ownExceptionHandler'));
			}

		function __destruct()
			{
//			echo "OwnLogging / __destruct is called ...";
			}

		protected function writeLogging ($handler, $severeError, $code, $message, $file, $line)
			{
			if (($severeError == 1 || self::OPERATING_MODE == "Development"))
				echo "<p><strong>From $handler: </strong>
					  <ul>
					    <li>Code: $code / Message: $message</li>
					    <li>File: $file / Line: $line</li>
					  </ul>
					  <br></p>";

			$loggingData = date("Y-m-d H:i:s", time()) . "  From $handler: " .
						   " Code: $code / Message: $message  / " .
						   " File: $file / Line: $line\r\n";

			file_put_contents ("./WebsiteLogging.txt", $loggingData, FILE_APPEND);
			}

		// Untenstehend eine selbstdefinierte Fehlerbehandlungsfunktion (mit 'set_error_handler').
		// Setzt eine benutzerdefinierte Funktion, um Fehler in einem Programm speziell behandeln zu können.
		// Anschliessend wird das Programm nach der fehlerverursachenden Anweisung eventuell fortgesetzt.
		// vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
		function ownErrorHandler ($errCode, $errMessage, $errFile, $errLine)
			{
			if ($errCode == E_NOTICE || $errCode == E_STRICT || $errCode == E_DEPRECATED)
				$severeErr = 0;
			else
				$severeErr = 1;

			$this->writeLogging ("\"ownErrorHandler\"", $severeErr, $errCode, $errMessage, $errFile, $errLine);

			if ($severeErr == 1)
				exit ("Sorry, an error occured ... Please contact 'kjede@gmx.ch'");

			return true;	// "True", damit der Standard Error-Handler nicht aufgerugen wird (falls nicht 'exit')
			}

		// Untenstehend einen selbstdefinierten Exceptionhandler (mit 'set_exception_handler').
		// Setzt den Standardexceptionhandler für Exceptions, die nicht über try/catch aufgefangen wurden.
		// Nach dem Aufruf vom Exceptionhandler wird die Ausführung des Programms angehalten.
		// vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
		function ownExceptionHandler ($exception)
			{
			$this->writeLogging ("\"ownExceptionHandler\"", 1, $exception->getCode(), $exception->getMessage(),
								 $exception->getFile(), $exception->getLine());

			exit ("Sorry, an exception occured ... Please contact 'kjede@gmx.ch'");

			// Keinen 'Return'-Wert hier, der Standard Exception-Handler wird ja nie aufgerugen (immer 'exit')
			}
		}
?>
