<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:36:26 - Hashcode: 7c2c4c315be6f7b210db4c6bb86ced25 
 ?><?php

	require_once($_SERVER['DOCUMENT_ROOT'].'/cmssystem/standard/funktionen.tri_datenbank.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/cmssystem/standard/funktionen.tricoma.php');
	
	mysql_connect ($host,$datenbankbenutzername,$datenbankpasswort) or die ("keine DB Verbindung");
	
	
	if($_REQUEST['apipasswort']<>'' and $_COOKIE["trisession"]==''){
		if($_REQUEST['apipasswort']==trieinstellungauslesen("administration","system","api_passwort") and trieinstellungauslesen("administration","system","api_aktiv")==1){
			$edit='system';
		}else{
			$IP					= getenv("REMOTE_ADDR"); 
			$datum				= date ("Y-m-d - H:i:s");	
			tri_db_query ($datenbanknamecms,"INSERT INTO `tri_logins` (  `aktivitaet` , `user` ,  `datum` , `IP` ) VALUES ( '3', 'API Fehler',  '$datum', '$IP');");
			die("<body ><font color=red>Ihre Session ist abgelaufen oder ungueltig</font><br>Bitte loggen Sie sich erneut in das System ein<br>");
		}
	}else{
		$sessionid 			= (isset($sessionid)==FALSE) ? $_COOKIE["trisession"] : $sessionid;
		$sessionvorhanden	= FALSE;
		$curdate			= time();
		$IP					= getenv("REMOTE_ADDR"); 
		$datum				= date ("Y-m-d - H:i:s");	
		$PC					= getenv("HTTP_USER_AGENT");
		$PC					= substr(str_replace("'","",$PC),0,100);
		
		$session_pruefung_ip			= trieinstellungauslesen("administration","system","session_pruefung_ip");
		if($session_pruefung_ip==1){	//Deaktivieren der IP Prüfung
			$sql_session_IP=" ";
		}else{
			$sql_session_IP=" and IP='$IP' ";
		}
		
		if(function_exists('standard_waehrung_informationen'))
		{
			$GLOBALS['system_waehrung'] = standard_waehrung_informationen();
		}
		//print_r(get_defined_vars());
		//echo "$IP $PC $curdate $sessionid";
		$sql		= "SELECT benutzer FROM tri_sessions where session='$sessionid' and starttime<='$curdate' and endtime>='$curdate' $sql_session_IP and hosttyp='$PC'";//
		//echo "<!--".$sql."-->";
		$res 		= tri_db_query ($GLOBALS['datenbanknamecms'], $sql) or die ("dd");
		while ($row = mysql_fetch_array ($res))
		{
			$sessionvorhanden	= TRUE;
			$edit				= $row['benutzer'];
		};
		if($sessionvorhanden==FALSE)
		{
			$fehler='';
			$sql		= "SELECT benutzer FROM tri_sessions where session='$sessionid' and starttime<='$curdate' and endtime>='$curdate' $sql_session_IP ";//
			//echo "<!--".$sql."-->";
			$res 		= tri_db_query ($GLOBALS['datenbanknamecms'], $sql) or die ("dd");
			if(mysql_num_rows($res)>0){
				$fehler='Hostfehler';
			}
		
			tri_db_query ($datenbanknamecms,"INSERT INTO `tri_logins` (  `aktivitaet` , `user` ,  `datum` , `IP` ) VALUES ( '3', '$fehler $sessionid $PC',  '$datum', '$IP');");
			//die(getenv("HTTP_USER_AGENT"));
			die("<body onload=\"top.location.href='/cmssystem/?sessionabgelaufen=1'\"><font color=red>Ihre Session ist abgelaufen oder ungueltig</font><br>Bitte loggen Sie sich erneut in das System ein<br>");
		}
		else
		{
			//tri_db_query ($GLOBALS['datenbanknamecms'], "update tri_sessions set aktivitaet='$curdate' where session='$sessionid'") or die ("Fehler beim Sessionupdate in rechtecheck.php");
			//Ausgelagert in die ajax.php
		};
	}

$benutzerlogin=FALSE;

function prueferecht($recht,$benutzer){
	if($benutzer=='system'){
		return TRUE;
	}else{
		if(isset($GLOBALS['tri_conf']['cache']['prueferecht'][$recht.$benutzer])){
			return $GLOBALS['tri_conf']['cache']['prueferecht'][$recht.$benutzer];
		}else{
			$vorhanden=FALSE;
			if($recht<>"loginerlaubt"){
					$res = @tri_db_query ($GLOBALS['datenbanknamecms'], "SELECT benutzerrecht
				FROM tri_benutzer, tri_benutzergruppen, tri_gruppen, tri_gruppenrechte
				WHERE tri_benutzer.name = '$benutzer'
				AND tri_gruppenrechte.benutzerrecht='$recht'
				AND tri_benutzer.ID = tri_benutzergruppen.benutzer
				AND tri_gruppen.ID = tri_benutzergruppen.gruppe
				AND tri_gruppen.ID = tri_gruppenrechte.gruppe") or die ("DB-Fehler in rechtecheck.php - prueferecht".mysql_error());
				if(mysql_num_rows($res)>=1){
					$vorhanden=TRUE;
				}
				//echo $recht.$vorhanden;
				if($vorhanden==FALSE){
					if(isset($GLOBALS['tri_conf']['cache']['prueferecht_vorhanden'][$recht])==FALSE){
						$res = tri_db_query ($GLOBALS['datenbanknamecms'], "SELECT recht FROM tri_rechte where recht='$recht'");
						if(mysql_num_rows($res)>0){
							$GLOBALS['tri_conf']['cache']['prueferecht_vorhanden'][$recht]=TRUE;
						}else{
							//echo 'NV';
							$GLOBALS['tri_conf']['cache']['prueferecht_vorhanden'][$recht]=TRUE;
							tri_db_query ($GLOBALS['datenbanknamecms'], "insert into tri_rechte set recht='$recht', beschreibung='Autoanlage'");
							tri_db_query ($GLOBALS['datenbanknamecms'], "insert into tri_gruppenrechte set benutzerrecht='$recht', gruppe='1'");
							
							unset($GLOBALS['tri_conf']['cache']['prueferecht'][$recht.$benutzer]);
							return prueferecht($recht,$benutzer);
						}
					}
				}
			}else{
					$res = @tri_db_query ($GLOBALS['datenbanknamecms'], "SELECT loginerlaubt FROM tri_benutzer WHERE tri_benutzer.name = '$benutzer'") or die ("DB-Fehler in rechtecheck.php - prueferecht".mysql_error());
					while ($row = mysql_fetch_array ($res))
					{
						if(1==$row['loginerlaubt']){$vorhanden=TRUE;};
					};	
			};
			$GLOBALS['tri_conf']['cache']['prueferecht'][$recht.$benutzer]=$vorhanden;
		}
		return $vorhanden;
	}
};

if($checkrecht<>null){
	if(prueferecht($checkrecht,$edit)==TRUE){
	
	}else{
		die("<font color=red>Sie haben unzureichend Rechte.</font><br>Ihnen fehlt das Recht $checkrecht<br>");
	};
};

$res = @tri_db_query ($GLOBALS['datenbanknamecms'], "SELECT wert FROM tri_einstellungen WHERE benutzer='$edit' and modul='standard' and typ='sprache'") or die ("DB-Fehler in rechtecheck.php - prueferecht".mysql_error());
$row = mysql_fetch_array ($res);
$lang=$row['wert'];

$firewall_level='low';
require_once($_SERVER['DOCUMENT_ROOT'].'/GeneratedItems/firewall.php');

?>
