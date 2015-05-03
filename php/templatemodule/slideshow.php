<?php 

	$ausgabe='
	<div id="slidesshow_startseite" class="slides">
		<div class="slides_container">
			{bilderserien}
		</div>
		<a class="next" href="#">&raquo;</a>
		<a class="prev" href="#">&laquo;</a>
	</div>
	<br class="clear">';

	$count=1;
	$res_img = mysql_db_query ($GLOBALS['datenbanknamecms'], "SELECT * FROM gallerypics where galleryid='1' and papierkorb='0' and prio>0 order by prio") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
	while ($row_img = mysql_fetch_array ($res_img))	
	{
		$link_target = ($row_img['link_target']==1) ? '_blank' : '_self';
	
		$images.='
			<div>
				<a href="'.$row_img['link'].'" target="'.$link_target.'"><img src="/modul.php?modul=bilderserie&modulkat=bild&ID='.$row_img['ID'].'&tump=0" alt="'.$row_img['titel'].'" title="'.$row_img['titel'].'"  border="0"/></a>
			</div>';
		$count++;
	}
	
	$ausgabe = str_replace('{bilderserien}', $images, $ausgabe);
	
	echo $ausgabe;
?>
