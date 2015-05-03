<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:36:30 - Hashcode: 2f76116e2887bc6c7bee96418de199dc 
 ?><?php 
include("../GeneratedItems/config.php");
$checkrecht="loginerlaubt";
include("rechtecheck.php");
include("../GeneratedItems/debug.php");
include("allgfunktionen.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<link rel="stylesheet" type="text/css" href="GeneratedItems/style_mobile.css">
		<title>Tricoma Mobile</title>

	</head>

	<body bgcolor="#f3f3f3" leftmargin="2" marginheight="1" marginwidth="2" topmargin="1">
		<div align="center">
			<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#979797">
				<tr>
					<td bgcolor="white">
						<table width="100%" border="0" cellspacing="0" cellpadding="1">
							<tr>
								<td bgcolor="white">
									<table width="100%" border="0" cellspacing="0" cellpadding="1">
										<tr>
											<td bgcolor="white" width="56">
												<div align="center">
													<img src="light/icon.png" alt="" height="32" width="32" border="0"></div>
											</td>
											<td bgcolor="white"><font size="3" color="#5e5e5e"><strong>Tricoma Mobile</strong></font></td>
											<td bgcolor="white">
												<div align="right">
													<a href="login.php?logout=1"><font size="3">Logout</font></a></div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor="#2e348c">
									<table width="100%" border="0" cellspacing="2" cellpadding="0" height=35>
										<tr>
															<?php 
													echo "<td width=100>";
													echo "<a href=\"indexlight.php?modul=\" class=\"";
														if($modul==''){
															echo 'Buttonmobile_oben_selektiert';
														}else{
															echo 'Buttonmobile_oben';
														}
													echo "\">Startseite</a>";
													echo "</td><td width=10></td>";
													$vorhanden=FALSE;
													$res = tri_db_query ($datenbanknamecms, "SELECT * FROM tri_menu");
													while ($row = mysql_fetch_array ($res))
													{
														if(prueferecht($row[ID],$GLOBALS[edit])==TRUE and file_exists($row['ID']."/light.php")==TRUE){ 
															echo "<td width=100>";
																echo "<a href=\"indexlight.php?modul=$row[ID]\" class=\"";
																if($modul==$row['ID']){
																	echo 'Buttonmobile_oben_selektiert';
																}else{
																	echo 'Buttonmobile_oben';
																}
																echo "\">$row[name]</font></a>";
															$vorhanden=TRUE;
															echo "</td><td width=10></td>";
														};
													};
							
												?>
												<td></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor="white"><?php 
					if($modul==null){
						?><br>
									<font size="3" color="#2e348c"><strong><?php 
					
						$anredeuhrzeit=date('G');
						if($anredeuhrzeit<=10){
							$anredeuhrzeit='Guten Morgen ';
						}elseif($anredeuhrzeit<=18){
							$anredeuhrzeit='Guten Tag ';
						}else{
							$anredeuhrzeit='Guten Abend ';
						};
					
						echo $anredeuhrzeit.' '.$edit.',';
					
					?></strong></font><br>willkommen im tricoma Mobile System. <br>
						<?php 
							
							$res = tri_db_query ($GLOBALS['datenbanknamecms'], "SELECT name,ID FROM tri_menu order by name asc");
							while ($row = mysql_fetch_array ($res))
							{
								if(file_exists("../$row[ID]/modul_meintricoma_light.php")){
									if($row[ID]=='standard' or prueferecht($row[ID],$edit)==TRUE){
										require_once("../$row[ID]/modul_meintricoma_light.php");
										if(function_exists($row[ID]."_meintricoma_uebersicht")==TRUE){
											$funktion=$row[ID]."_meintricoma_uebersicht";
											$return=$funktion();
											
											if($return<>''){
												echo "<br><table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\">";
												echo "<tr>
														<td width=40 valign=top><img src=\"../$row[ID]/icon.png\" height=24></td>
														<td valign=top><b><font size=\"3\" color=\"#89c935\">$row[name]</font></b></td>
													</tr>";
												echo "<tr>
														<td width=40 valign=top></td>
														<td valign=top>$return</td>
													</tr>";
												echo "</table>";
											};
										}
									};
								};
							}
						?><br>
									<?php 
					}else{
						if(prueferecht($modul,$GLOBALS['edit'])==TRUE){
							if(file_exists($modul."/light.php")==TRUE){
								include($modul."/light.php");
							}else{
								echo "<center><font color=red>Für das Modul $modul gibt es keine Light Version</font></center>";
							};
						}else{
							echo "<center><font color=red>Ihnen fehlen die Rechte für das Modul $modul</font></center>";
						};
					};
					?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>

</html>
