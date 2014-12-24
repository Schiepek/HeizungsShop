<?php 
	
	//Extension für die Detailansicht eines Artikels im Warenkorb
	//$ausgabe	= str_replace('{lieferzeit}',produkte_datenfelder($row['ID'],76),$ausgabe);
	
	$feldanzahl		= new template_uebersetzen($ausgabe,$GLOBALS['template'],"{aktiv_");
	$gesamtfelder 	= $feldanzahl->feldanzahl();
	
	$GLOBALS['tab_aktiv'] = ((int) $GLOBALS['tab_aktiv']>0) ? $GLOBALS['tab_aktiv'] : 1;
	
	for($i=1;$i<=$gesamtfelder;$i++)
	{
		$ausgabe	= ($i==$GLOBALS['tab_aktiv']) ? str_replace('{aktiv_'.$i.'}',' class="aktiv box"',$ausgabe) : str_replace('{aktiv_'.$i.'}',' class="box"',$ausgabe);	
	}
	
	
?>