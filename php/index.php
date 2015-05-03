<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:33:52 - Hashcode: e622b91387b269889a343c8cc8b03d84 
 ?><?php 

//die('test');

/*
ini_set('short_open_tag','On');
ini_set('display_errors','On');
ini_set('display_startup_errors', true);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
*/
//Standardfunktionen laden Anfang
	function getmicrotime() {
	   list($msec, $sec) = explode(" ",microtime()); 
	   return ($msec + $sec); 
	}
	$time_start = getmicrotime();
	
	if(is_numeric($ID)==FALSE){$ID='';};
	

	if(isset($bereichauswahl)==FALSE){
		$bereichauswahl="";
	};

	include("GeneratedItems/config.php");
	include("GeneratedItems/templates.php");
	@mysql_connect ("$host","$datenbankbenutzername","$datenbankpasswort") or die (template_keinedatenbank());
	include("GeneratedItems/debug.php");	
	include("cmssystem/allgfunktionen.php");	
	include("cmssystem/standard/class.tri_easymodulloading.php");
	include("cmssystem/standard/class.xml2array.php");
	include("cmssystem/mailer.php");	
	include("cmssystem/rubcoder.php");
	include("GeneratedItems/webseiteerkennen.php"); 
	include("GeneratedItems/firewall.php");

	
	$GLOBALS['datum'] = date('Y-m-d - H:i:s');
//echo $datum;

if(substr($_SERVER['REQUEST_URI'],0,12)=='/sitemap.xml'){
	die(tri_sitemap($pageid));
}elseif(is_int(strpos($_SERVER['REQUEST_URI'],'/onlineshop_bilder/')) and is_int(strpos($_SERVER['REQUEST_URI'],'.jpg'))){
	$pfad='cmssystem/produkte/modulext_bilder.php';
	$exp=explode('_',$_SERVER['REQUEST_URI']);
	$ID=$exp[count($exp)-2];
	$typ=$exp[count($exp)-1];
	if(file_exists($pfad)==TRUE and is_numeric($ID)){
		if($typ=='mid.jpg'){
			$mid=1;
		}elseif($typ=='mid2.jpg'){
			$mid2=1;
		}elseif($typ=='tump2.jpg'){
			$tump2=1;
		}elseif($typ=='tump.jpg'){
			$tump=1;
		}
		require_once($pfad);
	}else{
		echo 'Sie benoetigen die App Produkte oder die Parameter sind falsch';
	}
	die();
}elseif(substr($_SERVER['REQUEST_URI'],0,11)=='/robots.txt'){
	die("User-agent: *\nDisallow: /GeneratedItems/\nAllow: /");
}elseif(trieinstellungauslesen("seo","system","url_weiterleitung")==1){
	if(is_int(strpos($hauptdomain,'*'))==FALSE and is_int(strpos($hauptdomain,'http://'))==TRUE){
		$hautdomainexplode=explode('.',$hauptdomain);
	
		if(trieinstellungauslesen("seo","system","url_weiterleitung_www")==1 and count($hautdomainexplode)==2){
			$hauptdomain_neu=str_replace('http://www.','',$hauptdomain);
			$hauptdomain_neu=str_replace('http://','',$hauptdomain_neu);
			$hauptdomain_neu='http://www.'.$hauptdomain_neu;
			
			if('http://'.$_SERVER['HTTP_HOST']<>$hauptdomain_neu){
				$realdomain=$hauptdomain_neu.$_SERVER['REQUEST_URI'];
				header("Location: $realdomain");
				die();
			}
		}else{
			if('http://'.$_SERVER['HTTP_HOST']<>$hauptdomain){
				$realdomain=$hauptdomain.$_SERVER['REQUEST_URI'];
				header("Location: $realdomain");
				die();
			}
		}
	}
}

if(strpos($REQUEST_URI,'empty.html')===FALSE){
//HTML-Webseite Anfang
		$cut=strpos($_SERVER['REQUEST_URI'],"?");
		if($cut>=1){
			$scriptnameextern=substr($_SERVER['REQUEST_URI'],0,$cut);
		}else{
			$scriptnameextern=substr($_SERVER['REQUEST_URI'],0);
		};

		if($ID==null){
			if(modulvorhanden('linker')==TRUE){
				$exp_linker=explode('/',$_SERVER['REQUEST_URI']);
				if(count($exp_linker)<=3 and $exp_linker[1]<>''){
					$exp_linker[1]=addslashes($exp_linker[1]);
					$sql_linker="SELECT link FROM linker where quellseite='$GLOBALS[pageid]' and quellpfad='$exp_linker[1]' ";
					$res = tri_db_query($datenbanknamecms, $sql_linker) or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
					if(mysql_num_rows($res)>0){
						$row = mysql_fetch_array ($res);
						//echo 'die';
						header("Location: $row[link]"); /* Browser umleiten */
						exit;
					}
				}	
			}
		
			if(is_int(strpos($_SERVER['REQUEST_URI'],".html"))){
				$IDstring=substr(strrchr($_SERVER['REQUEST_URI'],"-"),1);
				$IDstring=substr($IDstring,0,strpos($IDstring,".html"));
				if(is_numeric($IDstring)==TRUE){
					$ID=$IDstring;
				};
				$url=$REQUEST_URI;
				$count=strpos($url,"?")+1;
				$cache="";
				$typ="var";
				$vari="";
				while($count<=strlen($url)){
					if($typ=="var" && substr($url,$count,1)=="="){
						$vari=$cache;
						$cache="";
						$typ="con";
					}elseif($typ=="var"){
						$cache.=substr($url,$count,1);
					}elseif($typ=="con" && substr($url,$count,1)=="&"){
						${$vari}=urldecode($cache);
						$_GET[$vari]=urldecode($cache);
						$cache="";
						$typ="var";
					}elseif($typ=="con"){
						$cache.=substr($url,$count,1);
					};
					$count++;
				};
				${$vari}=urldecode($cache);
				$_GET[$vari]=urldecode($cache);
			}elseif($tri_conf['ordnerstruktur']==TRUE){
				if(modulvorhanden('seo')==TRUE and strlen($_SERVER['REQUEST_URI'])>3){
					//echo "SELECT metadescription FROM seo where pageid='".$GLOBALS[pageid]."' and seitentitel='".$_SERVER['REQUEST_URI']."' and metakeywords='url_rewrite'";
					$pruefung=tri_db_query($GLOBALS['datenbanknamecms'], "SELECT metadescription FROM seo where pageid='".$GLOBALS[pageid]."' and seitentitel='".$_SERVER['REQUEST_URI']."' and metakeywords='url_rewrite'") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
					if(mysql_num_rows($pruefung)>0){
						$row = mysql_fetch_array ($pruefung);
						$urlexp=explode('/',$row['metadescription']);
					}else{	
						$vorhanden=FALSE;
						if(count(explode('/',$_SERVER['REQUEST_URI']))>3){
							$pruefung=tri_db_query($GLOBALS['datenbanknamecms'], "SELECT seitentitel FROM seo where pageid='".$GLOBALS[pageid]."' and metadescription='".$_SERVER['REQUEST_URI']."' and metakeywords='url_rewrite'") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
							if(mysql_num_rows($pruefung)>0){
								$host  = $_SERVER['HTTP_HOST'];
								$row = mysql_fetch_array ($pruefung);
								//die('test123');
								header("Location: http://$host".$row['seitentitel']);
								die();
							}
						}
						//echo 'd1';
						if($vorhanden==FALSE){
                            $fehler404=TRUE;
							$exp=explode('/',$_SERVER['REQUEST_URI']);
							$exp_org=$exp;
							$anzahl_ordnerstufen=count($exp);
							$exp[1]=substr($exp[1],0,strlen($exp[1])-2);
							$exp='/'.$exp[1].'/';
							//echo 'd2';
							//print_r($exp);
							if($exp_org[2]==''){
								//echo 'd3';
								$pruefung=tri_db_query($GLOBALS['datenbanknamecms'], "SELECT metadescription FROM seo where pageid='".$GLOBALS[pageid]."' and seitentitel='".$exp."' and metakeywords='url_rewrite'") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
								if(mysql_num_rows($pruefung)>0){
									$host  = $_SERVER['HTTP_HOST'];
									$row = mysql_fetch_array ($pruefung);
									header("Status: 404");
									header("Location: http://$host".$exp);
								}
								if($exp<>'//' and (isset($tri_conf['seo_redirector'])==FALSE or $tri_conf['seo_redirector']<>FALSE) and is_int(strpos($_SERVER['REQUEST_URI'],'?'))==FALSE and $anzahl_ordnerstufen<=3){
									header("Status: 404");
									header("Location: http://".$_SERVER['HTTP_HOST']);
								}
							}
						}
						$urlexp=explode('/',$_SERVER['REQUEST_URI']);
					}
				}else{
					$urlexp=explode('/',$_SERVER['REQUEST_URI']);
				}
				if(is_numeric($urlexp[2])){
					$ID=$urlexp[2];
				};
				$count=3;
				while($count<count($urlexp)){
					if($count%2=='1'){
						$variablenname=$urlexp[$count];
					}else{
						if($variablenname<>null){
							if(isset(${$variablenname})==FALSE and isset($GLOBALS[$variablenname])==FALSE){
								${$variablenname}=$urlexp[$count];
								$GLOBALS[$variablenname]=$urlexp[$count];
								$_REQUEST[$variablenname]=$urlexp[$count];
							}
						};
					};
					$count++;
				};
			};
			if($tri_conf['ordnerstruktur']==TRUE and substr($REQUEST_URI,-9,9)=='.html?t=1'){
				$host  = $_SERVER['HTTP_HOST'];
				header("Location: http://$host".linkpfad_erweitert($ID,'',TRUE));
				die();
			}
	};
//HTML-Webseite Ende



//KUNDENMODUL LADEN
if(modulvorhanden("kunden")==TRUE)
{
	if(!isset($GLOBALS['page_id_suffix_kunden']))
	{
		$GLOBALS['page_id_suffix_kunden'] = (trieinstellungauslesen("kunden","system","kunden_webseite_settings")==1 && $pageid>0) ? "_".$pageid : "";
	}
	if($_REQUEST['tri_login']==1)
	{
		$IP				= getenv("REMOTE_ADDR"); 
		$datum			= date ("Y-m-d - H:i:s");	
		$kundennummer	= 0;
		if($_REQUEST['tri_passwort']<>null)
		{
			$pwmd5=md5($_REQUEST['tri_passwort']);
		}
		elseif(isset($_REQUEST['tri_passwortmd5']))
		{
			$pwmd5=$_REQUEST['tri_passwortmd5'];
		}
		elseif($pwmd5=='')
		{
			$pwmd5='error';
		}
		
		//var_dump($pwmd5);
		
		$loginname=$_REQUEST['tri_benutzername'];
		if($loginname<>'')
		{
			if(trieinstellungauslesen("kunden","system","kunden_login_webseite")==1)
			{
				$kunden_login_webseite=" and (kunden.webseite='$pageid' or kunden.webseite='0')";
			}
			else
			{
				$kunden_login_webseite="";
			}
			$sql 		= "SELECT ID,benutzername FROM kunden where (benutzername='".mysql_real_escape_string($loginname)."' or ID='".mysql_real_escape_string($loginname)."') and passwort='".mysql_real_escape_string($pwmd5)."' and gesperrt='0' ".$kunden_login_webseite;
			$res 		= tri_db_query("$datenbanknamecms", $sql) or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
			while ($row = mysql_fetch_array ($res))
			{
				$kundennummer		= $row['ID'];
				$benutzername		= $row['benutzername'];
				$ansprechpartner_ID	= 0;
			}
			if($kundennummer==0)
			{
				$login_referenz	= trieinstellungauslesen("kunden","system","login_referenznummer".$GLOBALS['page_id_suffix_kunden']);
				$referenzfeld 	= ($login_referenz==1) ? 'referenznummer': 'mailfeld';
				$sql			= "SELECT kunden.ID,kunden.benutzername FROM kunden, kunden_felder, kunden_felder_werte where kunden.ID=kunden_felder_werte.kundennummer and kunden_felder.funktion='".$referenzfeld."' and kunden_felder.ID=kunden_felder_werte.feldid and kunden_felder_werte.wert1='".mysql_real_escape_string($loginname)."' and kunden.passwort='".mysql_real_escape_string($pwmd5)."' and kunden.gesperrt='0' ".$kunden_login_webseite;
				$res 			= tri_db_query("$datenbanknamecms", $sql) or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
				while ($row 	= mysql_fetch_array ($res))
				{
					$kundennummer		= $row['ID'];
					$benutzername		= $row['benutzername'];
					$ansprechpartner_ID	= 0;
				}
			};
			if($kundennummer==0 and trieinstellungauslesen("kunden","system","kunden_login_ansprechpartner")==1)
			{
				$res 		= tri_db_query("$datenbanknamecms", "SELECT ID,kundennummer,mail from kunden_ansprechpartner where mail='$loginname' and passwort='$pwmd5'") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
				while ($row = mysql_fetch_array ($res))
				{
					$kundennummer		= $row['kundennummer'];
					$benutzername		= $row['mail'];
					$ansprechpartner_ID	= $row['ID'];
				}
			}
		}
		if($kundennummer<>0){
			if($_REQUEST['tri_logindauer']==null){
				$logindauer=3600;
			}else{
				$logindauer=$_REQUEST['tri_logindauer'];
			};
			$curtime=time();
			$endtime=$curtime+$logindauer;
			$pwmd5=md5(substr($pwmd5,3,5));
			$adminnick=md5(substr($benutzername,2,2).substr($benutzername,3,2));
			if(is_numeric(substr(md5($curtime),6,1))==TRUE){
				$sessionid=date("w",$curtime).date("W",$curtime).substr($pwmd5,-5,5).$adminnick.md5($curtime);
				$sessionid=md5($sessionid).substr(md5($curtime),4,9).date("D",$curtime).$userid.date("Y",$curtime).date("z",$curtime);
			}else{
				$sessionid=md5($curtime).$adminnick.date("W",$curtime).date("w",$curtime).substr($pwmd5,-5,5);
				$sessionid=substr(md5($curtime),4,9).md5($sessionid).date("D",$curtime).$userid.date("Y",$curtime).date("z",$curtime);
			};
			$sessionid=substr($sessionid,-30,30).substr(getenv("REMOTE_ADDR"),0,30).substr(getenv("REMOTE_ADDR"),0,-5);
			tri_db_query($datenbanknamecms, "delete FROM kunden_sessions where endtime<='$curtime'") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
			tri_db_query($datenbanknamecms, "INSERT INTO `kunden_sessions` ( `session` , `kundennummer` , `starttime`, `endtime`, `ansprechpartner`) VALUES ( '$sessionid', '$kundennummer', '$curtime', '$endtime','$ansprechpartner_ID');") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
			tri_db_query($datenbanknamecms, "INSERT INTO `kunden_logins` ( `status` , `kundennummer` ,  `datum` , `IP` ) VALUES ( '0', '$kundennummer', '$datum', '$IP');") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
			tri_db_query("$datenbanknamecms", "update kunden set lastlogin='$datum',anzlogin=anzlogin+1 where ID='$kundennummer'") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
			setcookie ("triuser", $sessionid,time()+2592000);
			$session=$sessionid;
			
		}else{
			$res = tri_db_query("$datenbanknamecms", "SELECT ID as kundennummer,gesperrt FROM kunden where (benutzername='$loginname' or ID='$loginname') ") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
			$row = mysql_fetch_array ($res);
				if($row['gesperrt']==1){
					tri_db_query($datenbanknamecms, "INSERT INTO `kunden_logins` ( `status` , `kundennummer` ,  `datum` , `IP` ) VALUES ( '2', '$row[kundennummer]', '$datum', '$IP');") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
				}elseif($row['gesperrt']==0){
					tri_db_query($datenbanknamecms, "INSERT INTO `kunden_logins` ( `status` , `kundennummer` ,  `datum` , `IP` ) VALUES ( '1', '$row[kundennummer]', '$datum', '$IP');") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
				}elseif($row['gesperrt']==2){
					tri_db_query($datenbanknamecms, "INSERT INTO `kunden_logins` ( `status` , `kundennummer` ,  `datum` , `IP` ) VALUES ( '3', '$row[kundennummer]', '$datum', '$IP');") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);				
				}else{
					tri_db_query($datenbanknamecms, "INSERT INTO `kunden_logins` ( `status` , `kundennummer` ,  `datum` , `IP` ) VALUES ( '4', '0', '$datum', '$IP');") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);	
				}

			$sql="SELECT count(ID) as counter FROM kunden_logins where IP='$IP' and datum>='".date('Y-m-d - H:i:s',time()-60*60*24)."' and status>'0' ";
			$res = tri_db_query("$datenbanknamecms", $sql) or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
			$row = mysql_fetch_array ($res);

			if($row['counter']>15){
				tri_db_query($datenbanknamecms, "INSERT INTO `tri_ipsperre` (`IP`,`datum`,`variable`) VALUES ('$IP','$datum','Zu viele Loginversuche');") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
			}
		};
	}elseif($_REQUEST['tri_logout']==1){
		$session=$_COOKIE['triuser'];
		tri_db_query("$datenbanknamecms", "DELETE FROM kunden_sessions where session='$session'") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
		$session="";
		setcookie ("triuser", "",time());
		$kundennummer=0;
	}elseif(isset($_COOKIE['triuser'])==TRUE){
		$session=$_COOKIE['triuser'];
	}else{
		$session="";
	};
	if($session<>null){
		$kundennummer=0;
		$res2 = tri_db_query("$datenbanknamecms", "SELECT kundennummer,ansprechpartner FROM kunden_sessions where session='$session'") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
		while ($row2 = mysql_fetch_array ($res2))
		{
			$kundennummer=$row2['kundennummer'];
			$ansprechpartner_ID=$row2['ansprechpartner'];
		};
		if($kundennummer<>0){
			$kundenonlinefreigabe="bereich.onlinefreigabe>='1' and bereich.papierkorb='0'";
		}else{
			$kundennummer=0;
			$kundenonlinefreigabe="bereich.onlinefreigabe='1' and bereich.papierkorb='0'";
		};
	}else{
		$kundennummer=0;
		$kundenonlinefreigabe="bereich.onlinefreigabe='1' and bereich.papierkorb='0'";
	};
}else{
	$kundennummer=0;
	$kundenonlinefreigabe="bereich.onlinefreigabe='1' and bereich.papierkorb='0'";
};
//KUNDENMODUL LADEN ENDE


//AFFILIATEMODUL LADEN
	if(modulvorhanden("affiliate")==TRUE){
		include('cmssystem/affiliate/modulloading2.php');
	};
//AFFILIATEMODUL LADEN ENDE

//Webseite generieren Anfang
if($bereichauswahl==null and $ID==null){
	$res2 = tri_db_query($datenbanknamecms, "SELECT ID FROM bereiche where page='$pageid' and papierkorb='0' order by prio asc limit 1") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
	$row2 = mysql_fetch_array ($res2);
		$bereichauswahl=$row2['ID'];
};

if($bereichauswahl<>null and $ID==null){
	$res2 = tri_db_query($datenbanknamecms, "SELECT ID FROM bereich where bereich='$bereichauswahl' and unterbereich='0' and papierkorb='0' and $kundenonlinefreigabe order by prio asc limit 1") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
	$row2 = mysql_fetch_array ($res2);
		$ID=$row2['ID'];
	if($_SERVER['REQUEST_URI']<>'/' and $_SERVER['REQUEST_URI']<>''){
		$tri_conf['statistik_deaktivieren']=TRUE;
	}
};

	if (modulvorhanden('mandanten'))
	{
		require_once('cmssystem/mandanten/funktionen.php');
		$mandant	= (int) trieinstellungauslesen("bereiche","system","mandant_".$pageid);
		$GLOBALS['page_mandant'] = $mandant;
	}

	$pagevorhanden	= FALSE;
	$sql 			= "SELECT bereich.*,bereich_page.titel AS homepagename, bereich_page.mail FROM bereich,bereiche,bereich_page where bereich.ID='$ID' and $kundenonlinefreigabe AND bereich.bereich = bereiche.ID AND bereiche.page=bereich_page.ID";
	$res2 			= tri_db_query("$datenbanknamecms", $sql) or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
	while ($row2 	= mysql_fetch_array ($res2))
	{
		$meta_keywords.=$row2['keywords'];
		$meta_keywords_bereich=$row2['keywords'];
		$meta_description	= $row2['seitenbeschreibung'];
		$hptitel			= $row2['homepagetitel'];
		$hptitel_orginal	= $row2['homepagetitel'];
		$hptitel2			= $row2['homepagename'];
		$hptitel			= str_replace("%homepagename%", $hptitel2, $hptitel);
		$hptitel			= str_replace("%bereichname%", $row2['titel'], $hptitel);
		$hits				= $row2['hits'];
		$pageartikel		= stripslashes($row2['artikel']);
		$pagetitel			= $row2['titel'];
		$pagedatum			= $row2['datum'];
		$pageautor			= $row2['edit'];
		$bereichauswahl		= $row2['bereich'];
		$hitsip				= $row2['lastip'];
		$onlinefreigabepage	= $row2['onlinefreigabe'];
		$pagevorhanden		= TRUE;
		
		$GLOBALS['SMTP_STANDARD_MAIL'] 	= (checkmail($row2['mail']) && trim($row2['mail'])!="") ? $row2['mail'] : $GLOBALS['SMTP_STANDARD_MAIL'];
		$GLOBALS['SMTP_STANDARD_NAME']	= (checkmail($row2['mail']) && trim($row2['mail'])!="") ? $row2['mail'] : $GLOBALS['SMTP_STANDARD_NAME'];
	};

if($pagevorhanden==FALSE){
	$pagevorhanden=FALSE;
	$webseitenurfuerkunden=FALSE;
	$res2 = tri_db_query("$datenbanknamecms", "SELECT ID FROM bereich where ID='$ID'") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
	if(mysql_num_rows($res2)>0){
		$webseitenurfuerkunden=TRUE;
	}else{
		$fehler404=TRUE;
	};
}else{
	$IP=getenv("REMOTE_ADDR");
	$hits++;
	if($IP!=$hitsip) {
		$res = tri_db_query("$datenbanknamecms", "UPDATE `bereich` SET `hits` = '$hits', lastip='$IP' WHERE ID='$ID'") or die ("Fehler in der Bereichabfrage 4");
	};
};


if($webseitenurfuerkunden==TRUE){
	$gesamttemplate=templateeinlesen($template,"nichteingeloggt");
}elseif($onlinefreigabe==1){
	header("HTTP/1.0 200 OK");
	$gesamttemplate=templateeinlesen($template,"index");
}elseif($onlinefreigabe=='0'){
	$gesamttemplate=templateeinlesen($template,"offline");
}else{
	if(function_exists('template_keinewebseite')==TRUE){
		die(template_keinewebseite());
	}else{
		die("Zu dieser Webseite wurde keine Domain erstellt");
	};
};

if($kundennummer>0){
	$gesamttemplate=str_replace("{logout}",templateeinlesen($template,"index_logout"),$gesamttemplate);
}else{
	$gesamttemplate=str_replace("{logout}",'',$gesamttemplate);
};

$gesamttemplate=str_replace("{webseitenurl}",$domain,$gesamttemplate);

	//Standardpagefunktionen holen und umsetzen
		$artikeltemplate=templateeinlesen($template,"page");
		$artikeltemplate=str_replace("{artikel}",$pageartikel,$artikeltemplate);
		$artikeltemplate=str_replace("{titel}",$pagetitel,$artikeltemplate);
		$artikeltemplate=str_replace("{autor}",$pageautor,$artikeltemplate);
		$artikeltemplate=str_replace("{hits}",$hits,$artikeltemplate);
		$artikeltemplate=str_replace("{datum}",$pagedatum,$artikeltemplate);
		$extendedvar="";
		foreach ($_REQUEST as $name=>$value) {
			$extendedvar.="&$name=$value";
		};


		$artikeltemplate=str_replace("{druckansichtlink}","modul.php?modul=standard&modulkat=druckansicht&ID=$ID".$extendedvar,$artikeltemplate);
	//PAGEMODULE LADEN & UMSETZEN
		if(file_exists('cmssystem/seo/modulloading2.php')){
			$GLOBALS['modulseo_aktiv']=TRUE;
			$gesamttemplate=str_replace('{meta-keywords}','{meta-keywords}{meta-keywords-seo}',$gesamttemplate);
			$gesamttemplate=str_replace('{meta-description}','{meta-description}{meta-description-seo}',$gesamttemplate);
			$gesamttemplate=str_replace('{seitentitel}','{seitentitel}{seitentitel-seo}',$gesamttemplate);
			$gesamttemplate=str_replace('{hptitel}',$hptitel2,$gesamttemplate);
			
		}else{
			$GLOBALS['modulseo_aktiv']=FALSE;
		};
	

		include("GeneratedItems/module.php");

		if(file_exists('cmssystem/bereiche/modulloading2.php')){
			include('cmssystem/bereiche/modulloading2.php');
		};

		if(file_exists('cmssystem/seo/modulloading2.php')){
			include('cmssystem/seo/modulloading2.php');
		};
		
	//PAGE in das Template einbauen
		$artikeltemplate=str_replace("{ID}",$ID,$artikeltemplate);
        if($fehler404) {
            $fehlerseite=templateeinlesen($template,"fehlerseite");
            $gesamttemplate=str_replace("{page}",$fehlerseite,$gesamttemplate);
        } else {
            $gesamttemplate=str_replace("{page}",$artikeltemplate,$gesamttemplate);
        }

		
		
	//Pfade aus dem Template anpassen (./Labels)
		$gesamttemplate=templateverarbeiten($gesamttemplate);
		$gesamttemplate=templateglobalevariablen($gesamttemplate);
		$gesamttemplate=templatepfadanpassen($gesamttemplate,$template);
	

	//Vorherige m�gliche Ausgaben l�schen
	//	@ob_end_clean();
	
	//Ladezeit bestimmmen
	
	$time_end = getmicrotime();
	$time = round($time_end - $time_start,2);
	$gesamttemplate	= str_replace("{ladezeit}",$time,$gesamttemplate);
	$gesamttemplate	= str_replace("{aktuellesdatum}",date ("Y-m-d"),$gesamttemplate);
	$gesamttemplate	= str_replace("{aktuellezeit}",date ("H:i:s"),$gesamttemplate);
	$gesamttemplate	= str_replace("%template%",$template,$gesamttemplate);
	$gesamttemplate	= str_replace("{template}",$template,$gesamttemplate);
	
	$standardmail	= explode(";", $standardmail);
	$mandanten_ID	= trieinstellungauslesen("bereiche","system","mandant_".$GLOBALS['pageid']);
	$gesamttemplate	= tri_systemdaten_parsen($gesamttemplate,1,$mandanten_ID);
	$gesamttemplate	= str_replace('{bereiche_mail}', $standardmail[0], $gesamttemplate);
	$gesamttemplate	= str_replace('{jahr}', date("Y"), $gesamttemplate);
	
	
	if(file_exists('cmssystem/bereiche/class.template_uebersetzen.php'))
	{
		require_once('cmssystem/bereiche/class.template_uebersetzen.php');
		$template_uebersetzen 	= new template_uebersetzen($gesamttemplate,$template,"bereiche_link","linkpfad_erweitert",true);
		
		if(method_exists($template_uebersetzen, 'generateSeoUrl'))
		{
			$gesamttemplate 		= $template_uebersetzen->generateSeoUrl();
		}
	}
	
	$gesamttemplate	= str_replace('src="//', 'src="/', $gesamttemplate);
		
	//Ausgabe an den User �bermitteln
	echo $gesamttemplate;

//Webseite generieren ENDE

};

//echo tri_db_query_stat();

?>