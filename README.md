# getPhotoByFileID
A php script which works with Telegram Bot API to show a photo by its file_id.


Simply rename the file `token.php.example` in `token.php` and put your bot token into the $api var.

Once uploaded on a web server, you can access photos from telegram using the url

 http://example.com/getPhotoByFileID/?file_id=FILEIDFROMTELEGRAM

To enable the bot, just set the webhook using the setwebhook method

https://api.telegram.org/botTOKENHERE/setwebhook?url=https://examplce.com/getPhotoByFileID/bot.php

**You MUST have HTTPS**
