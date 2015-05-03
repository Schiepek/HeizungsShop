<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:36:53 - Hashcode: a8dbf501967262bcf544b38a9c641947 
 ?><?php 
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"'); 
require_once("../GeneratedItems/config.php");
require_once("../GeneratedItems/debug.php");
require_once("allgfunktionen.php");
mysql_connect ("$host","$datenbankbenutzername","$datenbankpasswort") or die ("keine DB Verbindung");
if($autologon=="NULL" or trieinstellungauslesen("administration","system","sicherheit_autologin")<>1){
	$autologon="";
	setcookie ("triautologon", "",time()-1);
}else{
	$autologon=$_COOKIE['triautologon'];
};
$curdate=time();
$benutzer="";
$passwortmd5="";
if($autologon<>""){
	$res = tri_db_query ($datenbanknamecms, "SELECT * FROM tri_benutzer") or die ("DB-Fehler in rechtecheck.php - prueferecht".mysql_error());
	while ($row = mysql_fetch_array ($res))
	{
		if(md5($row['name']).$row['pw']==$autologon){
			$benutzer=$row['name'];
			$passwortmd5=$row['pw'];
		};
	};
};
if($benutzer==""){
	$autologon="";
};
$IP=getenv("REMOTE_ADDR"); 
/*
$usergesperrt=0;
$res = tri_db_query ($datenbanknamecms, "SELECT * FROM tri_ipsperre where IP='$IP' and variable<>'whitelist'");
while ($row = mysql_fetch_array ($res))
{$usergesperrt="1";
};
*/

	$sql_sperre			= "SELECT * FROM tri_ipsperre where IP='$IP'";
	//echo $sql_sperre.'<hr>';
	$res 				= tri_db_query($datenbanknamecms, $sql_sperre) or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
	if(mysql_num_rows($res)>0)
	{
		$usergesperrt 		= 1;
		
		while ($row_sperre 	= mysql_fetch_array ($res))
		{
			if($row_sperre['variable']=='whitelist')
			{
				$usergesperrt = 0;
			}
		}
		//echo $sql_sperre;
	}


if($logout==1){
	setcookie ("trisession", "", time()-1);
}


if(trieinstellungauslesen("administration","system","erlaubte_domains")==''){
	$domainerlaubt=TRUE;
}else{
	$domainerlaubt=FALSE;
	$erlaubt=trieinstellungauslesen("administration","system","erlaubte_domains");
	$erlaubt=explode(',',$erlaubt);
	foreach($erlaubt as $value){
		if(str_replace('www.','',$_SERVER['SERVER_NAME'])==str_replace('www.','',$value)){
			$domainerlaubt=TRUE;
		}
	}
}

if($usergesperrt==0 and $domainerlaubt==TRUE){
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>


	<head>
		<title>tricoma @ <?php echo $_SERVER['SERVER_NAME']; ?></title>
		<link rel=stylesheet type=text/css href=GeneratedItems/style.CSS>
		<link rel="SHORTCUT ICON" href="images/favicon.ico">
	</head>

	<body leftmargin="0" marginheight="0" marginwidth="0" topmargin="0" onload="<?php 
	
	if($_REQUEST['autologin_now']==1 and $benutzer<>''){
		echo "document.getElementById('loginform').submit();";
	}
	
	if(trieinstellungauslesen("administration","system","erpenterprise")==1){
		$schriftfarbe='#e7e7e7';
	}else{
		$schriftfarbe='#232323';
	}
	
	if(trieinstellungauslesen("administration","system","ssl_aktiv")==1){
		$loginurl='https://'.$_SERVER["HTTP_HOST"].'/cmssystem/index2.php';
	}else{
		$loginurl='index2.php';
	}
	
	?>">
		<form action="<?php echo  $loginurl; ?>" method="post" name="loginform" id="loginform" target="_top" onsubmit="document.loginform.windowheight.value=screen.height;document.loginform.windowwidth.value=screen.width">
			<div align="center">
				<table  border="0" cellspacing="0" cellpadding="0" <?php if($mobile<>TRUE){ ?>height="100%" width="100%"<?php }; ?>>
					<tr>
						<td <?php if($mobile<>TRUE){ 
								if(trieinstellungauslesen("administration","system","erpenterprise")==1){
									?>background="images/indexnormal_login_erp.jpg"<?php 
								}else{
									?>background="images/indexnormal_login.jpg"<?php 
								}
							}; ?>>
							<div align="center">
								<table border="0" cellspacing="0" cellpadding="2">
									<tr>
										<td width="120"><font color="<?php echo $schriftfarbe; ?>">Name:</font></td>
										<td width="190"><font color="<?php echo $schriftfarbe; ?>"><?php if($benutzer<>null){echo $benutzer;echo "<input class=\"Feld\" type=\"hidden\" name=\"adminnick\" size=\"24\" value=\"$benutzer\" border=\"0\">";echo "<input class=\"Feld\" type=\"hidden\" name=\"pwmd5\" size=\"24\" value=\"$passwortmd5\" border=\"0\">";}else{echo "<input class=\"Feld\" type=\"text\" name=\"adminnick\" size=\"24\" border=\"0\" ".js_formularfeld_fade().">";}; ?></font></td>
									</tr>
									<?php if($autologon<>null){
																	echo "<tr height=10><td></td><td align=left>
																	<a href=\"login.php?autologon=NULL\"><font size=1 color=#6b6b6b>Sie sind nicht $benutzer?</font></a>
																	</td></tr>";
																}; 
																if($passwortmd5==null){
																?>
									<tr height=23>
										<td width="120"><font color="<?php echo $schriftfarbe; ?>">Passwort:</font></td>
										<td width="190"><font color="<?php echo $schriftfarbe; ?>"><?php  echo "<input class=\"Feld\" type=\"password\" name=\"pw\" size=\"24\" border=\"0\" ".js_formularfeld_fade().">"; ?></font></td>
									</tr>
									<?php }; ?>
									<?php if(modulvorhanden('light')) { ?>
									<tr>
										<td width="120"><font color="<?php echo $schriftfarbe; ?>">Logintyp:</td>
										<td width="190">
											<div align="left">
												<select name="logintyp" size="1" class=feld <?php echo js_formularfeld_fade(); ?>>
													<option value="normal">Normal</option>
													<option value="light" <?php if($mobile==TRUE){echo 'selected';}; ?>>Mobile</option>
												</select></div>
										</td>
									</tr>
									<?php }else{ ?>
										<input type="hidden" name="logintyp" value="normal">
									<?php }; ?>
									<?php if($mobile<>TRUE){ ?>
										<tr>
											<td width="120"><font color="<?php echo $schriftfarbe; ?>">Logindauer:</td>
											<td width="190"><select name="logindauer" size="1" class=feld <?php echo js_formularfeld_fade(); ?>>
													<option value="7200">2 Stunden</option>
													<option value="18000">5 Stunden</option>
													<option selected value="36000">10 Stunden</option>
													<option value="86400">1 Tag</option>
													<option value="432000">5 Tage</option>
													<option value="1209600">14 Tage</option>
												</select></td>
										</tr>
										
										<tr>
											<td width="120"><font color="<?php echo $schriftfarbe; ?>">Fenstergr&ouml;&szlig;e:</td>
											<td width="190"><select name="fenstergroesse" size="1" class=feld <?php echo js_formularfeld_fade(); ?>>
													<option selected value="100">100%</option>
													<option value="80">80%</option>
													<option value="60">60%</option>
													<option value="40">40%</option>
												</select></td>
										</tr>
										<?php if(trieinstellungauslesen("administration","system","sicherheit_autologin")==1){ ?>
										<tr>
											<td width="120"><font color="<?php echo $schriftfarbe; ?>">Login speichern:</td>
											<td width="190"><input type="checkbox" name="autologon" value="1" class=Feld <?php if($autologon<>null){echo "checked";}; ?> <?php echo js_formularfeld_fade(); ?>></td>
										</tr>
										<?php }; ?>
									<?php }; ?>
									<!--
									<tr>
										<td width="120">Sprache</td>
										<td width="190">
											<table width="89" border="0" cellspacing="2" cellpadding="0">
												<tr>
													<td width="18"><input type="radio" name="sprache" value="deu" checked <?php echo js_formularfeld_fade(); ?>></td>
													<td width="24"><img src="images/sprache_deu.png" alt="" height="16" width="16" border="0"></td>
													<td width="18">
														<div align="right">
															<input type="radio" name="sprache" value="eng" <?php echo js_formularfeld_fade(); ?>></div>
													</td>
													<td><img src="images/sprache_eng.png" alt="" height="16" width="16" border="0"></td>
												</tr>
											</table>
										</td>
									</tr>
									-->
									<tr>
										<td width="120"></td>
										<td width="190">
											<div align="right">
												<input type="hidden" name="windowheight" value="700">
															<input type="hidden" name="windowwidth" value="1000">
															<input type="hidden" name="sprache" value="deu">
															<font color="#232323"><input type="submit" name="submitbuton" value="Login" class=Button <?php echo js_formularbutton_fade(); ?>></font></div>
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</form>
	</body>

</html>
<?php }elseif($domainerlaubt==FALSE){ ?>
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
	
	<html>
	
		<head>
			<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
			<title>tricoma - trivial content management</title>
			<link rel="stylesheet" type="text/css" href="GeneratedItems/style.CSS">
		</head>
		<body  bgcolor="#EEECEF" leftmargin="0" marginheight="0" marginwidth="0" topmargin="0">
			<div align="center">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#4d4d4d" height="100%">
				<tr height="16">
					<td height="16" background="images/verlauf.jpg"></td>
				</tr>
				<tr>
					<td bgcolor="#d8d8d8">
						<div align="center">
							<br />
							<img src="images/login_fehlerhaft.jpg" alt="" height="48" width="48" border="0" /><br />
							<br>
							<b><font color=red>Der Login über diese Domain ist nicht erlaubt</font></b><br>
							Bitte wenden Sie sich an den Administrator um die Sperre aufzuheben.
								<br />
							<br />
							<br />
						</div>
					</td>
				</tr>
			</table>
		</div>
		</body>
	</html>
<?php }else{ ?>
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
	
	<html>
	
		<head>
			<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
			<title>tricoma - trivial content management</title>
			<link rel="stylesheet" type="text/css" href="GeneratedItems/style.CSS">
		</head>
		<body  bgcolor="#EEECEF" leftmargin="0" marginheight="0" marginwidth="0" topmargin="0">
			<div align="center">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#4d4d4d" height="100%">
				<tr height="16">
					<td height="16" background="images/verlauf.jpg"></td>
				</tr>
				<tr>
					<td bgcolor="#d8d8d8">
						<div align="center">
							<br />
							<img src="images/login_fehlerhaft.jpg" alt="" height="48" width="48" border="0" /><br />
							<br>
							<b><font color=red>Ihre IP ist aufgrund vermehrt fehlgeschlagener Loginversuche gesperrt worden</font></b><br>
							Bitte wenden Sie sich an den Administrator um die Sperre aufzuheben.
								<br />
							<br />
							<br />
						</div>
					</td>
				</tr>
			</table>
		</div>
		</body>
	</html>
<?php }; ?>