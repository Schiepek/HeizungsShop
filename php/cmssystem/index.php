<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:36:20 - Hashcode: e1e60dad8bea64707d1cb62f298dc5cf 
 ?><?php 
	include("../GeneratedItems/config.php");
	include("../GeneratedItems/templates.php");
	require_once('allgfunktionen.php');
	@mysql_connect ("$host","$datenbankbenutzername","$datenbankpasswort") or die (template_keinedatenbank());
	if(check_mobile()==TRUE){
		$mobile=TRUE;
		include('login.php');
	}else{
		header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"'); 
		if($logout==1){
			setcookie ("trisession", "", time()-1);
		}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>


	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<title>tricoma @ <?php echo $_SERVER['SERVER_NAME']; ?></title>
		<link rel="SHORTCUT ICON" href="images/favicon.ico">
		<script type="text/javascript" src="GeneratedItems/window_prototype.js"> </script> 
		<script type="text/javascript" src="GeneratedItems/window_effects.js"> </script> 
		<script type="text/javascript" src="GeneratedItems/window_window.js"> </script> 
		<script type="text/javascript" src="GeneratedItems/window_window_ext.js"> </script> 
		<script type="text/javascript" src="GeneratedItems/window_debug.js"> </script> 
		<link href="GeneratedItems/themes/default.css" rel="stylesheet" type="text/css"> 
		<link href="GeneratedItems/themes/<?php if(trieinstellungauslesen("administration","system","erpenterprise")==1){
								echo 'erpenterprise';
							}else{
								echo 'spread';
							} ?>.css" rel="stylesheet" type="text/css"> 
		<link rel="stylesheet" type="text/css" href="GeneratedItems/style.CSS">
<script type="text/javascript">
	function init() {
		win1 = new Window('1', {className: "<?php if(trieinstellungauslesen("administration","system","erpenterprise")==1){
								echo 'erpenterprise';
							}else{
								echo 'spread';
							} ?>", title: "Login", width:450, height:200, maximizable: false, minimizable: false, closable: false}); 
		win1.getContent().innerHTML = "<iframe height=100% width=100% src=login.php?autologin_now=<?php echo $_REQUEST['autologin']; ?>  scrolling=no frameborder=0 id=contentframe name=contentframe></iframe>";
		win1.showCenter();
	};
</script>
	</head>



	<body background="<?php 
							if(trieinstellungauslesen("administration","system","erpenterprise")==1){
								echo 'images/bg3.jpg';
							}else{
								echo 'images/bg1.jpg';
							}
										?>" bgcolor="#efefef" onload="init()">
		<table width="100%" border="0" cellspacing="2" cellpadding="0">
			<tr>
				<td width="250">
					<div align="left">
						</div>
				</td>
				<td align="right" valign="top">
					<table width="170" border="0" cellspacing="2" cellpadding="0" height="100%">
						<tr height="70">
							<td valign="top" height="70">
								<div align="right">
									<?php 
										if(trieinstellungauslesen("administration","system","erpenterprise")==1){
											echo '<img src="images/logo_erp.png" alt="" height="50" width="170" border="0">';
										}else{
											echo '<img src="images/logo.gif" alt="" height="50" width="170" border="0">';
										}
										?></div>
							</td>
						</tr>
						<tr>
							<td valign="top">
								<div align="center">
									<br>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><?php 
			if($sessionabgelaufen==1){
				echo "<center><font size=3 color=\"#a6a6a6\" face=\"Arial\">Ihre Session ist abgelaufen.<br>Bitte loggen Sie sich erneut ein.</font>";
			};
		?>
	</body>
</html>
<?php 
	};
?>

