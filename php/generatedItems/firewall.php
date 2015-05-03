<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:36:59 - Hashcode: 2dc5d2cd3f2831167cdc950808180c9c 
 ?><?php 

	if($firewall_loaded<>TRUE){
	
		$usergesperrt=0;
		$IP=getenv("REMOTE_ADDR");
		$datum=date ("Y-m-d - H:i:s");
		
		
		$IP_explode=explode('.',$IP);
		$IP1_sperre=$IP_explode[0].'.*';
		$IP2_sperre=$IP_explode[0].'.'.$IP_explode[1].'.*';
		$IP3_sperre=$IP_explode[0].'.'.$IP_explode[1].'.'.$IP_explode[2].'.*';
		$sperrgrund='';	
		$sperre=0;

		//Firewall laden
		if(file_exists($_SERVER['DOCUMENT_ROOT']."/cmssystem/standard/IDS/")){
			//echo 'Lade PHP IDS';
			//$string = preg_replace("/( +)/", " ", $string);
			set_include_path($_SERVER['DOCUMENT_ROOT']. '/cmssystem/standard/');
			
			require_once ($_SERVER['DOCUMENT_ROOT'].'/cmssystem/standard/IDS/Init.php');
			
			try {
			    $request = array(
			        'REQUEST' => $_REQUEST
			    );
			    
			    unset($request['REQUEST']['inhalt']);
			    
			    $init = IDS_Init::init($_SERVER['DOCUMENT_ROOT'] . '/cmssystem/standard/IDS/Config/Config.ini.php');
			
			    $init->config['General']['base_path'] = $_SERVER['DOCUMENT_ROOT'] . '/cmssystem/standard/IDS/';
			    $init->config['General']['use_base_path'] = true;
			    $init->config['Caching']['caching'] = 'none';
						
			    // 2. Initiate the PHPIDS and fetch the results
			    $ids = new IDS_Monitor($request, $init);
			    $result = $ids->run();

				$firewall_deaktiviert=array();	//Array mit den IDs aus PHPIDS welche nicht zur Sperrung führen sollen
				if($firewall_level=='low')
				{
					$firewall_deaktiviert['1']=TRUE; 	//finds html breaking injections including whitespace attacks --> Zu viele Leerzeichen
					$firewall_deaktiviert['2']=TRUE; 	//finds attribute breaking injections including whitespace attacks --> Erkennt HTML
					$firewall_deaktiviert['4']=TRUE; 	//Detects url-, name-, JSON, and referrer-contained payload attacks (4)
					$firewall_deaktiviert['5']=TRUE; 	//Detects hash-contained xss payload attacks, setter usage and property overloading
					$firewall_deaktiviert['6']=TRUE; 	//Detects self contained xss via with(), common loops and regex to string conversion (6)
					$firewall_deaktiviert['7']=TRUE; 	//Detects JavaScript with(), ternary operators and XML predicate attacks
					$firewall_deaktiviert['8']=TRUE; 	//Detects self-executing JavaScript functions (8
					$firewall_deaktiviert['9']=TRUE; 	//Detects the IE octal, hex and unicode entities (9)
					$firewall_deaktiviert['11']=TRUE; 	//Detects specific directory and path traversal (11)
					$firewall_deaktiviert['13']=TRUE; 	//Detects halfwidth/fullwidth encoded unicode HTML breaking attempts (13)
					$firewall_deaktiviert['14']=TRUE; 	//Detects possible includes, VBSCript/JScript encodeed and packed functions (14)
					$firewall_deaktiviert['10']=TRUE; 	//Detects basic directory traversal
					$firewall_deaktiviert['15']=TRUE; 	//Detects JavaScript DOM/miscellaneous properties and methods (15)
					$firewall_deaktiviert['16']=TRUE; 	//Detects possible includes and typical script methods --> Findet Backslashes
					$firewall_deaktiviert['17']=TRUE; 	//Detects JavaScript object properties and methods
					$firewall_deaktiviert['18']=TRUE; 	//Detects JavaScript array properties and methods 
					$firewall_deaktiviert['19']=TRUE; 	//Detects JavaScript string properties and methods (19)
					$firewall_deaktiviert['20']=TRUE;	//Detects JavaScript language constructs (20)
					$firewall_deaktiviert['21']=TRUE;	//Detects very basic XSS probings (21)
					$firewall_deaktiviert['22']=TRUE;	//Detects advanced XSS probings via Script(), RexExp, constructors and XML namespaces (22)
					$firewall_deaktiviert['23']=TRUE; 	//Detects JavaScript location/document property access and window access obfuscation --> Findet Backslashes
					$firewall_deaktiviert['24']=TRUE; 	//Detects basic obfuscated JavaScript script injections
					$firewall_deaktiviert['25']=TRUE; 	//Detects obfuscated JavaScript script injections (25),
					$firewall_deaktiviert['26']=TRUE; 	//Detects JavaScript cookie stealing and redirection attempts
					$firewall_deaktiviert['27']=TRUE; 	//URL injections, VBS injections and common URI schemes --> Findet Backslashes
					$firewall_deaktiviert['28']=TRUE; 	//Detects IE firefoxurl injections, cache poisoning attempts and local file inclusion/execution (28)
					$firewall_deaktiviert['30']=TRUE; 	//Detects common XSS concatenation patterns 1/2 --> Findet Backslashes
					$firewall_deaktiviert['31']=TRUE; 	//Detects common XSS concatenation patterns 2/2 
					$firewall_deaktiviert['32']=TRUE;   //Detects possible event handlers (32)
					$firewall_deaktiviert['33']=TRUE; 	//Detects obfuscated script tags and XML wrapped HTML --> Erkennt HTML
					$firewall_deaktiviert['35']=TRUE; 	//Detects common comment types --> Findet Backslashes
					$firewall_deaktiviert['38']=TRUE; 	//Detects possibly malicious html elements including some attributes
					$firewall_deaktiviert['39']=TRUE; 	//Detects nullbytes and other dangerous characters
					$firewall_deaktiviert['40']=TRUE; 	//Detects MySQL comments, conditions and ch(a)r injections (40)
					$firewall_deaktiviert['43']=TRUE; 	//Detects classic SQL injection probings 2/2 --> Erkennt Links
					$firewall_deaktiviert['42']=TRUE; 	//Detects classic SQL injection probings 1/2 (42)
					$firewall_deaktiviert['44']=TRUE; 	//Detects basic SQL authentication bypass attempts 1/3
					$firewall_deaktiviert['45']=TRUE; 	//Detects basic SQL authentication bypass attempts 2/3 --> Erkennt Links
					$firewall_deaktiviert['46']=TRUE; 	//Detects basic SQL authentication bypass attempts 3/3
					$firewall_deaktiviert['48']=TRUE; 	//Detects basic SQL authentication bypass attempts 3/3
					$firewall_deaktiviert['49']=TRUE; 	//Detects chained SQL injection attempts 2/2 
					
					$firewall_deaktiviert['51']=TRUE; 	//Detects MySQL UDF injection and other data/structure manipulation attempts (51)
					$firewall_deaktiviert['55']=TRUE; 	//Detects MSSQL code execution and information gathering attempts (55)
					$firewall_deaktiviert['56']=TRUE; 	//Detects MATCH AGAINST, MERGE, EXECUTE IMMEDIATE and HAVING injections
					
					$firewall_deaktiviert['57']=TRUE; 	//Detects MySQL comment-/space-obfuscated injections and backtick termination
					$firewall_deaktiviert['58']=TRUE; 	//Detects code injection attempts 1/3 (58)
					$firewall_deaktiviert['59']=TRUE; 	//Detects code injection attempts 2/3 (59)
					$firewall_deaktiviert['60']=TRUE; 	//Detects code injection attempts 3/3 (60)
					$firewall_deaktiviert['61']=TRUE; 	//Detects url injections and RFE attempts (61)
					$firewall_deaktiviert['62']=TRUE; 	//Detects common function declarations and special JS operators  (62)
					$firewall_deaktiviert['65']=TRUE; 	//Detects basic XSS DoS attempts (65)
					$firewall_deaktiviert['67']=TRUE; 	//Detects unknown attack vectors based on PHPIDS Centrifuge detection
					$firewall_deaktiviert['68']=TRUE; 	//Finds attribute breaking injections including obfuscated attributes
					$firewall_deaktiviert['71']=TRUE; 	//finds malicious attribute injection attempts and MHTML attacks
					$firewall_deaktiviert['74']=TRUE;	//Detects remote code exectuion tests. Will match "ping -n 3 localhost" and "ping localhost -n 3" 
					$firewall_deaktiviert['75']=TRUE; 	//Looking for a format string attack (75)
					//schon ca 12 doppelte einträge gelöscht!!!!
				}
				else
				{
					$firewall_deaktiviert['1']=TRUE; 	//finds html breaking injections including whitespace attacks --> Zu viele Leerzeichen
					$firewall_deaktiviert['2']=TRUE; 	//finds attribute breaking injections including whitespace attacks --> Erkennt HTML
					$firewall_deaktiviert['5']=TRUE; 	//Detects hash-contained xss payload attacks, setter usage and property overloading
					$firewall_deaktiviert['7']=TRUE; 	//Detects JavaScript with(), ternary operators and XML predicate attacks
					$firewall_deaktiviert['8']=TRUE; 	//Detects self-executing JavaScript functions (8
					$firewall_deaktiviert['9']=TRUE; 	//Detects the IE octal, hex and unicode entities (9), Detects the IE octal, hex and unicode entities (9)
					$firewall_deaktiviert['10']=TRUE; 	//Detects basic directory traversal
					$firewall_deaktiviert['13']=TRUE; 	//Detects halfwidth/fullwidth encoded unicode HTML breaking attempts (13)

					$firewall_deaktiviert['14']=TRUE; 	//Detects possible includes, VBSCript/JScript encodeed and packed functions
					$firewall_deaktiviert['15']=TRUE; 	//Detects JavaScript DOM/miscellaneous properties and methods (15)

					$firewall_deaktiviert['16']=TRUE; 	//Detects possible includes and typical script methods
					$firewall_deaktiviert['17']=TRUE; 	//Detects JavaScript object properties and methods
					$firewall_deaktiviert['18']=TRUE; 	//Detects JavaScript array properties and methods 
					$firewall_deaktiviert['20']=TRUE; 	//Detects JavaScript language constructs 
					$firewall_deaktiviert['22']=TRUE;	//Detects advanced XSS probings via Script(), RexExp, constructors and XML namespaces (22)
					
					$firewall_deaktiviert['23']=TRUE; 	//Detects JavaScript location/document property access and window access obfuscation --> Findet Backslashes
					$firewall_deaktiviert['24']=TRUE; 	//Detects basic obfuscated JavaScript script injections
					$firewall_deaktiviert['25']=TRUE; 	//Detects basic obfuscated JavaScript script injections
					$firewall_deaktiviert['27']=TRUE; 	//Detects data: URL injections, VBS injections and common URI schemes 
					
					$firewall_deaktiviert['30']=TRUE; 	//Detects common XSS concatenation patterns 1/2 
					$firewall_deaktiviert['31']=TRUE; 	// Detects common XSS concatenation patterns 2/2 (31)
					$firewall_deaktiviert['32']=TRUE; 	//Detects possible event handlers
					$firewall_deaktiviert['33']=TRUE; 	//Detects obfuscated script tags and XML wrapped HTML --> Erkennt HTML
					$firewall_deaktiviert['35']=TRUE; 	//Detects common comment types --> Findet Backslashes
					$firewall_deaktiviert['38']=TRUE; 	//Detects possibly malicious html elements including some attributes
					$firewall_deaktiviert['39']=TRUE; 	//Detects nullbytes and other dangerous characters (39)
					
					$firewall_deaktiviert['42']=TRUE; 	//Detects classic SQL injection probings 1/2 (42)
					$firewall_deaktiviert['43']=TRUE; 	//Detects classic SQL injection probings 2/2 --> Erkennt Links
					$firewall_deaktiviert['44']=TRUE; 	//Detects classic SQL injection probings 2/2 --> Erkennt Links
					$firewall_deaktiviert['45']=TRUE; 	//Detects basic SQL authentication bypass attempts 2/3 --> Erkennt Links
					$firewall_deaktiviert['46']=TRUE; 	//Detects basic SQL authentication bypass attempts 3/3
					
					$firewall_deaktiviert['57']=TRUE; 	//Detects MySQL comment-/space-obfuscated injections and backtick termination
					$firewall_deaktiviert['67']=TRUE; 	//Detects unknown attack vectors based on PHPIDS Centrifuge detection
					
					$firewall_deaktiviert['30']=TRUE; 	//Detects common XSS concatenation patterns 1/2 
					$firewall_deaktiviert['27']=TRUE; 	//Detects data: URL injections, VBS injections and common URI schemes 
					$firewall_deaktiviert['39']=TRUE; 	//Detects nullbytes and other dangerous characters
					
					$firewall_deaktiviert['61']=TRUE; 	//Detects url injections and RFE attempts (61)
					
					$firewall_deaktiviert['74']=TRUE;	//Detects remote code exectuion tests. Will match "ping -n 3 localhost" and "ping localhost -n 3" 
				}

			    if (!$result->isEmpty() and $firewall_level<>'low') {
			       	//echo $result->__toString();
			       	$firewall=$result->__toArray();
			       	foreach($firewall['details'] as $key => $value){
			       		foreach($value['details'] as $key2 => $value2){
			       			if($firewall_deaktiviert[$value2['ID']]<>TRUE){
			       				$sperrgrund.=$value2['desc'].' ('.$value2['ID'].'), ';
			       				$sperre=1;
			       			}
			       		}
			       	}
			       	//echo $sperrgrund;
			    } else {
			        //echo '<a href="?test=%22><script>eval(window.name)</script>">No attack detected - click for an example attack</a>';
			    }
			} catch (Exception $e) {
			    printf(
			        'An error occured: %s',
			        $e->getMessage()
			    );
			}

			restore_include_path();
			//echo 'Lade PHP IDS ENDE';
		}
				
		//if(file_exists($filename)
		
		$sql_sperre			= "SELECT IP FROM tri_ipsperre where (IP='$IP' or IP='$IP1_sperre' or IP='$IP2_sperre' or IP='$IP3_sperre')";// and variable<>'whitelist'
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
		
		
		if(mysql_num_rows($res)>0)
		{
			$sperre=1;
			$usergesperrt=1;
		}
		else
		{	
			//$ID und $bereichauswahl prüfen
			if(($_SERVER['PHP_SELF']=='/index.php' and is_numeric($ID)==FALSE and $ID!=null) or (is_numeric($bereichauswahl)==FALSE and $bereichauswahl!=null)){
				//$sperre="1";
				$ID="";
				$sperrgrund='Variablen ';
			}else{
				if($_SERVER['PHP_SELF']=='/index.php' and $ID>0){
					$sessionid=tri_session_ermitteln();
					$sessionwerte=tri_session_auslesen($sessionid);
					$sessionwerte['firewall_dos_time2']=$sessionwerte['firewall_dos_time1'];
					$sessionwerte['firewall_dos_time3']=$sessionwerte['firewall_dos_time2'];
					$sessionwerte['firewall_dos_time4']=$sessionwerte['firewall_dos_time3'];
					$sessionwerte['firewall_dos_time5']=$sessionwerte['firewall_dos_time4'];
					$sessionwerte['firewall_dos_time6']=$sessionwerte['firewall_dos_time5'];
					$sessionwerte['firewall_dos_time7']=$sessionwerte['firewall_dos_time6'];
					$sessionwerte['firewall_dos_time8']=$sessionwerte['firewall_dos_time7'];
					$sessionwerte['firewall_dos_time1']=time();
					//$sessionwerte['firewall_dos_time8']==$sessionwerte['firewall_dos_time7'] and $sessionwerte['firewall_dos_time7']==$sessionwerte['firewall_dos_time6'] and $sessionwerte['firewall_dos_time6']==$sessionwerte['firewall_dos_time5'] and $sessionwerte['firewall_dos_time5']==$sessionwerte['firewall_dos_time4'] and $sessionwerte['firewall_dos_time4']==$sessionwerte['firewall_dos_time3'] and $sessionwerte['firewall_dos_time3']==$sessionwerte['firewall_dos_time2'] and 
					if($sessionwerte['firewall_dos_time6']==$sessionwerte['firewall_dos_time1']){
						$sessionwerte['firewall_dos_verwarnt']++;
						if($sessionwerte['firewall_dos_verwarnt']>300){
							$sperre=1;
							$sperrgrund='DOS ';
						}
					}
					tri_session_speichern($sessionid,$sessionwerte);
				}
			}
		};
				
		if($sperre==1)
		{
			$sql = "SELECT IP FROM tri_ipsperre where (IP='$IP' or IP='$IP1_sperre' or IP='$IP2_sperre' or IP='$IP3_sperre') and variable='whitelist'";
			//echo $sql;
			$res = tri_db_query($datenbanknamecms, $sql) or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
			if(mysql_num_rows($res)==0 or $usergesperrt==1)
			{
				if($usergesperrt==0){
					foreach ($_GET as $name=>$value) {
						$sperrgrund.=$name." = ".$value." - ";
					}
					foreach ($_POST as $name=>$value) {
						$sperrgrund.=$name." = ".$value." - ";
					}
					foreach ($_COOKIE as $name=>$value) {
						$sperrgrund.=$name." = ".$value." - ";
					}
					$res = tri_db_query($datenbanknamecms, "SELECT IP FROM tri_ipsperre where IP='$IP'") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
					if(mysql_num_rows($res)==0){
						tri_db_query($datenbanknamecms, "INSERT INTO `tri_ipsperre` (`IP`,`datum`,`variable`) VALUES ('$IP','$datum','$sperrgrund');") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
					}
				};
				
				die('<html>
						<head>
							<meta http-equiv="content-type" content="text/html;charset=iso-8859-1" />
							<title>Green Screen</title>
						</head>
					
						<body bgcolor="#89c935" text="white">
							<br>
							<center>
								<div style="width: 700px; text-align: left;">
									<font face="Courier">A problem has been detected and the system has been shut down for your IP address to prevent damage on our computer.<br />
										<br />
											The problem seems to be caused by an hackattack from you computer<br />
										<br />
											ERROR_LOG_ON_OUR_DATABASE '.strtoupper(dechex(rand(9994444,499233333))).'<br />
										<br />
										If this is the first time you ve seen this stop error screen, please contact the server administrator.<br />
										<br />
											Your IP Adress has been logged and we will contact the RIPE if you attack again our network.<br />
										<br />
										*** STOP:&nbsp;0x0D (00x1337, 0x0815, V14924)<br />
										<br />
										*** config.sys
										<br />
										*** '.$IP.'
										</font></div>
							</center>
						</body>
					</html>');
			}
		};
		
		$firewall_loaded=TRUE;
	}
?>