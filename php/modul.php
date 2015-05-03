<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:33:50 - Hashcode: c7d834e7cc906c0e9b83edb33dbcdde5 
 ?><?php
	if(isset($_REQUEST['modul']) and isset($_REQUEST['modulkat']))
	{
		include("GeneratedItems/config.php");
		$GLOBALS['datum'] = date('Y-m-d - H:i:s');
		mysql_connect ("$host","$datenbankbenutzername","$datenbankpasswort") or die ("<b>Fehler</b><br>Kann keine Verbindung zur Datenbank herstellen<br>Bitte prüfen Sie die Zugangsdaten in Ihrer config.php");
		include("GeneratedItems/debug.php");
		include("cmssystem/allgfunktionen.php");
		if(file_exists("cmssystem/".$_REQUEST['modul']."/modulext_".$_REQUEST['modulkat'].".php")==TRUE){
			//include("GeneratedItems/firewall.php");
			include("GeneratedItems/templates.php");
			include("GeneratedItems/webseiteerkennen.php");
			include("cmssystem/standard/class.tri_easymodulloading.php");
			include("cmssystem/mailer.php");
			include("cmssystem/rubcoder.php");
			$kundennummer=0;
			if(modulvorhanden("kunden")==TRUE){
				$session=$_COOKIE['triuser'];
				$res2 = tri_db_query ($datenbanknamecms, "SELECT kundennummer FROM kunden_sessions where session='$session'");
				while ($row2 = mysql_fetch_array ($res2))
				{
					$kundennummer=$row2['kundennummer'];
				};
			}
			include("cmssystem/".$_REQUEST['modul']."/modulext_".$_REQUEST['modulkat'].".php");
		}else{
			echo "<center><font color=red>Fehler beim Laden des Moduls</font></center><br>cmssystem/".$_REQUEST['modul']."/modulext_".$_REQUEST['modulkat'].".php";
		};
	};
?>