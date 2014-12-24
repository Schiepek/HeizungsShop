<?php 

	if($GLOBALS['kundennummer']==0)
	{
		$ausgabe			= templateeinlesen($template,"kunden_login_individuell");
		$passwortbereich	= webseiten_modulvariablen_link("[kunden_passwortanfordern]",$GLOBALS['pageid']);
		$regbereich			= webseiten_modulvariablen_link("[kunden_registrierung]",$GLOBALS['pageid']);

		if($GLOBALS['tri_login']==1)
		{
			$meldung	= templateeinlesen($template,"kunden_login_individuell_fehler");
			$ausgabe	= str_replace('{meldung}',$meldung,$ausgabe);		
		};

		$ausgabe	= str_replace('{meldung}',"",$ausgabe);		
		$ausgabe	= str_replace('{passwortlink}',linkpfad_erweitert($passwortbereich,'Passwort',TRUE),$ausgabe);		
		$ausgabe	= str_replace('{reglink}',linkpfad_erweitert($regbereich,'Registrierung',TRUE),$ausgabe);		
	}
	else
	{
		$ausgabe			= templateeinlesen($template,"kunden_login_individuell_erfolgreich");
		$meinedaten			= webseiten_modulvariablen_link("[kunden_einstellungsverwaltung]",$GLOBALS['pageid']);
		$passwortbereich	= webseiten_modulvariablen_link("[kunden_passwort]",$GLOBALS['pageid']);
		$bestellungen		= webseiten_modulvariablen_link("[bestellungen]",$GLOBALS['pageid']);
		
		$ausgabe			= str_replace('{vorname}',kunden_datenfelder($GLOBALS['kundennummer'],'vornamensfeld'),$ausgabe);
		$ausgabe			= str_replace('{name}',kunden_datenfelder($GLOBALS['kundennummer'],'namensfeld'),$ausgabe);		
		$ausgabe			= str_replace('{datenlink}',linkpfad_erweitert($meinedaten,'Daten ändern',TRUE),$ausgabe);		
		$ausgabe			= str_replace('{passwortlink}',linkpfad_erweitert($passwortbereich,'Passwort',TRUE),$ausgabe);		
		$ausgabe			= str_replace('{bestelllink}',linkpfad_erweitert($bestellungen,'Bestellungen',TRUE),$ausgabe);

	};
	echo $ausgabe; 

?>