<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:35:30 - Hashcode: 329c9a87f38dd6884255f3b29ae16d8e 
 ?><?php 
	include("../GeneratedItems/config.php");
	$checkrecht="loginerlaubt";
	include("rechtecheck.php");
	include("allgfunktionen.php");
	include("../GeneratedItems/debug.php");
	include('standard/'.tri_sprachdatei_einlesen($lang));
	include('standard/funktionen.php');
	tri_db_query ($GLOBALS['datenbanknamecms'], "update tri_sessions set tray='' where session='$sessionid'") or die ("dd1");
	
	$theme=trieinstellungauslesen("meinedaten",$edit,"theme");
	if($theme==null or file_exists('GeneratedItems/themes/'.$theme.'.css')==FALSE){
		if(trieinstellungauslesen("administration","system","erpenterprise")==1 and file_exists('GeneratedItems/themes/erpenterprise.css')){
			$theme_design='erpenterprise';
		}else{
			$theme_design='alphacube';
		}
	}else{
		$theme_design=$theme;
	};
	$shortinfo_transparenz	= trieinstellungauslesen("administration","system","shortinfo_transparenz");
	$shortinfo_class		= ($shortinfo_transparenz==1) ? "" : "transparenz";
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">


<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
		<title>tricoma @ <?php echo $_SERVER['SERVER_NAME']; ?></title>
		<link rel="SHORTCUT ICON" href="images/favicon.ico">
		<script type="text/javascript" src="GeneratedItems/window_prototype.js"> </script> 
		<script type="text/javascript" src="GeneratedItems/window_effects.js"> </script> 
		<script type="text/javascript" src="GeneratedItems/window_window.js"> </script> 
		<script type="text/javascript" src="GeneratedItems/window_window_ext.js"> </script> 
		<script type="text/javascript" src="GeneratedItems/window_debug.js"> </script> 
		<link href="GeneratedItems/themes/default.css" rel="stylesheet" type="text/css"> 
		<link href="GeneratedItems/themes/<?php echo $theme_design; ?>.css" rel="stylesheet" type="text/css"> 
		<link href="GeneratedItems/themes/startmenu.css" rel="stylesheet" type="text/css"> 
		<script src="allgfunktionen.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="GeneratedItems/style.CSS">
		<div id="head_span"></div>
	</head>

	  <style type="text/css">
	    .popup_effect1 {
	      background:#11455A;
	      opacity: 0.2;
	    }
	    .popup_effect2 {
	      background:#FF0041;
	      border: 3px dashed #000;
	    }
	    
	  </style>	
<script language='JAVASCRIPT' type='TEXT/JAVASCRIPT'>
//Rechtsklickfunktion aktivieren ANFANG
var rechtsklickfunktion='rechtsklick(e);';
var linksklickfunktion='linksklick(e);';
document.onmousedown = rightclick;		
function rechtsklick(ereignis){
	posx = document.all ? window.event.clientX : ereignis.pageX;
	posy = document.all ? window.event.clientY : ereignis.pageY;
	if(posy>30){
		document.getElementById('rechtsklickdiv').style.display='block';
		document.getElementById('rechtsklickdiv').style.left = posx  + "px";
		document.getElementById('rechtsklickdiv').style.top = posy  + "px";
	};
};	
function linksklick(ereignis){
	document.getElementById('rechtsklickdiv').style.display='none';
	startmenuverwaltung_close();
};
//Rechtsklickfunktion aktivieren ENDE


// globale Instanz von XMLHttpRequest
var xmlHttp = false;
var startmenusichtbar = false;
var startmenuallgemeinsichtbar = false;
var startmenuwebseitesichtbar = false;
var startmenuwebseitenmodulesichtbar = false;
var startmenucommunitysichtbar = false;
var startmenukundensichtbar = false;
var startmenuwebofficesichtbar = false;
var infoindex = 1;
var fensterindex = 1;

// XMLHttpRequest-Instanz erstellen
// ... für Internet Explorer
try {
    xmlHttp  = new ActiveXObject("Msxml2.XMLHTTP");
    xmlHttptray  = new ActiveXObject("Msxml2.XMLHTTP");
    xmlHttpshort  = new ActiveXObject("Msxml2.XMLHTTP");
} catch(e) {
    try {
        xmlHttp  = new ActiveXObject("Microsoft.XMLHTTP");
        xmlHttpshort  = new ActiveXObject("Microsoft.XMLHTTP");
    } catch(e) {
        xmlHttp  = false;
    }
}
// ... für Mozilla, Opera und Safari
if (!xmlHttp  && typeof XMLHttpRequest != 'undefined') {
    xmlHttp = new XMLHttpRequest();
    xmlHttptray  = new XMLHttpRequest();
    xmlHttpshort  = new XMLHttpRequest();
}

//Uhr laden
setInterval("loadData()",55000);
function loadData()
{
 if (xmlHttp) {
     xmlHttp.open('GET', 'ajax.php?ajaxsessionid=<?php echo $sessionid; ?>', true);
     xmlHttp.onreadystatechange = function () {
         if (xmlHttp.readyState == 4) {
             document.getElementById("asb_content").innerHTML = xmlHttp.responseText;
         }
     };
     xmlHttp.send(null);
 }
}

function unloadData()
{
 if (xmlHttp) {
     xmlHttp.open('GET', 'ajax.php?ajaxsessionid=<?php echo $sessionid; ?>&auswahl=logout', true);
     xmlHttp.onreadystatechange = function () {
         if (xmlHttp.readyState == 4) {
         	//alert('dd');
             //document.getElementById("asb_content").innerHTML = xmlHttp.responseText;
         }
     };
     xmlHttp.send(null);
 }
}

var showshortinfo=false;
//Lade ShortInfos
<?php if(trieinstellungauslesen("standard","system","ajax_abfrage_deaktivieren")<>1){ ?>
	setInterval("loadDatashort()",29500);
<?php }; ?>
function loadDatashort(){
 if (xmlHttpshort) {
     xmlHttpshort.open('GET', 'ajax.php?auswahl=shortinfo&ajaxsessionid=<?php echo $sessionid; ?>', true);
     xmlHttpshort.onreadystatechange = function () {
         if (xmlHttpshort.readyState == 4) {
         	if(xmlHttpshort.responseText!=''){
         		if(document.getElementById("shortinfo_content").innerHTML==''){
         			ton_aktivieren();
         		}
         		document.getElementById("shortinfo_content").innerHTML = xmlHttpshort.responseText;
             	if(showshortinfo==true){
             		document.getElementById('shortinfo').style.display = 'block';
             	}else{
             		document.getElementById('shortinfo2').style.display = 'block';
             	}
            }else{
            	document.getElementById('shortinfo').style.display = 'none';
            	document.getElementById("shortinfo_content").innerHTML='';
            	ton_deaktivieren();
            };
         }
     };
     xmlHttpshort.send(null);
 }
};

//Funktion zur Suche
function startsearch(suche,modulbegrenzung,pfad,quellmodul)
{
	if (xmlHttpshort) 
	{
		var url ='ajax.php?auswahl=shortsearch&ajaxsessionid=<?php echo $sessionid; ?>&suche=' + suche + '&modulbegrenzung=' + modulbegrenzung + '&pfad=' + pfad + '&quellmodul=' + quellmodul;
		
		xmlHttpshort.open('GET', url, true);
		xmlHttpshort.onreadystatechange = function () 
		{
			if (xmlHttpshort.readyState == 4) 
			{
				if(xmlHttpshort.responseText!='')
				{
					document.getElementById("shortsearch").innerHTML = xmlHttpshort.responseText;
					document.getElementById('shortsearch').style.display = 'block';
				}
				else
				{
					document.getElementById('shortsearch').style.display = 'none';
			};
		}
	};
	xmlHttpshort.send(null);
	}
};

//Alle Fenster schließen
var cWins = new Array();
function closeAll() {
    var x = 0;
    var lag=250;
	for(var i=(cWins.length-1);  i>=0;  i--) {
	  setTimeout('cWins['+i+'].hide()',(x*lag));
	  x++;
	}
	setTimeout('cWins.length=0; idx=0; cascade=0;',x*lag);
}


function changemenuBG(node) {
	if (node.style.backgroundColor != "") {
		node.style.backgroundColor = "";
	} else {
		node.style.backgroundColor = "#f5f5f5";
	}
}

function startmenuverwaltung(){
	if(startmenusichtbar == false){
		win1.show();
		win1.toFront();
		startmenusichtbar=true;
		document.getElementById('startbutton').style.filter='alpha(opacity=70)';
		document.getElementById('startbutton').style.opacity='0.7';
	}else{
		startmenuverwaltung_close();
	};
};

function startmenuverwaltung_close(){
	if(startmenusichtbar == true){
		win1.hide();
		startmenusichtbar=false;
		document.getElementById('startbutton').style.filter='alpha(opacity=30)';
		document.getElementById('startbutton').style.opacity='0.3';
		startmenuverwaltung_allgemein_close();
		startmenuverwaltung_webseite_close();
		startmenuverwaltung_webseitenmodule_close();
		startmenuverwaltung_community_close();
		startmenuverwaltung_kunden_close();
		startmenuverwaltung_weboffice_close();
	};
};

function startmenuverwaltung_allgemein(){
	if(startmenuallgemeinsichtbar == false){
		win10.show();
		win10.toFront();
		startmenuallgemeinsichtbar=true;
		startmenuverwaltung_webseite_close();
		startmenuverwaltung_webseitenmodule_close();
		startmenuverwaltung_community_close();
		startmenuverwaltung_kunden_close();
		startmenuverwaltung_weboffice_close();
	}else{
		startmenuverwaltung_allgemein_close();
	};
};
function startmenuverwaltung_allgemein_close(){
	if(startmenuallgemeinsichtbar == true){
		win10.hide();
		startmenuallgemeinsichtbar=false;
	};
};

function startmenuverwaltung_webseite(){
	if(startmenuwebseitesichtbar == false){
		win11.show();
		win11.toFront();
		startmenuwebseitesichtbar=true;
		startmenuverwaltung_allgemein_close();
		startmenuverwaltung_webseitenmodule_close();
		startmenuverwaltung_community_close();
		startmenuverwaltung_kunden_close();
		startmenuverwaltung_weboffice_close();
	}else{
		startmenuverwaltung_webseite_close();
	};
};
function startmenuverwaltung_webseite_close(){
	if(startmenuwebseitesichtbar == true){
		win11.hide();
		startmenuwebseitesichtbar=false;
	};
};

function startmenuverwaltung_webseitenmodule(){
	if(startmenuwebseitenmodulesichtbar == false){
		win12.show();
		win12.toFront();
		startmenuwebseitenmodulesichtbar=true;
		startmenuverwaltung_allgemein_close();
		startmenuverwaltung_webseite_close();
		startmenuverwaltung_community_close();
		startmenuverwaltung_kunden_close();
		startmenuverwaltung_weboffice_close();
	}else{
		startmenuverwaltung_webseitenmodule_close();
	};
};
function startmenuverwaltung_webseitenmodule_close(){
	if(startmenuwebseitenmodulesichtbar == true){
		win12.hide();
		startmenuwebseitenmodulesichtbar=false;
	};
};

function startmenuverwaltung_community(){
	if(startmenucommunitysichtbar == false){
		win13.show();
		win13.toFront();
		startmenucommunitysichtbar=true;
		startmenuverwaltung_allgemein_close();
		startmenuverwaltung_webseite_close();
		startmenuverwaltung_webseitenmodule_close();
		startmenuverwaltung_kunden_close();
		startmenuverwaltung_weboffice_close();
	}else{
		startmenuverwaltung_community_close();
	};
};
function startmenuverwaltung_community_close(){
	if(startmenucommunitysichtbar == true){
		win13.hide();
		startmenucommunitysichtbar=false;
	};
};

function startmenuverwaltung_kunden(){
	if(startmenukundensichtbar == false){
		win14.show();
		win14.toFront();
		startmenukundensichtbar=true;
		startmenuverwaltung_allgemein_close();
		startmenuverwaltung_webseite_close();
		startmenuverwaltung_webseitenmodule_close();
		startmenuverwaltung_community_close();
		startmenuverwaltung_weboffice_close();
	}else{
		startmenuverwaltung_kunden_close();
	};
};
function startmenuverwaltung_kunden_close(){
	if(startmenukundensichtbar == true){
		win14.hide();
		startmenukundensichtbar=false;
	}
};

function startmenuverwaltung_weboffice(){
	if(startmenuwebofficesichtbar == false){
		win15.show();
		win15.toFront();
		startmenuwebofficesichtbar=true;
		startmenuverwaltung_allgemein_close();
		startmenuverwaltung_webseite_close();
		startmenuverwaltung_webseitenmodule_close();
		startmenuverwaltung_community_close();
		startmenuverwaltung_kunden_close();
	}else{
		startmenuverwaltung_weboffice_close();
	};
};
function startmenuverwaltung_weboffice_close(){
	if(startmenuwebofficesichtbar == true){
		win15.hide();
		startmenuwebofficesichtbar=false;
	}
};

function preloading(){
	<?php 
		if(trieinstellungauslesen("standard",$edit,"meintricoma_deaktivieren")<>1){
			echo "win_d_meintricoma.show();
			tray_open('d_meintricoma');
			contentframed_meintricoma.location.href='meinedaten/meintricoma.php';";
		}
	?>
	document.getElementById('ladeanzeige').style.display = 'none';
};

function desktopicon_anzeigen(desele,typ){
	document.getElementById(desele).style.filter='alpha(opacity=80)';
	document.getElementById(desele).style.opacity='0.8';
};

function desktopicon_ausblenden(desele){
	document.getElementById(desele).style.filter='alpha(opacity=50)';
	document.getElementById(desele).style.opacity='0.5';
};


function infofenster(titel,inhalt,hoehe,breite) 
{
  	Dialog.info('<table width="100%" border=0 cellspacing=2 bgcolor="white"><tr><td>' + inhalt + '</td></tr></table>', {className: "<?php echo $theme_design; ?>", title: "<b>"+titel+"<b>",  width: breite, id: "d" + infoindex, hideEffect: Element.hide,showEffect: Element.show,minimizable: false,closable: true,draggable: true})
  	infoindex++;
}

function normalesfenster(titel,url,hoehe,breite){
	eval('winstd' + fensterindex + " = new Window('std" + fensterindex + "', {className: \"<?php echo $theme_design; ?>\", title: \"<b>" + titel + "</b>\", width: " + breite + ", height:" + hoehe + ", top:33, left:120,hideEffect: Element.hide,showEffect: Element.show,minimizable: false,minWidth: 300, minHeight:200, destroyOnClose: true, url: '" + url + "&fensterid=winstd" + fensterindex + "'});");
	eval('winstd' + fensterindex + ".show();");
	eval('winstd' + fensterindex + ".toFront();");
	//eval('winstd' + fensterindex + ".setHTMLContent(\"<iframe height=98% width=100% src='" + url + "&fensterid=winstd" + fensterindex + "' scrolling=yes frameborder=0 id=stdcontentframe" + fensterindex + " name=stdcontentframe" + fensterindex + "></iframe>\");");
	fensterindex++;
	return true;
};

normalesfensterv2arr = new Array();

function normalesfenster_v2(titel,url,hoehe,breite,fenstername){
	if(normalesfensterv2arr[fenstername]==1){
		eval('winstdv2' + fenstername + ".show();");
		eval('winstdv2' + fenstername + ".toFront();");
	}else{
		eval('winstdv2' + fenstername + " = new Window('std" + fenstername + "', {className: \"<?php echo $theme_design; ?>\", title: \"<b>" + titel + "</b>\", width: " + breite + ", height:" + hoehe + ", top:33, left:120,hideEffect: Element.hide,showEffect: Element.show,minimizable: false,minWidth: 300, minHeight:200, destroyOnClose: false, url: '" + url + "&fensterid=winstdv2" + fenstername + "'});");
		eval('winstdv2' + fenstername + ".show();");
		eval('winstdv2' + fenstername + ".toFront();");
		normalesfensterv2arr[fenstername]=1;
	}
	return true;
};

function normalesfenster_schliessen(fenstername){
	eval(fenstername + ".destroy();");
};

function normalesfenster_titelanpassen(fenstername,titel){
	eval(fenstername + ".setTitle('<b>" + titel + "</b>');");
};


function infofenster_schliessen(){
	Windows.closeAllModalWindows();
	return true;
};

function modulfenster_anzeigen(modul,frameurl){
	eval('win_' + modul + '.show();');
	eval('win_' + modul + '.toFront();');
	eval('tray_open("' + modul + '");');
	if(frameurl == ''){
		if(modul!='messenger'){
			eval('menuframe' + modul + '.location.href=\'/cmssystem/obenmenu.php?menuid=' + modul + '&firstload=1&sessionid=<?php echo $sessionid; ?>\';');
		}
	}else{
		if(modul!='messenger'){
			eval('menuframe' + modul + '.location.href=\'/cmssystem/obenmenu.php?menuid=' + modul + '&sessionid=<?php echo $sessionid; ?>\';');
		}
		eval('contentframe' + modul + '.location.href=\'' + frameurl + '\';');
	};
	startmenuverwaltung_close();
};

//Drag'n Drop
var dragobjekt = null;
var dragx = 0;
var dragy = 0;
var posx = 0;
var posy = 0;
var dragname=null;
var dragnameleft=null;
var dragnametop=null;
var trayinuse=0;	//Wenn 1 dann wird gerade der Tray geladen


function draginit() {
  document.onmousemove = drag;
  document.onmouseup = dragstop;
}


function dragstart(element,dragobjektname) {
  dragobjekt = element;
  dragname = dragobjektname;
  dragx = posx - dragobjekt.offsetLeft;
  dragy = posy - dragobjekt.offsetTop;
}


function dragstop() {
	if(dragname!=null){
		dragnameleft=dragobjekt.style.left;
		dragnametop=dragobjekt.style.top;
		dragobjekt=null;
	  	dragposition_save(dragname);
	  	dragname=null;
	 }
}

function dragposition_save(dragname)
{
	if(trayinuse==0){
		 if (xmlHttp) {
		    xmlHttp.open('GET', 'ajax.php?auswahl=desktopicon&ajaxsessionid=<?php echo $sessionid; ?>&icon=' + dragname + '&posx=' + dragnameleft + '&posy=' + dragnametop, true);
		    xmlHttp.send(null);
		 }
	};
}

function drag(ereignis) {
  posx = document.all ? window.event.clientX : ereignis.pageX;
  posy = document.all ? window.event.clientY : ereignis.pageY;
  if(dragobjekt != null && (posy - dragy)>30) {
    dragobjekt.style.left = (posx - dragx) + "px";
    dragobjekt.style.top = (posy - dragy) + "px";
  }
}

//Neue Desktopelemente
function neuesdesktopicon(titel,saveid,aktion,icon,posx,posy,typ){
	var htmlcode='';
	htmlcode = htmlcode + "<div style=\"position:absolute;top:" + posy + "px;left:" + posx + "px;width:113px;\" onmousedown=\"dragstart(this,'" + saveid + "')\" id='desktopicon_" + saveid + "'>";
	htmlcode = htmlcode + "<table width=\"113\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"cursor: pointer;\"  onmouseover=\"javascript:desktopicon_anzeigen('desktopicon2_" + saveid + "');\" onmouseout=\"javascript:desktopicon_ausblenden('desktopicon2_" + saveid + "');\" ondblclick=\"" + aktion + "\">";
	htmlcode = htmlcode + "<tr><td align=\"center\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"32\" height=\"32\"><tr><td background=\"" + icon + "\">&nbsp;";
	htmlcode = htmlcode + "</td></tr></table>"; 
	htmlcode = htmlcode + "</td></tr><tr><td align=\"center\">";
	htmlcode = htmlcode + "<table width=\"100%\" border=\"0\" cellspacing=\"0\" bgcolor=\"#e5e5e5\" style=\"FILTER: alpha(opacity=50); opacity:0.5; cursor: pointer; border: solid 1px #343434;\" id=\"desktopicon2_" + saveid + "\"><tr><td align=center UNSELECTABLE = \"on\">";
	htmlcode = htmlcode + titel + "</td></tr></table>";
	htmlcode = htmlcode + "</td></tr></table></div>";
	if(typ==1){
		document.getElementById('iconbereich1').innerHTML=document.getElementById('iconbereich1').innerHTML + htmlcode;
	}else{
		document.getElementById('iconbereich2').innerHTML=document.getElementById('iconbereich2').innerHTML + htmlcode;
	};
};

//Tray
function tray_open(traymodul)
{
	 if (xmlHttptray) {
	     xmlHttptray.open('GET', 'ajax.php?auswahl=trayopen&ajaxsessionid=<?php echo $sessionid; ?>&lang=<?php echo $lang; ?>&traymodul=' + traymodul, true);
	     xmlHttptray.onreadystatechange = function () {
	         if (xmlHttptray.readyState == 4) {
	             document.getElementById("traybereich").innerHTML = xmlHttptray.responseText;
	         }
	     };
	     xmlHttptray.send(null);
	 }
	 trayinuse=0;
}

function tray_close(traymodul)
{
	 if (xmlHttptray) {
	     xmlHttptray.open('GET', 'ajax.php?auswahl=trayclose&ajaxsessionid=<?php echo $sessionid; ?>&lang=<?php echo $lang; ?>&traymodul=' + traymodul, true);
	     xmlHttptray.onreadystatechange = function () {
	         if (xmlHttptray.readyState == 4) {
	             document.getElementById("traybereich").innerHTML = xmlHttptray.responseText;
	         }
	     };
	     xmlHttptray.send(null);
	 }
}

var toncache=0;
function ton_aktivieren() 
{ 
	if(toncache!=1){
		document.getElementById("sound_frame").src='ajax.php?auswahl=sound&aktiv=1'; 
	}
	toncache=1;
} 

function ton_deaktivieren() 
{ 
	if(toncache!=2){
		document.getElementById("sound_frame").src='ajax.php?auswahl=sound&aktiv=0'; 
	}
	toncache=2;
} 

function autostart(){
		<?php 
		$autostart_vorhanden=FALSE;
		$res = tri_db_query ($datenbanknamecms, "SELECT ID,name FROM tri_menu where anzeigen='1' order by name asc");
		while ($row = mysql_fetch_array ($res))
		{
			if(prueferecht($row['ID'],$edit)==TRUE){
				if(trieinstellungauslesen("standard",$edit,'autostart')==$row[ID]){
					$startpage=trieinstellungauslesen("standard",$GLOBALS['edit'],"haupttextspeichern_$row[ID]");
					if($startpage==null){
						$res2 = tri_db_query ($datenbanknamecms, "SELECT berechtigung,link,ID FROM tri_untermenu where ID like '$row[ID]%' ORDER BY name asc");
						while ($row2 = mysql_fetch_array ($res2))
						{ 
							if(prueferecht($row2['berechtigung'],$GLOBALS['edit'])==TRUE and $startpage==null){
								$startpage=$row2['ID'];
								$startpagelink=$row2['link'];
								trieinstellungsetzen("standard",$GLOBALS['edit'],"haupttextspeichern_$row[ID]",$row2['ID']);	
							};
						};
					}else{
						$res2 = tri_db_query ($datenbanknamecms, "SELECT link FROM tri_untermenu where ID like '$startpage' limit 1");
						$row2 = mysql_fetch_array ($res2);
						$startpagelink=$row2['link'];
						$link=explode('?',$row['link']);
						if(count($link)==1){
							$startpagelink=$startpagelink.'?sessionid='.$sessionid;
						}else{
							$startpagelink=$startpagelink.'&sessionid='.$sessionid;
						};
					};
					echo "top.modulfenster_anzeigen('".$row['ID']."','$startpagelink');\r\n";
					$autostart_vorhanden=TRUE;
				}
			}
		}
		if(trieinstellungauslesen("administration","system","app_marketplace_start")==1){
			echo "javascript:win_d_netzwerk.show();tray_open('d_netzwerk');win_d_netzwerk.toFront();\r\n";
		}
		if($autostart_vorhanden==FALSE){
			echo "startmenuverwaltung();\r\n";
		}
?>
}

</script>
<style type="text/css" media="screen">

	#asb_container {
	 border: 1px dashed #454545;
	 width: 90%;
	}
	
	#startmenu {
	 width: 170px;
	}
	
	#asb_contentwrap {
	 font: 8pt Arial;
	 height: 20px;
	 background-color: #f6f6f6;
	 overflow: auto;
	}
	
	#asb_contentwrap2 {
	 font: 8pt Arial;
	 height: 78px;
	 background-color: #f6f6f6;
	 overflow: auto;
	}
	
	#asb_content {
	 margin: 2px;
	}
	
	#asb_content .name {
	 color: #555555;
	 font-weight: bold;
	 padding-right: 5px;
	}
	
	#asb_inputwrap {
	 font: 8pt Arial;
	}
	
	#asb_input {
	 margin: 5px;
	}
</style>

	<body background="<?php 
		$hintergrund=trieinstellungauslesen("meinedaten",$edit,"hintergrund"); 
		if($hintergrund<>null){
			echo $hintergrund;
		}else{
			if(trieinstellungauslesen("administration","system","erpenterprise")==1){
				echo "images/bg3.jpg";
			}else{
				echo "images/bg1.jpg";
			}
		}; ?>" onload="javascript:preloading();draginit();autostart();" onunload="unloadData();" oncontextmenu="return false;"  bgcolor="white" leftmargin="0" marginheight="0" marginwidth="0" topmargin="0">
			

		<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#c6c6c6" background="GeneratedItems/themes/<?php echo $theme_design; ?>/verlauf_taskleiste.jpg" height="30">
			<tr>
				<td width="9"></td>
				<td width="90">
					<table width="80" border="0" cellspacing="1" cellpadding="0" style="FILTER: alpha(opacity=30); opacity:0.3; cursor: pointer;" bgcolor="#a0a0a0" height="22" id="startbutton" onclick="javascript:startmenuverwaltung();" onmouseover="rightclickactiv='1';" onmouseout="rightclickactiv='0';">
						<tr>
							<td bgcolor="white">
								<div align="center">
									<b>Menü</b></div>
							</td>
						</tr>
					</table>
				</td>
				<td><div id="traybereich" style="width=95%"><table><tr><td> </td></tr></table>
						
					</div></td>
				<td align="center" valign="middle" width="220">
					<table width="90%" border="0" cellspacing="0" cellpadding="0">
						<tr>
								<td>
									<div align="right">
										<input type="text" id="suchfeld" name="suchfeld" size="20" maxlength="20" style="FILTER: alpha(opacity=70); opacity:0.7; font-size: 10px; height: 19px; border: solid 1pt #a2a2a2;" onkeyup="startsearch(this.value,'','')"></div>
								</td>
							<td width="20">
								<div align="center">
									<img src="images/find.png" alt="" height="16" width="16" border="0"></div>
							</td>
						</tr>
					</table>
				</td>
				<td align="center" valign="middle" width="200">
					<div align="right">
							<table width="124" border="0" cellspacing="1" cellpadding="0" style="FILTER: alpha(opacity=70); opacity:0.7;" bgcolor="#a0a0a0" height="22">
								<tr>
								<td bgcolor="white">
										
										<table width="210" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td width="85">
													<div align="center">
														<table border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td width="25">
																	<div align="center">
																		<img src="images/oben_info.gif" alt="<?php echo $sprache['standard']['desktop_tray_infos']; ?>" height="16" width="16" border="0" onclick="javascript:win2.show();document.frames['contentframeinfo2'].location.href='standard/info.php';" style="cursor: pointer;"></div>
																</td>
																<td width="25">
																	<div align="center">
																		<a href="http://hilfe.tricoma.de" target="_blank"><img src="images/oben_hilfe.gif" alt="<?php echo $sprache['standard']['desktop_tray_hilfe']; ?>" height="16" width="16" border="0"></a></div>
																</td>
																<td width="25">
																	<div align="center">
																	<a href="#" onclick="win_d_meintricoma.show();tray_open('d_meintricoma');contentframed_meintricoma.location.href='meinedaten/meintricoma.php';"><img src="images/desktop_meintricoma.png" alt="<?php echo $sprache['standard']['desktop_tray_homepage']; ?>" height="16" width="16" border="0"></a></div>
																</td>
																<?php if(prueferecht('kalender',$edit)==TRUE){ ?>
															<td width="25">
																<div align="center">
																	<a href="#" onclick="javascript:top.modulfenster_anzeigen('kalender','/cmssystem/kalender/kalender_wochenuebersicht.php');"><img src="kalender/icon.png" alt="Kalender" height="16" width="16" border="0"></a></div>
															</td>
															<?php }; ?>
														</tr>
														</table>
													</div>
												</td>
												<td>
													<iframe id="sound_frame" src="ajax.php?auswahl=sound&aktiv=0" style="display: block;" border="0" frameborder="0" height="1" width="1"></iframe>
													<div id="asb_content" align="right">
														<?php echo '<font color=#aeaeae>loading...</font>'; ?></div>
												</td>
											</tr>
										</table>
									</td>
							</tr>
							</table>
				</td>
				<td width="10"></td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top" width="150">
					<div align="center">
						<div id="ladeanzeige" style="background-color: white; padding: 7px; margin: -196px 0 0 -258px; position:absolute; top: 50%;left: 50%;width: 500px;height: 180px;border-style: dashed; border-width: 1px; align: center;FILTER: alpha(opacity=80);z-index:10;">
							<center>
								<br>
								<br>
								<br>
								<img src="images/loading.gif"><br>
								<font color="#B6D010" size=3>preloading...</font></center>
						</div>
						<div id="rechtsklickdiv" style="position:absolute;  align: center;z-index:10;display:none;">
							<?php 
							$menuepunkte[0]['titel']=$sprache['standard']['meinedaten'];
							$menuepunkte[0]['javascript']="document.getElementById('rechtsklickdiv').style.display='none';tray_open('meinedaten');win_meinedaten.show();win_meinedaten.toFront();menuframemeinedaten.location.href='obenmenu.php?menuid=meinedaten&firstload=1&sessionid=$sessionid';";
							/*
							$menuepunkte[1]['titel']='Icons auf dem Desktop:';
							$menuepunkte[1]['javascript']="";
							$menuepunkte[2]['titel']='Administration';
							$menuepunkte[2]['javascript']="alert('test');";*/
							echo rechtsklickmenue($menuepunkte); ?>
						</div>
						<br>
						<?php 
							$js_icons=standard_desktop_icons('desktop');
						?>
					</div>
				</td>
				<td align="right" valign="top">
					<?php 
						if(trieinstellungauslesen("administration","system","systemmeldung_login")<>''){
							echo trieinstellungauslesen("administration","system","systemmeldung_login");
						}
					?>
					<table width="190" border="0" cellspacing="2" cellpadding="0" background="<?php 
					if($theme_design=='erpenterprise'){
						echo "images/logo_erp.png";
					}else{
						echo "images/logo.png";
					}
					?>">
						<tr height="58">
							<td valign="top" width="190" height="58">
							</td>
						</tr>
					</table>
					<div id="iconbereich1"></div>
					<div id="iconbereich2"></div>
				</td>
			</tr>
		</table>
		<div id="startmenu" style="display: none;">
							<table width="180" border="0" cellspacing="1" cellpadding="0" bgcolor="#9d9d9d">
								<tr>
					<td rowspan="3" bgcolor="white" width="26" background="GeneratedItems/themes/<?php echo $theme_design; ?>/indexnormal_menu_links.jpg"></td>
					<td bgcolor="white"><?php 
if(is_numeric($ww) and $ww>800 and $ww<2900){
	$ajaxwindowwidth=$ww-110;								
}else{
	$ajaxwindowwidth=810;	
};

if(is_numeric($wh) and $wh>600 and $wh<2900){
	$ajaxwindowheight=$wh-290;						
}else{
	$ajaxwindowheight=690;	
};

									
$windowcount=1;
$GLOBALS['javascript']="";
	$GLOBALS['javascript'].= "<script type=\"text/javascript\">
		var win".$GLOBALS['windowcount']." = new Window('".$GLOBALS['windowcount']."', {className: \"startmenu\", title: \"\", width:200, height:250, top:27, left:2,hideEffect: Element.hide,showEffect: Element.show,minimizable: false,closable: false,draggable: false,maximizable: false}); 
		win".$GLOBALS['windowcount'].".getContent().innerHTML = document.getElementById(\"startmenu\").innerHTML;
	</script>";
$windowcount++;
	$GLOBALS['javascript'].= "<script type=\"text/javascript\">
		var win".$GLOBALS['windowcount']." = new Window('".$GLOBALS['windowcount']."', {className: \"$theme_design\", title: \"Info\", width:450, height:302, top:200, left:400,minimizable: false,maximizable: false,resizable: false}); 
		win".$GLOBALS['windowcount'].".getContent().innerHTML = \"<iframe height=98% width=100% src='standard/empty.php' scrolling=no frameborder=0 id=contentframeinfo2 name=contentframeinfo2>\"
	</script>";
$windowcount++;
	$GLOBALS['javascript'].= "<script type=\"text/javascript\">
		var win_d_rechner = new Window('win_d_rechner', {className: \"$theme_design\", title: \"".$sprache['standard']['desktop_rechner']."\", width:150, height:190, top:300, left:10,minimizable: false,maximizable: false,resizable: false}); 
		win_d_rechner.getContent().innerHTML = \"<iframe height=98% width=100% src='standard/empty.php' scrolling=no frameborder=0 id=contentframerechner name=contentframerechner>\"
	</script>";
$windowcount++;
	$GLOBALS['javascript'].= "<script type=\"text/javascript\">
		var win_d_papierkorb = new Window('win_d_papierkorb', {className: \"$theme_design\", title: \"<b>".$sprache['standard']['desktop_papierkorb']."</b>\", width:".$GLOBALS['ajaxwindowwidth'].", height:".$GLOBALS['ajaxwindowheight'].", top:31, left:80,hideEffect: Element.hide,showEffect: Element.show,minWidth: 550, minHeight:300}); 
		win_d_papierkorb.getContent().innerHTML = \"<iframe height=98% width=100% src='standard/empty.php' scrolling=yes frameborder=0 id=contentframepapierkorb name=contentframepapierkorb>\"
	</script>";
$windowcount++;
	$GLOBALS['javascript'].= "<script type=\"text/javascript\">
		var win_d_passwortmanager = new Window('win_d_passwortmanager', {className: \"$theme_design\", title: \"<b>".$sprache['standard']['desktop_passwortmanager']."</b>\", width:850, height:450, top:31, left:80,hideEffect: Element.hide,showEffect: Element.show,minWidth: 550, minHeight:300}); 
		win_d_passwortmanager.getContent().innerHTML = \"<iframe height=98% width=100% src='standard/empty.php' scrolling=yes frameborder=0 id=contentframepwmanager name=contentframepwmanager>\"
	</script>";
$windowcount++;
	$GLOBALS['javascript'].= "<script type=\"text/javascript\">
		var win_d_notizen = new Window('win_d_notizen', {className: \"$theme_design\", title: \"<b>".$sprache['standard']['desktop_notizen']."</b>\", width:600, height:500, top:31, left:80,hideEffect: Element.hide,showEffect: Element.show,minWidth: 550, minHeight:300}); 	
		win_d_notizen.getContent().innerHTML = \"<iframe height=98% width=100% src='standard/empty.php' scrolling=yes frameborder=0 id=contentframenotizen name=contentframepnotizen>\"
	</script>";
$windowcount++;
	$GLOBALS['javascript'].= "<script type=\"text/javascript\">
		var win_d_eigenedateien = new Window('win_d_eigenedateien', {className: \"$theme_design\", title: \"<b>".$sprache['standard']['desktop_eigenedateien']."</b>\", width:".$GLOBALS['ajaxwindowwidth']*0.8.", height:450, top:31, left:80,hideEffect: Element.hide,showEffect: Element.show,minWidth: 550, minHeight:300}); 	
		win_d_eigenedateien.getContent().innerHTML = \"<iframe height=98% width=100% src='standard/empty.php' scrolling=yes frameborder=0 id=contentframeeigenedateien name=contentframeeigenedateien>\"
	</script>";
$windowcount++;
	$GLOBALS['javascript'].= "<script type=\"text/javascript\">
		var win_d_oeffentlichedateien = new Window('win_d_oeffentlichedateien', {className: \"$theme_design\", title: \"<b>".$sprache['standard']['desktop_oeffentlichedateien']."</b>\", width:".$GLOBALS['ajaxwindowwidth']*0.8.", height:450, top:31, left:80,hideEffect: Element.hide,showEffect: Element.show,minWidth: 550, minHeight:300}); 	
		win_d_oeffentlichedateien.getContent().innerHTML = \"<iframe height=98% width=100% src='standard/empty.php' scrolling=yes frameborder=0 id=contentframemeinedaten2 name=contentframemeinedaten2>\"
	</script>";
$windowcount++;
	$GLOBALS['javascript'].= "<script type=\"text/javascript\">
		var win_d_netzwerk = new Window('win_d_netzwerk', {className: \"$theme_design\", title: \"<b>".$sprache['standard']['desktop_netzwerk']."</b>\", width:".$GLOBALS['ajaxwindowwidth'].", height:".$GLOBALS['ajaxwindowheight'].", top:31, left:80,hideEffect: Element.hide,showEffect: Element.show,minWidth: 550, minHeight:300}); 
		win_d_netzwerk.getContent().innerHTML = \"<iframe height=98% width=100% src='' scrolling=yes frameborder=0 id=contentframenetzwerk name=contentframenetzwerk>\"
	</script>";
$windowcount++;
	$GLOBALS['javascript'].= "<script type=\"text/javascript\">
		win".$GLOBALS['windowcount']." = new Window('".$GLOBALS['windowcount']."', {className: \"startmenu\", title: \"\", width:160, height:300, top:28, left:178,hideEffect: Element.hide,showEffect: Element.show,minimizable: false,closable: false,draggable: false,maximizable: false}); 
		win".$GLOBALS['windowcount'].".getContent().innerHTML = document.getElementById(\"startmenu_allgemein\").innerHTML;
	</script>";
$windowcount++;
	$GLOBALS['javascript'].= "<script type=\"text/javascript\">
		var win".$GLOBALS['windowcount']." = new Window('".$GLOBALS['windowcount']."', {className: \"startmenu\", title: \"\", width:160, height:300, top:58, left:178,hideEffect: Element.hide,showEffect: Element.show,minimizable: false,closable: false,draggable: false,maximizable: false}); 
		win".$GLOBALS['windowcount'].".getContent().innerHTML = document.getElementById(\"startmenu_webseite\").innerHTML;
	</script>";
$windowcount++;
	$GLOBALS['javascript'].= "<script type=\"text/javascript\">
		var win".$GLOBALS['windowcount']." = new Window('".$GLOBALS['windowcount']."', {className: \"startmenu\", title: \"\", width:160, height:500, top:88, left:178,hideEffect: Element.hide,showEffect: Element.show,minimizable: false,closable: false,draggable: false,maximizable: false}); 
		win".$GLOBALS['windowcount'].".getContent().innerHTML = document.getElementById(\"startmenu_webseitenmodule\").innerHTML;
	</script>";
$windowcount++;
	$GLOBALS['javascript'].= "<script type=\"text/javascript\">
		var win".$GLOBALS['windowcount']." = new Window('".$GLOBALS['windowcount']."', {className: \"startmenu\", title: \"\", width:160, height:300, top:120, left:178,hideEffect: Element.hide,showEffect: Element.show,minimizable: false,closable: false,draggable: false,maximizable: false}); 
		win".$GLOBALS['windowcount'].".getContent().innerHTML = document.getElementById(\"startmenu_community\").innerHTML;
	</script>";
$windowcount++;
	$GLOBALS['javascript'].= "<script type=\"text/javascript\">
		var win".$GLOBALS['windowcount']." = new Window('".$GLOBALS['windowcount']."', {className: \"startmenu\", title: \"\", width:160, height:530, top:151, left:178,hideEffect: Element.hide,showEffect: Element.show,minimizable: false,closable: false,draggable: false,maximizable: false}); 
		win".$GLOBALS['windowcount'].".getContent().innerHTML = document.getElementById(\"startmenu_kunden\").innerHTML;
	</script>";
$windowcount++;
	$GLOBALS['javascript'].= "<script type=\"text/javascript\">
		var win".$GLOBALS['windowcount']." = new Window('".$GLOBALS['windowcount']."', {className: \"startmenu\", title: \"\", width:160, height:300, top:182, left:178,hideEffect: Element.hide,showEffect: Element.show,minimizable: false,closable: false,draggable: false,maximizable: false}); 
		win".$GLOBALS['windowcount'].".getContent().innerHTML = document.getElementById(\"startmenu_weboffice\").innerHTML;
	</script>";
$windowcount++;
	$GLOBALS['javascript'].= "<script type=\"text/javascript\">
		var win_d_meintricoma = new Window('win_d_meintricoma', {className: \"$theme_design\", title: \"<b>".$sprache['standard']['desktop_meintricoma']."</b>\", width:900, height:600, top:31, left:80,hideEffect: Element.hide, showEffect: Element.show,minWidth: 550, minHeight:300}); 	
		win_d_meintricoma.getContent().innerHTML = \"<iframe height=1 width=100% src='standard/empty.php' scrolling=no frameborder=0 id=menuframed_meintricoma name=menuframed_meintricoma></iframe><iframe height=98% width=100% src='standard/empty.php' scrolling=yes frameborder=0 id=contentframed_meintricoma name=contentframed_meintricoma>\"
	</script>";
$windowcount++;
function menuausgabe($typ){
	$ausgabe="<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		$count=0;
		$res = tri_db_query ($GLOBALS['datenbanknamecms'], "SELECT * FROM tri_menu where bereich='$typ' and anzeigen='1' order by name asc");
		while ($row = mysql_fetch_array ($res))
		{
			$res2 = tri_db_query ($GLOBALS['datenbanknamecms'], "SELECT count(ID) as counter FROM tri_untermenu where ID like '$row[ID]%' LIMIT 1");
			$row2 = mysql_fetch_array ($res2);
			if(prueferecht($row['ID'],$GLOBALS['edit'])==TRUE and $row2['counter']>0){ 
				if($GLOBALS['lang']<>null){
					if(file_exists($row['ID'].'/_lang_'.$GLOBALS['lang'].'.php')==TRUE){
						include($row['ID'].'/_lang_'.$GLOBALS['lang'].'.php');
						if($sprache[$row['ID']]['titel']<>null){
							$row['name']=$sprache[$row['ID']]['titel'];
						};
						
					};
				};

				$res2 = tri_db_query ($GLOBALS['datenbanknamecms'], "SELECT link FROM tri_untermenu where ID='$startpage' LIMIT 1");
				$row2 = mysql_fetch_array ($res2);
				$startpage=$row2['link'];
				
				if($count>0){
					$ausgabe.="<tr height=\"1\" >
									<td bgcolor=\"#cacaca\" height=\"1\"></td>
								</tr>";
				};
				
				if($row['ID']=='messenger'){
					$pos_left_messenger=$_REQUEST['ww']-250;
					$GLOBALS['javascript'].= "<script type=\"text/javascript\">
						var win_".$row['ID']." = new Window('win_$row[ID]', {className: \"$GLOBALS[theme_design]\", title: \"<b>$row[name]</b>\", width:190, height:".$GLOBALS['ajaxwindowheight'].", top:33, left: $pos_left_messenger, hideEffect: Element.hide,minimizable: false,maximizable: false,showEffect: Element.show,minWidth: 190, minHeight:300}); 
						win_".$row['ID'].".getContent().innerHTML = \"<iframe height=100% width=100% src='messenger/datachange.php' scrolling=yes frameborder=0 id=contentframe$row[ID] name=contentframe$row[ID]></iframe>\";
					</script>";
					$ausgabe.= "
								<tr style=\"FILTER: alpha(opacity=30); cursor: pointer;\" onmouseover=\"rightclickactiv='1';\" onmouseout=\"rightclickactiv='0';\">
									<td ";
										if($GLOBALS['theme_design']=='erpenterprise'){
											$ausgabe.="bgcolor=\"#404040\"";
										}else{
											$ausgabe.="bgcolor=\"white\" onMouseOver=\"javascript:changemenuBG(this)\" onMouseOut=\"javascript:changemenuBG(this)\"";
										}
									$ausgabe.=">
										<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
											<tr onclick=\"win_".$row['ID'].".show();win_".$row['ID'].".toFront();tray_open('$row[ID]');startmenuverwaltung_close();\">
												<td width=\"32\" align=center><img src=\"$row[ID]/icon.png\" height=\"24\" width=\"24\" border=\"0\"></td>
												<td width=\"100\"><font color=";
													if($GLOBALS['theme_design']=='erpenterprise'){
														$ausgabe.="#efefef";
													}else{
														$ausgabe.="#414141";
													}
												$ausgabe.="><div style=\"font-size:11px;\">$row[name]</font></td>
											</tr>
										</table>
									 </td>
							</tr>";
				}else{
					$GLOBALS['javascript'].= "<script type=\"text/javascript\">
						var win_".$row['ID']." = new Window('win_$row[ID]', {className: \"$GLOBALS[theme_design]\", title: \"<b>$row[name]</b>\", width:".$GLOBALS['ajaxwindowwidth'].", height:".$GLOBALS['ajaxwindowheight'].", top:33, left:8,hideEffect: Element.hide,showEffect: Element.show,minWidth: 550, minHeight:300}); 
						win_".$row['ID'].".getContent().innerHTML = \"<iframe height=25 width=100% src='standard/empty.php' scrolling=no frameborder=0 id=menuframe$row[ID] name=menuframe$row[ID]></iframe><iframe height=95% width=100% src='standard/empty.php' scrolling=yes frameborder=0 id=contentframe$row[ID] name=contentframe$row[ID]></iframe>\";
					</script>";
					$ausgabe.= "
								<tr style=\"FILTER: alpha(opacity=30); cursor: pointer;\" onmouseover=\"rightclickactiv='1';\" onmouseout=\"rightclickactiv='0';\">
									<td ";
										if($GLOBALS['theme_design']=='erpenterprise'){
											$ausgabe.="bgcolor=\"#404040\"";
										}else{
											$ausgabe.="bgcolor=\"white\" onMouseOver=\"javascript:changemenuBG(this)\" onMouseOut=\"javascript:changemenuBG(this)\"";
										}
									$ausgabe.=">
										<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
											<tr onclick=\"win_".$row['ID'].".show();win_".$row['ID'].".toFront();tray_open('$row[ID]');menuframe".$row['ID'].".location.href='obenmenu.php?menuid=$row[ID]&firstload=1&sessionid=".$GLOBALS['sessionid']."';startmenuverwaltung_close();\">
												<td width=\"32\" align=center><img src=\"$row[ID]/icon.png\" height=\"24\" width=\"24\" border=\"0\"></td>
												<td width=\"100\"><font color=";
													if($GLOBALS['theme_design']=='erpenterprise'){
														$ausgabe.="#efefef";
													}else{
														$ausgabe.="#414141";
													}
												$ausgabe.="><div style=\"font-size:11px;\">$row[name]</font></td>
											</tr>
										</table>
									 </td>
							</tr>";
				}


				$GLOBALS['windowcount']++;
				$count++;
			};
			
		}
	if($count==0){
		$ausgabe.= "<tr style=\"FILTER: alpha(opacity=30); cursor: pointer;\" onmouseover=\"rightclickactiv='1';\" onmouseout=\"rightclickactiv='0';\" height=25>
							<td bgcolor=\"white\" onMouseOver=\"javascript:changemenuBG(this)\" onMouseOut=\"javascript:changemenuBG(this)\">
								<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
									<tr startmenuverwaltung_close();\">
										<td width=\"32\" align=center></td>
										<td width=\"100\"><font color=#7b7b7b><div style=\"font-size:11px;\">Kein Modul vorhanden</font></td>
									</tr>
								</table>
							 </td>
					</tr>";
	};
	$ausgabe.="</table>";
	return $ausgabe;
	};
	


										?><?php 
										
										$ausgabe_allgemein='';
										$ausgabe_allgemein=menuausgabe(1); 
										
										?>
										<table width="100%" border="0" cellspacing="0" cellpadding="2" height="30" background="<?php 
										if($theme_design=='erpenterprise'){
											echo "GeneratedItems/themes/erpenterprise/indexnormal_menu_verlauf.jpg";
										}else{
											echo "images/indexnormal_menu_verlauf.jpg";
										}
										?>" style="cursor: pointer;" onclick="javascript:startmenuverwaltung_allgemein();" onmouseover="rightclickactiv='1';" onmouseout="rightclickactiv='0';">
											<tr>
												<td width="5"></td>
												<td><div style="font-size:12px; <?php 
													if($theme_design=='erpenterprise'){
														echo "color:white;";
													}
												?>"><?php echo $sprache['standard']['desktop_gruppe_allgemein']; ?></div></td>
												<td>
													<div align="right">
														<img src="images/indexnormal_pfeil.png" alt="" height="10" width="10" border="0"></div>
												</td>
											</tr>
										</table>
									<?php 
									
									$ausgabe_webseite='';
									$ausgabe_webseite=menuausgabe(2); 
									
									?>
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr height="1">
														<td colspan="2" bgcolor="#cacaca" height="1"></td>
													</tr>
												</table>
												<table width="100%" border="0" cellspacing="0" cellpadding="2" height="30" background="<?php 
										if($theme_design=='erpenterprise'){
											echo "GeneratedItems/themes/erpenterprise/indexnormal_menu_verlauf.jpg";
										}else{
											echo "images/indexnormal_menu_verlauf.jpg";
										}
										?>" style="cursor: pointer;" onclick="javascript:startmenuverwaltung_webseite();" onmouseover="rightclickactiv='1';" onmouseout="rightclickactiv='0';">
													<tr>
														<td width="5"></td>
														<td ><div style="font-size:12px;<?php 
													if($theme_design=='erpenterprise'){
														echo "color:white;";
													}
												?>"><?php echo $sprache['standard']['desktop_gruppe_webseite']; ?></div></td>
														<td>
															<div align="right">
															<img src="images/indexnormal_pfeil.png" alt="" height="10" width="10" border="0"></div>
														</td>
													</tr>
												</table>
											<?php 
											$ausgabe_webseitenmodule="";
											$ausgabe_webseitenmodule=menuausgabe(3); 
											?>
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr height="1">
												<td colspan="2" bgcolor="#cacaca" height="1"></td>
											</tr>
										</table>
										<table width="100%" border="0" cellspacing="0" cellpadding="2" height="30" background="<?php 
										if($theme_design=='erpenterprise'){
											echo "GeneratedItems/themes/erpenterprise/indexnormal_menu_verlauf.jpg";
										}else{
											echo "images/indexnormal_menu_verlauf.jpg";
										}
										?>" style="cursor: pointer;" onclick="javascript:startmenuverwaltung_webseitenmodule();" onmouseover="rightclickactiv='1';" onmouseout="rightclickactiv='0';">
											<tr>
												<td width="5"></td>
												<td ><div style="font-size:12px;<?php 
													if($theme_design=='erpenterprise'){
														echo "color:white;";
													}
												?>"><?php echo $sprache['standard']['desktop_gruppe_webseitenmodule']; ?></div></td>
												<td>
													<div align="right">
													<img src="images/indexnormal_pfeil.png" alt="" height="10" width="10" border="0"></div>
												</td>
											</tr>
										</table>
										<?php 
										$ausgabe_community="";
										$ausgabe_community=menuausgabe(6); 
										?>
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr height="1">
														<td colspan="2" bgcolor="#cacaca" height="1"></td>
													</tr>
												</table>
												<table width="100%" border="0" cellspacing="0" cellpadding="2" height="30" background="<?php 
										if($theme_design=='erpenterprise'){
											echo "GeneratedItems/themes/erpenterprise/indexnormal_menu_verlauf.jpg";
										}else{
											echo "images/indexnormal_menu_verlauf.jpg";
										}
										?>" style="cursor: pointer;" onclick="javascript:startmenuverwaltung_community();" onmouseover="rightclickactiv='1';" onmouseout="rightclickactiv='0';">
													<tr>
														<td width="5" ></td>
														<td ><div style="font-size:12px;<?php 
													if($theme_design=='erpenterprise'){
														echo "color:white;";
													}
												?>"><?php echo $sprache['standard']['desktop_gruppe_community']; ?></div></td>
														<td >
															<div align="right">
																<img src="images/indexnormal_pfeil.png" alt="" height="10" width="10" border="0"></div>
														</td>
													</tr>
												</table>

											<?php 
												$ausgabe_kunden='';
												$ausgabe_kunden=menuausgabe(5); 
											?>
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr height="1">
												<td colspan="2" bgcolor="#cacaca" height="1"></td>
											</tr>
										</table>
										<table width="100%" border="0" cellspacing="0" cellpadding="2" height="30" background="<?php 
										if($theme_design=='erpenterprise'){
											echo "GeneratedItems/themes/erpenterprise/indexnormal_menu_verlauf.jpg";
										}else{
											echo "images/indexnormal_menu_verlauf.jpg";
										}
										?>" style="cursor: pointer;" onclick="javascript:startmenuverwaltung_kunden();" onmouseover="rightclickactiv='1';" onmouseout="rightclickactiv='0';">
											<tr>
												<td width="5" ></td>
												<td ><div style="font-size:12px;<?php 
													if($theme_design=='erpenterprise'){
														echo "color:white;";
													}
												?>"><?php echo $sprache['standard']['desktop_gruppe_kunden']; ?></div></td>
												<td >
													<div align="right">
														<img src="images/indexnormal_pfeil.png" alt="" height="10" width="10" border="0"></div>
												</td>
											</tr>
										</table>
											<?php 
											$ausgabe_weboffice="";
											$ausgabe_weboffice=menuausgabe(4); 
											?>
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr height="1">
												<td colspan="2" bgcolor="#cacaca" height="1"></td>
											</tr>
										</table>
										<table width="100%" border="0" cellspacing="0" cellpadding="2" height="30" background="<?php 
										if($theme_design=='erpenterprise'){
											echo "GeneratedItems/themes/erpenterprise/indexnormal_menu_verlauf.jpg";
										}else{
											echo "images/indexnormal_menu_verlauf.jpg";
										}
										?>" style="cursor: pointer;" onclick="javascript:startmenuverwaltung_weboffice();" onmouseover="rightclickactiv='1';" onmouseout="rightclickactiv='0';">
											<tr>
												<td width="5" ></td>
												<td ><div style="font-size:12px;<?php 
													if($theme_design=='erpenterprise'){
														echo "color:white;";
													}
												?>"><?php echo $sprache['standard']['desktop_gruppe_weboffice']; ?></div></td>
												<td >
													<div align="right">
														<img src="images/indexnormal_pfeil.png" alt="" height="10" width="10" border="0"></div>
												</td>
											</tr>
										</table>

										</td>
				</tr>
				<tr height="2">
					<td bgcolor="#b3b3b3" height="2"></td>
				</tr>
				<tr height="27">
					<td valign="middle" bgcolor="#dfdfdf" height="27">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr onMouseOver="javascript:changemenuBG(this);rightclickactiv='1';" onMouseOut="javascript:changemenuBG(this);rightclickactiv='0';" style="cursor: pointer;" onclick="document.location='index.php?logout=1';">
								<td align="right"><strong><font color="#5a5a5a">Logout</font></strong></td>
								<td width="35" align="center"><img src="images/desktop_logout.png" alt="" height="24" width="24" border="0"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div id="shortinfo" class="<?php echo $shortinfo_class; ?>">
			<div id="shortinfo_min_max" onclick="document.getElementById('shortinfo').style.display = 'none';document.getElementById('shortinfo2').style.display = 'block';showshortinfo=false;"><img src="images/closelabel.png"></div>
			<div id="shortinfo_content"></div>
		</div>
		<div id="shortinfo2" class="<?php echo $shortinfo_class; ?>" align="center" onclick="document.getElementById('shortinfo2').style.display = 'none';document.getElementById('shortinfo').style.display = 'block';showshortinfo=true;"><img src="images/wiedervorlage_animation.gif"></div>
		<div id="shortsearch" class="<?php echo $shortinfo_class; ?>"></div>
		<div id="startmenu_allgemein" style="display: none">
			<table border="0" cellspacing="0" cellpadding="0" width="180">
				<?php 
				if($ausgabe_allgemein==""){
					$ausgabe_allgemein='<tr><td bgcolor=white height=24>'.$sprache['standard']['desktop_keinmodul'].'</td></tr>';
				};
				echo $ausgabe_allgemein; ?>
			</table>
		</div>
		<div id="startmenu_webseite" style="display: none">
			<table border="0" cellspacing="1" cellpadding="0" width="150" bgcolor="#d5d5d5">
				<tr>
					<td>
						<table border="0" cellspacing="0" cellpadding="1" width="100%">
							<?php 
							if($ausgabe_webseite==""){
								$ausgabe_webseite='<tr><td bgcolor=white height=24>'.$sprache['standard']['desktop_keinmodul'].'</td></tr>';
							};
							echo $ausgabe_webseite; ?>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div id="startmenu_webseitenmodule" style="display: none">
			<table border="0" cellspacing="1" cellpadding="0" width="150" bgcolor="#d5d5d5">
				<tr>
					<td>
						<table border="0" cellspacing="0" cellpadding="1" width="100%">
							<?php 
							if($ausgabe_webseitenmodule==""){
								$ausgabe_webseitenmodule='<tr><td bgcolor=white height=24>'.$sprache['standard']['desktop_keinmodul'].'</td></tr>';
							};
							echo $ausgabe_webseitenmodule; ?>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div id="startmenu_community" style="display: none">
			<table border="0" cellspacing="1" cellpadding="0" width="150" bgcolor="#d5d5d5">
				<tr>
					<td>
						<table border="0" cellspacing="0" cellpadding="1" width="100%">
							<?php 
							if($ausgabe_community==""){
								$ausgabe_community='<tr><td bgcolor=white height=24>'.$sprache['standard']['desktop_keinmodul'].'</td></tr>';
							}
							echo $ausgabe_community; ?>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div id="startmenu_kunden" style="display: none">
			<table border="0" cellspacing="1" cellpadding="0" width="150" bgcolor="#d5d5d5">
				<tr>
					<td>
						<table border="0" cellspacing="0" cellpadding="1" width="100%">
							<?php 
							if($ausgabe_kunden==""){
								$ausgabe_kunden='<tr><td bgcolor=white height=24>'.$sprache['standard']['desktop_keinmodul'].'</td></tr>';
							};
							echo $ausgabe_kunden; ?>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div id="startmenu_weboffice" style="display: none">
			<table border="0" cellspacing="1" cellpadding="0" width="150" bgcolor="#d5d5d5">
				<tr>
					<td>
						<table border="0" cellspacing="0" cellpadding="1" width="100%">
							<?php 
							if($ausgabe_weboffice==""){
								$ausgabe_weboffice='<tr><td bgcolor=white height=24>'.$sprache['standard']['desktop_keinmodul'].'</td></tr>';
							};
							echo $ausgabe_weboffice; ?>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<?php echo $GLOBALS['javascript']; ?>
		<script type="text/javascript">
			//LadaAjaxuhr
			loadData();
			<?php echo $js_icons; ?>
		</script>
		
	</body>

</html>
