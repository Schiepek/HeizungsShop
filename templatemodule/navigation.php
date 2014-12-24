<?php 

	$mzID		= webseiten_modulvariablen_link("[warenkorb_merkliste]",$GLOBALS['pageid']);
	$wkID		= webseiten_modulvariablen_link("[warenkorb_artikelausgabe]",$GLOBALS['pageid']);

	$freigabe 	= ($GLOBALS['kundennummer']>0) ? " (bereich.onlinefreigabe='1' OR bereich.onlinefreigabe='2') " : " bereich.onlinefreigabe='1' ";
	$sql 		= "SELECT bereich.* FROM bereich where $freigabe and bereich.bereich='2' and bereich.papierkorb='0' and bereich.unterbereich='0' order by bereich.prio asc";
	$res 		= tri_db_query ("$datenbanknamecms", $sql) or die ("keine gutige DB Abfrage1".mysql_error());
	while ($row = mysql_fetch_assoc ($res))
	{
		if($GLOBALS['kundennummer']>0 && $row['titel']=="Registrierung")
		{
		
		}
		else
		{
			$headline	= $row['headline'];
			if($GLOBALS['kundennummer']>0 && $row['titel']=="Login")
			{
				$row['titel'] 	= "Logout";
				$url			= "/index.php?tri_logout=1";
			}
			else
			{
				$url	= linkpfad_erweitert($row['ID'],$row['titel'],TRUE);
			}
			if($row['ID']==$mzID)
			{
				$sessionid		= tri_session_ermitteln();
				$sessionwerte	= tri_session_auslesen($sessionid);
				$daten			= json_decode($sessionwerte['warenkorb_merkliste'], true);
				$zusatz			= ' ('.count($daten).')'; 
			}
			else
			{
				$zusatz = "";
			}
			$ukataktiv 	= false;
			if($row['ID']==$wkID)
			{
				$submenu 	= "k";
				$ausgabe2	= "";
				if (!isset($GLOBALS['warenkorb_produkt_kategorien_array']))
				{
					require_once('cmssystem/warenkorb/funktionen.php');
					$GLOBALS['warenkorb_produkt_kategorien_array'] = warenkorb_produkt_kategorien(0,'prio');
				} 
				
				if(is_array($GLOBALS['warenkorb_produkt_kategorien_array']) && count($GLOBALS['warenkorb_produkt_kategorien_array'])>0)
				{
					$ausgabe2		= '<ul class="level0 box">';
						
					foreach ($GLOBALS['warenkorb_produkt_kategorien_array'] as $key => $value)
					{
						$class2	= ($GLOBALS['warenkorb_kat']==$key) ? "aktiv" : "";
						if($GLOBALS['warenkorb_kat']==$key)
						{
							$ukataktiv = true;
						}
						$url2	= linkpfad_erweitert($wkID,$value['titel'],TRUE,'&warenkorb_kat='.$key);
						$ausgabe2.='
						<li onmouseover="toggleMenu(this,1)" onmouseout="toggleMenu(this,0)" class="level1 nav-'.$submenu.'-'.$row['ID'].'-'.$key.' '.$class2.' parent">
							<a href="'.$url2.'">'.$value['titel'].'</a>
						</li>';
					} 
					$ausgabe2.="</ul>";
				}
				else
				{
					$ausgabe2		= "";
				}
			}
			else
			{
				$submenu 	= "b";
				$ausgabe2	= "";
				
				if($row['ID']==871)
				{
					$sql2 		= "SELECT bereich.* FROM bereich where $freigabe and bereich.papierkorb='0' AND bereich='122' AND unterbereich='0' order by bereich.prio asc";
				}
				else
				{
					$sql2 		= "SELECT bereich.* FROM bereich where $freigabe and bereich.papierkorb='0' AND unterbereich='".$row['ID']."' order by bereich.prio asc";
				}
				
				$res2 		= tri_db_query ("$datenbanknamecms", $sql2) or die ("keine gultige DB Abfrage1".mysql_error());
				if(mysql_num_rows($res2)>0)
				{
					$ausgabe2		= '<ul class="level0 box">';
					while ($row2 	= mysql_fetch_assoc ($res2))
					{
						$class2	= ($GLOBALS['ID']==$row2['ID']) ? "active" : "";
						if($GLOBALS['ID']==$row2['ID'])
						{
							$ukataktiv = true;
						}
						$url2	= linkpfad_erweitert($row2['ID'],$row2['titel'],TRUE);
						
						$ausgabe2.='
						<li onmouseover="toggleMenu(this,1)" onmouseout="toggleMenu(this,0)" class="level1 nav-'.$submenu.'-'.$row['ID'].'-'.$row2['ID'].' '.$class2.' parent">
							<a href="'.$url2.'">'.$row2['titel'].'</a>
						</li>';
					}
					$ausgabe2.="</ul>";
				}
				else
				{
					$ausgabe2		= "";
				}
			}
			$class	= ($GLOBALS['ID']==$row['ID'] || $ukataktiv==true) ? "active" : "";
			$ausgabe.='<li onmouseover="toggleMenu(this,1)" onmouseout="toggleMenu(this,0)" class="level0 nav-'.$submenu.'-'.$row['ID'].' '.$class.' parent"><a href="'.$url.'">'.$row['titel'].'</a>'.$ausgabe2.'</li>';
		}
	} 
	echo $ausgabe; 
?>