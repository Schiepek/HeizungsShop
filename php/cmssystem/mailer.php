<?php //tricoma Versionsync - Upload durch Administrator am 2014-02-28 - 13:36:57 - Hashcode: 3544d039058e6861ef95291a01201cd6 
 ?><?php

function trimailer_easy($to,$subject,$message,$absendermail,$absender,$prio,$file1='',$file1_name='',$file2='',$file2_name='',$file3='',$file3_name='',$file4='',$file4_name='',$file5='',$file5_name='',$file6='',$file6_name='',$file7='',$file7_name='',$file8='',$file8_name='',$file9='',$file9_name='',$file10='',$file10_name=''){
	$timestamp=time();
	$message=str_replace("\"",'"',$message);
	$message=str_replace("\'","'",$message);
	$file1=addslashes($file1);
	$file2=addslashes($file2);
	$file3=addslashes($file3);
	$file4=addslashes($file4);
	$file5=addslashes($file5);
	$file6=addslashes($file6);
	$file7=addslashes($file7);
	$file8=addslashes($file8);
	$file9=addslashes($file9);
	$file10=addslashes($file10);
	$message=addslashes($message);
	$subject=addslashes($subject);
	
	$sql="INSERT INTO `tri_mailer` ( `von` , `vonmail` , `anmail` , `betreff` , `inhalt` , `prio` , `timestamp`, `file1` , `file1_name` , `file2` , `file2_name` , `file3` , `file3_name` , `file4` , `file4_name` , `file5` , `file5_name`, `file6` , `file6_name`, `file7` , `file7_name`, `file8` , `file8_name`, `file9` , `file9_name`, `file10` , `file10_name` ) 
	VALUES ('$absender', '$absendermail', '$to', '$subject', '$message', '$prio', '','$file1', '$file1_name', '$file2', '$file2_name', '$file3', '$file3_name', '$file4', '$file4_name', '$file5', '$file5_name', '$file6', '$file6_name', '$file7', '$file7_name', '$file8', '$file8_name', '$file9', '$file9_name', '$file10', '$file10_name');";
	tri_db_query ($GLOBALS['datenbanknamecms'], $sql) ;
	return TRUE;
};

class trimailer{
	var $absender_name='';
	var $absender_mail='';
	var $betreff='';
	var $content='';
	var $an_kundennummer_1='';
	var $an_1_name='';
	var $an_1_mail='';
	var $datei_1_pfad='';
	var $datei_1_name='';
	var $datei_2_pfad='';
	var $datei_2_name='';
	var $mail_speichern;
	var $mandanten_ID;
	var $signatur='standard';
	var $mailid=0;

	function send(){
		if($this->absender_mail==''){
			$this->absender_mail=$GLOBALS['SMTP_STANDARD_MAIL'];
			$this->absender_name=$GLOBALS['SMTP_STANDARD_NAME'];
		}
		if(is_numeric($this->an_kundennummer_1)){
			$this->an_1_mail=kunden_datenfelder($this->an_kundennummer_1,'mailfeld');
			$this->an_1_name=kunden_namenausgabe($this->an_kundennummer_1);
			$this->content=kunden_textparsen($row['kundennummer'],$this->content);
		}
		
		if($this->datei_1_pfad<>''){
			if(file_exists($this->datei_1_pfad)==TRUE){
				$datei_inhalt=file_get_contents($this->datei_1_pfad);
				$datei_name=$this->datei_1_pfad;
				if($this->datei_1_name==''){
					$datei_name_kurz=explode('/',$datei_name);
					$datei_name_kurz=$datei_name_kurz[count($datei_name_kurz)-1];
				}else{
					$datei_name_kurz=$this->datei_1_name;
				}
			}
		}
		
		//echo $this->datei_2_pfad;
		
		if($this->datei_2_pfad<>''){
			//echo 'Pfad222';
			if(file_exists($this->datei_2_pfad)==TRUE){
				$datei_inhalt2=file_get_contents($this->datei_2_pfad);
				$datei_name2=$this->datei_2_pfad;
				if($this->datei_2_name==''){
					$datei_name_kurz2=explode('/',$datei_name2);
					$datei_name_kurz2=$datei_name_kurz2[count($datei_name_kurz2)-1];
				}else{
					$datei_name_kurz2=$this->datei_2_name;
				}
			}
		}
		
		if(is_numeric($this->mandanten_ID)==FALSE){
			$this->mandanten_ID='';
		}
		
		if($this->signatur=='standard')
		{
			if($this->mandanten_ID>0)
			{
				$this->content.=trimailvorlage_nachricht("mails_signatur".$this->mandanten_ID);
			}
			else
			{
				$this->content.=trimailvorlage_nachricht("mails_signatur");
			}
		}
		else
		{
			if(modulvorhanden('mailsimap'))
			{
				//echo $GLOBALS['edit'];
				$this->content.=trimailvorlage_nachricht("mailsimap_signatur_".$GLOBALS['edit']);
			}
			else
			{
				//$this->content.=trimailvorlage_nachricht("mails_signatur".$this->mandanten_ID);
				$this->content.=trimailvorlage_nachricht("mails_signatur".$this->mandanten_ID);
			}
		}
		
		if($this->an_1_mail<>''){
			trimailer_easy($this->an_1_mail,$this->betreff,$this->content,$this->absender_mail,$this->absender_name,9,$datei_inhalt,$datei_name_kurz,$datei_inhalt2,$datei_name_kurz2,'','','','','','');
		}
		/*if(modulvorhanden('mails')==TRUE){
			$this->content=str_replace("\"",'"',$this->content);
			$this->content=str_replace("\'","'",$this->content);
			$this->content=addslashes($this->content);
			tri_db_query ($GLOBALS['datenbanknamecms'], "INSERT INTO `mails_mails` (`von`, `von_mail`, `an`, `an_mail`, `betreff`, `datum`, `nachricht`, `spamrating`, `spamrating_desc`, `size`, `ORDNER_ID`, `ORDNER_ID_alt`, `status`, `USER_ID`, `gelesen`) 
			VALUES ('".$this->absender_name."', '".$this->absender_mail."', '".$this->an_1_name."', '".$this->an_1_mail."', '".$this->betreff."', '".time()."', '".$this->content."', '0.00', '', '0', '9', '', '2', '0', '1');");
			$mailid=mysql_insert_id();
			if($datei_name<>''){
				$datei_name_lokal=$mailid.'-1-pdf-'.md5($datei_name);
				if(file_exists('../mails/anhaenge/')){
					$datei_pfad_lokal='../mails/anhaenge/'.$datei_name_lokal;
				}else{
					$datei_pfad_lokal='cmssystem/mails/anhaenge/'.$datei_name_lokal;
				}
				 $handler = fopen($datei_pfad_lokal , "a+");
				 fwrite($handler , $datei_inhalt); 
				 fclose($handler);
				 
						 /*$finfo = finfo_open(FILEINFO_MIME_TYPE);
						 $dateityp=finfo_file($finfo, $datei_pfad_lokal);
						 finfo_close($finfo);*/
				 /*$dateityp=mime_content_type($datei_pfad_lokal);
				 $size=filesize($datei_pfad_lokal);

				tri_db_query ($GLOBALS['datenbanknamecms'], "INSERT INTO `mails_anhaenge` (`MAIL_ID`, `dateiname`, `dateiname_lokal`, `dateityp`, `size`) 
				values ('$mailid','$datei_name_kurz','$datei_name_lokal','$dateityp','$size');");
			}
			$this->mailid=$mailid;
		}*/
	}
}

function trimailer_sms($to,$message,$absender)
{
	if($absender=='')
	{
		$absender=trieinstellungauslesen("administration","system","smsabsender");
	};
	$gateway	= trieinstellungauslesen("administration","system","smsgateway");
	$gateway	= str_replace('%empf%',$to,$gateway);
	$gateway	= str_replace('%abs%',$absender,$gateway);
	$message	= urlencode($message);
	$gateway	= str_replace('%txt%',$message,$gateway);
	$handle 	= @fopen (trim($gateway), "r");
	
	if($handle)
	{
		$result 	= @fread($handle,8192);
		/*
		var_dump($gateway);
		var_dump($result);
		*/
		if(trim($result)==trieinstellungauslesen("administration","system","smsok")){
			return TRUE;
		}else{
			debugger("Fehler beim SMS Versand: $result",__FILE__,__LINE__);
			return FALSE;
		};
	}
};

function trimailer_mailbutton($an,$betreff,$text,$datei1='',$datei1name='',$datei2='',$datei2name='',$datei3='',$datei3name='',$datei4='',$datei4name='',$datei5='',$datei5name='',$icon=''){
		if($icon==''){
			$icon='/cmssystem/mails/icon_klein.png';
		}
		$count=explode('---',$text);
		if(count($count)<>3){
			$text=urlencode(string_nach_ascii($text));
		}else{
			$text=urlencode($text);
		};
		if(modulvorhanden('mailsimap')){
			return "<a href=\"#\" onclick=\"javascript:top.normalesfenster('Mailer','/cmssystem/mailsimap/eintragen.php?an=".$an."','470','800');\">
			<img src=\"$icon\" height=\"16\" border=\"0\" style=\"cursor:help;\" align=\"absmiddle\">
			</a>";
		}else{
			return "<a href=\"#\" onclick=\"javascript:top.normalesfenster('Mailer','/cmssystem/mails/eintragen.php?ascii_decode=1&an=".urlencode(string_nach_ascii($an))."&betreff=".urlencode(string_nach_ascii($betreff))."&text=".$text."&datei1=".urlencode(string_nach_ascii($datei1))."&datei1name=".urlencode(string_nach_ascii($datei1name))."&datei2=".urlencode(string_nach_ascii($datei2))."&datei2name=".urlencode(string_nach_ascii($datei2name))."&datei3=".urlencode(string_nach_ascii($datei3))."&datei3name=".urlencode(string_nach_ascii($datei3name))."&datei4=".urlencode(string_nach_ascii($datei4))."&datei4name=".urlencode(string_nach_ascii($datei4name))."&datei5=".urlencode(string_nach_ascii($datei5))."&datei5name=".urlencode(string_nach_ascii($datei5name))."','470','800');\">
			<img src=\"$icon\" height=16 border=0 style=\"cursor:help;\" align=\"absmiddle\">
			</a>";
		}
};


function trimailer_mailbutton_v2($modul,$ID,$callback,$vorlage,$icon='',$anhang=1){
		if($icon=='' and modulvorhanden('mailsimap')){
			$icon='/cmssystem/mailsimap/icon.png';
		}elseif($icon==''){
			$icon='/cmssystem/mails/icon_klein.png';
		}
		if(modulvorhanden('mailsimap')){
			return "<a onclick=\"javascript:top.normalesfenster('Mailer','/cmssystem/mailsimap/eintragen.php?modul=".$modul."&ID=".$ID."&callback=".$callback."&vorlage=".$vorlage."&anhang=".$anhang."','470','800');\">
			<img src=\"$icon\" height=\"16\" border=\"0\" style=\"cursor:help;\" align=\"absmiddle\">
			</a>";
		}else{
			return "<a onclick=\"javascript:top.normalesfenster('Mailer','/cmssystem/mails/eintragen_v2.php?modul=".$modul."&ID=".$ID."&callback=".$callback."&vorlage=".$vorlage."&anhang=".$anhang."','470','800');\">
			<img src=\"$icon\" height=\"16\" border=\"0\" style=\"cursor:help;\" align=\"absmiddle\">
			</a>";
		}
};


function trimailer_faxbutton($faxnummer,$funktion,$datei1='',$datei1name='',$icon=''){
		if($icon==''){
			$icon='/cmssystem/images/16x16/outbox_sh.png';
		}
		$count=explode('---',$text);
		if(count($count)<>3){
			$text=urlencode(string_nach_ascii($text));
		}else{
			$text=urlencode($text);
		};
		return "<a href=\"#\" onclick=\"javascript:top.normalesfenster('Fax','/cmssystem/standard/funktion_faxversand.php?ascii_decode=1&faxnummer=".entferne_buchstaben($faxnummer)."&funktion=".urlencode(string_nach_ascii($funktion))."&datei=".urlencode(string_nach_ascii($datei1))."&dateiname=".urlencode(string_nach_ascii($datei1name))."','150','400');\">
		<img src=\"$icon\" height=\"16\" border=\"0\" style=\"cursor:help;\" align=\"absmiddle\"></a>";
};

function trimailer_briefbutton($funktion,$datei1='',$datei1name='',$icon=''){
		if($icon==''){
			$icon='/cmssystem/images/16x16/document_up.png';
		}
		$count=explode('---',$text);
		if(count($count)<>3){
			$text=urlencode(string_nach_ascii($text));
		}else{
			$text=urlencode($text);
		};
		return "<a href=\"#\" onclick=\"javascript:top.normalesfenster('Brief','/cmssystem/standard/funktion_briefversand.php?ascii_decode=1&faxnummer=".entferne_buchstaben($faxnummer)."&funktion=".urlencode(string_nach_ascii($funktion))."&datei=".urlencode(string_nach_ascii($datei1))."&dateiname=".urlencode(string_nach_ascii($datei1name))."','150','400');\">
		<img src=\"$icon\" height=\"16\" border=\"0\" style=\"cursor:help;\" align=\"absmiddle\"></a>";
};

?>