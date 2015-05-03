<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 15:12:14 - Hashcode: 4123aa6d93ff3b73c8b8b891799e79c0 
 ?><?php 
function templates_papierkorb_inhalt($order){
	include('../templates/'.tri_sprachdatei_einlesen($GLOBALS['lang']));
	if(prueferecht('templates_module',$GLOBALS['edit'])==1){	
		$res = tri_db_query ($GLOBALS['datenbanknamecms'], "SELECT ID,modulname,edit,datum,papierkorb,papierkorb_edit,papierkorb_datum FROM tri_templatemodules where papierkorb='1'");
		while ($row = mysql_fetch_array ($res))
		{
			$GLOBALS['papierkorb']['templates']['templates'][$row['ID']]['titel']=$row['modulname'];
			$GLOBALS['papierkorb']['templates']['templates'][$row['ID']]['erstellt_datum']=$row['datum'];
			$GLOBALS['papierkorb']['templates']['templates'][$row['ID']]['erstellt_edit']=$row['edit'];
			$GLOBALS['papierkorb']['templates']['templates'][$row['ID']]['geloescht_datum']=$row['papierkorb_datum'];
			$GLOBALS['papierkorb']['templates']['templates'][$row['ID']]['geloescht_edit']=$row['papierkorb_edit'];
			$GLOBALS['papierkorb']['templates']['templates'][$row['ID']]['typ']=$sprache['templates']['templatemodul'];
		};
	};	
};

function templates_papierkorb_bearbeiten($tabelle,$ID,$typ){
	if(prueferecht('templates_module',$GLOBALS['edit'])==1){
			if($typ==1){
				papierkorb_wiederherstellen('templates','tri_templatemodules',$ID,'modulname');
			}elseif($typ==2){
				text_backup_loeschen('templates','tri_templatemodules','templatecode',$ID);
				papierkorb_loeschen('templates','tri_templatemodules',$ID,'modulname');
		};
	};
};

?>