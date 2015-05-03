<?php  

	require_once('cmssystem/warenkorb/class.warenkorb_engine.php');
	$warenkorbid 		= new warenkorb_engine(false, $GLOBALS['kundennummer'], false);
	$warenkorbid 		= $warenkorbid->getSession();
	
	$sqlArtikel 		= "SELECT * FROM `warenkorb_artikel` WHERE warenkorbid = '$warenkorbid';";
	$resArtikel 		= tri_db_query ($GLOBALS['datenbanknamecms'], $sqlArtikel);
	
	if(mysql_num_rows($resArtikel)>0)
	{
		echo '
			<script type="text/javascript">
   				document.location.href=\''.linkpfad_erweitert(19,false,TRUE,'&schritt=2').'\';
   			</script>';
	}
	
?>