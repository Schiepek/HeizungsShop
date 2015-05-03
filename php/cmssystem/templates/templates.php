<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 15:12:13 - Hashcode: 577a1be6516f74328f709275baf90df7 
 ?><?php
include("../../GeneratedItems/config.php");
$checkrecht="templates";
include("../rechtecheck.php");
include("../../GeneratedItems/debug.php");
include("../allgfunktionen.php");
include(tri_sprachdatei_einlesen($lang));
$reparieren=0;
?>
<html>
	<head>
		<script src="../allgfunktionen.js" type="text/javascript"></script>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<link rel="stylesheet" type="text/css" href="../GeneratedItems/style.CSS">
		<title><?php echo $sprache['templates']['titel']; ?></title>
	</head>
	<body bgcolor="#ffffff" leftmargin="0" marginheight="0" marginwidth="0" topmargin="0">
		<div align="center">
			<table width="100%" border="0" cellspacing="2" cellpadding="0" bgcolor="#cccccc" background="../images/verlauf_oben_rund.gif">
				<tr>
					<td><font style="font-size:14px;" color="white"><strong><?php echo $sprache['templates']['templates_bearbeiten']; ?></strong></font></td>
					<td>
						<div align="right">
						</div>
					</td>
				</tr>
			</table>
			<br><?php 
if($filesave==1){
	if($ordnerauswahl==null){
		$dateipfad="../../templates/$template/$datei";
	}else{
		$dateipfad="../../templates/$template/$ordnerauswahl$datei";
	};
	$dateiinhalt=str_replace('\"','"',$dateiinhalt);
	$dateiinhalt=str_replace("\'","'",$dateiinhalt);
	if (is_writable($dateipfad)) {
		if(is_writable($dateipfad)==FALSE and file_exists($dateipfad)==TRUE){
				chmod($dateipfad, 0777);
		};
	   if (!$handle = fopen($dateipfad, "w")) {
	         echo str_replace('%dateipfad%',$dateipfad,$sprache['templates']['kann_datei_nicht_oeffnen']);
	   }elseif (!fwrite($handle, $dateiinhalt)) {
	          echo str_replace('%dateipfad%',$dateipfad,$sprache['templates']['kann_datei_nicht_schreiben']);
	   }else{
	  	 	print "<b>".$sprache['templates']['templates_wurde_bearbeitet']."</b>";
	   };
	   fclose($handle);
	
	}else{
	   echo str_replace('%dateipfad%',$dateipfad,$sprache['templates']['kann_datei_nicht_schreiben']);
	}
};	
		?>
			<form id="FormName" action="templates.php" method="get" name="FormName">
				<table width="95%" border="0" cellspacing="1" cellpadding="2" bgcolor="#a3a3a3">
					<tr>
						<td bgcolor="white" background="../images/einstellungen_hintergrund.gif">
							<div align="center">
								<table width="100%" border="0" cellspacing="0" cellpadding="2">
									<tr>
										<td valign="top" width="49">
											<div align="center">
												<img src="../images/img_suchen.gif" alt="" height="32" width="32" border="0"></div>
										</td>
										<td>
											<div align="center">
												<table width="474" border="0" cellspacing="2" cellpadding="0">
													<tr>
														<td><strong><?php echo $sprache['templates']['feld_ordner']; ?>:</strong></td>
														<td>
															<select name="template" <?php echo js_formularfeld_fade(); ?> size="1" class="feld">
																<?												
																	if(isset($template)==TRUE)
																	{
																		trieinstellungsetzen("templates",$edit,"ordnerauswahl",$template);	
																	}
																	else
																	{
																		$template=trieinstellungauslesen("templates",$edit,"ordnerauswahl");
																	};		
																	$pfad="../../templates/";
																	echo standard_template_auswahl($pfad,$template); 
																?>
															</select>
														</td>
														<td valign="top" width="140">
															<div align="right">
																<input class="Buttonanzeigen" type="submit" name="submitButtonName" value="<?php echo $sprache['templates']['button_anzeigen']; ?>"<?php echo js_formularbutton_fade(); ?>></div>
														</td>
													</tr>
												</table>
											</div>
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
				</table>
			</form>
			<?php if($template==null){echo fehlerausgabe($sprache['templates']['fehler_titel'],$sprache['templates']['fehler_hinweis']);}else{ ?>
			<form Id="formname2" action="templates.php" method="post" name="FormName2">
				<table width="95%" border="0" cellspacing="0" cellpadding="2">
						<tr>
						<td><strong><?php 
					if($ordnerauswahl==null){
						echo "templates/$template/";
					}else{
						echo "templates/$template/$ordnerauswahl";
					};
					
					?></strong>
					</td></tr>
					<tr>
						<td>
							<div align="center">
								<table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#a1a1a1">
									<tr>
										<?php if($reparieren==1){ ?>
										<td bgcolor="#d1d1d1" width="30" background="../images/verlauf_oben_rund2.gif"><?php echo helpdesk($sprache['templates']['helpdesk_titel_checkbox'],$sprache['templates']['helpdesk_checkbox']); ?></td>
										<?php }; ?>
										<td bgcolor="#d1d1d1" background="../images/verlauf_oben_rund2.gif"><strong><font color="white"><?php echo $sprache['templates']['feld_dateiname']; ?> </font></strong></td>
										<td bgcolor="#d1d1d1" width="200" background="../images/verlauf_oben_rund2.gif"><strong><font color="white"><?php echo $sprache['templates']['feld_dateityp']; ?> </font></strong></td>
										<td bgcolor="#d1d1d1" width="75" background="../images/verlauf_oben_rund2.gif"><strong><font color="white"><?php echo $sprache['templates']['feld_groeße']; ?> </font></strong></td>
										<td bgcolor="#d1d1d1" width="125" background="../images/verlauf_oben_rund2.gif"><strong><font color="white"><?php echo $sprache['templates']['feld_aenderung']; ?> </font></strong></td>
									</tr>
									<?php 
			
						$color1="white";
						$color2="#dedede";
						$color=1;	
						
					if($ordnerauswahl==null){
						$pfad="../../templates/$template/";
					}else{
						$pfad="../../templates/$template/$ordnerauswahl";
					};
					$ordnercount=0;
					$dateicount=0;
					$verz=opendir ($pfad);
					while ($file=readdir($verz))
					{
						if($file<>"." and $file<>".."){
							if(filetype($pfad.$file)=="dir"){
								$ordner[$ordnercount]=$file;
								$ordnercount++;
							}else{
								$dateien[$dateicount]=$file;
								$dateicount++;
							};
						};
					}
				closedir($verz);
				
				$count=0;
				$gesamt=0;
				while($count<$dateicount){
								
						$count_gesamt=filesize($pfad.$dateien[$count]);
						$gesamt=$gesamt+$count_gesamt;
						$count++;
				};
				if($ordnerauswahl<>null){
					echo"<tr bgcolor=\"${"color".$color}\" ".js_zeile_fade()." ondblclick=\"javascript:document.location='templates.php?template=$template'\">";
							if($reparieren==1){
							echo "<td></td>";
							}
							echo"<td><a href=\"templates.php?template=$template\">".dateitypicon("ordner",1)." 
							".$sprache['templates']['hauptverzeichnis']."
							</a></td>
							<td>".dateitypicon("ordner",2)."</td>
							<td>".dateigroesse($gesamt)."</td>
							<td></td>
						</tr>";	
					if($color==1){$color=2;}else{$color=1;};
				};
				
				if($ordnercount<>0){
					sort($ordner);
					$count=0;
					while($count<$ordnercount){
						echo"<tr bgcolor=\"${"color".$color}\" ".js_zeile_fade()." ondblclick=\"javascript:document.location='templates.php?template=$template&ordnerauswahl=$ordnerauswahl$ordner[$count]/'\">";
							if($reparieren==1){
							echo "<td></td>";
							}
							echo"
							<td><a href=\"templates.php?template=$template&ordnerauswahl=$ordnerauswahl$ordner[$count]/\"><img src=\"../images/icon_ordner.gif\" height=16 border=0> $ordner[$count]</a></td>
							<td>".dateitypicon("ordner",2)."</td>
							<td>".dateigroesse($gesamt)."</td>
							<td></td>
						</tr>";	
						if($color==1){$color=2;}else{$color=1;};
						$count++;		
					};
				};
				
				if($dateicount<>0){
					sort ($dateien);
					$count=0;
					while($count<$dateicount){
							echo"<tr bgcolor=\"${"color".$color}\" ".js_zeile_fade()." ";
							if(dateitypicon(substr($dateien[$count],-3,3),3)==TRUE){
								echo "ondblclick=\"javascript:document.location='templates-dateiedit.php?template=$template&datei=$dateien[$count]&ordnerauswahl=$ordnerauswahl'\">";
							}else{
								echo ">";
							}
							if($reparieren==1){
							echo "<td><input type=\"checkbox\" name=\"".str_replace(".","-",$dateien[$count])."\" value=\"1\"></td>";
							}
							echo"<td>";
							if(dateitypicon(substr($dateien[$count],-3,3),3)==TRUE){
								echo "<a href=\"templates-dateiedit.php?template=$template&datei=$dateien[$count]&ordnerauswahl=$ordnerauswahl\"><font color=#484848>";
							}elseif(dateityp($dateien[$count],2)=="image"){
								echo "<a href=\"/modul.php?modul=templates&modulkat=fileopen&name=$dateien[$count]&templatename=$template&ordnerauswahl=$ordnerauswahl\" target=_blank>";
							}
							echo "<img src=\"../images/icon_".dateityp($dateien[$count],2).".gif\" height=16 border=0> $dateien[$count]</a></td>
							<td>".dateityp($dateien[$count],1)."</td>
							<td>".dateigroesse(filesize($pfad.$dateien[$count]))."</td>
							<td>".date("Y-m-d - H:s",fileatime($pfad.$dateien[$count]))."</td>
						</tr>";	
						if($color==1){$color=2;}else{$color=1;};
						$marker.="document.form2.".str_replace(".","-",$dateien[$count]).".checked=%typ%; \n";	
						$count++;	
					};
				};
			?>
			</form>
			<?php if(1==2){ ?></div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td><img src="../images/pfeil.jpg" alt="" height="30" width="30" border="0"><select name="aktion" size="1" class=feld>
														<?php
										
												  $pfad="../../templates/";
												  $verz=opendir ($pfad);
												  while ($file=readdir($verz))
												  {
												        if(filetype($pfad.$file)=="dir" and $file<>"." and $file<>".."){
												       		if($template<>$file){
													       		echo "<option value=\"copytemp-$file\"";
																echo ">
																 ".$sprache['templates']['kopieren_nach']."
																 $file</option>";
															
															};
												       	};
												  }
												  closedir($verz);

											?>
													</select><input type="submit" name="submit" value="<?php echo $sprache['templates']['ausfuehren']; ?>" class=button><input type="hidden" name="nachrichtenauswahl" value="<?php echo $nachrichtenauswahl; ?>"><input type="hidden" name="aktionvorhanden" value="1"><br>
												</td>
												<td>
													<div align="right">
														<?php if("MUH"=="KUH") { ?>
														<script language="JavaScript" type="text/javascript">
function markierealle() {
<?php echo str_replace("%typ%","true",$marker); ?>
}
function demarkierealle() {
<?php echo str_replace("%typ%","false",$marker); ?>
}
</script>
														<a href="javascript:markierealle()"><?php echo $sprache['templates']['alle_waehlen']; ?></a> / <a href="javascript:demarkierealle()"><?php echo $sprache['templates']['entwaehlen']; ?></a><?php }; ?></div>
												</td>
											</tr>
										</table>
		<?php }; ?>
		<?php } ;?>
	</body>
</html>