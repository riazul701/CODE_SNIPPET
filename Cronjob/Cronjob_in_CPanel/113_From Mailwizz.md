###### This cron job is from mailwizz email marketing software [http://www.mailwizz.com/]
###### Follow this for CodeIgniter in CPanel

Cron jobs - Please add the following cron jobs to your server
If you have problems in running the cron jobs, please read the Cron jobs common issues
(http://www.mailwizz.com/article/cron-jobs-common-issues) article for solutions.

Please note, below timings for running the cron jobs are the recommended ones, but if you feel you need
to adjust them, go ahead.

```
# Campaigns sender, runs each minute.
* * * * * /usr/bin/php‐cli ‐q /home/codagevps/public_html/email/apps/console/console
.php send‐campaigns >/dev/null 2>&1
# Transactional email sender, runs once at 2 minutes.
*/2 * * * * /usr/bin/php‐cli ‐q /home/codagevps/public_html/email/apps/console/conso
le.php send‐transactional‐emails >/dev/null 2>&1
# Bounce handler, runs once at 10 minutes.
*/10 * * * * /usr/bin/php‐cli ‐q /home/codagevps/public_html/email/apps/console/cons
ole.php bounce‐handler >/dev/null 2>&1
# Feedback loop handler, runs once at 20 minutes.
*/20 * * * * /usr/bin/php‐cli ‐q /home/codagevps/public_html/email/apps/console/cons
ole.php feedback‐loop‐handler >/dev/null 2>&1
# Delivery/Bounce processor, runs once at 3 minutes.
*/3 * * * * /usr/bin/php‐cli ‐q /home/codagevps/public_html/email/apps/console/conso
le.php process‐delivery‐and‐bounce‐log >/dev/null 2>&1
# Daily cleaner, runs once a day.
0 0 * * * /usr/bin/php‐cli ‐q /home/codagevps/public_html/email/apps/console/console
.php daily >/dev/null 2>&1
```

If you have a control box like CPanel, Plesk, Webmin etc, you can easily add the cron jobs to the server
cron.
In case you have shell access to your server, following commands should help you add the crons easily:

```
# copy the current cron into a new file
crontab ‐l > mwcron
# add the new entries into the file
echo "* * * * * /usr/bin/php‐cli ‐q /home/codagevps/public_html/email/apps/console/c
onsole.php send‐campaigns >/dev/null 2>&1" >> mwcron
echo "*/2 * * * * /usr/bin/php‐cli ‐q /home/codagevps/public_html/email/apps/console
/console.php send‐transactional‐emails >/dev/null 2>&1" >> mwcron
echo "*/10 * * * * /usr/bin/php‐cli ‐q /home/codagevps/public_html/email/apps/consol
e/console.php bounce‐handler >/dev/null 2>&1" >> mwcron
echo "*/20 * * * * /usr/bin/php‐cli ‐q /home/codagevps/public_html/email/apps/consol
e/console.php feedback‐loop‐handler >/dev/null 2>&1" >> mwcron
echo "*/3 * * * * /usr/bin/php‐cli ‐q /home/codagevps/public_html/email/apps/console
/console.php process‐delivery‐and‐bounce‐log >/dev/null 2>&1" >> mwcron
echo "0 0 * * * /usr/bin/php‐cli ‐q /home/codagevps/public_html/email/apps/console/c
onsole.php daily >/dev/null 2>&1" >> mwcron
# install the new cron
crontab mwcron
# remove the crontab file since it has been installed and we don't use it anymore.
rm mwcron
```

Or, if you like working with VIM, then you know you can manually add them.
Open the crontab in edit mode ( crontab ‐e ) add the cron jobs and save, that's all.