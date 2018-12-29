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


function instagram($keyword) {
    $uri = "https://rest.farzain.com/api/ig_profile.php?id=" . $keyword . "&apikey=fDh6y7ZwXJ24eiArhGEJ55HgA";
  
    $response = Unirest\Request::get("$uri");
  
    $json = json_decode($response->raw_body, true);
    $parsed = array();
    $parsed['a1'] = $json['info']['username'];
    $parsed['a2'] = $json['info']['bio'];
    $parsed['a3'] = $json['count']['followers'];
    $parsed['a4'] = $json['count']['following'];
    $parsed['a5'] = $json['count']['post'];
    $parsed['a6'] = $json['info']['full_name'];
    $parsed['a7'] = $json['info']['profile_pict'];
    $parsed['a8'] = "https://www.instagram.com/" . $keyword;
    return $parsed;
}

function shalat($keyword) {
    $uri = "https://time.siswadi.com/pray/" . $keyword;
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $result = "「Jadwal shalat」";
    $result .= "\nLokasi : ";
    $result .= $json['location']['address'];
    $result .= "\nTanggal : ";
    $result .= $json['time']['date'];
    $result .= "\n\nShubuh : ";
    $result .= $json['data']['Fajr'];
    $result .= "\nDzuhur : ";
    $result .= $json['data']['Dhuhr'];
    $result .= "\nAshar : ";
    $result .= $json['data']['Asr'];
    $result .= "\nMaghrib : ";
    $result .= $json['data']['Maghrib'];
    $result .= "\nIsya : ";
    $result .= $json['data']['Isha'];
    $result .= "\n\n sumber : time.siswandi.com/pray";

    return $result;
}


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
 


function tolong($keyword) {
    $result = "/help";
    return $result;
}

function ashiap($keyword) {
    $result = "keyword\n";
    $result .= "- /sop\n";
    $result .= "- /jadwal\n";
    $result .= "- /livereport";
    return $result;
}


function apakah($keyword){		#Kalau di bot Yuuko-chan ini adalah Function Apakah
    $list_jwb = array(		#ini adalah kumpulan list jawaban random yang akan keluar, bisa kalian ubah sesuka hati kalian
		'Ya',
		'Tidak',
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

function translate($keyword) {        
    $uri="https://translate.yandex.net/api/v1.5/tr.json/translate?key=trnsl.1.1.20181228T200704Z.7fb9eff9dbf5a160.a422eb8ba04807d17ca2427bc8ed1d2bdf6e4d57&text=".$keyword."&lang=id-en";
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true); 
    $result = $json['text']['0'];
    return $result;
}


function bitly($keyword) {    
    $uri = "https://api-ssl.bitly.com/v3/shorten?access_token=e75a7dfcb1ed94f5a19149ed120482e8f6367dc6&longUrl=" . $keyword;    #Ubah kata kata MASUKAN_APPID_KALIAN dengan APP ID kalian dengan cara daftar di website bitly.com, video tutorialnya ada di folder Materi -> 9 Lain Lain
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true); 
    $result = "Berhasil\nURL Asli: ";
    $result .= $json['data']['long_url'];
    $result .= "\nURL Pendek: ";
    $result .= $json['data']['url'];
    return $result;
}

#-------------------------[Function]-------------------------#
function cuaca($keyword) {
    $uri = "http://api.openweathermap.org/data/2.5/weather?q=" . $keyword . ",ID&units=metric&appid=e172c2f3a3c620591582ab5242e0e6c4";
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $result = "Ini ada Ramalan Cuaca Untuk Daerah ";
    $result .= $json['name'];
    $result .= " Dan Sekitarnya";
    $result .= "\n\nCuaca : ";
    $result .= $json['weather']['0']['main'];
    $result .= "\nDeskripsi : ";
    $result .= $json['weather']['0']['description'];
    $result .= " \n\n Sumber : openweathermap.org";
    return $result;
}

//show menu, saat join dan command /menu
if ($type == 'join') {
    $text = "Terima kasih sudah mengundang saya di grup ini";
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

if($message['type']=='text') {

    if ($command == '/tolong' || $command == 'tolong') {
         
        $result = tolong($options);
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

else if($command)
    {   
                             $balas = array(
                            'replyToken' => $replyToken,                                                        
                            'messages' => array(
                                array(
                                        'type' => 'text',                                   
                                        'text' => 'Maap keyword tidak ditemukan. silahkan ketik /keyword atau /help'                                       
                                    
                                    )
                            )
                        );
                        
    }

}


if ($command == '/keyword' || $command == 'keyword' || $command == 'Keyword') {
         
        $result = ashiap($options);
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

if($command == '/booking' || $command == 'Booking' || $command == 'booking')
    {   
                             $balas = array(
                            'replyToken' => $replyToken,                                                        
                            'messages' => array(
                                array(
                                        'type' => 'text',                                   
                                        'text' => 'http://bit.ly/jadwalbookingjarkoman'                                       
                                    
                                    )
                            )
                        );
                        
    }

}

 

if($message['type']=='text') {
    if ($command == '/instagram') { 
        
        $result = instagram($options);

        $altText2 .= "\nFollowers : " . $result['a3'];
        $altText2 .= "\nFollowing :" . $result['a4'];
        $altText2 .= "\nPost :" . $result['a5'];

        $balas = array( 
            'replyToken' => $replyToken, 
            'messages' => array( 
                array ( 
                        'type' => 'template', 
                          'altText' => 'Instagram' . $options, 
                          'template' =>  
                          array ( 
                            'type' => 'buttons', 
                            'thumbnailImageUrl' => $result['a7'], 
                            'imageAspectRatio' => 'rectangle', 
                            'imageSize' => 'cover', 
                            'imageBackgroundColor' => '#FFFFFF', 
                            'title' => $result['a6'], 
                            'text' => $altText2, 
                            'actions' =>  
                            array ( 
                              0 =>  
                              array ( 
                                'type' => 'uri', 
                                'label' => 'Check', 
                                'uri' => $result['a8'],
                              ), 
                            ), 
                          ), 
                        ) 
            ) 
        ); 
    }
}





if($message['type']=='text') {
        if ($command == '/shalat') {
        $result = shalat($options);
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



     if ($command == 'bitly' || $command == '/bitly' || $command == 'Bitly') {
         
        $result = bitly($options);
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


if ($command == 'translate' || $command == '/translate' || $command == '/terjemahan' ) {
        $result = translate($options);
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
    'title' => 'MENU CREATOR',
    'text' => 'creator by anonymousliem',
    'defaultAction' => 
    array (
      'type' => 'uri',
      'label' => 'View detail',
      'uri' => 'http://instagram.com/anonymousliem',
    ),
    'actions' => 
    array (

      0 => 
      array (
        'type' => 'uri',
        'label' => 'View detail',
        'uri' => 'http://instagram.com/anonymousliem',
      ),
    ),
  ),
)
            )
        );
    }
 
	  
     
 /*   if ($command == 'yes') {
         
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
    }*/
 
if($message['type']=='text') {
        if ($command == '/cuaca') {
        $result = cuaca($options);
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
                'text' => 'Maaf, bot tidak dapat mendeteksi pesan dari kamu, silahkan ADD terlebih dahulu'
            )
        )
    ); }
    $client->replyMessage($balas_gagal);
}




?>