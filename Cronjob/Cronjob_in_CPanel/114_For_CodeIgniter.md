###### Without function Argument (Run at Every Minute)
    *	*	*	*	*	/usr/bin/php-cli -q /home/codagevps/public_html/sms/index.php cron_sms send_sms >/dev/null 2>&1
    
###### With function Argument (Run at Every Minute)
    *	*	*	*	*	/usr/bin/php-cli -q /home/codagevps/public_html/sms/index.php cron_sms send_sms 400 >/dev/null 2>&1 

###### Cron run at every day 12:00 PM 
    00 12 * * * /usr/bin/php-cli -q /home/codagevps/public_html/sms/index.php cron_notification notification_create >/dev/null 2>&1

###### Cron run at every day 05:00 AM
    00 05 * * * /usr/bin/php-cli -q /home/codagevps/public_html/sms/index.php cron_clean cron_sms_clean >/dev/null 2>&1

###### Cron run at 04:00PM and 05:00PM at Every Day
    0 	16,17 	* 	* 	* 	/usr/bin/php-cli -q /home/codagevps/public_html/sms/index.php cron_notification notification_create >/dev/null 2>&1  