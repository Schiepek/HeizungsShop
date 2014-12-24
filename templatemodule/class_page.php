<?php 
	
	if($GLOBALS['warenkorb_produktid']>0 || $GLOBALS['warenkorb_kat'])
	{
	}
	else
	{
		$bereich_blacklist = array(webseiten_modulvariablen_link("[warenkorb]",$GLOBALS['pageid']),2,webseiten_modulvariablen_link("[warenkorb_artikelausgabe",$GLOBALS['pageid']));
			
		if (in_array($GLOBALS['ID'], $bereich_blacklist)==false)
		{
			echo "box boxPage";
		}
	}
	
?>