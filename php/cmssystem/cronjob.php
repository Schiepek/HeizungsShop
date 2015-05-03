<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:35:40 - Hashcode: 049bd24ace41dc0cd1579c4509a8a99e 
 ?><?php

include("../GeneratedItems/config.php");
mysql_connect ("$host","$datenbankbenutzername","$datenbankpasswort") or die ("keine DB Verbindung");
include("../GeneratedItems/debug.php");
include("allgfunktionen.php");
include("rubcoder.php");

	$htpasswd_pswd					= trieinstellungauslesen("administration","system","htpasswd_pswd");
	$htpasswd_user					= trieinstellungauslesen("administration","system","htpasswd_user");

$time=time();
$res = tri_db_query ($datenbanknamecms, "SELECT * FROM tri_menu order by ID asc");
while ($row = mysql_fetch_array ($res))
{
		if(file_exists("./".$row['ID']."/cronjob.php")==TRUE)
		{
			$auswert	= trieinstellungauslesen($row['ID'],"system","crontab");
			$lastexec	= trieinstellungauslesen($row['ID'],"system","crontab_exec");
			if($auswert==null){$auswert=60;};
			
			if($auswert<>"0")
			{
				if($lastexec+($auswert*60)<$time)
				{
					echo "Ausfuehrung des Moduls $row[ID]<br><table width=\"80%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#a2a2a2\">
			<tr>
				<td bgcolor=\"#ececec\">";
					trieinstellungsetzen($row['ID'],"system","crontab_exec","$time");
					
					
					
					$pfad="http://".$_SERVER[HTTP_HOST]."/cmssystem/".$row['ID']."/cronjob.php";
					//echo $pfad;
					//$r = new HTTPRequest($pfad); 
					//echo $r->DownloadToString();
					$return=tri_download_socket($pfad,false,$htpasswd_user,$htpasswd_pswd);
					echo $return;
				
					echo "</td>
			</tr>
		</table><br><br>";
				}
				else
				{
					echo 'Modul '.$row[ID].' kürzlich erst ausgeführt.<hr>';
				}
			};
		};
};


?>