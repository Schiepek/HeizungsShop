<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:37:00 - Hashcode: 287341c4f457d453ff64f85dd1e36046 
 ?><?php

function templateeinlesen($template,$templatetyp){
	if($template==null){
		$template=$GLOBALS['template'];
	};
	if($template<>null){
		$templatepfad="templates/$template/$templatetyp.html";
		//Prüfen ob Template vorhanden ist
		if(file_exists("$templatepfad")==FALSE){
			$datei=$templatetyp.'.html';
			$modul=explode('_',$datei);
			$modul=str_replace('.html','',$modul[0]);
			//echo $modul;
			if(file_exists('cmssystem/'.$modul.'/templatesystem/'.$datei)==TRUE){
				$inhalt=file_get_contents('cmssystem/'.$modul.'/templatesystem/'.$datei);
				$handler = fopen($templatepfad , "a+"); 
				fwrite($handler , $inhalt); 
				fclose($handler); 
				return $inhalt;
			}else{
				$fehler=new tri_easymodulloading(); 
				//echo $fehler->int_html_code_fehlerausgabe("Das Template <b>$templatepfad</b> wurde nicht gefunden.<br>Erstellen Sie bitte eine Template des Typs <b>$templatetyp</b>");
			};
		}else{
			//Template einlesen
			$fp=fopen($templatepfad, "r");
			$templatestring=fread($fp, filesize($templatepfad));
			fclose($fp);
			return $templatestring;
		};
	}else{
		$fehler=new tri_easymodulloading(); 
		echo $fehler->int_html_code_fehlerausgabe("Es wurde kein Template definiert oder eine URL aufgerufen,<br> welche noch nicht im System eingetragen ist.<br>Bitte wenden Sie sich an den Betreiber der Webseite");
	};
};

function templateglobalevariablen($templatestring){

	$templatestring=str_replace("{meta-keywords}",$GLOBALS['meta_keywords'],$templatestring);
	$templatestring=str_replace("{meta-autor}",$GLOBALS['meta_autor'],$templatestring);
	$templatestring=str_replace("{meta-publisher}",$GLOBALS['meta_publisher'],$templatestring);
	$templatestring=str_replace("{meta-copyright}",$GLOBALS['meta_copyright'],$templatestring);
	$templatestring=str_replace("{meta-pagetopic}",$GLOBALS['meta_pagetopic'],$templatestring);
	$templatestring=str_replace("{meta-pagetyp}",$GLOBALS['meta_pagetyp'],$templatestring);
	$templatestring=str_replace("{meta-description}",eregi_replace("\{([^\[]+)\}","",$GLOBALS['meta_description']),$templatestring);
	$templatestring=str_replace("{seitentitel}",$GLOBALS['hptitel'],$templatestring);
	$templatestring=str_replace("{hptitel}",$GLOBALS['hptitel2'],$templatestring);
	return $templatestring;
};

function templateverarbeiten($templatestring){
	//Prüfen ob Template vorhanden ist
	if($templatestring==null){
		return fehlerausgabe("Template ist leer","Die Templatedatei muss einen Inhalt haben");
	}else{
		$res = tri_db_query($GLOBALS['datenbanknamecms'], "select modulname from tri_templatemodules") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
		while ($row = mysql_fetch_array ($res))
		{		
			if(strlen(strstr($templatestring,"{$row['modulname']}"))>0){
				$templatestring=str_replace("{".$row['modulname']."}",templatemodul($row['modulname']),$templatestring);
			};
		};
		if(file_exists('templates/'.$GLOBALS['template'].'/templatemodule')==TRUE){
			$pfad='templates/'.$GLOBALS['template'].'/templatemodule/';
			$verz=opendir ($pfad);
			//while ($file=readdir($verz))
			while (false !== ($file = readdir($verz)))
			{
			    if (filetype($pfad.$file)!="dir")
			    {
			    	$modulname=str_replace('.php','',$file);
					if(is_int(strpos($templatestring,"{".$modulname."}"))==TRUE){
						$templatestring=str_replace("{".$modulname."}",templatemodul($pfad.$file,'txt'),$templatestring);
					};
			    }
			}
			closedir($verz);
		};
		return $templatestring;
	};
}

function templatepfadanpassen($templatestring,$template){
		$templatestring=str_replace("=\"Labels/","=\"/templates/$template/Labels/",$templatestring);
		$templatestring=str_replace("=\"templates/","=\"/templates/",$templatestring);
		$templatestring=str_replace("=\"cmssystem/","=\"/cmssystem/",$templatestring);
		$templatestring=str_replace("='Labels/","='/templates/$template/Labels/",$templatestring);
		$templatestring=str_replace("src=\"Labels/","src='/templates/$template/Labels/",$templatestring);
		$templatestring=str_replace("=\"modul.php","=\"/modul.php",$templatestring);
		$templatestring=str_replace("src=Labels/","src=/templates/$template/Labels/",$templatestring);
		$templatestring=str_replace("src=\"js/","src=\"/templates/$template/js/",$templatestring);
		$templatestring=str_replace("href=\"css/","href=\"/templates/$template/css/",$templatestring);
		$templatestring=str_replace("src=\"index.php","src=\"/index.php",$templatestring);
		$templatestring=str_replace("action=\"index.php","action=\"/index.php",$templatestring);
		$templatestring=str_replace("src=\"modul.php","src=\"/modul.php",$templatestring);
		$templatestring=str_replace("=\"../images/","=\"/cmssystem/images/",$templatestring);
		$templatestring=str_replace("<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">","<link rel=\"stylesheet\" type=\"text/css\" href=\"/templates/$template/style.css\">",$templatestring);
		return $templatestring;
};

function templatemodul($modulname,$typ='sql'){
	$datenbanknamecms=$GLOBALS['datenbanknamecms'];
	$ID=$GLOBALS['ID'];
	ob_start();
	if($typ=='sql'){
		$res = tri_db_query("$datenbanknamecms", "select templatecode from tri_templatemodules where modulname='$modulname'") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
		while ($row = mysql_fetch_array ($res))
		{	
			eval($row['templatecode']);
		};
	}elseif($typ=='txt'){
		include($modulname);
	};
	$out=ob_get_contents();
	ob_end_clean();
	return $out;
};


function template_keinewebseite(){
	return "<html><head>
		<meta http-equiv=\"content-type\" content=\"text/html;charset=iso-8859-1\" />
		<title>Keine Webseite f&uuml;r die Domain $GLOBALS[domain] angelegt</title>
		<link rel=\"stylesheet\" type=\"text/css\" href=\"/cmssystem/GeneratedItems/style.CSS\">
	</head><body bgcolor=\"#ececec\"><br>
		<div align=\"center\">
			<table width=\"600\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"#b5b5b5\">
				<tr>
					<td bgcolor=\"white\">
						<div align=\"right\">
							<img src=\"/cmssystem/images/logo.gif\" alt=\"\" border=\"0\" /></div>
						<p align=\"center\"><font color=#3f3f3f size=2>F&uuml;r die Domain ".str_replace('http://','',$GLOBALS['domain'])." wurde derzeit noch keine Webseite angelegt.</font><br />
							<br />
							<a href=\"http://www.tricoma.de\" target=\"_blank\"><font size=\"1\" color=\"#9b9b9b\">CMS: tricoma (trivial content managment) </font></a><font size=\"1\" color=\"#9b9b9b\">- </font><a href=\"http://www.ipresearch.de\" target=\"_blank\"><font size=\"1\" color=\"#9b9b9b\">supported by IPResearch<br />
									<br />
								</font></a></p>
					</td>
				</tr>
			</table>
		</div>
		<p></p>
	</body></html>";
};

function template_keinedatenbank(){
	return "<html><head>
		<meta http-equiv=\"content-type\" content=\"text/html;charset=iso-8859-1\" />
		<title>Fehlerhafte Datenbankzugangsdaten</title>
		<link rel=\"stylesheet\" type=\"text/css\" href=\"/cmssystem/GeneratedItems/style.CSS\">
	</head><body bgcolor=\"#ececec\"><br>
		<div align=\"center\">
			<table width=\"600\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"#b5b5b5\">
				<tr>
					<td bgcolor=\"white\">
						<div align=\"right\">
							<img src=\"/cmssystem/images/logo.gif\" alt=\"\" border=\"0\" /></div>
						<p align=\"center\"><font color=#3f3f3f size=2>Bitte prüfen Sie die Zugangsdaten für die Datenbank in der Datei GeneratedItems/config.php</font><br />
							<br />
							<a href=\"http://www.tricoma.de\" target=\"_blank\"><font size=\"1\" color=\"#9b9b9b\">CMS: tricoma (trivial content managment) </font></a><font size=\"1\" color=\"#9b9b9b\">- </font><a href=\"http://www.ipresearch.de\" target=\"_blank\"><font size=\"1\" color=\"#9b9b9b\">supported by IPResearch<br />
									<br />
								</font></a></p>
					</td>
				</tr>
			</table>
		</div>
		<p></p>
	</body></html>";
};

function tri_sitemap($pageid){
	$xml='<?xml version="1.0" encoding="UTF-8"?>
			<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">';
	$res = tri_db_query($GLOBALS['datenbanknamecms'], "SELECT ID FROM bereich_page where ID='$pageid'") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
	while ($row = mysql_fetch_array ($res))
	{
		$xml.='<url>
			      <loc>http://'.$_SERVER["HTTP_HOST"].'/</loc>
			      <lastmod>'.date('Y-m-d').'</lastmod>
			      <changefreq>daily</changefreq>
			      <priority>1.0</priority>
			   </url>';
		$res2 = tri_db_query($GLOBALS['datenbanknamecms'], "SELECT ID FROM bereiche where page='$pageid' order by prio asc") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
		while ($row2 = mysql_fetch_array ($res2))
		{
			$res3 = tri_db_query($GLOBALS['datenbanknamecms'], "SELECT * FROM bereich where bereich='$row2[ID]' and onlinefreigabe='1' and papierkorb='0' order by prio asc") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
			while ($row3 = mysql_fetch_array ($res3))
			{
				$xml.='<url>
					      <loc>http://'.$_SERVER["HTTP_HOST"].''.linkpfad_erweitert($row3[ID],$row3[titel],TRUE).'</loc>
					      <lastmod>'.substr($row3['datum'],0,10).'</lastmod>
					      <changefreq>weekly</changefreq>
					      <priority>0.7</priority>
					   </url>';
			}
		}
	}
	$verzeichnis = opendir('./cmssystem'); 
	while (false !== ($file = readdir($verzeichnis))) {
	 if ($file != "." && $file != "..") {
	 	$file='./cmssystem/'.$file.'/modul_sitemap.php';
	 	if(file_exists($file)==TRUE){
	 		include($file);
	 	}
	 }
	}
	closedir($verzeichnis); 
	$xml.='</urlset>';
	return $xml;
}


?>