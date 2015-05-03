<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:35:26 - Hashcode: 857c2d05636064244e23037b42284ccf 
 ?><?php 

	include("../GeneratedItems/config.php");
	$checkrecht="loginerlaubt";
	include("rechtecheck.php");
	include("../GeneratedItems/debug.php");
	include("allgfunktionen.php");

	if($_REQUEST['setzemandanten']==1)
	{
		trieinstellungsetzen('mandanten',$edit,'mandant',$_REQUEST['mandanten']);
	 	$firstload=1;
	}
	$theme=trieinstellungauslesen("meinedaten",$edit,"theme");
	
	if($theme==null or file_exists('GeneratedItems/themes/'.$theme.'.css')==FALSE)
	{
		$theme_design='alphacube';
	}
	else
	{
		$theme_design=$theme;
	};

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
	<title>Bestellungen</title>
	
	<link rel="stylesheet" type="text/css" href="GeneratedItems/style.CSS">
	<link rel="stylesheet" type="text/css" href="standard/jquery/core/1.5/css/smoothness/jquery-ui-1.8.9.custom.css">
	<script type="text/javascript" src="standard/jquery/core/1.5/js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="standard/jquery/core/1.5/js/jquery-ui-1.8.9.custom.min.js"></script>
	<script type="text/javascript" src="standard/jquery/plugins/tri.system_functions.js"></script>
	<script src="allgfunktionen.js" type="text/javascript"></script>
	
	<script type="text/javascript">
		function changemenuBG(node) {
			var sessionid = '<?php echo $sessionid ?>';
			if (node.style.backgroundColor != "") 
			{
				node.style.backgroundColor = "";
			} 
			else 
			{
			<?php
				if($theme_design=='erpenterprise')
				{
					echo 'node.style.backgroundColor = "#3c3c3c";';
				}
				else
				{
					echo 'node.style.backgroundColor = "#f2f2f2";';
				}
			?>
			}
		}
	</script>
</head>
<?php 

	if($firstload==1)
	{
		$row['ID']	= $menuid;
		$startpage	= trieinstellungauslesen("standard",$GLOBALS['edit'],"haupttextspeichern_$row[ID]");
		
		if($startpage==null)
		{
			$sql 			= "SELECT berechtigung,link,ID FROM tri_untermenu where ID like '$row[ID]%' ORDER BY prio,name asc";
			$res2 			= tri_db_query ($datenbanknamecms, $sql);
			while ($row2 	= mysql_fetch_array ($res2))
			{ 
				if(prueferecht($row2['berechtigung'],$GLOBALS['edit'])==TRUE and $startpage==null)
				{
					$startpage		= $row2['ID'];
					$startpagelink	= $row2['link'];
					trieinstellungsetzen("standard",$GLOBALS['edit'],"haupttextspeichern_$row[ID]",$row2['ID']);	
				};
			};
		}
		else
		{
			$res2 			= tri_db_query ($datenbanknamecms, "SELECT link FROM tri_untermenu where ID like '$startpage' limit 1");
			$row2 			= mysql_fetch_array ($res2);
			$startpagelink	= $row2['link'];
			$link			= explode('?',$row['link']);
			if(count($link)==1)
			{
				$startpagelink=$startpagelink.'?sessionid='.$sessionid;
			}
			else
			{
				$startpagelink=$startpagelink.'&sessionid='.$sessionid;
			};
		};
	}
	else
	{
		$startpage='';
	};
	
	$haupttextspeichern = trim($haupttextspeichern);
?>

	<body bgcolor="#ebebeb" background="<?php 
					if($theme_design=='erpenterprise'){
						echo "GeneratedItems/themes/erpenterprise/obenmenuverlauf.jpg";
					}else{
						echo "images/obenmenu_verlauf.jpg";
					}
					?>" leftmargin="0" marginheight="0" marginwidth="0" topmargin="0" <?php if($startpage<>null){echo "onload=\"FrameAendern('$startpagelink', 'contentframe$menuid');\"";}; ?> oncontextmenu="return false">
	
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
<?php

	$datum=date ("Y-m-d - H:i:s");	
	if($haupttextspeichern!="")
	{
		trieinstellungsetzen("standard",$edit,"haupttextspeichern_$menuid",$haupttextspeichern);	
	};
	if($menuid==null)
	{
		$menuid=trieinstellungauslesen("standard",$edit,"menuoben");
	};	

	$berechtigung	= "";
	$res 			= tri_db_query ($datenbanknamecms, "SELECT ID FROM tri_menu where ID='$menuid'");
	$row 			= mysql_fetch_array ($res);
	$berechtigung	= $row['ID'];
	
	
	if(prueferecht($berechtigung,$edit)==TRUE) 
	{
		$sql 		= "SELECT * FROM tri_untermenu where ID like '".$menuid."%' ORDER BY prio,name asc";
		$res 		= tri_db_query ($datenbanknamecms, $sql);
		while ($row = mysql_fetch_array ($res))
		{ 
			$i++;
		
			if(prueferecht($row['berechtigung'],$edit)==TRUE and (is_int(strpos($row[ID],$menuid.'_')) or $menuid==$row[ID]))
			{
				if($GLOBALS['lang']<>null)
				{
					$modul=explode('_',$row['ID']);
					if(file_exists($modul['0'].'/_lang_'.$GLOBALS['lang'].'.php')==TRUE){
						include($modul['0'].'/_lang_'.$GLOBALS['lang'].'.php');
						if($sprache[$modul['0']][$modul['1']]<>null){
							$row['name']=$sprache[$modul['0']][$modul['1']];
						};
					};
				};
				if($row['ID']=='kalender_einsehen')
				{
					$benutzerauswahl=trieinstellungauslesen("kalender",$edit,"benutzerauswahl");
					if(trieinstellungauslesen("kalender",$edit,"standardansicht")=='monatsansicht'){
						$row['link']='kalender/einsehen.php';
					}elseif(trieinstellungauslesen("kalender",$edit,"standardansicht")=='wochenansicht'){
						$row['link']='kalender/kalender_wochenuebersicht.php?timestampjahr='.date('Y').'&kw='.date('W');
					}elseif(trieinstellungauslesen("kalender",$edit,"standardansicht")=='tagesansicht'){
						$row['link']='kalender/kalender_tagesuebersicht.php?timestampjahr='.date('Y').'&timestampmonat='.date('m').'&timestamptag='.date('d');
					};
				};
				
				$link=explode('?',$row['link']);
				if(count($link)==1){
					$row['link']=$row['link'].'?sessionid='.$sessionid;
				}else{
					$row['link']=$row['link'].'&sessionid='.$sessionid;
				};

				echo "<td width=10 height=23></td>
						<td width=1 ></td>
						<td bgcolor=\"";
					if($theme_design=='erpenterprise'){
						echo "black";
					}else{
						echo "white";
					}
					
					//
					
					$row['link'].= '&menu_modul='.$menuid.'&menu_bereich='.$row['ID'];
					
					echo "\" onclick=\"FrameAendern('$row[link]', 'contentframe$menuid');FrameAendern('obenmenu.php?menuid=$menuid&haupttextspeichern=$row[ID]&sessionid=$sessionid', 'menuframe$menuid');top.document.getElementById('shortsearch').style.display = 'none';\" onMouseOver=\"javascript:changemenuBG(this)\" onMouseOut=\"javascript:changemenuBG(this)\" style=\"cursor: pointer;\" valign=\"middle\"> 
						<table border=0 cellspacing=0 cellpadding=0>
							<tr>
								<td width=10></td>
								<td width=23 align=left>
									<img src=\"$menuid/icon.png\" alt=\"\" height=\"15\" width=\"15\" border=\"0\"> 
								</td><td>
									<font color=";
									if($theme_design=='erpenterprise'){
										echo "white";
									}else{
										echo "black";
									}
									echo " size=2><b>$row[name]</b></font>
								</td>
								<td width=10></td>
							</td>
						</table>
				</td><td width=1 bgcolor=#b1b1b1>";

			//if($i==6) {echo "</tr><tr>";};
			};
		};
		trieinstellungsetzen("standard",$edit,"menuoben",$menuid);		
	};

?></tr>
						</table>
					</td>
<?php 
	if(modulvorhanden('mandanten')==TRUE)
	{
		require_once('mandanten/funktionen.php');
		$module=mandanten_kompatible_module('./');
		
		
		if($module[$menuid]==1 or $menuid=='administration')
		{ 
?>
							<td width="30" align=center>
								<img src="mandanten/icon.png" height=20>
							</td>
							<td width="150" align=left>
								<form id="mandantenform" action="obenmenu.php" method="post" name="mandantenform">
								<div align="right">
									<select name="mandanten" size="1" onchange="document.getElementById('mandantenform').submit()">
											<?php
												$all="<option value=\"0\">Alle Mandanten</option>";
												$cache='';
												$deaktivierter_enthalten=FALSE;
												$mandant_gewaehlt=FALSE;
												$gewaehltermandant=99999;
												
												$array=mandanten_array();
												$vorhanden=FALSE;
												foreach($array as $value){
													$check=trieinstellungauslesen('mandanten',$edit,"mandant_deaktivieren_".$value['ID']);
													if($check<>1){
														$gewaehltermandant=$value['ID'];
														$cache.= "<option value=\"$value[ID]\" ";
														if(trieinstellungauslesen('mandanten',$edit,'mandant')==$value['ID']){
															$cache.='selected';$mandant_gewaehlt=TRUE;
														};
														$cache.= ">- ".textkuerzen($value[titel],25)."</option>";
														$vorhanden=TRUE;
													}else{
														$deaktivierter_enthalten=TRUE;
													}
												}	
												if($deaktivierter_enthalten==FALSE){
													echo $all;
												}
												if($mandant_gewaehlt==FALSE and $deaktivierter_enthalten==TRUE and count($array)>0){
													trieinstellungsetzen('mandanten',$edit,'mandant',$gewaehltermandant);
													//echo 'DEBUG--->2'.$edit.$gewaehltermandant;
												}
												echo $cache;
											?>
										</select><input type="hidden" name="menuid" value="<?php echo $menuid; ?>">
										<input type="hidden" name="setzemandanten" value="1">
										<input type="hidden" name="haupttextspeichern" value="<?php echo $haupttextspeichern; ?> ">
										
									</div>
								</form>
							</td>
<?php 
						};
					}; 
					
			$tri_menu_array = tri_menu_array();
										
			if(is_array($tri_menu_array) && count($tri_menu_array)>0)
			{
				foreach($tri_menu_array as $key => $value)
				{
					$pfad = tri_modul_pfad('','',__FILE__).'/'.$key;
				
					if(file_exists($pfad."/modul_obenmenu.php"))
					{
						require_once($pfad."/funktionen.php");
						include($pfad."/modul_obenmenu.php");
					};
				}
			}
?>
			<td width="30" align="right"><img src="images/reload.png" alt="" height="16" width="16" border="0" onclick="javascript:parent['contentframe<?php echo $menuid; ?>'].location.reload();" style="cursor: pointer;"></td>
			<td width="10"></td>
		</tr>
	</table>
			
	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#a7a7a7">
		<tr height="1">
			<td height="1"></td>
		</tr>
		<tr height="10" bgcolor=white>
			<td height="10"></td>
		</tr>
	</table>
</body>
</html>
