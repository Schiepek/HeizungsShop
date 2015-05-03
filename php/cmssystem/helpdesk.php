<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:36:34 - Hashcode: 7863eb288612260742c978a6fc493ab1 
 ?><?php 
	include("../GeneratedItems/config.php");
	$checkrecht="loginerlaubt";
	include("rechtecheck.php");
	include("../GeneratedItems/debug.php");
	include("allgfunktionen.php");
	if (trim($modul)<>"")
	{
		require_once($modul."/_lang_deu.php");
		$titel 			= $sprache[$modul][$titel];
		$beschreibung	= $sprache[$modul][$beschreibung];
	}
	else
	{
		$titel 			= ascii_nach_string($titel);
		$beschreibung 	= ascii_nach_string($beschreibung);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<link rel="stylesheet" type="text/css" href="GeneratedItems/style.CSS">
		<title>Helpdesk</title>
	</head>

	<style>
		html, body {
		 	height:100%;
		}
	</style>

	<body bgcolor="#dfdfdf" leftmargin="0" marginheight="0" marginwidth="0" topmargin="0">
		<div align="center">
			<table width="100%" border="0" cellspacing="0" cellpadding="3" height="100%">
				<tr height="23">
					<td width="40" height="23"></td>
					<td height="23"><strong><font size="3"><?php echo $titel; ?></font></strong></td>
				</tr>
				<tr>
					<td valign="top" bgcolor="white" width="40"><img src="images/hilfesystem_gross.gif" alt="" height="32" width="32" border="0"></td>
					<td valign="top" bgcolor="white">
						<div align="left">
							<font color="#6d6d6d"><?php echo $beschreibung; ?></font></div>
					</td>
				</tr>
				<tr height="25">
					<td colspan="2" height="25">
						<div align="center">
							<a href="javascript:top.normalesfenster_schliessen('<?php echo $fensterid; ?>');">Fenster schlie&szlig;en</a></div>
					</td>
				</tr>
			</table>
		</div>
	</body>

</html>