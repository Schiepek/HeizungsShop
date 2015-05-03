<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:37:07 - Hashcode: 8c60169c42211214448a2308c8d580dc 
 ?><?php 
	$domain="http://".str_replace("www.","",$_SERVER["HTTP_HOST"]);
	$urlsql="url='$domain' ";
	$count=2;
	while($count<=20){
		$urlsql.=" or url$count='".$domain."' ";
		$count++;
	};
	$meta_description="";

	$res2 = tri_db_query("$datenbanknamecms", "SELECT ID FROM bereich_page where ($urlsql) and papierkorb='0'") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
	if(mysql_num_rows($res2)==0){
		$domain="http://*";
		$urlsql="url='$domain' ";
		$count=2;
		while($count<=20){
			$urlsql.=" or url$count='".$domain."' ";
			$count++;
		};
	};

	$res2 = tri_db_query("$datenbanknamecms", "SELECT * FROM bereich_page where ($urlsql) and papierkorb='0'") or error_mysql_debugger(mysql_error(),__FILE__,__LINE__);
	while ($row2 = mysql_fetch_array ($res2))
	{		
		$hptitel=$row2['titel'];
		$hptitel2=$row2['titel'];
		$pageid=$row2['ID'];
		$standardmail=$row2['mail'];
		$template=$row2['template'];
		$meta_keywords=XHTML2string($row2['meta_keywords']);
		$meta_keywords_webseite=XHTML2string($row2['meta_keywords']);
		$page_land=$row2['land'];
		$meta_autor=XHTML2string($row2['meta_autor']);
		$meta_publisher=XHTML2string($row2['meta_publisher']);
		$meta_copyright=XHTML2string($row2['meta_copyright']);
		$meta_pagetopic=XHTML2string($row2['meta_pagetopic']);
		$meta_pagetyp=XHTML2string($row2['meta_pagetyp']);
		$wechselfarbe1=$row2['template_wechselfarbe1'];
		$wechselfarbe2=$row2['template_wechselfarbe2'];
		$onlinefreigabe=$row2['onlinefreigabe'];
		$hauptdomain=$row2['url'];
	};
	//print_r($_SERVER);
	if($hauptdomain<>$domain and $hauptdomain<>'' and $hauptdomain<>'http://*'){
		header("Location: ".$hauptdomain.$_SERVER['REQUEST_URI']);
	}
	$domain="http://".str_replace("www.","",$_SERVER["HTTP_HOST"]);

?>