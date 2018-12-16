<?php
/*
copyright @ medantechno.com
Modified @ Farzain - zFz
edited @ anonymousliem 
2018

*/

require_once('./line_class.php');
require_once('./unirest-php-master/src/Unirest.php');

$channelAccessToken = 'KXAUqsQGVu/jeOYDslFyXFx7O+yPEAWuHx4jwAoPxJPQgGKMpVLE4eXKYfqfLip4N0CvPRLmmTb7GnWMpcoZYqlbr0sC2v5baZy3SIl3gLb0Ow2gHROoiWSwPXME21iZVcsh5M/Zx6TPHa9tz4K29gdB04t89/1O/w1cDnyilFU='; 
$channelSecret = '7ea943d2a33356237c63cad58a0ef1ed'; 

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$userId 	= $client->parseEvents()[0]['source']['userId'];
$groupId 	= $client->parseEvents()[0]['source']['groupId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$timestamp	= $client->parseEvents()[0]['timestamp'];
$type 		= $client->parseEvents()[0]['type'];

$message 	= $client->parseEvents()[0]['message'];
$messageid 	= $client->parseEvents()[0]['message']['id'];

$profil = $client->profil($userId);

$pesan_datang = explode(" ", $message['text']);

$command = $pesan_datang[0]; # /shalat bandung
$options = $pesan_datang[1];
if (count($pesan_datang) > 2) {
    for ($i = 2; $i < count($pesan_datang); $i++) {
        $options .= '+';
        $options .= $pesan_datang[$i];
    }
}

#-------------------------[Function]-------------------------# # 
function shalat($keyword) { 
    $uri = "https://time.siswadi.com/pray/" . $keyword; 

    $response = Unirest\Request::get("$uri"); 

    $json = json_decode($response->raw_body, true); 
    $parsed = array(); 
    $parsed['sunrise'] = $json['data']['Sunrise']; 
    $parsed['shubuh'] = $json['data']['Fajr']; 
    $parsed['dzuhur'] = $json['data']['Dhuhr']; 
    $parsed['ashar'] = $json['data']['Asr']; 
    $parsed['maghrib'] = $json['data']['Maghrib']; 
    $parsed['isya'] = $json['data']['Isha']; 
    return $parsed; 
} 
function sederhana($keyword) {
	$belajar = "HELLO WORLD\n";
	$belajar .= "<br>";
	$belajar .= " HELLO";
    return $belajar;
}

#function text sederhana
function admin ($keyword){
	$result = "admin hari ini adalah";
	return $result;
}

#function pake public api json
function jadwalbelajar($keyword){
	$uri = "https://time.siswandi.com/pray" .$keyword; //website penyedia public api
	$response = Unirest\Request::get("$uri"); //responnya
	$json = json_decode($response->raw_body, true); //format wajib
	$result = $json['data']['Dhuhr']; //lokasi path dari api yang ingin diambil
	return $result;
}

#function dari api xml
function jadwalbelajar1($keyword){
	$uri = "https://time.siswandi.com/pray" .$keyword; //website penyedia public api
	$xml = new SimpleXMLElement($uri);
	$result = "title \n";
	$result .= $xml->entry[0]->title;
	$result .= "\n synonymous \n";
	$result .= $xml->entry[0]->synonymous;
	return $result;
}

#function text dari sebuah website
function acaratv($keyword){
$uri = "https://yuubase.herokuapp.com/acaratv.php?id=" .$keyword;
$hasil = file_get_contents($uri);
/*$result = str_replace(<br />, "\n", $hasil) ;
return $result;*/
}


#function pake return $result
function jadwalbola	($keyword){
	$uri = "https://time.siswandi.com/pray" .$keyword; //website penyedia public api
	$response = Unirest\Request::get("$uri"); //responnya
	$json = json_decode($response->raw_body, true); //format wajib
/*	$result = "jadwal chelsea jam" //lokasi path dari api yang ingin diambil
	$result .= $json['data']['Fajr'];
	return $result;*/
}

#function dengan return $parsed gunanya untuk pisah pisah berguna untuk carousel
function jadwalbola1($keyword){
	$uri = "https://time.siswandi.com/pray" .$keyword; //website penyedia public api
	$response = Unirest\Request::get("$uri"); //responnya
	$json = json_decode($response->raw_body, true); //format wajib
	$parsed = array();
	$parsed['a']=$json['data']['Fajr'];
	$parsed['b']=$json['data']['Dhuhr'];
	return $parsed;
}

#-------------------------[Function]-------------------------#
/*
//show menu, saat join dan command /menu
if ($type == 'join' || $command == 'menu') {
    $text = "HALLO SEMUA";
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $text
            )
        )
    );
}

#command list text tanpa function
if ($messages['type']=='text'){
if ($command == '/hariini') {
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
               array (
				  'type' => 'text',
				  'text' => 'Hello, world',
					)
            )
        );
    }




#tessting command sederhana pakai function	
	if ($command == '/adminn') {
		
		$result = admin($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }

	if ($command == 'yes') {
		
		$result = sederhana($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => str_replace("HELLO","HAI",$result),
                )
            )
        );
    }

}


if (isset($balas)) {
    $result = json_encode($balas);
//$result = ob_get_clean();

    file_put_contents('./balasan.json', $result);


    $client->replyMessage($balas);
}
?>*/

//show menu, saat join dan command /menu
if ($type == 'join' || $command == 'menu') {
    $text = "HALLO SEMUA";
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $text
            )
        )
    );
}

#command list text tanpa function
if ($messages['type']=='text'){
if ($command == '/hariini') {
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
               array (
				  'type' => 'text',
				  'text' => 'Hello, world',
					)
            )
        );
    }




#tessting command sederhana pakai function	
	if ($command == '/adminn') {
		
		$result = admin($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }

}


if (isset($balas)) {
    $result = json_encode($balas);
//$result = ob_get_clean();

    file_put_contents('./balasan.json', $result);


    $client->replyMessage($balas);
}
?>
