<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:35:56 - Hashcode: c032a5fe4bc09c72966acf3c63cff5ae 
 ?><?php
	//error_reporting(E_ALL); 
	//ini_set('display_errors','On');
	
	if (!get_magic_quotes_gpc()) 
	{
   	 	function request_addslashes(&$value, $key) 
		{
			$value 		= addslashes($value);
		}
		$request_array 	= array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST, &$_SERVER);
	   	array_walk_recursive($request_array, 'request_addslashes');
	}
	else
	{
		/*
		function magicQuotes_awStripslashes(&$value, $key) {$value = stripslashes($value);}
    	$gpc = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
   	 	array_walk_recursive($gpc, 'magicQuotes_awStripslashes');
   	 	*/
	}

	/*
	foreach ($_POST as $key => $value)
	{
		if (!is_null($value) && !is_array($value) )
		{
			$_POST[$key] = addslashes($value);
		}
	};
	foreach ($_GET as $key => $value)
	{
		if (!is_null($value) && !is_array($value) )
		{
			$_GET[$key]	= addslashes($value);
		}
	};
	foreach ($_REQUEST as $key => $value)
	{
		if (!is_null($value) && !is_array($value) )
		{
			$_REQUEST[$key] = addslashes($value);
		}
	};
	foreach ($_SERVER as $key => $value)
	{
		if (!is_null($value) && !is_array($value) )
		{
			$_SERVER[$key]=addslashes($value);
		}
	};
	*/

	/*if (!ini_get('register_globals')) 
	{ */
	/*foreach ($_POST as $key => $value)
	{
		if(isset($GLOBALS[$key])==FALSE or $key=='ID')
		{
			$GLOBALS[$key]=$value;
		}
	};
	
	foreach ($_GET as $key => $value)
	{
		if(isset($GLOBALS[$key])==FALSE or $key=='ID')
		{
			$GLOBALS[$key]=$value;
		}
	};*/
		
	foreach ($_REQUEST as $key => $value)
	{
		if(substr($key,0,8)<>'firewall'){
			$GLOBALS[$key]=$value;
		}
	};
	//}
	
	if(substr($_SERVER['DOCUMENT_ROOT'],-1,1)<>'/'){
		$_SERVER['DOCUMENT_ROOT'].='/';
	}
	
	$tri_standard_pfad=$_SERVER['DOCUMENT_ROOT'].'/cmssystem/standard/';
	require_once($tri_standard_pfad.'funktionen.tricoma.php');
	require_once($tri_standard_pfad.'funktionen.tri_array.php');
	require_once($tri_standard_pfad.'funktionen.tri_connect.php');
	require_once($tri_standard_pfad.'funktionen.tri_dateisystem.php');
	require_once($tri_standard_pfad.'funktionen.tri_datenbank.php');
	require_once($tri_standard_pfad.'funktionen.tri_geo.php');
	require_once($tri_standard_pfad.'funktionen.tri_kalender.php');
	require_once($tri_standard_pfad.'funktionen.tri_session.php');
	require_once($tri_standard_pfad.'funktionen.tri_sicherheit.php');
	require_once($tri_standard_pfad.'funktionen.tri_statistik.php');
	require_once($tri_standard_pfad.'funktionen.tri_text.php');
	require_once($tri_standard_pfad.'funktionen.tri_wawi.php');
	if(file_exists($tri_standard_pfad.'funktionen.tri_export.php'))
	{
		require_once($tri_standard_pfad.'funktionen.tri_export.php');
	}
	
?>