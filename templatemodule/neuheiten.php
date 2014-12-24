<?php 

	
	$tmp		= templateeinlesen($template,"warenkorb_artikeluebersicht_felder_feld");
	$ausgabe	= templateeinlesen($template,"neuheiten");
	$sql 		= "	SELECT 	produkte.* 
					FROM 	produkte{sql_kategorie}
					WHERE	produkte.gesperrt='0'  
					AND		ukat='0'
					".warenkorb_webseite_sql()." {sql_kategorie_zuordnung}
					ORDER by ID desc limit 5";
	
	if(function_exists('warenkorb_rechtesystem_sql_parsen'))
	{
		$sql 	= warenkorb_rechtesystem_sql_parsen($sql);
	}
	else
	{
		$sql 	= str_replace("{sql_kategorie}", "", $sql);
		$sql 	= str_replace("{sql_kategorie_zuordnung}", "", $sql);
	}
	if(trim($sql!=""))
	{
		$res 		= mysql_db_query ($GLOBALS['datenbanknamecms'], $sql) or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
		if(mysql_num_rows($res)>0)
		{
			while ($row = mysql_fetch_array ($res))
			{ 
				$neuheit.=warenkorb_produkte_template($tmp,$row['ID']);
				
	
	
				
			}
			$ausgabe = str_replace("{artikel}", $neuheit, $ausgabe);
			echo $ausgabe;
		}
	}
?>