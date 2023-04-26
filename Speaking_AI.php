<?php 

/**
* Title: Talking AI Script
* Author: L. Hogan <bentbot@outlook.com>
* Date Created: April 18, 2023
* Last Updated: April 25, 2023
* References: https://chat.openai.com/ https://cloud.google.com/text-to-speech
* Requirements: OpenAI API Key, Google TTS API Key, afplay / ffmpeg
* Description:
*  Run this script with regular PHP notation. Ex.
*	$ php Speaking_AI.php [chat 'Ask me a question...'] [pitch 0.25-4] [speakingRate 0-2] [volume 0-1] [voice] [language]
*  Or move ./ai to /usr/local/bin to be able to run with the shortcut. Ex.
*   $ ai tell me the top ten hair bands of the seventies
**/

$openai_api_key = 'OPEN_API_KEY';

if(getenv("OPEN_AI_API_KEY") !== false) {
	$openai_api_key=getenv('OPEN_AI_API_KEY');
}
global $filters;
$filters = array_fill(0, 3, null);
for($i = 1; $i < $argc; $i++) {
	$filters[$i - 1] = $argv[$i];
}
$prompt = isset($filters[0])?$filters[0]:false;
$pitch = isset($filters[1])?$filters[1]:0.87;
$speakingRate = isset($filters[2])?$filters[2]:0.9;
$volume = isset($filters[3])?$filters[3]:0.60556;
$voice = isset($filters[4])?$filters[4]:'en-US-Neural2-H';
$file = isset($filters[5])?$filters[5]:'ai_speaking';
$language = isset($filters[6])?$filters[6]:'en-us';
$muting = ( $pitch === false || $speakingRate === false || $volume === false ) ? true : false;
if(!$prompt||$prompt==""||$prompt=="'-h'"||$prompt=="'--help'") {
	echo("  Run the script with regular script notation. Example:\n");
	echo("   ai --voices [see all voices available]\n");
	echo("   ai [chat] [pitch] [rate] [vol] ['voice'] ['file_name']\n");
	echo("      [chat] 'Ask for something here' \n");
	echo("      [pitch] 0.9 / 1 / 1.3 / 2\n");
	echo("      [speakingRate] 0.8 / 1 / 1.2 / 2.3\n");
	echo("      [volume] 0.2 / 0.4 / 0.6 / 1\n");
	echo("      [voice] en-US-Studio-M\n");
	echo("      [filename] 'voice_file' [output the spoken audio to MP3]\n");
	echo("      [language] en-us\n");
	echo("  Examples:\n");
	echo("   ai what is the sum of pi\n");
	echo("   php Speaking AI.php --voices\n");
	echo("   php ./Speaking\ AI.php \"where's pluto\" 1 1 1 'en-US-Neural2-H';\n");
	echo("   ai --help\n");
	exit();
} else if ($prompt=="'--voices'") {
	available_voices(false); exit();
} else if ($voice=="'random'") {
	$voice = available_voices(true);
}
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
		if(isset($data['choices'][0]['message'])){

			// print_r($data); // Raw AI Data

			$text = $data['choices'][0]['message']['content'];
			$read_lines=str_replace('- ', ' ... - ',$text);
			echo("\n	".$text."\n\n");

			if (!$muting) {
				read($text,$language,$voice,$pitch,$speakingRate,$volume,$file);
			}
		} else {
			print_r($data);
		}
	}
}
function read($text,$language,$voice,$pitch,$speakingRate,$vol,$file) {
	
	$google_api_key = "GOOGLE_API_KEY";

	if(getenv("GOOGLE_TTS_KEY") !== false) {
		$google_api_key=getenv("GOOGLE_TTS_KEY");
	}
	if($voice&&$voice!='0'&&$voice!='false'&&$file&&$file!='false'&&$file!='0') {
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
				echo($content->error->message);
		} else if($file&&$file!='false'&&$file!='0') {
			$base64 = $content->audioContent;
			$mp3 = base64_decode($base64);
			fwrite($myfile, $mp3);
			fclose($myfile);
			chmod($filename, 0755);
			if($vol>0)play($filename,$vol);
			if($file=='ai_speaking')unlink($filename);
		}
	}
}
function play($filename,$volumes) {
	if(isset($volumes)) {
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			$cmd="ffplay -v 0 -volume ".$volumes." -nodisp -autoexit ".$filename;
		} else {
			$cmd="afplay -v ".$volumes." ./".$filename.";";
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
	$voices = ["en-US-Neural2-A","en-US-Neural2-C","en-US-Neural2-D","en-US-Neural2-E","en-US-Neural2-F","en-US-Neural2-G","en-US-Neural2-H","en-US-Neural2-I","en-US-Neural2-J","en-US-Studio-M","en-US-Studio-O","en-US-Wavenet-G","en-US-Wavenet-H","en-US-Wavenet-I","en-US-Wavenet-J","en-US-Wavenet-A","en-US-Wavenet-B","en-US-Wavenet-C","en-US-Wavenet-D","en-US-Wavenet-E","en-US-Wavenet-F","en-US-News-K","en-US-News-L","en-US-News-M","en-US-News-N","en-US-Standard-A","en-US-Standard-B","en-US-Standard-C","en-US-Standard-D","en-US-Standard-E","en-US-Standard-F","en-US-Standard-G","en-US-Standard-H","en-US-Standard-I","en-US-Standard-J"];
	if($rand) {
		$r=rand(0,count($voices)-1);
		return $voices[$r];
	} else {
		echo(" Available voices:\n");
		foreach ($voices as $key => $value) echo("  ".$value."\n");
	}
}
