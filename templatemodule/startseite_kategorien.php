<?php 

	if (!isset($GLOBALS['warenkorb_produkt_kategorien_array']))
	{
		require_once('cmssystem/warenkorb/funktionen.php');
		$GLOBALS['warenkorb_produkt_kategorien_array'] = warenkorb_produkt_kategorien(0,'prio');
	} 

	$array = $GLOBALS['warenkorb_produkt_kategorien_array'];
	
	if(is_array($array) && count($array)>0)
	{
		$count 				= 1;
		$warenkorbbereich	= webseiten_modulvariablen_link("[warenkorb_artikelausgabe]",$GLOBALS['pageid']);
		
		$tmp				= templateeinlesen($template,"warenkorb_artikeluebersicht_unterkategorien_felder_feld_bild");
		
		/*'
		<div class="box artikel_listing">
			<img src="{bild_tump}" alt=""border="0" alt="{titel}" title="{titel}"/>
			<a href="{link}">{titel}</a>
		</div>';
		*/
		
		$ausgabe			= '
		<div class="artikel">
			{kategorien}
			<br class="clear">
		</div>';
		
		foreach ($array as $key => $value)
		{
			$cache.=$tmp;
			
			$titel 	= $value['titel'];//tri_sprache_ausgabe('produkte','kat',$key,$GLOBALS['page_land'],'titel',$value['titel']);
			$link	= linkpfad_erweitert($warenkorbbereich,warenkorb_produktekat_titel($key,TRUE,'/'),TRUE,'&warenkorb_kat='.$key);
			$cache 	= str_replace("{link}", $link, $cache);
			$cache 	= str_replace("{titel}", $titel, $cache);
			
			if(file_exists('cmssystem/produkte/bilder/kat_'.$key))
			{
				$cache			= str_replace('{bild_mid}','cmssystem/produkte/bilder/kat_'.$key.'-mid',$cache);
			}
			else
			{
				$cache			= str_replace('{bild_mid}','templates/'.$GLOBALS['template'].'/Labels/img_no_kat.png',$cache);
			};

			

			$count++;
		}
		
		$ausgabe = str_replace("{kategorien}", $cache, $ausgabe);
		
		echo $ausgabe;
	}
?>