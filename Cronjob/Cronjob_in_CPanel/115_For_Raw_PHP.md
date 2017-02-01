###### Cron run at every minute
    * * * * * /usr/bin/php -q /home/codagevps/public_html/sms/cron_sms_raw.php 400 >/dev/null 2>&1

###### Cron run at every 30 seconds
    * * * * * /usr/local/bin/php -q /home/codagevps/public_html/sms/cron_sms_raw.php 400 >/dev/null 2>&1
    * * * * * ( sleep 30 ; /usr/local/bin/php -q /home/codagevps/public_html/sms/cron_sms_raw.php 400 >/dev/null 2>&1 )