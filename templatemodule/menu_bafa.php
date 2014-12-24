<?php 

	echo '
	<div>
		<h3>BAFA-F&ouml;rderung</h3>
		<ul>';

	$count		= 1;
	$freigabe 	= ($GLOBALS['kundennummer']>0) ? " (bereich.onlinefreigabe='1' OR bereich.onlinefreigabe='2') " : " bereich.onlinefreigabe='1' ";
	$sql 		= "SELECT bereich.*, bereiche.titel AS headline FROM bereich,bereiche WHERE bereich.bereich=bereiche.ID AND $freigabe AND bereich.bereich='{ID}' and bereich.papierkorb='0' and bereich.unterbereich='0' order by bereich.prio asc";
	$res 		= tri_db_query ("$datenbanknamecms", str_replace('{ID}', 11, $sql)) or die ("keine gültige DB Abfrage1".mysql_error());
	while ($row = mysql_fetch_assoc ($res))
	{
		
		$class	= ($GLOBALS['ID']==$row['ID']) ? "aktiv" : "";
		$url	= linkpfad_erweitert($row['ID'],$row['titel'],TRUE);
		echo 	 '<li class="'.$class.'"><a href="'.$url.'">'.$row['titel'].'</a></li>';
		
		
		$count++;
	} 

	echo '</ul>
		</div>';

?>