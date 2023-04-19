# Talking AI Script

Command Line PHP Script that that talks back to you! Powered by: ChatGPT + Google Speech Synthesis. 

### Chatting

Just run the PHP script with regular PHP notation. Example:

      php Speaking_AI.php "Ask me a question..." [prompt] [pitch 0.25-4] [speaking rate] [volume 0-1] [voice] [language]
      
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
    
Please send love and feedback! :)
