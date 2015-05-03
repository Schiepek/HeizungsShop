<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 15:12:10 - Hashcode: 71d4549b202b0ae6317f25bc39b6dff6 
 ?><?php
include("../../GeneratedItems/config.php");
$checkrecht="templates";
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
		<title><?php echo $sprache['templates']['templates_bearbeiten']; ?></title>
	</head>
	<body bgcolor="#ffffff" leftmargin="0" marginheight="0" marginwidth="0" topmargin="0">
		<div align="center">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td background="../images/verlauf_oben_rund.gif"><font style="font-size:14px;" color="white"><strong><?php echo $sprache['templates']['templates_bearbeiten']; ?></strong></font></td>
					<td background="../images/verlauf_oben_rund.gif">
						<div align="right">
							<a href="templates.php?template=<?php echo $template; ?>"><font color="white"><?php echo $sprache['templates']['uebersicht']; ?></font></a></div>
					</td>
				</tr>
			</table>
			<br><?php
			if($ordnerauswahl==null){
				$dateipfad="../../templates/$template/$datei";
			}else{
				$dateipfad="../../templates/$template/$ordnerauswahl$datei";
			};
			if(file_exists($dateipfad)==TRUE){ 
			?>
			<form id="FormName" action="templates.php" method="post" name="FormName">
				<table width="58%" border="0" cellspacing="1" cellpadding="0" bgcolor="#8e8e8e">
					<tr>
						<td bgcolor="white">
							<table width="100%" border="0" cellspacing="0" cellpadding="2" background="../images/img_bg_felder.gif">
								<tr>
									<td align="center" width="85%"><b><?php echo $datei; ?></b></td>
								</tr>
								<tr>
									<td width="85%">
										<div align="center">
											<font color="#ffff99"><textarea <?php echo js_formularfeld_fade(); ?> name="dateiinhalt" rows="35" cols="85" class=feld><?php 
								if(filesize($dateipfad)>0){
									$fp=fopen($dateipfad, "r");
									 echo fread($fp, filesize($dateipfad));
									fclose($fp);
								};
							?></textarea><br>
												<br>
											</font><input type="hidden" name="ordnerauswahl" value="<?php echo $ordnerauswahl; ?>"><input type="hidden" name="template" value="<?php echo $template; ?>"><input type="hidden" name="datei" value="<?php echo $datei; ?>"><input type="hidden" name="filesave" value="1"></div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr height="5">
						<td height="5"></td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<div align="center">
								<table width="58%" border="0" cellspacing="1" cellpadding="2" bgcolor="#d9d9d9">
									<tr>
										<td bgcolor="white">
											<div align="right">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td width="50%">
															<div align="left"></div>
														</td>
														<td width="50%">
															<div align="right">
																<input type="submit" name="submit" value="<?php echo $sprache['templates']['button_speichern']; ?>" <?php echo js_formularbutton_fade(); ?> class=Buttonspeichern></div>
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
			<?php }else{echo $sprache['templates']['datei_nicht_vorhanden']; }; ?></div>
	</body>

</html>
