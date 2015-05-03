<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:36:00 - Hashcode: c38d73d8c3623d0c00aba565ba1634b5 
 ?><?php 

//print_r($GLOBALS);

header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTR STP IND DEM"'); 
//if(get_magic_quotes_gpc()==0){die("Ihr Tricomasystem ist aufgrund falscher Einstellung Ihrer php.ini nicht lauffähig. <br>Bitte prüfen Sie ob <b>magic quotes gpc</b> aktiviert ist.");};

include("../GeneratedItems/config.php");
include("../GeneratedItems/debug.php");
include("allgfunktionen.php");

if($logintyp==null){$logintyp='normal';};


mysql_connect ("$host","$datenbankbenutzername","$datenbankpasswort") or die ("keine DB Verbindung");

$deldate=time()-60*60*24;
tri_db_query ($GLOBALS['datenbanknamecms'], "delete from tri_sessions where aktivitaet<'$deldate' ") or die ("Fehler beim Sessionupdate in rechtecheck.php");

$IP=getenv("REMOTE_ADDR"); 
$PC=getenv("HTTP_USER_AGENT");
$PC=substr(str_replace("'","",$PC),0,100);
$datum=date ("Y-m-d - H:i:s");	
$usergesperrt=0;
/*
$res = tri_db_query ($datenbanknamecms, "SELECT IP FROM tri_ipsperre where IP='$IP' and variable<>'whitelist'");
if (mysql_num_rows($res)>0){
	$usergesperrt=1;
}
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


if($usergesperrt==0){

	//print_r($GLOBALS);

	$name="notvaliduser";
	$adminnick=addslashes($GLOBALS['adminnick']);
	
	if($pwmd5==null){
		$pwmd5=md5(addslashes($GLOBALS['pw']));
	}else{
		$pwmd5=addslashes($pwmd5);
	};
	$loginerlaubt=0;

	$sql="SELECT * FROM tri_benutzer where name='".$adminnick."' and pw='$pwmd5'";
	//echo $sql;

	$res = tri_db_query ($datenbanknamecms, $sql);
	if (mysql_num_rows($res)<=0){
		//hohe sicherheit
		tri_hoheloginsicherheit($name,$adminnick,$IP,$datum);
		setcookie ("trisession", "");
	} else {
		$row = mysql_fetch_array ($res);
		$userid=$row['ID'];
		$name=$row['name'] ;
		$loginerlaubt=$row['loginerlaubt'];
		$adminnick=$row['name'];
		
		if($name<>"notvaliduser" and $loginerlaubt==1) {
		
			if(trieinstellungauslesen("administration","system","sicherheit_autologin")==1 and $GLOBALS['autologon']==1){
				setcookie ("triautologon", md5($name).$pwmd5,time()+2592000);
			}else{
				setcookie ("triautologon", '0',time()-1);
			};
			$curtime=time();
			$endtime=$curtime+2592000;
			$pwmd5=md5(substr($pwmd5,3,5));
			$adminnick=md5(substr($adminnick,2,2).substr($adminnick,3,2));
			if(is_numeric(substr(md5($curtime),6,1))==TRUE){
				$sessionid=date("w",$curtime).date("W",$curtime).substr($pwmd5,-5,5).$adminnick.md5($curtime);
				$sessionid=md5($sessionid).substr(md5($curtime),4,9).date("D",$curtime).$userid.date("Y",$curtime).date("z",$curtime);
			}else{
				$sessionid=md5($curtime).$adminnick.date("W",$curtime).date("w",$curtime).substr($pwmd5,-5,5);
				$sessionid=substr(md5($curtime),4,9).md5($sessionid).date("D",$curtime).$userid.date("Y",$curtime).date("z",$curtime);
			};
			$sessionid=substr($sessionid,-30,30);
			//tri_db_query ($datenbanknamecms, "Delete FROM tri_sessions where endtime<='$curtime'");
			$sql = "INSERT INTO `tri_sessions` ( `session` , `benutzer` , `starttime` , `endtime` , `autologon` , `logintyp` , `IP` , `hosttyp` ) 
			VALUES ( '$sessionid', '$name', '$curtime', '$endtime', '$autologon', '$logintyp','$IP','$PC');";
			tri_db_query ($datenbanknamecms, $sql);
			tri_db_query ($datenbanknamecms, "update tri_benutzer set lastlog='$datum' where name='$name'");
			setcookie ("trisession", $sessionid, time()+2592000);
			trieinstellungsetzen('standard',$name,'sprache',$sprache);
			
			if(modulvorhanden('zeiterfassung')){
				if(trieinstellungauslesen("zeiterfassung","system","autologin")==1){
					$res2 = tri_db_query ($datenbanknamecms, "SELECT ID FROM zeiterfassung where edit='$name' and ende='0'");
					if(mysql_num_rows($res2)==0){
						tri_db_query ($datenbanknamecms, "insert into zeiterfassung (edit,datum,start,ende,zeit,typ) values ('$name','".date('Y-m-d')."','".time()."','0','0','1')");
					}
				}
			}
		} else {
			//hohe sicherheit
			tri_hoheloginsicherheit($name,$adminnick,$IP,$datum);
			setcookie ("trisession", "");
		}
	}
	
	if($name!="notvaliduser" and $loginerlaubt==1) {
		tri_db_query ($datenbanknamecms,"INSERT INTO `tri_logins` (  `aktivitaet` , `user` ,  `datum` , `IP` ) VALUES ( '0', '$name',  '$datum', '$IP');");
	}elseif($name=="notvaliduser") {
		$pw=md5($pw);
		tri_db_query ($datenbanknamecms,"INSERT INTO `tri_logins` (  `aktivitaet` , `user` , pw, `datum` , `IP` ) VALUES ( '1', '$name', '$pw', '$datum', '$IP');");
		$ausgabe=1;
	}elseif($loginerlaubt==0) {
		tri_db_query ($datenbanknamecms,"INSERT INTO `tri_logins` (  `aktivitaet` , `user` ,  `datum` , `IP` ) VALUES ( '2', '$name',  '$datum', '$IP');");
		$ausgabe=1;
	};
	
	if($ausgabe=="1"){
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
	
	<html xmlns=\"http://www.w3.org/1999/xhtml\">
	
		<head>
			<meta http-equiv=\"content-type\" content=\"text/html;charset=iso-8859-1\" />
			<title>Fehlerhafte Zugangsdaten</title>
			<meta http-equiv=\"refresh\" content=\"6; URL=index.php\">
			<link rel=\"stylesheet\" type=\"text/css\" href=\"GeneratedItems/style.CSS\">
		</head>
	
		<body bgcolor=\"#EEECEF\" background=\"images/bg1.jpg\" ><center><br><br>
				<table width=\"495\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\"  height=\"274\">
					<tr>
						<td valign=\"top\" >
							<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"  height=\"100%\">
								<tr height=\"70\" align=left>
									<td bgcolor=\"white\" height=\"70\"><img src=\"images/logo_klein.jpg\" alt=\"\" height=\"70\" width=\"250\" border=\"0\" /></td>
								</tr>
								<tr height=\"16\">
									<td height=\"16\" ></td>
								</tr>
								<tr>
									<td >
										<div align=\"center\">
											<br /><br>
											<b><font color=red size=3>Sie haben keine gültigen Zugangsdaten eingegeben</font></b><br><br>
												<a href=\"index.php\"><font color=#cdcdcd size=3>Klicken Sie hier um zum Login zurückzukehren.</font></a>
			<br />
											<br />
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table></center>
			<p></p>
		</body>
	
	</html>";
	die("");
	}; 
	 
	
	 
	 // Erkl?rung der K?rzel: 0 = login OK - 1 = Falsche Zugangsdaten - 2 = Gesperrter User
	if($_REQUEST['logintyp']=="normal")
	{
		$windowheight	= $windowheight*$fenstergroesse/100;
		$windowwidth	= $windowwidth*$fenstergroesse/100;

?>
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
	
	<html>
	
		<head>
			<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
			<title>tricoma @ <?php echo $_SERVER['SERVER_NAME']; ?></title>
			<meta http-equiv="refresh" content="0; URL=indexnormal.php?wh=<?php if(is_numeric($windowheight)){echo $windowheight;}; ?>&ww=<?php if(is_numeric($windowwidth)){echo $windowwidth;}; ?>&sessionid=<?php echo $sessionid; ?>">
			<link rel="stylesheet" type="text/css" href="GeneratedItems/style.CSS">
			<link rel="SHORTCUT ICON" href="images/favicon.ico">
			<meta http-equiv="P3P" content='CP="NOI ADM DEV PSAi COM NAV OUR OTR STP IND DEM"'>
		</head>
		<body  bgcolor="#fafafa" background="<?php 
							if(trieinstellungauslesen("administration","system","erpenterprise")==1){
								echo 'images/bg3.jpg';
							}else{
								echo 'images/bg1.jpg';
							}
										?>" bgcolor="#efefef">
			<div align="center">
			<table width="100%" border="0" cellspacing="2" cellpadding="0">
				<tr>
					<td width="250" align="left"></td>
					<td align="right" valign="top">
						<table width="170" border="0" cellspacing="2" cellpadding="0" height="100%">
							<tr height="70">
								<td valign="top" height="70" align="right"><?php 
										if(trieinstellungauslesen("administration","system","erpenterprise")==1){
											echo '<img src="images/logo_erp.png" alt="" height="50" width="170" border="0">';
										}else{
											echo '<img src="images/logo.gif" alt="" height="50" width="170" border="0">';
										}
										?></td>
							</tr>
							<tr>
								<td valign="top"><br /></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td width="250" align="left"></td>
					<td align="right" valign="top"></td>
				</tr>
			</table>
		</div>
		</body>
	</html>
	<?php }elseif($_REQUEST['logintyp']=="light"){ ?>
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
	
	<html>
	
		<head>
			<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
			<title>tricoma - trivial content management</title>
			<meta http-equiv="refresh" content="1; URL=indexlight.php">
			<link rel="stylesheet" type="text/css" href="GeneratedItems/style.CSS">
		</head>
		<body  bgcolor="#EEECEF">
			<div align="center">
				<b>Authentifizierung erfolgt.</b> <br>Klicken Sie <a href="indexlight.php">hier</a> um in das System zu gelangen.
			</div>
		</body>
	</html>
	<?php }; ?>
<?php }else{ ?>
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
	
	<html>
	
		<head>
			<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
			<title>tricoma - trivial content management</title>
			<link rel="stylesheet" type="text/css" href="GeneratedItems/style.CSS">
		</head>
		<body  bgcolor="#EEECEF" background="images/bg1.jpg" bgcolor="#efefef">
			<div align="center">
<table width="100%" border="0" cellspacing="2" cellpadding="0" height="89%">
				<tr height="100">
					<td colspan="3" height="100">
						<p></p>
					</td>
				</tr>
				<tr>
					<td></td>
					<td valign="middle" width="457">
						<div align="center">
					<table width="495" border="0" cellspacing="1" cellpadding="0" bgcolor="#dadada" height="274">
										<tr>
											<td valign="top" bgcolor="#d8d8d8">
												<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#4d4d4d" height="100%">
											<tr height="70">
														<td bgcolor="white" height="70"><img src="images/logo_klein.jpg" alt="" height="70" width="250" border="0" /></td>
													</tr>
											<tr>
														<td bgcolor="#d8d8d8">
															<div align="center">
																<br />
																
																<img src="images/login_fehlerhaft.jpg" alt="" height="48" width="48" border="0" /><br /><br>
																<b><font color=red>Ihre IP ist aufgrund vermehrt fehlgeschlagener Loginversuche gesperrt worden</font></b><br>
																	Bitte wenden Sie sich an den Administrator um die Sperre aufzuheben.
								<br />
																<br />
																<br />
															</div>
														</td>
													</tr>
										</table>
											</td>
										</tr>
									</table>
						</div>
					</td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td width="457"></td>
					<td></td>
				</tr>
			</table>

			</div>
		</body>
	</html>
<?php }; ?>