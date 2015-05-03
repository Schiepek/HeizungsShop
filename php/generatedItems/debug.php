<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:37:00 - Hashcode: 025f00470356853e0cea119388572ac8 
 ?><?php

	function error_debugger_ausgabe($err,$typ,$stack=''){
		$stack_ausgabe='';
		if(is_array($stack)==TRUE){
			//print_r($stack);
			$stack_ausgabe.='<strong>Stackausgabe:</strong><br><br>';
			foreach($stack as $key => $value){
				$stack_ausgabe.='<strong>'.$value['file'].'</strong><br>';
				$stack_ausgabe.='<i>Zeile: '.$value['line'].'</i><br>';
				$stack_ausgabe.='<br>';
			}
		}
		return "<div align=\"center\">
							<table width=\"500\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"#797979\">
								<tr>
									<td bgcolor=\"white\">
										<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
											<tr>
												<td>
													<div align=\"left\">
														<img src=\"/cmssystem/images/logo_klein.jpg\" alt=\"\" height=\"70\" width=\"250\" border=\"0\" /></div>
												</td>
												<td>
													<div align=\"right\">
														<strong><font size=4 face=Arial>Debugger<br />
															</font><font size=\"4\" color=\"red\" face=\"Arial\">$typ</font></strong></div>
												</td>
											</tr>
											<tr>
												<td colspan=\"2\"><font size=4 face=Arial>$err</font></td>
											</tr>
											<tr>
												<td colspan=\"2\"><hr><font size=4 face=Arial><table border=0 cellspacing=0><tr><td valign=top>Stack: </td><td><b>$stack_ausgabe</b></td><tr></table></font></td>
											</tr>
											<tr>
												<td colspan=\"2\" bgcolor=\"#f3f3f3\">
													<div align=\"center\">
														<a href=\"http://tricoma.de\" target=\"_blank\"><font color=#6f6f6f size=2 face=Arial>System by tricoma</font></a></div>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</div>";
	};



if($debug==TRUE){
	function error_debugger($errno, $errmsg, $filename, $linenum, $vars) {
		   if ($errno==E_USER_ERROR or $errno==E_WARNING or $errno==E_USER_NOTICE or $errno==E_USER_WARNING) {
			   // timestamp for the error entry
			   
			
			   // define an assoc array of error string
			   // in reality the only entries we should
			   // consider are E_WARNING, E_NOTICE, E_USER_ERROR,
			   // E_USER_WARNING and E_USER_NOTICE
			   $errortype = array (
			               E_ERROR          => "Error",
			               E_WARNING        => "Warning",
			               E_PARSE          => "Parsing Error",
			               E_NOTICE          => "Notice",
			               E_CORE_ERROR      => "Core Error",
			               E_CORE_WARNING    => "Core Warning",
			               E_COMPILE_ERROR  => "Compile Error",
			               E_COMPILE_WARNING => "Compile Warning",
			               E_USER_ERROR      => "User Error",
			               E_USER_WARNING    => "User Warning",
			               E_USER_NOTICE    => "User Notice",
			               E_STRICT          => "Runtime Notice"
			               );
			   // set of errors for which a var trace will be saved
			   $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);
		   		$dt = date("Y-m-d - H:i:s");
			   $err = "\n";
			   $err .= "\t Zeit auf dem Server: <b>" . $dt . "</b><br>\n";
			   $err .= "\t Fehlernummer: <b>" . $errno . "</b><br>\n";
			   $err .= "\t Fehlertyp: <b>" . $errortype[$errno] . "</b><br>\n";
			   $err .= "\t Fehlermeldung: <b>" . $errmsg . "</b><br>\n";
			   $err .= "\t Datei: <b>" . $filename . "</b><br>\n";
			   $err .= "\t Zeile: <b>" . $linenum . "</b>\n";

			   $err .= "\n\n";
			   if(is_int(strpos($filename,'cmssystem/standard/phpids/IDS'))==FALSE){
			   // for testing
			   if ($GLOBALS['debug_logging']==TRUE) {	
				   $vars="";
					foreach ($_GET as $name=>$value) {
						$vars.="$name = $value \n";
					};
					foreach ($_POST as $name=>$value) {
						$vars.="$name = $value \n";
					};
			      	@tri_db_query ("$GLOBALS[datenbanknamecms]", "INSERT INTO `tri_errorlog` ( `datei` , `typ` , `typ_erweitert` , `zeile` , `meldung` , `variablen` , `datum` ) VALUES ( '".addslashes($filename)."', 'PHP-Error', 
			      	'".addslashes($errortype[$errno])."', 
			      	'$linenum', '".addslashes($errmsg)."', 
			      	'".addslashes($vars)."', 
			      	'$dt');") or die ("Fehler im Debugger - DB<br>Womöglich wurde die Tabelle tri_errorlog nicht angelegt".mysql_error()); 
			   };
			   
			   if($GLOBALS['debug_ausgabe']==TRUE){
			   		if($GLOBALS['debug_stop']==TRUE){
			   			die(error_debugger_ausgabe($err,"PHP-Error"));
			   		}else{
			   			echo error_debugger_ausgabe($err,"PHP-Error");
			   		};
				}else{
			   		if($GLOBALS['debug_stop']==TRUE){
			   			die("<b>#500</b><br>Das System ist derzeit aufgrund von Programmfehlern nicht verfügbar.<br>Bitte wenden Sie sich an den Administrator");
			   		};
				};
			};
			}
		}
	$err_handler=set_error_handler("error_debugger");
	};

	function error_mysql_debugger($meldung,$datei,$zeile){
		if($GLOBALS['mysql_debug']==TRUE){
			$dt = date("Y-m-d - H:i:s");
			if ($GLOBALS['mysql_debug_logging']==TRUE) {
					$vars="";
					foreach ($_GET as $name=>$value) {
						$vars.="$name = $value \n";
					};
					foreach ($_POST as $name=>$value) {
						$vars.="$name = $value \n";
					};
			      	@tri_db_query ("$GLOBALS[datenbanknamecms]", "INSERT INTO `tri_errorlog` ( `datei` , `typ` , `typ_erweitert` , `zeile` , `meldung` , `variablen` , `datum` ) VALUES ( '".addslashes($datei)."', 'MySQL-Error', 
			      	'', 
			      	'$zeile', '".addslashes($meldung)."', 
			      	'".addslashes($vars)."', 
			      	'$dt');") or die ("<b>Fehler im Debugger<b><br>Womöglich wurde die Tabelle tri_errorlog nicht angelegt".mysql_error()); 
			};
			   
			if($GLOBALS['mysql_debug_ausgabe']==TRUE){
			   		if($GLOBALS['mysql_debug_stop']==TRUE){
			   			die(error_debugger_ausgabe("<table border=0 cellspacing=0><tr><td>Zeit auf dem Server: </td><td><b>" . $dt . "</b></td></tr><tr><td>Datei: </td><td><b>$datei</b></td></tr><tr><td>Zeile: </td><td><b>$zeile</b></td></tr><tr><td>Meldung: </td><td><b>$meldung</b></td><tr></table>","MySQL-Error"));
			   		}else{
			   			echo error_debugger_ausgabe("Zeit auf dem Server: <b>" . $dt . "</b><br>Datei: <b>$datei</b><br>Zeile: <b>$zeile</b><br>Meldung: <b>$meldung</b>","MySQL-Error");
			   		};
			}else{
			   		if($GLOBALS['mysql_debug_stop']==TRUE){
			   			die("<b>#500</b><br>Das System ist derzeit aufgrund von Datenbankfehlern nicht verfügbar.<br>Bitte wenden Sie sich an den Administrator");
			   		};
			};
		};
	};


	function debugger($meldung,$datei='',$zeile='',$typ='Debugger'){
		$vars="";
		$dt = date("Y-m-d - H:i:s");
		foreach ($_GET as $name=>$value) {
			$vars.="$name = $value \n";
		};
		foreach ($_POST as $name=>$value) {
			$vars.="$name = $value \n";
		};
      	@tri_db_query ("$GLOBALS[datenbanknamecms]", "INSERT INTO `tri_errorlog` ( `datei` , `typ` , `typ_erweitert` , `zeile` , `meldung` , `variablen` , `datum` ) VALUES ( '".addslashes($datei)."', '$typ', 
      	'', 
      	'$zeile', '".addslashes($meldung)."', 
      	'".addslashes($vars)."', 
      	'$dt');") or die ("<b>Fehler im Debugger<b><br>Womöglich wurde die Tabelle tri_errorlog nicht angelegt"); 
	};


?>