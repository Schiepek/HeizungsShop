<?php 

	if($GLOBALS['warenkorb_produktid']>0)
	{
		$kategorie		= '';
		$sql 			= "SELECT titel from produkte_kat_zuordnung,produkte_kat where produkte_kat.ID=produkte_kat_zuordnung.kategorie AND produktid='".$GLOBALS['warenkorb_produktid']."' order by produkte_kat_zuordnung.prio asc limit 1";
		$res 			= tri_db_query($GLOBALS['datenbanknamecms'], $sql) or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
		if(mysql_num_rows($res)>0)
		{
			$row 		= mysql_fetch_array ($res);
			$titel 		= $row['titel'];//warenkorb_produktekat_titel($row['kategorie'],'');
			$kategorie	= '<a href="'.linkpfad_erweitert($GLOBALS['ID'],$titel,TRUE,'&warenkorb_kat='.$row['ID']).'" title="'.$titel.'" class="cms_page">'.$titel.'</a><span> / </span>';
		}
		
		echo '
		<div class="breadcrumbs">
    		<a href="/" title="Zur Startseite" class="home">Startseite</a><span> / </span>
			'.$kategorie.'
			<strong>'.produkte_datenfelder($GLOBALS['warenkorb_produktid'],'namensfeld').'</strong>
		</div>';
	}
	elseif($GLOBALS['warenkorb_kat']>0)
	{
		$titel = warenkorb_produktekat_titel($GLOBALS['warenkorb_kat'],'&nbsp;/&nbsp;');
		
		echo '
		<div class="breadcrumbs">
			<a href="/" title="Zur Startseite" class="home">Startseite</a><span> / </span>
			<strong>'.$titel.'</strong>
		</div>';
	}
	elseif($GLOBALS['suche']==1)
	{
		echo '
		<div class="breadcrumbs">
			<a href="/" title="Zur Startseite" class="home">Startseite</a><span> / </span>
			<strong>Suchergebnisse für: '.$GLOBALS['warenkorb_suche'].'</strong>
		</div>';
	}
	elseif($GLOBALS['ID']!=847)
	{
		echo '
		<div class="breadcrumbs">
			<a href="/" title="Zur Startseite" class="home">Startseite</a><span> / </span>
			<strong class="cms_page">'.$GLOBALS['pagetitel'].'</strong>
		</div>';
	}


?>
