<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 15:12:10 - Hashcode: 1092fdb53518078f953bc708b6af860d 
 ?><?php
include('cmssystem/templates/'.tri_sprachdatei_einlesen($GLOBALS['lang']));
if(dateityp($name,2)=="image"){
	if(file_exists("templates/$templatename/$ordnerauswahl/$name")){
				echo "<img src=\"templates/$templatename/$ordnerauswahl/$name\" border=0>";
	};
}else{
	echo fehlerausgabe($sprache['templates']['fehler_titel'],$sprache['templates']['nur_bilder']);
}
?> 
