<?php

$datei_name = 'camt054.xml';

if (@file_exists($datei_name) == true) {
	if (@unlink($datei_name) == true) {
	} else {
	}
} else {
}

if(isset($_POST['send']) && $_POST['send'] == "1"){

	if(move_uploaded_file($_FILES['userfile']['tmp_name'], '' . $datei_name)){
	}
	else{
		echo "Fehler beim Hochladen der Datei. Fehlermeldung:\n<br />";
		print_r($_FILES);
	}
}

$file = $datei_name;
$inhalt = file_get_contents( $file );

$xml = simplexml_load_string($inhalt, "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xml);
$array = json_decode($json,TRUE);

//print_r ($array);

// Gruppen Kopf
$NachrichtID				=	$array["BkToCstmrDbtCdtNtfctn"]["GrpHdr"]["MsgId"];
$HergestelltDatum			=	date("d.m.Y H:i", strtotime($array["BkToCstmrDbtCdtNtfctn"]["GrpHdr"]["CreDtTm"]));
$AnzahlSeiten				=	$array["BkToCstmrDbtCdtNtfctn"]["GrpHdr"]["MsgPgntn"]["PgNb"];
$LetzteSeite				=	$array["BkToCstmrDbtCdtNtfctn"]["GrpHdr"]["MsgPgntn"]["LastPgInd"];
$DetailInfo					=	$array["BkToCstmrDbtCdtNtfctn"]["GrpHdr"]["AddtlInf"];

// Nachrichten Daten
$BenachrichtigungID			=	$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Id"];
$ErstellungsDatum			=   date("d.m.Y", strtotime($array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["CreDtTm"]));
$ZeitraumVon				=	date("d.m.Y H:i", strtotime($array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["FrToDt"]["FrDtTm"]));
$ZeitraumBis				=	date("d.m.Y H:i", strtotime($array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["FrToDt"]["ToDtTm"]));
$IBANEmpfaenger				=	$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Acct"]["Id"]["IBAN"];
$NameEmpfaenger				=	$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Acct"]["Ownr"]["Nm"];

// Einzel Daten
$TeilnehmernummerNr			=	$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryRef"];
$TotalUeberweisungen		=	$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["Amt"];
$SollHabenIndikator			=	$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["CdtDbtInd"];

// Transaction Details
$TeilnehmernummerNr			=	$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryRef"];
$TotalUeberweisungen		=	$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["Amt"];
$SollHabenIndikator			=	$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["CdtDbtInd"];
$AnzahlBuchungen			=	$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["Btch"]["NbOfTxs"];


// Einzelne Transationen
$AcctSvcrRef				=	$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][0]["Refs"]["AcctSvcrRef"];
$PmtInfId					=	$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][0]["Refs"]["PmtInfId"];
$EndToEndId 				=	$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["Btch"]["NbOfTxs"];
$Prtry_Tp					=	$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][0]["Refs"]["Prtry"]["Tp"];
$Prtry_Ref					=	$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][0]["Refs"]["Prtry"]["Ref"];

// AddtlNtryInf
$AddtlNtryInf				=	$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["AddtlNtryInf"];


echo '<link rel="stylesheet" type="text/css" href="style.css">';
echo '<table class="blueTable">';
echo '<tr class="row">
<th>Erstellungs Datum:</th>
<th>Nachricht ID:</th>
<th>Hergestellt Datum</th>
<th>Anzahl Seiten</th>
<th>Letzte Seite</th>
<th>Detail Info</th>
<th>Benachrichtigungs ID:</th>
<th>Teilnehmernummer Nr:</th>
</tr>';

echo '<tr>
<td>'			. $ErstellungsDatum .'</td>
<td>'			. $NachrichtID .'</td>
<td>'			. $HergestelltDatum .'</td>
<td>'			. $AnzahlSeiten .'</td>
<td>'			. $LetzteSeite .'</td>
<td>'			. $DetailInfo .'</td>
<td>'			. $BenachrichtigungID .'</td>
<td>'			. $TeilnehmernummerNr .'</td>
</tr>';
echo '</table>';

echo '<br>';

echo '<link rel="stylesheet" type="text/css" href="style.css">';
echo '<table class="blueTable">';
echo '<tr class="row">
<th>Von Datum:</th>
<th>Bis Datum:</th>
<th>IBAN Empfänger:</th>
<th>Name Empfänger:</th>
<th>Total Überweisungen:</th>
<th>Soll/Haben Indikator:</th>
<th>Total Buchungen:</th>
</tr>';
echo '<tr>

<td>'			. $ZeitraumVon .'</td>
<td>'			. $ZeitraumBis .'</td>
<td>'			. $IBANEmpfaenger .'</td>
<td>'			. $NameEmpfaenger .'</td>
<td>'			. $TotalUeberweisungen .'</td>
<td>'			. $SollHabenIndikator .'</td>
<td>'			. $EndToEndId .'</td>
</tr>';
echo '</table>';

echo '<br>';
echo '<br>';
/*

echo "Nachricht-ID: " . $NachrichtID . "<br>";
echo "Hergestellt-Datum: " . $HergestelltDatum . "<br>";
echo "Anzahl Seiten: " . $AnzahlSeiten . "<br>";
echo "Letzte Seite: " . $LetzteSeite . "<br>";
echo "Detail Info: " . $DetailInfo . "<br>";

echo "Benachrichtigungs-ID: " . $BenachrichtigungID . "<br>";
echo "Erstellungs-Datum: " . $ErstellungsDatum . "<br>";
echo "Von Datum: " . $ZeitraumVon . "<br>";
echo "Bis Datum: " . $ZeitraumBis . "<br>";
echo "IBAN Empfänger: " . $IBANEmpfaenger . "<br>";
echo "Name Empfänger: " . $NameEmpfaenger . "<br>";

echo "Teilnehmernummer Nr: " . $TeilnehmernummerNr . "<br>";
echo "Total Überweisungen: " . $TotalUeberweisungen . "<br>";
echo "Soll/Haben Indikator: " . $SollHabenIndikator . "<br>";

echo "PmtInfId: " . $PmtInfId . "<br>";
echo "EndToEndId: " . $EndToEndId . "<br>";

echo "Prtry_Tp: " . $Prtry_Tp . "<br>";
echo "Prtry_Ref: " . $Prtry_Ref . "<br>";
echo "Amt: " . $Amt . "<br>";
echo "CdtDbtInd: " . $CdtDbtInd . "<br>";
echo "Domn_Cd: " . $Domn_Cd . "<br>";
echo "Domn_Fmly: " . $Domn_Fmly . "<br>";
echo "Domn_Fmly_Cd: " . $Domn_Fmly_Cd . "<br>";
echo "Domn_Fmly_SubFmlyCd: " . $Domn_Fmly_SubFmlyCd . "<br>";
echo "Nm: " . $Nm . "<br>";
echo "StrtNm: " . $StrtNm . "<br>";
echo "BldgNb: " . $BldgNb . "<br>";
echo "PstCd: " . $PstCd . "<br>";
echo "TwnNm: " . $TwnNm . "<br>";
echo "Ctry: " . $Ctry . "<br>";
echo "IBAN: " . $IBAN . "<br>";
echo "BICFI: " . $BICFI . "<br>";
echo "FinInstnId_Nm: " . $FinInstnId_Nm . "<br>";
echo "PstlAdr_AdrLine1: " . $PstlAdr_AdrLine1 . "<br>";
echo "PstlAdr_AdrLine2: " . $PstlAdr_AdrLine2 . "<br>";
echo "CdOrPrtry_Prtry: " . $Prtry . "<br>";
echo "RefNr: " . $RefNr . "<br>";
echo "PstlAdr_AdrLine2: " . $AddtlRmtInf . "<br>";
echo "AccptncDtTm: " . $AccptncDtTm . "<br>";

print_r ($array["BkToCstmrDbtCdtNtfctn"]["GrpHdr"]["MsgId"]);
print_r ($array["BkToCstmrDbtCdtNtfctn"]["GrpHdr"]["MsgId"]);

*/

echo '<link rel="stylesheet" type="text/css" href="style.css">';
echo '<table class="blueTable">';
echo '<tr class="row">
<th>Lastschriftdatum</th>
<th>Firmen Adresse</th>
<th>IBAN</th>
<th>Bank Name</th>
<th>BICFI</th>
<th>Referenz Nr.</th>
<th>Betrag</th>
<th>Gebüren</th>
</tr>';
foreach($array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"] as $key => $value){

	echo '<tr><td>'.date("d.m.Y", strtotime($array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][$key]["RltdDts"]["AccptncDtTm"])).'
	         </td>
          <td>'.$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][$key]["RltdPties"]["Dbtr"]["Nm"].'<br>'
		       .$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][$key]["RltdPties"]["Dbtr"]["PstlAdr"]["AdrLine"]["0"].'<br>'
			   .$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][$key]["RltdPties"]["Dbtr"]["PstlAdr"]["AdrLine"]["1"].'<br>'
			   .$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][$key]["RltdPties"]["Dbtr"]["PstlAdr"]["StrtNm"].'
			  '.$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][$key]["RltdPties"]["Dbtr"]["PstlAdr"]["BldgNb"].'<br>'
			   .$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][$key]["RltdPties"]["Dbtr"]["PstlAdr"]["PstCd"].'
			  '.$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][$key]["RltdPties"]["Dbtr"]["PstlAdr"]["TwnNm"].'
		  <td>'.$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][$key]["RltdPties"]["DbtrAcct"]["Id"]["IBAN"].'
		 </td>
		  <td>'.$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][$key]["RltdAgts"]["DbtrAgt"]["FinInstnId"]["Nm"].'<br>'
			   .$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][$key]["RltdAgts"]["DbtrAgt"]["FinInstnId"]["PstlAdr"]["AdrLine"]["0"].'<br>'
			   .$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][$key]["RltdAgts"]["DbtrAgt"]["FinInstnId"]["PstlAdr"]["AdrLine"]["1"].'
	     </td>
		  <td>'.$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][$key]["RltdAgts"]["DbtrAgt"]["FinInstnId"]["BICFI"].'
	     </td>
		  <td><b><a href="../rechnung_eser.php?txtFirma='.substr($array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][$key]["RmtInf"]["Strd"]["CdtrRefInf"]["Ref"], 0, -1).'" target="_top">'.substr($array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][$key]["RmtInf"]["Strd"]["CdtrRefInf"]["Ref"], 0, -1).'</b>
	     </td>
		  <td>'.$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][$key]["Amt"].'
		 </td>
		  <td>'.$array["BkToCstmrDbtCdtNtfctn"]["Ntfctn"]["Ntry"]["NtryDtls"]["TxDtls"][$key]["Chrgs"]["TtlChrgsAndTaxAmt"].'
	     </td>
	  </tr>';
}
echo '</table>';

echo "<br>";
echo "Abschluss Info: " . $AddtlNtryInf . "<br>";

?>

<button onclick="window.print()">Drucken</button> 