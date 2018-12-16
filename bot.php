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
function sederhana1($keyword) {
	$result = "HELLO PETTER";
    return $result;
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

//pesan bergambar
if($message['type']=='text') {
	
	if ($command == 'imagemap') {
		$balas = array(
			'replyToken' => $replyToken,
			'message' => array(
				array (
				'type' => 'imagemap',
				'baseUrl' => 'https://example.com/bot/images/rm001',
				'altText' => 'Imagemap',
				'baseSize' => 
				array (
					'height' => 1040,
					'width' => 1040,
				),
				'actions' => 
				array (
					0 => 
					array (
					'type' => 'message',
					'text' => '1',
					'area' => 
					array (
						'x' => 0,
						'y' => 0,
						'width' => 520,
						'height' => 1040,
					),
					),
					1 => 
					array (
					'type' => 'message',
					'text' => '2',
					'area' => 
					array (
						'x' => 520,
						'y' => 0,
						'width' => 520,
						'height' => 1040,
					),
					),
					2 => 
					array (
					'type' => 'message',
					'text' => '3',
					'area' => 
					array (
						'x' => 0,
						'y' => 0,
						'width' => 1040,
						'height' => 520,
					),
					),
					3 => 
					array (
					'type' => 'message',
					'text' => '4',
					'area' => 
					array (
						'x' => 0,
						'y' => 520,
						'width' => 1040,
						'height' => 520,
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
?>
