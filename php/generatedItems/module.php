<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:37:07 - Hashcode: d0b6fefd6c7d28dfac1587fe202b8ba4 
 ?><?php 

$resmodul = tri_db_query ($datenbanknamecms, "SELECT ID FROM tri_menu where modulloadingprio<>'0' order by modulloadingprio asc");
while ($rowmodul = mysql_fetch_array ($resmodul))
{

	if(file_exists("cmssystem/$rowmodul[ID]/modulloading.php")==TRUE){

		//$timenow1=getmicrotime();
		//echo "$rowmodul[ID] start:<br>";
		include("cmssystem/$rowmodul[ID]/modulloading.php");
		//$time_end = getmicrotime();
		//echo  round($time_end - $timenow1,5)."<br>";
	};
};

?>