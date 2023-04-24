# :sparkle: Talking AI Script

Command Line PHP Script that that talks back to you! Powered by: ChatGPT + Google Speech Synthesis. 

## Simple AI Talking Command Line
 1. Go to [Google Cloud Console](https://console.cloud.google.com/) and [OpenAI API Keys](https://platform.openai.com/account/api-keys) to generate API credentials.
 1. Open the script with `nano ./Speaking_AI.php` and replace the two API key variables: `OPEN_API_KEY` & `GOOGLE_API_KEY` (lines 50, 91) in `Speaking_AI.php`.
 1. Open `ai` with `nano ./ai` and customize your AI's voice characteristics, see **Chatting**.
 2. Modify the `FULL_PAITH_TO_THIS_DIR_FILE` with the full system path to the PHP file. 
 3. Make sure all required dependencies are in your bin folder, an then install `ai` into it. *MacOS installation shown below.*
 ```
chmod +x ./ai
sudo cp ./ai /usr/local/bin
ai hello world
 ```

 ```
admin@MacBook ~ % ai joke

 		Why couldn't the bicycle stand up by itself? 

Because it was two-tired.
 
 ```
Baahaha. :laughing:

### Chatting

Just run the PHP script with regular PHP notation.

      php Speaking_AI.php "Ask me a question..." [prompt] [pitch 0.25-4] [speaking rate] [volume 0-1] [voice] [language]

*Please note that some answers that the AI may provide could include computer code and may not be considered short enough to synthesize to speech. Therefore, long text will sometimes appear and audio may not play.*

### Example Requests

      php ./Speaking_AI.php "Hello, are you there?" 1 1.2 0.3
      php ./Speaking_AI.php "Who were the first settlers in the Amazon rain forest?" 1 2 1 "en-US-Studio-M"
      php ./Speaking_AI.php "What is the current world population?" 1 1.4 0.5 "en-US-Studio-O"
      php ./Speaking_AI.php "What is Neuton's Law of Gravity?" 1 1 1 "en-US-Neural2-G"
      php ./Speaking_AI.php "How many times does the earth orbit the sun per decade?" 1 1 1 "en-US-Neural2-H"
      php ./Speaking_AI.php "Is life possible on any of Jupitar's moons?" 1 1 1 "en-US-Neural2-I"

### Default Options
 - prompt: Required
 - pitch: 0.7
 - speakingRate: 0.3
 - volume: 0.4
 - voice: 'en-US-Studio-M'
 - language: 'en-us'

### Supported:
 - Mac
 - Linux (untested)
 - Windows (untested)
 
### Troubleshooting
 - Please make sure you have `afplay` or `ffplay` by [ffmpeg](https://ffmpeg.org/download.html) installed and ready in order to hear the voices.
 - Make sure you've signed up for [Google Text-To-Speech Console](https://console.cloud.google.com/) and [OpenAI ChatGPT API](https://platform.openai.com/account/api-keys) access systems and inserted your API keys.
 - Do you have [PHP](https://www.google.com/search?q=php+download+and+install) installed on your computer system?

### Available Voices (en-US)
 - en-US-Neural2-A (thru J)
 - en-US-Studio-M (thru O)
 - en-US-Wavenet-G (thru F)
 - en-US-News-K (thru N)
 - en-US-Standard-A (thru J)
 - Use `--voices` to view the full list of English voices.
 - Additional voices & languages can be found and tried on [Google's TTS Demo](https://cloud.google.com/text-to-speech).

Please send love and feedback! :) [@bentbot](http://liamhogan.ca)
