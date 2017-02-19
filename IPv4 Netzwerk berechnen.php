<?php
//IP
$ip1 = '172.16.20.96';
$ip1array = explode('.', $ip1);
$ip1arr = [];
//IP in Binär umwandeln
for($i = 0; $i < 4; $i++){
	$ip1arr[] = sprintf('%08b',  $ip1array[$i]);
}
$iparr1 = str_split(implode($ip1arr), 1);
//Subnetzmaske
$ip2 = '255.255.248.0';
$ip2array = explode('.', $ip2);
$ip2arr = [];
//Subnetzmaske in Binär umwandeln
for($i = 0; $i < 4; $i++){
	$ip2arr[] = sprintf('%08b',  $ip2array[$i]);
}
$netzanteil = implode($ip2arr);
$iparr2 = str_split(implode($ip2arr), 1);
//Hostanteil abtrennen
for($i = 0; $i < 32; $i++){
	if($iparr2[$i] == 1){
	}
	else{
		$trennung = $i;
		break;
	}
}
////////////////////////
$netzwerk = (32 - $trennung);
for($i = 0; $i < 3; $i++){
	if($netzwerk > 8){
		$netzanteil = substr($netzanteil, 0, -8);
		$netzwerk = $netzwerk - 8;
	}else{
	break;
	}
}
$trenner = $trennung;
for($i = 0; $i < 3; $i++){
	if(($trenner / 8) > 1){
		$trenner = $trenner - 8;
		$netzanteil = substr($netzanteil, 8);
	}else{
		break;
	}
}
$netzcount = 0;
$netzanteil = str_split($netzanteil, 1);
for($i = 0; $i < 8; $i++){
	if($netzanteil[$i] == 1){
		$netzcount = $netzcount + 1;
	}else{
		break;
	}
}
//Hostanteil berechnen
for($i = 0; $i < $trennung; $i++){
	if($iparr1[$i] == 0){
		$iphost[$i] = 0;
	}
	else{
		$iphost[$i] = 1;
	}
}
//Hostanteil berechnen
for($i = $trennung; $i < 32; $i++){
	if($iparr1[$i] == 0){
		$ipnetz[$i] = 0;
	}
	else{
		$ipnetz[$i] = 1;
	}
}
$host = 0;
$hoch = 0;
//Host Nummer berechnen
for($i = 31; $i >= $trennung; $i--){
	if($iparr1[$i] == 1){
			$host = $host + (2 ** $hoch);
	}
	$hoch = $hoch + 1;
}
//Netzadresse berechnen
$netzbin = str_pad(implode($iphost), 32, '0');
$netz = str_split($netzbin, 8);
for($i = 0; $i < 4; $i++){
	$netzdec[] = bindec($netz[$i]);
}
//Zu Binär
$netzbiner = $netzbin;
$netzaddressebin = (implode('.', $netz));
//Ersten Host berechnen
$netzadresse = $netzdec;
$netzdec[3] = $netzdec[3] + 1;
//Broadcast berechnen
$netzbin = str_pad(implode($iphost), 32, '1');
$netz = str_split($netzbin, 8);
for($i = 0; $i < 4; $i++){
	$broad[] = bindec($netz[$i]);
}
//Letzten Host berechnen
$broadcast = $broad;
$broad[3] = $broad[3] - 1;
//Anzahl Netze berechnen
//2^Subnetbits -2
$netzanzahl = (2 ** $netzcount) - 2;
//Anzahl Hosts berechnen
//2^Hostbits -2
$hostanzahl = 32 - $trennung;
$hostanzahl = (2 ** $hostanzahl) - 2;
//Host Nr berechnen
echo 'Test<code>test</code>';
echo 'IP Binär: <pre>'.(implode('.', $ip1arr)).'</pre>';
echo 'Netzmaske Binär: <pre>'.(implode('.', $ip2arr)).'</pre>';
echo 'Netwerkbits des letzten Oktetts: <pre>'.$netzcount.'</pre>';
echo 'Netzaddresse Binär: <pre>'.$netzaddressebin.'</pre>';
echo 'Netzadresse: <pre>'.implode('.', $netzadresse).'</pre>';
echo 'Erster Host: <pre>'.implode('.', $netzdec).'</pre>';
echo 'Host Nummer: <pre>'.$host.'</pre>';
echo 'Letzter Host: <pre>'.implode('.', $broad).'</pre>';
echo 'Broadcast: <pre>'.implode('.', $broadcast).'</pre>';
echo 'Anzahl Netze: <pre>'.$netzanzahl.'</pre>';
echo 'Anzahl hosts: <pre>'.$hostanzahl.'</pre>';
echo 'CIDR: <pre>/'.$trennung.'</pre>';
?>