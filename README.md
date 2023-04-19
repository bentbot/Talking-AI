# AI Talking Script

Command Line PHP Script that that talks back to you! Powered by: ChatGPT + Google Speech Synthesis. 

### Chatting

Just run the PHP script with regular PHP notation.

      php Speaking_AI.php "Ask me a question..." [prompt] [pitch 0.25-4] [speaking rate] [volume 0-1] [voice] [language]

Example Requests:

      php ./Speaking\ AI.php "Hello, are you there?" 1 1.2 0.3
      php ./Speaking\ AI.php "What were the first settlers in the Amazon rain forest?" 1 2 1 "en-US-Studio-M"
      php ./Speaking\ AI.php "What is the current world population?" 1 1.4 0.5 "en-US-Studio-O"
      php ./Speaking\ AI.php "What is Neuton's Law of Gravity?" 1 1 1 "en-US-Neural2-G"
      php ./Speaking\ AI.php "How many times does the earth orbit the sun per decade?" 1 1 1 "en-US-Neural2-H"
      php ./Speaking\ AI.php "Is life possible on any of Jupitar's moons?" 1 1 1 "en-US-Neural2-I"
      
      
Default options are as follows:
 - prompt: Required
 - pitch: 0.7
 - speakingRate: 0.3
 - volume: 0.4
 - voice: 'en-US-Studio-M'
 - language: 'en-us'

### Supported:
 - Mac
 - Linux
 
### Troubleshooting
 Please make sure you have `afplay` or equivalent for the play() function to work properly. You may want to replace the commands on lines 117 & 119 with your own system's choice command-line audio player.

### Available Voices (en-US)
en-US-Neural2-A (thru J)
en-US-Studio-M (thru O)
en-US-Wavenet-G (thru F)
en-US-News-K (thru N)
en-US-Standard-A (thru J)
Additional voices & languages can be found and tried on Google's TTS website.

Please send love and feedback! :)
