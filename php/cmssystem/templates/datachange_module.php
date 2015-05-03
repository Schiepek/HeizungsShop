<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 15:12:17 - Hashcode: 783cf52cd89c73609b01e667bd4c1cac 
 ?><?php
include("../../GeneratedItems/config.php");
$checkrecht="templates_module";
include("../rechtecheck.php");
include("../../GeneratedItems/debug.php");
include("../allgfunktionen.php");
include(tri_sprachdatei_einlesen($lang));
?>
<html>
	<head>
		<script src="../allgfunktionen.js" type="text/javascript"></script>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<link rel="stylesheet" type="text/css" href="../GeneratedItems/style.CSS">
		<title><?php echo $sprache['templates']['module']; ?></title>
	</head>
<?php
if(isset($selektionsuche)==TRUE){
	trieinstellungsetzen("templates",$edit,"sortierauswahl",$auswahl);	
	trieinstellungsetzen("templates",$edit,"sortierrichtung",$order);	
}else{
	$auswahl=trieinstellungauslesen("templates",$edit,"sortierauswahl");
	$order=trieinstellungauslesen("templates",$edit,"sortierrichtung");
};
			 	
if($auswahl_loeschen=='loeschen'){
	$res = tri_db_query ($datenbanknamecms, "SELECT ID FROM tri_templatemodules");
	while ($row = mysql_fetch_array ($res))
	{			
		if(${"feld".$row["ID"]}==$row["ID"]){
			papierkorb_verschieben('templates','tri_templatemodules',$row['ID'],'modulname');
		};
	};
}

if($speichern==1){
	$res = tri_db_query ($datenbanknamecms, "SELECT * FROM tri_templatemodules where modulname='$modulname'");
	if(mysql_num_rows($res)>=1)
	{
		echo hinweisausgabe($sprache['templates']['fehler_titel'],$sprache['templates']['fehler_ausgabe']);
		die(); 
	}else{
		$eintragen = tri_db_query($datenbanknamecms, "INSERT INTO tri_templatemodules (modulname, edit, datum) VALUES ('$modulname','$edit','$datum')");
		logfile('templates','tri_templatemodules',mysql_insert_id(),'modulname',1);
	};
}
?>
	<body bgcolor="#ffffff" leftmargin="0" marginheight="0" marginwidth="0" topmargin="0">
		<div align="center">
			<table width="100%" border="0" cellspacing="2" cellpadding="0" bgcolor="#cccccc" background="../images/verlauf_oben_rund.gif">
				<tr>
					<td><font style="font-size:14px;" color="white"><strong><?php echo $sprache['templates']['module']; ?> </strong></font></td>
					<td>
						<div align="right">
						</div>
					</td>
				</tr>
			</table>
			<br>
			<form id="FormName" action="datachange_module.php" method="post" name="FormName">
				<div align="center">
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
															<td><?php echo $sprache['templates']['sort']; ?>:</td>
															<td><select class="Feld" name="auswahl" size="1" <?php echo js_formularfeld_fade(); ?>>
																	<option <?php if($auswahl=="alle"){ echo "selected"; }; ?> value="alle"><?php echo $sprache['templates']['alle']; ?></option>
																	<option <?php if($auswahl=="modulname"){ echo "selected"; }; ?> value="modulname"><?php echo $sprache['templates']['modul_name']; ?></option>
																	<option <?php if($auswahl=="kategorie"){ echo "selected"; }; ?> value="kategorie"><?php echo $sprache['templates']['menue']; ?></option>
																	<option <?php if($auswahl=="beschreibung"){ echo "selected"; }; ?> value="beschreibung"><?php echo $sprache['templates']['beschreibung']; ?></option>
																	<option <?php if($auswahl=="autor"){ echo "selected"; }; ?> value="autor"><?php echo $sprache['templates']['autor']; ?></option>
																</select></td>
															<td rowspan="2" valign="top" width="140">
																<div align="right">
																	<input class="Buttonanzeigen" type="submit" name="submitButtonName" value="<?php echo $sprache['templates']['button_anzeigen']; ?>" <?php echo js_formularbutton_fade(); ?>><input type="hidden" name="selektionsuche" value="1"></div>
															</td>
														</tr>
														<tr>
															<td><?php echo $sprache['templates']['richtung']; ?>:</td>
															<td><select class="Feld" name="order" size="1" <?php echo js_formularfeld_fade(); ?>>
																	<option value="asc" <?php if($order=="asc"){echo 'selected';}; ?>><?php echo $sprache['templates']['asc']; ?></option>
																	<option value="desc" <?php if($order=="desc"){echo 'selected';}; ?>><?php echo $sprache['templates']['desc']; ?></option>
																</select></td>
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
				</div>
			</form>
			<form id="formname2" action="datachange_module.php" method="post" name="FormName2">
				<table width="95%" border="0" cellspacing="0" cellpadding="2">
					<tr>
						<td>
							<div align="left">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
										<td>
											<div align="right">
												<table width="100%" border="0" cellspacing="0" cellpadding="0" height="30">
													<tr>
														<td>
															<div align="right">
																<a href="zeigedaten_module.php?eintragen=1"><img src="../images/plus.jpg" alt="" height="20" width="20" border="0"></a></div>
														</td>
													</tr>
												</table>
											</div>
										</td>
									</tr>
									</table>
								<table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#a1a1a1">
									<tr>
										<td bgcolor="#d1d1d1" width="30" background="../images/verlauf_oben_rund2.gif"><?php echo helpdesk($sprache['templates']['helpdesk_titel_checkbox'],$sprache['templates']['helpdesk_checkbox']); ?></td>
										<td bgcolor="#d1d1d1" width="30" background="../images/verlauf_oben_rund2.gif"><b><font color="white"><strong><?php echo $sprache['templates']['ID']; ?></strong></font></b></td>
										<td bgcolor="#d1d1d1" background="../images/verlauf_oben_rund2.gif"><b><font color="white"><strong><?php echo $sprache['templates']['modul_name']; ?></strong></font></b></td>
										<td bgcolor="#d1d1d1" width="100" background="../images/verlauf_oben_rund2.gif"><b><font color="white"><strong><?php echo $sprache['templates']['menue']; ?></strong></font></b></td>
										<td bgcolor="#d1d1d1" width="150" background="../images/verlauf_oben_rund2.gif"><font color="white"><strong><?php echo $sprache['templates']['beschreibung']; ?></strong></font></td>
										<td bgcolor="#d1d1d1" width="100" background="../images/verlauf_oben_rund2.gif"><b><font color="white"><strong><?php echo $sprache['templates']['autor']; ?></strong></font></b></td>
										<td bgcolor="#d1d1d1" width="45" background="../images/verlauf_oben_rund2.gif"></td>
									</tr>
									<?php

	if($auswahl=="modulname"){
		$sql="select * from tri_templatemodules where papierkorb = '0' order by modulname ";
	}elseif($auswahl=="kategorie"){
		$sql="select * from tri_templatemodules where papierkorb = '0' order by kategorie ";
	}elseif($auswahl=="beschreibung"){
		$sql="select * from tri_templatemodules where papierkorb = '0' order by beschreibung ";
	}elseif($auswahl=="autor"){
		$sql="select * from tri_templatemodules where papierkorb = '0' order by edit ";
	}else{
		$sql="SELECT * FROM tri_templatemodules where papierkorb='0' order by ID ";
	};
	
	if($order=='desc'){
		$sql.=" desc";
	}else{
		$sql.=" asc";
	};
$vorhanden=0;
$color1="white";
$color2="#dedede";
$color=1;	

$sql2.=seitenumschaltung($sql,'datachange.php',2);

$res = tri_db_query ($datenbanknamecms, $sql2);
while ($row = mysql_fetch_array ($res))
{									
									
	$vorhanden=1;
	$onclick=js_zeile_onclick('formname2','feld'.$row['ID'],$row['ID']);
	echo "<tr bgcolor=\"${"color".$color}\" id=\"zeile$row[ID]\" ".js_zeile_fade()." ondblclick=\"javascript:document.location='zeigedaten_module.php?ID=$row[ID]'\">
		<td valign=\"top\"><input type=\"checkbox\" name=\"feld$row[ID]\" value=\"$row[ID]\" ></td>
			
				<td valign=\"top\" $onclick>$row[ID]</td>
				<td valign=\"top\" $onclick>$row[modulname]</td>
				<td valign=\"top\" $onclick>$row[kategorie]</td>
				<td valign=\"top\" $onclick>$row[beschreibung]</td>
				<td valign=\"top\" $onclick>$row[edit]</td>
				<td valign=\"top\" $onclick>
					<div align=\"right\"><a href=\"zeigedaten_module.php?ID=$row[ID]\">".$sprache['templates']['details']."</a></div>
				</td>
			
					
		</tr>";
	if($color==1){
		$color=2;
	}else{
		$color=1;
	};
	$marker.="document.FormName2.feld$row[ID].checked=%typ%;document.getElementById('zeile$row[ID]').style.backgroundColor='%color%';";
};
	
if($vorhanden==0){
	$bild="<img src=\"../images/plus_klein.gif\" height=\"16\" width=\"16\" border=\"0\">";
	$sprache['templates']['keine_module']=str_replace('%bild%',$bild,$sprache['templates']['keine_module']);
	echo "<tr><td colspan=\"7\" bgcolor=\"white\"><center><b>".$sprache['templates']['keine_module']."</b></center></td></tr>";
}	
?>
								</table>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="30"><img src="../images/pfeil.png" alt="" height="30" width="30" border="0"></td>
										<td>
										<select class="Feld" name="auswahl_loeschen" size="1" <?php echo js_formularfeld_fade(); ?>>
												<option value="loeschen"><?php echo $sprache['templates']['papierkorb']; ?></option>
											</select><input type="submit" name="submit" value="<?php echo $sprache['templates']['button_ausfuehren']; ?>" class="Buttonausfuehren" <?php echo js_formularbutton_fade(); ?>><br>
										</td>
										<td>
											<div align="right">
												<script language="JavaScript" type="text/javascript">
												function markierealle() {
													<?php echo str_replace("%color%","#f8e49c",str_replace("%typ%","true",$marker)); ?>
												}
												function demarkierealle() {
													<?php echo str_replace("%color%","",str_replace("%typ%","false",$marker)); ?>
												}
												</script>
												<a href="javascript:markierealle()"><?php echo $sprache['templates']['alle_waehlen']; ?></a> / <a href="javascript:demarkierealle()"><?php echo $sprache['templates']['alle_ent']; ?></a></div>
										</td>
										<td width="30">
											<div align="right">
												<a href="zeigedaten_module.php?eintragen=1"><img src="../images/plus.jpg" alt="" height="20" width="20" border="0"></a></div>
										</td>
									</tr>
								</table>
							</div>
							<div align="center">
						<br>
					<?php echo seitenumschaltung($sql,'datachange_module.php',1); ?></div>		
			</form>
		</div>
	</body>
</html>