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


function sederhana1($keyword) {
    $result = "HELLO PETTER";
    return $result;
}


function bott($keyword) {
    $result = "test bot";
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


function lokasi($keyword) {
    $uri = "https://time.siswadi.com/geozone/?address=" . $keyword; 
    $response = Unirest\Request::get("$uri"); 
    $json = json_decode($response->raw_body, true); 
    $parsed = array(); 
    $parsed['lat'] = $json['data']['latitude']; 
    $parsed['long'] = $json['data']['longitude']; 
	$parsed['loct1'] = $json['data']['address'];
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


    if ($command == 'creator' || $command == 'Creator' || $command == '/creator' || $command == '/Creator') {
        $result = lokasi($options);
        $balas = array(
                    'replyToken' => $replyToken,
                    'messages' => array(
                     array (
  'type' => 'template',
  'altText' => 'This is a buttons template',
  'template' => 
  array (
    'type' => 'buttons',
    'thumbnailImageUrl' => 'https://hobbydb-production.s3.amazonaws.com/processed_uploads/subject_photo/subject_photo/image/14935/1469053350-30688-5549/Creator.png',
    'imageAspectRatio' => 'rectangle',
    'imageSize' => 'cover',
    'imageBackgroundColor' => '#FFFFFF',
    'title' => 'Menu',
    'text' => 'Please select',
    'defaultAction' => 
    array (
      'type' => 'uri',
      'label' => 'View detail',
      'uri' => 'http://example.com/page/123',
    ),
    'actions' => 
    array (
      0 => 
      array (
        'type' => 'postback',
        'label' => 'Buy',
        'data' => 'action=buy&itemid=123',
      ),
      1 => 
      array (
        'type' => 'postback',
        'label' => 'Add to cart',
        'data' => 'action=add&itemid=123',
      ),
      2 => 
      array (
        'type' => 'uri',
        'label' => 'View detail',
        'uri' => 'http://example.com/page/123',
      ),
    ),
  ),
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
 
    if ($command == 'bottt') {
         
        $result = bott($options);
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

        if ($command == 'sigawe' || $command == '/Sigawe' || $command == 'Sigawe' || $command == '/sigawe'){
         
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
          'type' => 'location',
          'title' => 'my location',
          'address' => '〒150-0002 東京都渋谷区渋谷２丁目２１−１',
          'latitude' => 35.65910807942214688637250219471752643585205078125,
          'longitude' => 139.70372892916202545166015625,
                        )
                )
            );
        }


        if ($command == 'confirm'){
         
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'template',
  'altText' => 'this is a confirm template',
  'template' => 
  array (
    'type' => 'confirm',
    'text' => 'Are you sure?',
    'actions' => 
    array (
      0 => 
      array (
        'type' => 'message',
        'label' => 'Yes',
        'text' => 'yes',
      ),
      1 => 
      array (
  'type' => 'uri',
  'label' => 'View details',
  'uri' => 'http://google.com/',
  'altUri' => 
  array (
    'desktop' => 'http://google.com',
  ),
    ),
        ),
      ),
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