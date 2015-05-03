<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:36:40 - Hashcode: dd8a39d263f291da5948de672481cd75 
 ?><?php

$updateserver="http://updates.tricoma.de";

//Passwort entschlüsseln
function decode($key, $chiffre)
{
    $l_k = strlen($key);
    $l_t = strlen($chiffre);
    
    if($l_k == 0) return $text; 
    
    $decoded = "";
    
    $k = 0; 
    for($i=0; $i<$l_t; $i++)
    {
        if($k > $l_k) $k = 0; 
        $decoded .= chr(ord($chiffre[$i]) ^ ord($key[$k]));
        $k++;
    }
    
    return $decoded;
}

//Passwort verschlüsseln
function encode($key, $text)
{
    $l_k = strlen($key);
    $l_t = strlen($text);
    
    if($l_k == 0) return $text; 
    
    $encoded = "";
    $k = 0; // Position im Key
    for($i=0; $i<$l_t; $i++)
    {
        if($k > $l_k) $k = 0; 
        $encoded .= chr(ord($text[$i]) ^ ord($key[$k])); 
        $k++;
    }
    return $encoded;
}


class HTTPRequest
{
   var $_fp;        // HTTP socket
   var $_url;        // full URL
   var $_host;        // HTTP host
   var $_protocol;    // protocol (HTTP/HTTPS)
   var $_uri;        // request URI
   var $_port;        // port
   
   // scan url
   function _scan_url()
   {
       $req = $this->_url;
       
       $pos = strpos($req, '://');
       $this->_protocol = strtolower(substr($req, 0, $pos));
       
       $req = substr($req, $pos+3);
       $pos = strpos($req, '/');
       if($pos === false)
           $pos = strlen($req);
       $host = substr($req, 0, $pos);
       
       if(strpos($host, ':') !== false)
       {
           list($this->_host, $this->_port) = explode(':', $host);
       }
       else 
       {
           $this->_host = $host;
           $this->_port = ($this->_protocol == 'https') ? 443 : 80;
       }
       
       $this->_uri = substr($req, $pos);
       if($this->_uri == '')
           $this->_uri = '/';
   }
   
   // constructor
   function HTTPRequest($url)
   {
       $this->_url = $url;
       $this->_scan_url();
   }
   
   // download URL to string
   function DownloadToString()
   {
       $crlf = "\r\n";
       
       // generate request
       $req = 'GET ' . $this->_uri . ' HTTP/1.0' . $crlf
           .    'Host: ' . $this->_host . $crlf
           .    $crlf;
       
       // fetch
       $this->_fp = @fsockopen(($this->_protocol == 'https' ? 'ssl://' : '') . $this->_host, $this->_port,$empty,$empty,5);
       @fwrite($this->_fp, $req);
       while(is_resource($this->_fp) && $this->_fp && !feof($this->_fp))
           $response .= @fread($this->_fp, 1024);
       @fclose($this->_fp);
       
       // split header and body
       $pos = strpos($response, $crlf . $crlf);
       if($pos === false)
           return($response);
       $header = substr($response, 0, $pos);
       $body = substr($response, $pos + 2 * strlen($crlf));
       
       // parse headers
       $headers = array();
       $lines = explode($crlf, $header);
       foreach($lines as $line)
           if(($pos = strpos($line, ':')) !== false)
               $headers[strtolower(trim(substr($line, 0, $pos)))] = trim(substr($line, $pos+1));
       
       // redirection?
       if(isset($headers['location']))
       {
           $http = new HTTPRequest($headers['location']);
           return($http->DownloadToString($http));
       }
       else 
       {
           return($body);
       }
   }
}


function chmodpfad($path, $mod, $ftp_details)
{
   // extract ftp details (array keys as variable names)
   extract ($ftp_details);
   
   // set up basic connection
   $conn_id = ftp_connect($ftp_server);
   
   // login with username and password
   $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
   echo "FTP-CHMOD $mod ";
   // try to chmod $path directory
   if (@ftp_site($conn_id, 'CHMOD 0'.$mod.' '.$ftp_root.$path) !== false) {
       $success=TRUE;
   }else{
       $success=FALSE;
   }
   if($success==TRUE){
   	echo "<font color=#b7da00> erfolgreich</font><br>";
   }else{
   	echo "<font color=#a92300> fehler</font><br>";
   };
   // close the connection
   ftp_close($conn_id);
   return $success;
}

//Updateserverfunktionen
function updateserververfuegbar(){
	$pfad="$GLOBALS[updateserver]/index.php?aktion=alive";
	$r = new HTTPRequest($pfad);
	if($r->DownloadToString()=="alive"){
		return true;
	}else{
		return false;
	};
};

function updateserververfuegbarausgabe(){
	return "<font color=red>Der Tricomaupdateserver ist derzeit leider nicht verf?gbar.<br>Bitte probieren Sie es sp?ter erneut</font>";
};

function updateserversession(){
	$lizenznummer=trieinstellungauslesen("administration","system","lizenznummer");
	$lizenzcrt=trieinstellungauslesen("administration","system","lizenzcrt");
	$lizenznehmerkey=trieinstellungauslesen("administration","system","lizenznehmerkey");
	$pfad="$GLOBALS[updateserver]/index.php?aktion=holesession&lizenznummer=$lizenznummer&lizenzcrtvar=$lizenzcrt&lizenznehmerkey=$lizenznehmerkey&IP=".$_SERVER['SERVER_ADDR']."&docroot=".$_SERVER['DOCUMENT_ROOT'];
	//echo $pfad;
	$r = new HTTPRequest($pfad);
	$session=$r->DownloadToString();
	if($session=="ungueltigelizenz"){
		return "ungueltigelizenz";
	}elseif($session<>null){
		return $session;
	}else{
		return "error";
	};
};

function lizenzaktivieren($lizenznummer,$lizenznehmerkey){
	$pfad="$GLOBALS[updateserver]/index.php?aktion=aktivieretricoma&lizenznummer=$lizenznummer&lizenznehmerkey=$lizenznehmerkey&IP=".$_SERVER['SERVER_ADDR']."&docroot=".$_SERVER['DOCUMENT_ROOT'];
	//echo $pfad;
	$r = new HTTPRequest($pfad);
	$lizenzcrt=$r->DownloadToString();
	if($session=="ungueltigelizenz" or $session=="FALSE"){
		return "ungueltigelizenz";
	}elseif($lizenzcrt<>null){
		return $lizenzcrt;
	}else{
		return "error";
	};
};


//Modulfunktionen (Info)
function rubcoder_modulname($modul){
	$pfad="$GLOBALS[updateserver]/index.php?session=$GLOBALS[serversession]&aktion=holemodulname&modul=$modul"; 
	$r = new HTTPRequest($pfad); 
	return $r->DownloadToString();
};

function rubcoder_modulbereich($modul){
	$pfad="$GLOBALS[updateserver]/index.php?session=$GLOBALS[serversession]&aktion=holemodulbereich&modul=$modul"; 
	$r = new HTTPRequest($pfad); 
	return $r->DownloadToString();
};

function rubcoder_modulbeschreibung($modul){
	$pfad="$GLOBALS[updateserver]/index.php?session=$GLOBALS[serversession]&aktion=holemodulbeschreibung&modul=$modul"; 
	$r = new HTTPRequest($pfad); 
	return $r->DownloadToString();
};

function rubcoder_modulversion($modul){
	$pfad="$GLOBALS[updateserver]/index.php?session=$GLOBALS[serversession]&aktion=holemodulversion&modul=$modul"; 
	$r = new HTTPRequest($pfad); 
	return $r->DownloadToString();
};

function rubcoder_modullegal($modul){
	$pfad="$GLOBALS[updateserver]/index.php?session=$GLOBALS[serversession]&aktion=pruefemodullegal&modul=$modul"; 
	$r = new HTTPRequest($pfad); 
	return $r->DownloadToString();
};


function rubcoder_allemoduldaten(){
	$pfad="$GLOBALS[updateserver]/index.php?session=$GLOBALS[serversession]&aktion=allemoduldaten"; 
	$r = new HTTPRequest($pfad); 
	$module_cache = explode("###", $r->DownloadToString());
	$cache=array();
	$count=0;
	while($count<500){
		if($module_cache[$count]<>null){
			$cache=explode("*#*", $module_cache[$count]);
			$module[$cache['0']]['version']=$cache['1'];
			$module[$cache['0']]['beschreibung']=$cache['2'];
			$module[$cache['0']]['legal']=$cache['3'];
		}else{
			$count=500;
		};
		$count++;
	};
	return $module;
};

function rubcoder_allegekauftenmodule(){
	$pfad="$GLOBALS[updateserver]/index.php?session=$GLOBALS[serversession]&aktion=allegekauftenmodule"; 
	$r = new HTTPRequest($pfad); 
	$module_cache = explode("###", $r->DownloadToString());
	$cache=array();
	$count=0;
	while($count<500){
		if($module_cache[$count]<>null){
			$cache=explode("*#*", $module_cache[$count]);
			$module[$count]['id']=$cache['0'];
			$module[$count]['name']=$cache['1'];
			$module[$count]['version']=$cache['2'];
			$module[$count]['beschreibung']=$cache['3'];
		}else{
			$count=500;
		};
		$count++;
	};
	return $module;
};

//Modulupdate
function rubcoder_holemoduldateien($modul){
	$pfad="$GLOBALS[updateserver]/index.php?session=$GLOBALS[serversession]&aktion=holemoduldateien&modul=$modul"; 
	$r = new HTTPRequest($pfad); 
	return $r->DownloadToString();
};

function rubcoder_holemodulordner($modul){
	$pfad="$GLOBALS[updateserver]/index.php?session=$GLOBALS[serversession]&aktion=holemodulordner&modul=$modul"; 
	$r = new HTTPRequest($pfad); 
	return $r->DownloadToString();
};

function rubcoder_holemodulsqlupdate($modul,$version){
	$pfad="$GLOBALS[updateserver]/index.php?session=$GLOBALS[serversession]&aktion=holemodulsqlupdate&modul=$modul&version=$version"; 
	$r = new HTTPRequest($pfad); 
	return $r->DownloadToString();
};

function rubcoder_holemodulsqlinstall($modul){
	$pfad="$GLOBALS[updateserver]/index.php?session=$GLOBALS[serversession]&aktion=holemodulsqlinstall&modul=$modul"; 
	$r = new HTTPRequest($pfad); 
	return $r->DownloadToString();
};

function rubcoder_holemodulrechte($modul){
	$pfad="$GLOBALS[updateserver]/index.php?session=$GLOBALS[serversession]&aktion=holemodulrechte&modul=$modul"; 
	$r = new HTTPRequest($pfad); 
	return $r->DownloadToString();
};

function rubcoder_holemodulunterbereiche($modul){
	$pfad="$GLOBALS[updateserver]/index.php?session=$GLOBALS[serversession]&aktion=holemodulunterbereiche&modul=$modul"; 
	$r = new HTTPRequest($pfad); 
	return $r->DownloadToString();
};

function rubcoder_holemoduldateiinhalt($modul,$datei){
	$pfad="$GLOBALS[updateserver]/index.php?session=$GLOBALS[serversession]&aktion=holemoduldateiinhalt&modul=$modul&datei=$datei"; 
	$r = new HTTPRequest($pfad); 
	return $r->DownloadToString();
};


?>
