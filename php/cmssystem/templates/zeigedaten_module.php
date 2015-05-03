<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 15:12:15 - Hashcode: 7182e7a2663ebd2d1e0a4f149aad0af0 
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
		<title><?php 
					if($eintragen==1){
						echo $sprache['templates']['modul_eintragen'];
					}else{
						echo $sprache['templates']['modul_bearbeiten'];
					}; ?>
		</title>
	</head>

	<body bgcolor="#ffffff" leftmargin="0" marginheight="0" marginwidth="0" topmargin="0">
		<div align="center">
			<table width="100%" border="0" cellspacing="2" cellpadding="0" bgcolor="#cccccc" background="../images/verlauf_oben_rund.gif">
				<tr>
					<td><font style="font-size:14px;" color="white"><strong>
					<?php 
					if($eintragen==1){
						echo $sprache['templates']['modul_eintragen'];
					}else{
						echo $sprache['templates']['modul_bearbeiten'];
					}; ?></strong></font></td>
					<td>
						<div align="right"><a href="datachange_module.php"><font color="white"><?php echo $sprache['templates']['uebersicht']; ?></font></a>
						</div>
					</td>
				</tr>
			</table>
			<br>
<?php
if($eintragen==1){
?>
<form action="datachange_module.php" method="post">
				<font face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular"></font>
				<div align="center">
					<div align="center">
						<table width="600" border="0" cellspacing="1" cellpadding="0" bgcolor="#797979">
							<tr>
								<td bgcolor="white">
									<table width="100%" border="0" cellspacing="0" cellpadding="2">
										<tr>
											<td bgcolor="#cccccc" background="../images/verlauf_oben_rund2.gif"><b><font color="white"><?php echo $sprache['templates']['modul_eintragen']; ?></font></b></td>
										</tr>
										<tr>
											<td background="../images/img_bg_felder3.gif">
												<div align="center">
													<table width="600" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td>
																<div align="right">
																	<table width="100%" border="0" cellspacing="2" cellpadding="0">
																		<tr>
																			<td valign="top" width="90">
																				<div align="center">
																					<p><img src="../images/img_hinzu.png" alt="" height="32" width="32" align="middle" border="0" /></p>
																				</div>
																			</td>
																			<td valign="top">
																				<table width="100%" border="0" cellspacing="1" cellpadding="2">
																					<tr>
																						<td valign="top" width="77"><?php echo $sprache['templates']['modul_name']; ?>:</td>
																						<td><input class="Feld" type="text" name="modulname" size="67" <?php echo js_formularfeld_fade(); ?>></td>
																					</tr>
																				</table>
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
								</td>
							</tr>
						</table>
						<table width="90%" border="0" cellspacing="0" cellpadding="0">
							<tr height="5">
								<td height="5"></td>
							</tr>
						</table>
						<table width="600" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<div align="right">
										<table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#d9d9d9">
											<tr>
												<td bgcolor="white">
													<div align="right">
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td width="50%">
																	<div align="left">
																		<input type="hidden" name="speichern" value="1"></div>
																</td>
																<td width="50%">
																	<div align="right">
																		<input type="submit" name="submit" value="<?php echo $sprache['templates']['button_eintragen']; ?>" class=Buttoneintragen <?php echo js_formularbutton_fade(); ?>></div>
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
					</div>
					<div align="right">
						<p></p>
					</div>
				</div>
			</form>
<?php
}else{
			//Bearbeitung des Moduls	
			if($bearbeitenid<>0 and $submitspeichern<>null){
				tri_db_query($datenbanknamecms, "UPDATE `tri_templatemodules` SET modulname= '$modulname' , templatecode='$templatecode' , beschreibung='$beschreibung' , kategorie='$menue' WHERE ID = '$bearbeitenid'");
				text_backup('templates','tri_templatemodules','templatecode',$ID,$templatecode,$edit,'../templates/zeigedaten_module.php?ID='.$ID);
				logfile('templates','tri_templatemodules',$bearbeitenid,'modulname',2);
			};
			
			if($bearbeitenid<>0 and $submitpapierkorb<>null){
				papierkorb_verschieben('templates','tri_templatemodules',$bearbeitenid,'modulname');
				echo "<head> <meta http-equiv=\"refresh\" content=\"0; URL=datachange_module.php?\"> </head>";
				die();
			};		
			
				$res = tri_db_query ($datenbanknamecms, "SELECT * FROM tri_templatemodules where ID='$ID' order by ID asc");
				$row = mysql_fetch_array ($res);
				
			?>
			<form action="zeigedaten_module.php" method="post">
				<font face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular"></font>
				<div align="center">
					<table width="600" border="0" cellspacing="0" cellpadding="1" bgcolor="#8e8e8e">
						<tr>
							<td>
								<div align="center">
									<div align="center">
										<table width="100%" border="0" cellspacing="1" cellpadding="2" background="../images/img_bg_felder3.gif">
											<tr>
												<td valign="top" width="150" background="(EmptyReference!)"><?php echo $sprache['templates']['modul_name']; ?>:</td>
												<td width="80%" background="(EmptyReference!)"><input class="Feld" type="text" name="modulname" size="40" value="<?php echo $row['modulname']; ?>" <?php echo js_formularfeld_fade(); ?>></td>
											</tr>
											<tr>
												<td valign="top" width="150" background="(EmptyReference!)"><?php echo $sprache['templates']['menue']; ?>:</td>
												<td width="80%" background="(EmptyReference!)"><input class="Feld" type="text" name="menue" size="40" value="<?php echo $row['kategorie']; ?>" <?php echo js_formularfeld_fade(); ?>></td>
											</tr>
											<tr>
												<td valign="top" width="150" background="(EmptyReference!)"><?php echo $sprache['templates']['beschreibung']; ?>:</td>
												<td width="80%" background="(EmptyReference!)"><input class="Feld" type="text" name="beschreibung" size="40" value="<?php echo $row['beschreibung']; ?>" <?php echo js_formularfeld_fade(); ?>></td>
											</tr>
											<tr>
												<td colspan="2" valign="top" background="(EmptyReference!)"><?php echo $sprache['templates']['templatecode']; ?>:</td>
											</tr>
											<tr>
												<td colspan="2" valign="top" bgcolor="white">
													<div align="center">
														<textarea name="templatecode" rows="35" cols="85" class="Feld" <?php echo js_formularfeld_fade(); ?>><?php echo $row['templatecode']?></textarea></div>
												</td>
											</tr>
											<tr>
												<td colspan="2" valign="top" bgcolor="#f0f0f0">
													<div align="center">
														<input type="hidden" name="ID" value="<?php echo $ID; ?>"><input type="hidden" name="bearbeitenid" value="<?php echo $ID; ?>"><?php echo text_backup_link('templates','tri_templatemodules','templatecode',$ID); ?></div>
												</td>
											</tr>
										</table>
									</div>
								</div>
							</td>
						</tr>
					</table>
					<table width="90%" border="0" cellspacing="0" cellpadding="0">
						<tr height="5">
							<td height="5"></td>
						</tr>
					</table>
					<table width="700" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>
								<div align="right">
									<table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#d9d9d9">
										<tr>
											<td bgcolor="white">
												<div align="right">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td width="50%">
																<div align="left">
																	<input class="Buttonspeichern" type="submit" name="submitspeichern" value="<?php echo $sprache['templates']['button_speichern']; ?>" border="0" <?php echo js_formularbutton_fade(); ?>></div>
															</td>
															<td width="50%">
																<div align="right">
																	<input class="Buttonpapierkorb" type="submit" name="submitpapierkorb" value="<?php echo $sprache['templates']['button_papierkorb']; ?>" border="0" <?php echo js_formularbutton_fade(); ?>></div>
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
				</div>
			</form>
			</div><?php };?>
	</body>
</html>