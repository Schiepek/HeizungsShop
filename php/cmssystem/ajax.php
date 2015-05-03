<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:36:50 - Hashcode: 4e38901f29c9f2d55d0997a7c0f0ea34 
 ?><?php
include("allgfunktionen.php");

if(isset($_REQUEST['auswahl'])==TRUE and $_REQUEST['auswahl']=='sound'){
	if($aktiv==1){ 
		header("Expires: Sat, 05 Nov 2005 00:00:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header("Content-Type: utf-8");
		include("../GeneratedItems/config.php");
		include("../GeneratedItems/debug.php");
		mysql_connect ($host,$datenbankbenutzername,$datenbankpasswort) or die ("keine DB Verbindung");
		if(trieinstellungauslesen("administration","system","sound_deaktivieren")<>1){
			echo '<html><head>
			<bgsound src="/cmssystem/standard/sounds/standard.wav" loop="1">´
			</head>
			<body><embed src="/cmssystem/standard/sounds/standard.wav" id="sound" autostart="true" loop="false" hidden="true" height="0" width="0"/></body>
			</html>';
		//
		}
	}else{
		echo '<html><head></head><body>-</body></html>';
	}
}else{
	header("Expires: Sat, 05 Nov 2005 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header("Content-Type: utf-8");
	include("../GeneratedItems/config.php");
	include("../GeneratedItems/debug.php");
	$IP=getenv("REMOTE_ADDR"); 
	$PC=getenv("HTTP_USER_AGENT");
	$PC=substr(str_replace("'","",$PC),0,100);
	$curdate=time();
	mysql_connect ($host,$datenbankbenutzername,$datenbankpasswort) or die ("keine DB Verbindung");
	if($auswahl==null){
		echo "<font color=\"#565656\">".date ("Y-m-d - H:i")."</font>";
		$curdate=time();
		tri_db_query ($GLOBALS['datenbanknamecms'], "update tri_sessions set aktivitaet='$curdate' where session='$ajaxsessionid' and IP='$IP'") or die ("Fehler beim Sessionupdate in rechtecheck.php");
	}elseif($auswahl=='logout'){
		$res_session = tri_db_query ($GLOBALS['datenbanknamecms'], "SELECT tray,benutzer FROM tri_sessions where session='$ajaxsessionid' and starttime<='$curdate' and endtime>='$curdate' and IP='$IP' and hosttyp='$PC'") or die ("Error");
		while ($row_session = mysql_fetch_array ($res_session))
		{
			$edit=$row_session['benutzer'];
			if(modulvorhanden('zeiterfassung')){
				include('zeiterfassung/funktionen.php');
				if(trieinstellungauslesen("zeiterfassung","system","autologout")==1){
					$res2 = tri_db_query ($datenbanknamecms, "SELECT ID,start,ende FROM zeiterfassung where edit='$edit' and ende='0'");
					if(mysql_num_rows($res2)>=1){
						$row=mysql_fetch_array($res2);
						zeiterfassung_beende_arbeitszeit($row[ID]);
					}
				}
			}
			tri_db_query ($GLOBALS['datenbanknamecms'], "delete from tri_sessions where session='$ajaxsessionid' and IP='$IP'") or die ("Fehler beim Sessionupdate in rechtecheck.php");
		}
	}elseif($auswahl=='desktopicon' and strlen($icon)>3 and strlen($icon)<28){
		$posx=str_replace('px','',$posx);
		$posy=str_replace('px','',$posy);
		if(is_numeric($posy) and is_numeric($posx)){
			$curdate=time();
			$res = tri_db_query ($GLOBALS['datenbanknamecms'], "SELECT benutzer FROM tri_sessions where session='$ajaxsessionid' and starttime<='$curdate' and endtime>='$curdate' and IP='$IP' and hosttyp='$PC'") or die ("dd");
			while ($row = mysql_fetch_array ($res))
			{
				trieinstellungsetzen("standard",$row['benutzer'],"desktopicon_".$icon,$posx.'#'.$posy);	
			};
		};
	}elseif($auswahl=='trayopen' or $auswahl=='trayclose'){
		$ausgabe=FALSE;
		echo "
		<table border=\"0\" cellspacing=\"3\" cellpadding=\"1\">
			<tr height=22>
			";
		$res = tri_db_query ($GLOBALS['datenbanknamecms'], "SELECT tray FROM tri_sessions where session='$ajaxsessionid' and starttime<='$curdate' and endtime>='$curdate' and IP='$IP' and hosttyp='$PC'") or die ("dd");
		while ($row = mysql_fetch_array ($res))
		{
		
			$res2 = tri_db_query ($GLOBALS['datenbanknamecms'], "SELECT ID,name FROM tri_menu") or die ("dd");
			while ($row2 = mysql_fetch_array ($res2))
			{
				$cache_modulname[$row2['ID']]=$row2['name'];
			}
		
			if($row['tray']==null){
				$row['tray']='***';
			}
			if($auswahl=='trayopen'){
				if($traymodul<>null){
					$pos = strpos($row['tray'], '***'.$traymodul.'???');
					if ($pos===false) {
						$row['tray'].=$traymodul.'???***';
					};
				};
			}elseif($auswahl=='trayclose'){
				if($traymodul<>null){
					$traymodul=str_replace('win_','',$traymodul);
					$row['tray']=str_replace('***'.$traymodul.'???','',$row['tray']);
				};
			};
			tri_db_query ($GLOBALS['datenbanknamecms'], "update tri_sessions set tray='$row[tray]' where session='$ajaxsessionid'") or die ("dd1");
			$tray=explode('***',$row['tray']);
			$standardinclude=FALSE;
			$gesamttasks=count($tray);
			$fensterschliessen='';
			foreach ($tray as $key => $val) {
				$val=explode('???',$val);
				if($val[0]<>''){
					$fensterschliessen.="win_$val[0].close();";
				};
			}
			foreach ($tray as $key => $val) {
				if($val<>null){
					$val=explode('???',$val);
					if(substr($val['0'],0,2)=='d_'){
						if($standardinclude==FALSE){
							if(file_exists('standard/_lang_'.$lang.'.php')){
								include('standard/_lang_'.$lang.'.php');
							}else{
								include('standard/_lang_deu.php');
							};
							$standardinclude=TRUE;
						}
						$titel=$sprache['standard'][str_replace('d_','desktop_',$val['0'])];
						$icon='images/'.str_replace('d_','desktop_',$val['0']).'.png';
					}else{
						$include=FALSE;
						if(file_exists($val['0'].'/_lang_'.$lang.'.php')){
							include($val['0'].'/_lang_'.$lang.'.php');
							$include=TRUE;
						};
						if($include==FALSE and $lang<>'deu' and file_exists($val['0'].'/_lang_deu.php')){
							include($val['0'].'/_lang_deu.php');
						};
						if(file_exists($val[0].'/icon.jpg')){
							$icon=$val[0].'/icon.jpg';
						}else{
							$icon='';
						};
						//print_r($cache_modulname);
						if($sprache[$val['0']]['titel']<>null){
							$titel=$sprache[$val['0']]['titel'];
						}else{
							$titel=strtoupper(substr($val['0'],0,1)).substr($val['0'],1);
						};
					};

					if($cache_modulname[strtolower($titel)]<>''){
						$titel=$cache_modulname[strtolower($titel)];
					}

					$titel=str_replace('ä','&auml;',$titel);
					$titel=str_replace('ö','&ouml;',$titel);
					$titel=str_replace('ü','&uuml;',$titel);
					if($ausgabe==FALSE){
					echo "<td style=\"FILTER: alpha(opacity=50); opacity:0.5; cursor: pointer; border: solid 1px #a5a5a5;\" bgcolor=\"white\" onclick=\"javascript:$fensterschliessen\" ondblclick=\"\" id=\"tray_closer\" onmouseover=\"javascript:desktopicon_anzeigen('tray_closer');\" onmouseout=\"javascript:desktopicon_ausblenden('tray_closer');\">
							<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
								<tr>
									<td width=\"20\" align=\"center\"><img src=\"images/icon_fenster_schliessen.png\" height=\"16\" alt=\"Desktop\"></td>
								</tr>
							</table>
						</td>";
					};
					echo "<td style=\"FILTER: alpha(opacity=50); opacity:0.5; cursor: pointer; border: solid 1px #a5a5a5;\" bgcolor=white onclick=\"javascript:win_$val[0].show();win_$val[0].toFront();\" ondblclick=\"win_$val[0].close();\" id=\"tray_$val[0]\" onmouseover=\"javascript:desktopicon_anzeigen('tray_$val[0]');\" onmouseout=\"javascript:desktopicon_ausblenden('tray_$val[0]');\">
							<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
								<tr>
									<td width=\"20\" align=\"center\">";if($icon<>null){echo "<img src=\"$icon\" height=16>";};
							
								echo "</td><td>";
							if($gesamttasks>7){echo textkuerzen($titel,5);}else{echo $titel;};
								echo "</td>
								</tr>
							</table>
						</td>";
					$ausgabe=TRUE;
				};
			};
		};
		echo "<td></td>
	</tr>
</table>
";
	}elseif($auswahl=='shortinfo'){
		$shortinfocount=0;
		function shortinfo_ausgabe($modul,$info,$link,$timestamp){
			$info=str_replace("<br>","<br/>", $info);
			$GLOBALS['shortinfoarray'][$GLOBALS['shortinfocount']]['modul']=$modul;
			$GLOBALS['shortinfoarray'][$GLOBALS['shortinfocount']]['info']=$info;
			$GLOBALS['shortinfoarray'][$GLOBALS['shortinfocount']]['link']=$link;
			$GLOBALS['shortinfoarray'][$GLOBALS['shortinfocount']]['timestamp']=$timestamp;
			$GLOBALS['shortinfocount']++;
		};
		$curdate=time();
		$res_session = tri_db_query ($GLOBALS['datenbanknamecms'], "SELECT tray,benutzer FROM tri_sessions where session='$ajaxsessionid' and starttime<='$curdate' and endtime>='$curdate' and IP='$IP' and hosttyp='$PC'") or die ("Error");
		while ($row_session = mysql_fetch_array ($res_session))
		{
			$edit=$row_session['benutzer'];
			$res_modul = tri_db_query ($GLOBALS['datenbanknamecms'], "SELECT ID from tri_menu") or die ("Error2");
			while ($row_modul = mysql_fetch_array ($res_modul))
			{
				if(file_exists($row_modul['ID'].'/modulshortinfo.php')==TRUE){
					include($row_modul['ID'].'/modulshortinfo.php');
				};
			};
			$count=0;
			while($count<$shortinfocount){
				if($count==0){
					$color=trieinstellungauslesen('meinedaten',$edit,'farbe'); 
					if($color=='1'){
						trieinstellungsetzen('meinedaten',$edit,'farbe',2);
						$farbe="bgcolor=\"#fde9ae\"";
					}else{
						trieinstellungsetzen('meinedaten',$edit,'farbe',1);
						$farbe='';
					};					 			
				}
				if(file_exists($GLOBALS['shortinfoarray'][$count]['modul']."/icon.png")==FALSE){
					$icon="standard/icon.png";
				}else{
					$icon=$GLOBALS['shortinfoarray'][$count]['modul']."/icon.png";
				};
				echo "
				<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" $farbe>
					<tr>
						<td align=\"center\" width=\"40\"><a href=\"#\" onclick=\"javascript:top.modulfenster_anzeigen('".$GLOBALS['shortinfoarray'][$count]['modul']."','".$GLOBALS['shortinfoarray'][$count]['link']."');\"><img src=\"$icon\" height=\"20\" alt=\"\" border=\"0\" /></a></td>
						<td><a href=\"#\" onclick=\"javascript:top.modulfenster_anzeigen('".$GLOBALS['shortinfoarray'][$count]['modul']."','".$GLOBALS['shortinfoarray'][$count]['link']."');\"><font size=\"1\">".$GLOBALS['shortinfoarray'][$count]['info']."</font></a></td>
					</tr>
					<tr height=\"1\">
						<td bgcolor=\"#8b8b8b\" width=\"40\" height=\"1\"></td>
						<td bgcolor=\"#8b8b8b\" height=\"1\"></td>
					</tr>
				</table>
				";
				$count++;
			};
		};
		
		$datei='meinedaten/dateien/debuglog_'.$GLOBALS['edit'];
		if(file_exists($datei)){
			$datum=filectime($datei);
			if($datum>=time()-60*3){
				$content=file_get_contents($datei);
				$content=explode('|||',$content);
				echo '<hr><b>'.$content[0].'</b><br><font size=1>'.$content[1].'<br>Zeile: '.$content[2].'<br>Funktion '.$content[3].'</font>';
			}else{
				@unlink($datei);
			}
		}
	}
	elseif($auswahl=='shortsearch')
	{
		if(strlen($suche)>=2){
			$shortsearchcount=0;
			function shortsearch_ausgabe($modul,$info,$link,$timestamp,$zusatz=''){
				$GLOBALS['shortsearcharray'][$GLOBALS['shortsearchcount']]['modul']=$modul;
				$GLOBALS['shortsearcharray'][$GLOBALS['shortsearchcount']]['info']=$info;
				$GLOBALS['shortsearcharray'][$GLOBALS['shortsearchcount']]['link']=$link;
				$GLOBALS['shortsearcharray'][$GLOBALS['shortsearchcount']]['timestamp']=$timestamp;		//PRIO
				$GLOBALS['shortsearcharray'][$GLOBALS['shortsearchcount']]['zusatz']=$zusatz;
				$GLOBALS['shortsearchcount']++;
			};
			$curdate=time();
			$res_session = tri_db_query ($GLOBALS['datenbanknamecms'], "SELECT tray,benutzer FROM tri_sessions where session='$ajaxsessionid' and starttime<='$curdate' and endtime>='$curdate' and IP='$IP' and hosttyp='$PC'") or die ("Error");
			while ($row_session = mysql_fetch_array ($res_session))
			{
				$edit=$row_session['benutzer'];
				if($modulbegrenzung<>null){
					$sql="SELECT ID,name from tri_menu where ID='$modulbegrenzung'";
				}else{
					$sql="SELECT ID,name from tri_menu";
				};
				if($pfad<>null)
				{
				
					$pfad=ascii_nach_string($pfad);
				};
				$res_modul = tri_db_query ($GLOBALS['datenbanknamecms'], $sql) or die ("Error2");
				while ($row_modul = mysql_fetch_array ($res_modul))
				{
					if(trieinstellungauslesen("standard",$edit,'schnellsuche_deakt_'.$row_modul['ID'])<>1){
						if(file_exists($row_modul['ID'].'/modulsearch.php')==TRUE){
							include($row_modul['ID'].'/modulsearch.php');
						};
						if(strtolower($suche)==strtolower($row_modul['name']) or strtolower($suche)==strtolower($row_modul['ID']) or (strlen($suche)>=3 and strtolower($suche)==substr(strtolower($row_modul['ID']),0,strlen($suche)))){
							shortsearch_ausgabe($row_modul['ID'],'Modul: '.$row_modul['name'],'',time());
						};
					}
				};
				$count=0;
				while($count<$shortsearchcount)
				{
					if($pfad<>null)
					{
						$link="javascript:if(isNaN($pfad)){".$GLOBALS['shortsearcharray'][$count]['link']."};document.getElementById('suchfeld').value='';document.getElementById('shortsearch').style.display = 'none';";
					}else{
						$link="javascript:top.modulfenster_anzeigen('".$GLOBALS['shortsearcharray'][$count]['modul']."','".$GLOBALS['shortsearcharray'][$count]['link']."');document.getElementById('suchfeld').value='';document.getElementById('shortsearch').style.display = 'none';";
					};
					
					echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
						<tr>
							<td align=\"center\" width=\"40\" valign=\"top\"><a href=\"#\" onclick=\"$link\"><img src=\"".$GLOBALS['shortsearcharray'][$count]['modul']."/icon.png\" height=\"20\" alt=\"\" border=\"0\" /></a></td>
							<td><a href=\"#\" onclick=\"$link\"><font size=\"1\">".umlaute_anpassen($GLOBALS['shortsearcharray'][$count]['info'])."</font></a>";
							if($GLOBALS['shortsearcharray'][$count]['zusatz']<>''){
								echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
										<tr>
											<td width=\"10\"></td>
											<td>".$GLOBALS['shortsearcharray'][$count]['zusatz'];
								echo "</td>
									</tr>
								</table>";
							};
							echo "</td>
						</tr>
						<tr height=\"1\">
							<td bgcolor=\"#8b8b8b\" width=\"40\" height=\"1\"></td>
							<td bgcolor=\"#8b8b8b\" height=\"1\"></td>
						</tr>
					</table>";
					$count++;
				};
			};
		};
	};
}

?>