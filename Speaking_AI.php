<?php 

/**
* Title: Talking AI Script
* Description: An Advanced Talking Computer Chat Using OpenAI ChatGPT, Google TTS, & command line tool `afplay`
* Author: Liam Hogan <liamhogan7@gmail.com>
* Date: April 18, 2023
* Reference: https://cloud.google.com/text-to-speech https://chat.openai.com/ https://platform.openai.com/account/api-keys
* Requirements: google_api_key openai_api_key afplay
**/

/* 
	How to run this script with regular PHP notation:
	php Speaking_AI.php [chat]('Ask me a question...') [pitch 0.25-4] [speakingRate] [volume 0-1] [voice] [language]
*/

global $filters;
$filters = array_fill(0, 3, null);
for($i = 1; $i < $argc; $i++) {
	$filters[$i - 1] = $argv[$i];
}
$prompt = isset($filters[0])?$filters[0]:false;
$pitch = isset($filters[1])?$filters[1]:0.7;
$speakingRate = isset($filters[2])?$filters[2]:0.3;
$volume = isset($filters[3])?$filters[3]:0.36;
$voice = isset($filters[4])?$filters[4]:'en-US-Studio-M';
$language = isset($filters[5])?$filters[5]:'en-us';
if(!$prompt) {
	echo("Run this script with regular PHP notation. Example:\n");
	echo('php ./Speaking_AI.php [chat] "Ask me a question..." [pitch] 2 [speakingRate] 2.3 [volume] 1 [voice] en-US-Studio-M [language] en-us');
	exit();
}

$openai_api_key = 'YOUR_OPENAI_API_KEY';

$url = 'https://api.openai.com/v1/chat/completions';

$post_data = [
    "model"=>"gpt-3.5-turbo",
		"messages"=>[[
			"role"=> "user", 
			"content"=> $prompt
		]]
];

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($post_data),
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $openai_api_key,
    ),
));
$response = curl_exec($curl);
curl_close($curl);

if(isset($response)){
	$data = json_decode($response, true);
    if(isset($data)){
    	print_r($data);
    	$text = $data['choices'][0]['message']['content'];
    	read($text,$language,$voice,$pitch,$speakingRate);
    }
}

function read($text,$language,$voice,$pitch,$speakingRate) {
	$file='AI_Say';
	$google_api_key = "YOUR_GOOGLE_API_KEY";
	$filename = str_replace(' ', '_', strtolower($file)).'.mp3';
	$myfile = fopen($filename, "w") or die("Unable to open file!");
	$post_data = [
		'input' => [
			'text' => $text
		],
		'voice' => [
			'languageCode' => $language,
			'name' => $voice
		],
		'audioConfig' => [
			'audioEncoding' => 'MP3',
			'pitch' => $pitch,
			'speakingRate' => $speakingRate,
		]
	];
	$url = "https://texttospeech.googleapis.com/v1/text:synthesize";
	$post = json_encode($post_data);
	$google_api_ch = curl_init();
	curl_setopt($google_api_ch, CURLOPT_URL, $url);
	curl_setopt($google_api_ch, CURLOPT_HTTPHEADER, [
		'X-Goog-Api-Key: '.$google_api_key,
		'Content-Type: application/json; charset=utf-8'
	]);
	curl_setopt($google_api_ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($google_api_ch, CURLOPT_POST,1);
	curl_setopt($google_api_ch, CURLOPT_POSTFIELDS, $post);
	$result=curl_exec( $google_api_ch );
	curl_close( $google_api_ch );
	$content = json_decode($result);
	if(isset($content->error)) {
		print_r($content->error);
	} else {
		$base64 = $content->audioContent;
		$mp3 = base64_decode($base64);
		fwrite($myfile, $mp3);
		fclose($myfile);
		chmod($filename, 0755);
		play($filename); // To play the file
		unlink($filename);
	}
}

function play($filename) {
	$volume = isset($filters[3])?$filters[3]:0.4;
	if(isset($volume)) {
		$cmd="afplay -v ".$volume." ./".$filename.";";
	} else {
		$cmd="afplay -v 0.05 ./".$filename.";";	
	}
	exec($cmd);
}
