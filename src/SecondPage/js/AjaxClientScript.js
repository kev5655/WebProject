/* *********************************************** */
/* Programm 'Contacts' / Denis Kjelsberg / 08.2020 */
/* *********************************************** */

	function getLocality (postcode)
	{
		var xhttp;

		if (postcode.length == 4) {				// erst wenn alle 4 Ziffern eingegeben
			xhttp = new XMLHttpRequest();		// sind, wird es zum Server geschickt

			xhttp.onreadystatechange = function() {
			// 'Callback'-Funktion (inline), die aufgerufen wird wenn 'send'-Antwort eintrifft
				if (this.readyState == 4 && this.status == 200)
				// 4: DONE, operation completed  /  200: OK, successful HTTP request
					if (this.responseText.length > 0)
					// Bei Fehler, da in "AjaxServerProgram.php", 'error_reporting (0)' definiert ist,
					// wird "responseText" leer sein (ansonsten würde es die Fehlermeldung beinhalten)
						document.getElementById("OrtschaftTextfield").value = this.responseText;
					else
						document.getElementById("OrtschaftTextfield").value = "Information nicht erhältlich";
			}

			xhttp.open("GET", "../php/AjaxServerProgram.php?Postcode="+postcode, true);
			xhttp.send();									// true: asynchron
		}
		else
			document.getElementById("OrtschaftTextfield").value = "wird automatisch ergänzt ...";
	}
