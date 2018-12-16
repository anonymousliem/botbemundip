<?php
/*
copyright @ medantechno.com
Modified @ Farzain - zFz
2017
 
*/
 
require_once('./line_class.php');
require_once('./unirest-php-master/src/Unirest.php');
 
$channelAccessToken = 'KXAUqsQGVu/jeOYDslFyXFx7O+yPEAWuHx4jwAoPxJPQgGKMpVLE4eXKYfqfLip4N0CvPRLmmTb7GnWMpcoZYqlbr0sC2v5baZy3SIl3gLb0Ow2gHROoiWSwPXME21iZVcsh5M/Zx6TPHa9tz4K29gdB04t89/1O/w1cDnyilFU='; 
$channelSecret = '7ea943d2a33356237c63cad58a0ef1ed'; 


$client = new LINEBotTiny($channelAccessToken, $channelSecret);
 
$userId     = $client->parseEvents()[0]['source']['userId'];
$groupId    = $client->parseEvents()[0]['source']['groupId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$timestamp  = $client->parseEvents()[0]['timestamp'];
$type       = $client->parseEvents()[0]['type'];
 
$message    = $client->parseEvents()[0]['message'];
$messageid  = $client->parseEvents()[0]['message']['id'];
$profil = $client->profil($userId);
$profileName    = $profil->displayName;
$profileURL     = $profil->pictureUrl;
$profielStatus  = $profil->statusMessage;
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
function tts($keyword) {        
    $uri = "https://translate.google.com/translate_tts?ie=UTF-8&tl=id-ID&client=tw-ob&q=" . $keyword; 
    $result = $uri; 
    return $result; 
}
 
function tts2($keyword) {        
    $uri = "https://translate.google.com/translate_tts?ie=UTF-8&tl=en-ID&client=tw-ob&q=" . $keyword; 
    $result = $uri; 
    return $result; 
} 
 
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
    $belajar = "Y";
    return $belajar;
}
function sederhana1($keyword) {
    $result = "HELLO PETTER";
    return $result;
}

function apakah($keyword){		#Kalau di bot Yuuko-chan ini adalah Function Apakah
    $list_jwb = array(		#ini adalah kumpulan list jawaban random yang akan keluar, bisa kalian ubah sesuka hati kalian
		'Ya',
		'Tidak',
		'Bisa jadi',
		'Tentu tidak',
		);
    $jaws = array_rand($list_jwb);
    $jawab = $list_jwb[$jaws];
    return($jawab);
}


function lokasi($keyword) { 	#Kalau di bot Yuuko-chan ini adalah Function /lokasi, PUBLIC API ini dapat dari website maps.google.com
    $uri = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=" . $keyword; 
    $response = Unirest\Request::get("$uri"); 
    $json = json_decode($response->raw_body, true); 
    $parsed = array(); 
    $parsed['lat'] = $json['results']['0']['geometry']['location']['lat']; 
    $parsed['long'] = $json['results']['0']['geometry']['location']['lng']; 
	$parsed['loct1'] = $json['results']['0']['address_components']['0']['long_name'];
    return $parsed; 
}

function kosan($keyword) { 	#Kalau di bot Yuuko-chan ini adalah Function /lokasi, PUBLIC API ini dapat dari website maps.google.com
    $uri = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=kos%20sigawe%20ceria%2014"; 
    $response = Unirest\Request::get("$uri"); 
    $json = json_decode($response->raw_body, true); 
    $parsed = array(); 
    $parsed['lat'] = $json['results']['0']['geometry']['location']['lat']; 
    $parsed['long'] = $json['results']['0']['geometry']['location']['lng']; 
	$parsed['loct1'] = $json['results']['0']['address_components']['0']['long_name'];
    return $parsed; 
}
#-------------------------[Function]-------------------------#
 
 
 
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
 
     if ($command == 'apakah' || $command == 'Apakah' || $command == '/apakah') {
         
        $result = apakah($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result,
                )
            )
        );
    }

	
     
    if ($command == 'say' || $command == 'Say' || $command == '/say' || $command == '/Say') {
        $result = tts($options);
        $balas = array(
                    'replyToken' => $replyToken,
                    'messages' => array(
                                    array (
  'type' => 'audio',
  'originalContentUrl' => $result,
  'duration' => 60000,
)
            )
        );
    }
	
    if ($command == 'say en' || $command == '/sayen' || $command == '/say en' || $command == '/Say en' || $command == 'Say en') {
        $result = tts2($options);
        $balas = array(
                    'replyToken' => $replyToken,
                    'messages' => array(
                                    array (
  'type' => 'audio',
  'originalContentUrl' => $result,
  'duration' => 60000,
)
            )
        );
    }
	
	  if ($command == 'lokasi' || $command == 'Lokasi' || $command == '/lokasi' || $command == '/Lokasi') {
        $result = lokasi($options);
        $balas = array(
                    'replyToken' => $replyToken,
                    'messages' => array(
                                   	 array (
						'id' => '325708',
						'type' => 'location',
						'title' => $options,
						'address' => $result['loct1'],
						'latitude' => $result['lat'],
						'longitude' => $result['long'],
					)
            )
        );
    }
 
	  if ($command == 'kosan sigawe') {
        $balas = array(
                    'replyToken' => $replyToken,
                    'messages' => array(
                                   	 array (
						    'type' => 'location',
							'title' => 'Kosan Sigawe',
							'address' => 'Gg. Sigawe No. 14, Tembalang, Kota Semarang, Jawa Tengah 50275',
							'latitude' => -7.057101,
							'longitude' => 110.441235,
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
                    'text' => $result,
                )
            )
        );
    }
 
if (isset($balas)) {
    $result = json_encode($balas);
    file_put_contents('./balasan.json', $result);
    if ($profileName) {
        $client->replyMessage($balas);
    } elseif($type == 'join') {
        $client->replyMessage($balas);
    } else {
    $balas_gagal = array(
        'replyToken' => $replyToken,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => 'Maaf, Anonymousliem tidak dapat mendeteksi pesan dari kamu, silahkan ADD terlebih dahulu anonymousliem'
            )
        )
    ); }
    $client->replyMessage($balas_gagal);
}
?>