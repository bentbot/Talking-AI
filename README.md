# :sparkle: Talking AI Console Script

The AI program that talks back to you! It can be used to help solve complex problems when the solution is too challenging to too hard to find. It can help you accomplish simple tasks and write code. Please try the talking AI online: **[AI Search](http://liamhogan.ca/ai/)**

## Simple Talking AI in the Command Line
 1. Go to [Google Cloud Console](https://console.cloud.google.com/) and [OpenAI API 
Keys](https://platform.openai.com/account/api-keys) to generate API credentials.
 2. Edit the PHP script `Speaking_AI.php` to find & replace these API keys: `OPEN_API_KEY` and `GOOGLE_API_KEY`. Alternatively,  set them up as environment variables: `GOOGLE_TTS_KEY`,`OPEN_AI_API_KEY`,`AI_PATH`.
 3. Optional: Open `ai` with `nano ./ai` and customize your AI's voice characteristics. See the **Chatting** section.
 4. Install `ai` with the command `chmod +x ./ai;` and copy it into your local `bin` folder `sudo cp ./ai 
/usr/local/bin;` 
 5. Run it directly from the command line: `ai bake chocolate chip cookies`

## Command-Line Installation

1. Get ahold of these two keys:
```
OPEN_API_KEY
GOOGLE_API_KEY
```

2. Clone and install the AI by replacing those variables:
 ```
git clone https://github.com/bentbot/Talking-AI.git
cd Talking-AI
nano Speaking_AI.php ai
chmod +x ./ai
sudo cp ./ai /usr/local/bin
ai hello world
 ```
3. Play with the AI:
 ```
$ ai joke

  Why couldn't the bicycle stand up by itself? 

 Because it was two-tired.
 
 ```
Hahaha :laughing:

## Web Server Installation

1. Get ahold of these two keys:
```
OPEN_API_KEY
GOOGLE_API_KEY
```
2. Clone and install the AI by replacing those variables:
 ```
git clone https://github.com/bentbot/Talking-AI.git
cd Talking-AI
nano Speaking_AI.php 
 ```
3. Upload the AI to your server with FTP. Modify the directory the PHP file resides in so it is chmod mode 777. View it in your browser.

## Examples

 - `ai what is the sum of pi`
 - `php Speaking AI.php --voices`
 - `php ./Speaking\ AI.php "where's pluto" 1 1 1 'en-US-Neural2-H';`
 - `ai --help`

All speech options can be seen with the `--help` command.
```
ai --help
  Run the script with regular script notation. Example:
   ai --voices [see all voices available]
   ai [chat] 'make a demand' [pitch] 2 [speakingRate] 2.3 [volume] 1 [voice] 'en-US-Studio-M' [language] 'en-us'
      [chat] 'Ask for something here' 
      [pitch] 0.9 / 1 / 1.3 / 2
      [speakingRate] 0.8 / 1 / 1.2 / 2.3
      [volume] 0.2 / 0.4 / 0.6 / 1 / 0 (mute)
      [voice] 'en-US-Studio-M' / 'en-US-Wavenet-I' / false (mute) / 0 (mute)
      [filename] 'voice_file' (save spoken words to an MP3 file) / false or 0 may mute the audio playback.
      [language] 'en-us' (experimental)
```

## Chatting

Just run the PHP script **on a web server** or in the command line with regular PHP notation.

      php Speaking_AI.php "Ask me a question..." [prompt] [pitch 0.25-4] [speaking rate] [volume 0-1] [voice] 

*Please note that some answers that the AI may provide could include computer code and may not be considered short 
enough to synthesize to speech. Therefore, long text will sometimes appear and audio may not play.*

      php ./Speaking_AI.php "Hello, are you there?" 1 1.2 0.3
      php ./Speaking_AI.php "Who were the first settlers in the Amazon rain forest?" 1 2 1 "en-US-Studio-M"
      php ./Speaking_AI.php "What is the current world population?" 1 1.4 0.5 "en-US-Studio-O"
      php ./Speaking_AI.php "What is Neuton's Law of Gravity?" 1 1 1 "en-US-Neural2-G"
      php ./Speaking_AI.php "How many times does the earth orbit the sun per decade?" 1 1 1 "en-US-Neural2-H"
      php ./Speaking_AI.php "Is life possible on any of Jupitar's moons?" 1 1 1 "en-US-Neural2-I"

### Available Voices (en-US)
 - en-US-Neural2-A (thru J)
 - en-US-Studio-M (thru O)
 - en-US-Wavenet-G (thru F)
 - en-US-News-K (thru N)
 - en-US-Standard-A (thru J)
 - Use `--voices` to view the full list of English voices.
 - Additional voices & languages can be found and tried on [Google's TTS 
Demo](https://cloud.google.com/text-to-speech).
cli-ai cli ai terminal cmd shell power-shell google voice openai chat artificial intelligence command-line interface

## Troubleshooting
 - Make sure all required dependencies (`ai`, `afplay`, `ffplay`) are located in your local system `bin` folder
 - Please make sure you have `afplay` or `ffplay` by [ffmpeg](https://ffmpeg.org/download.html) installed and ready 
in order to hear the voices.
 - Make sure you've signed up for [Google Text-To-Speech Console](https://console.cloud.google.com/) and [OpenAI 
ChatGPT API](https://platform.openai.com/account/api-keys) access systems and inserted your API keys.
 - Do you have [PHP](https://www.google.com/search?q=php+download+and+install) installed on your computer system?

Please send love and feedback! :) [@bentbot](http://liamhogan.ca)
