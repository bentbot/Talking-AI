<?php 

/**
* Title: Talking AI Script
* Author: Liam Hogan <bentbot@outlook.com>
* Date: April 18, 2023
* Reference: https://cloud.google.com/text-to-speech https://chat.openai.com/
* Required: afplay/ffplay google_api_key openai_api_key
**/

/* 
	Run this script with regular PHP notation. Ex.
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
$volume = isset($filters[3])?$filters[3]:1;
$voice = isset($filters[4])?$filters[4]:'en-US-Studio-M';
$language = isset($filters[5])?$filters[5]:'en-us';
if(!$prompt) {
	echo("Run this script with regular PHP notation. Example:\n");
	echo('php ./Speaking_AI.php [chat] "Ask me a question..." [pitch] 2 [speakingRate] 2.3 [volume] 1 [voice] en-US-Studio-M [language] en-us');
	exit();
} else if ($prompt=='--voices') {
	available_voices(false); exit();
} else if ($voice=='random') {
	$voice = available_voices(true);
}

$openai_api_key = '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';

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
    	$text = $data['choices'][0]['message']['content'];
    	echo("\n	".$text."\n\n");
    	read($text,$language,$voice,$pitch,$speakingRate);
    }
}

function read($text,$language,$voice,$pitch,$speakingRate) {
	$file='ai_speaking';
	$google_api_key = "AIzaSyCALjIlUt0tA6cLwBO20-kG1wYINUf-oNE";
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
		if($content->error->message!='This request contains sentences that are too long.')
			print_r($content->error->message);
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
	$volume = isset($filters[3])?$filters[3]:1;
	if(isset($volume)) {
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			$cmd="ffplay -v 0 -volume ".$volume." -nodisp -autoexit ".$filename;
		} else {
			$cmd="afplay -v ".$volume." ./".$filename.";";
		}
	} else {
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			$cmd="ffplay -v 0 -volume 1 -nodisp -autoexit ".$filename;
		} else {
			$cmd="afplay -v 1 ./".$filename.";";	
		}
	}
	exec($cmd);
}

function available_voices($rand) {
	$voices = [
		"en-US-Neural2-A",
		"en-US-Neural2-C",
		"en-US-Neural2-D",
		"en-US-Neural2-E",
		"en-US-Neural2-F",
		"en-US-Neural2-G",
		"en-US-Neural2-H",
		"en-US-Neural2-I",
		"en-US-Neural2-J",
		"en-US-Studio-M",
		"en-US-Studio-O",
		"en-US-Wavenet-G",
		"en-US-Wavenet-H",
		"en-US-Wavenet-I",
		"en-US-Wavenet-J",
		"en-US-Wavenet-A",
		"en-US-Wavenet-B",
		"en-US-Wavenet-C",
		"en-US-Wavenet-D",
		"en-US-Wavenet-E",
		"en-US-Wavenet-F",
		"en-US-News-K",
		"en-US-News-L",
		"en-US-News-M",
		"en-US-News-N",
		"en-US-Standard-A",
		"en-US-Standard-B",
		"en-US-Standard-C",
		"en-US-Standard-D",
		"en-US-Standard-E",
		"en-US-Standard-F",
		"en-US-Standard-G",
		"en-US-Standard-H",
		"en-US-Standard-I",
		"en-US-Standard-J",
	];
	if(true){
		$r=rand(0,count($voices)-1);
		return $voices[$r];
	} else {
		print_r(" Available voices:\n");
		foreach ($voices as $key => $value) print_r("  ".$value."\n");
	}
}
