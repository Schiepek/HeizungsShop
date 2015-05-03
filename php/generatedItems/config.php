<?php //tricoma Versionsync - Update durch Administrator am 2014-02-28 - 13:33:48 - Hashcode: a549bb5dc21bd9afb0236d92815b3b59 
 ?><?php //tricoma Versionsync - Upload durch Administrator am 2013-10-11 - 09:49:22 - Hashcode: 00c5bbde761f6ffabaab51d723396a5c 
 ?><?php

//Standarkonfigurationsdatei zu Ihrem tricoma System
//Bitte nehmen Sie in dieser Datei nur Aenderungen vor, wenn dies noetig ist.
//tricoma ist ein Produkt von IPResearch
//Weitere Informationen finden Sie unter www.ipresearch.de

	//Datenbankeinstellungen
	$datenbanknamecms="vhost1542_db7684";
	$datenbankpasswort="PAAyv7";
	$host="localhost";
	$datenbankbenutzername="vhost1542_db7684";
	
	//Maileinstellungen
	$SMTP_MAILING=TRUE;					//(Empfohlen ist TRUE) Mails über SMTP versenden? Bei FALSE wird die mail() Funktion von PHP verwendet.
	$SMTP_AUTH=TRUE;					//Server erfordert Authentifizierung zum senden?
	$SMTP_STANDARD_MAIL="info@ofen-solar.com";
	$SMTP_STANDARD_NAME="esycor GmbH";
	$SMTP_SERVER="mail.ipresearch.de";
	$SMTP_PORT="25";
	$SMTP_USERNAME="mail35";
	$SMTP_PASSWORD="PnBq9";
    $SMTP_SECURE='TLS';
	
	//Webseite(n) mit Endung .html darstellen bzw. als Ordnerstruktur anzeigen lassen
	$tri_conf['htmlwebseite']=TRUE;
	$tri_conf['ordnerstruktur']=TRUE;
	
	//Updateeinstellungen
	$chmoderlaubt=TRUE;
	$ftp_details['ftp_user_name'] = "";
	$ftp_details['ftp_user_pass'] = "";			
	$ftp_details['ftp_root'] = '/public_html/';					// z. B. '/public_html/'; 	mit / am Anfang UND Ende
	$ftp_details['ftp_server'] = $_SERVER['HTTP_HOST'];
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///AB HIER KEINE ÄNDERUNGEN VORNEHMEN///////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$pfadzumeditor="cmssystem/editor/";
	
	//PHP-Code-Debugeinstellungen
	$debug=TRUE;				//Schaltet internen Debugger an. Empfohlen ist TRUE
	$debug_stop=FALSE;			//Stoppt den Scriptaufruf bei einem Fehler. Es wird nicht empfohlen auf TRUE zu setzen.
	$debug_ausgabe=TRUE;		//Gibt den Fehler zurück
	$debug_logging=TRUE;		//Speichert die Fehler in die Tabelle tri_errorlog
	$debug_level=1;
	
	//MySQL-Debugeinstellungen
	$mysql_debug=TRUE;			//NIEMALS AUF FALSE setzen
	$mysql_debug_stop=TRUE;		//Stoppt den Scriptaufruf bei einem Fehler. Es wird nicht empfohlen auf FALSE zu setzen.
	$mysql_debug_ausgabe=TRUE;	//Gibt den Fehler zurück
	$mysql_debug_logging=TRUE;	//Speichert die Fehler in die Tabelle tri_errorlog
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	//Umask zum Dateien anlegen
	umask(0022);

?>