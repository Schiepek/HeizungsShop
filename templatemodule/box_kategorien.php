<?php  

	require_once('cmssystem/warenkorb/funktionen.php');
	require_once('cmssystem/warenkorb/modulloading_funktionen.php');

	
		$warenkorbbereich=webseiten_modulvariablen_link("[warenkorb_artikelausgabe]",$GLOBALS['pageid']);
		
		if ($GLOBALS['suche']==1)
		{
			$GLOBALS['warenkorb_kat']=0;
		}
		if (!isset($GLOBALS['warenkorb_produkt_kategorien_array']))
		{
			require_once('cmssystem/warenkorb/funktionen.php');
			$GLOBALS['warenkorb_produkt_kategorien_array'] = warenkorb_produkt_kategorien(0,'prio');
		} 
		$GLOBALS['ebene_prefix'][1]="";
		$GLOBALS['ebene_prefix'][2]="&raquo; ";
		$GLOBALS['ebene_prefix'][3]="&raquo; ";
		
		if (is_numeric($GLOBALS['warenkorb_produktid']))
		{
			$res	= tri_db_query ($GLOBALS['datenbanknamecms'], "SELECT kategorie FROM produkte_kat_zuordnung where produktid='$GLOBALS[warenkorb_produktid]' $zusatz") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
			$row	= mysql_fetch_array($res);
			$GLOBALS['warenkorb_kat']=$row['kategorie'];
		}
		function warenkorb_ukat_ativ($ID,$key)
		{
			$GLOBALS['aktiv_array'] = array();
			select_kat($ID);
			
			if (in_array($key, $GLOBALS['aktiv_array']))
			{
				return true;
			} 
			else 
			{
				return false;
			}
		}
		function select_kat($ID)
		{
			$res	= tri_db_query ($GLOBALS['datenbanknamecms'], "SELECT ukat FROM produkte_kat where oeffentlich='1' and ID='$ID'") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
			$row	= mysql_fetch_array($res);
			if ($row['ukat']>0)
			{
				array_push($GLOBALS['aktiv_array'], $row['ukat']);
				select_kat($row['ukat']);
			}
		}
		function warenkorb_kategorie_listing_left($array,$ebene,$warenkorbbereich)
		{
			$cache = "";
			if(is_array($array) && count($array)>0)
			{
				foreach ($array as $key => $value)
				{
					$aktiv = warenkorb_ukat_ativ($GLOBALS['warenkorb_kat'],$key);
					$titel = $value['titel'];//tri_sprache_ausgabe('produkte','kat',$key,$GLOBALS['page_land'],'titel',$value['titel']);
					
					$GLOBALS['parent'] = ($ebene==1) ? $key : $GLOBALS['parent'];
					
					if ($GLOBALS['warenkorb_kat']==$key || $aktiv==true)
					{ 
						$class	= "";
						$class2 = "ebene".$ebene."_aktiv ebene".$ebene."";
						$class2 = ($ebene!=1) ? $class2." parent".$GLOBALS['parent'] : $class2;
					}
					else 
					{
						$class	= "";
						$class2	="ebene".$ebene." inaktiv";
						$class2 = ($ebene!=1) ? $class2." parent".$GLOBALS['parent'] : $class2;
					}
					$url=linkpfad_erweitert($warenkorbbereich,warenkorb_produktekat_titel($key,TRUE,'/'),TRUE,'&warenkorb_kat='.$key);
					
				$ausgabe.=	'
					<tr>
						<td class="'.$class2.'" parent="'.$GLOBALS['parent'].'"><a href="'.$url.'" class="'.$class.'">'.$GLOBALS['ebene_prefix'][$ebene].$titel.'</a></td>
					</tr>';
			
					
					if($GLOBALS['warenkorb_kat']==$key || $aktiv==true)
					{ 
						if (is_array($value['kategorien']))
						{
							$cache=warenkorb_kategorie_listing_left($value['kategorien'],$ebene+1,$warenkorbbereich);
							$ausgabe.= $cache;
						} 
					}
				}
			}
			return $ausgabe;
		}
		echo  '
		<div class="box boxColumn">
			<h3>Produkte</h3>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" id="navigation_produkte">
			'.warenkorb_kategorie_listing_left($GLOBALS['warenkorb_produkt_kategorien_array'],1,$warenkorbbereich).'	
			</table>
		</div>';
	
	
		
?>