###### Using Page Refresh  
**From:** http://stackoverflow.com/questions/23028783/creating-schedule-task-without-cron-job  

There are multiple ways of doing repetitive jobs. Some of the ways that I can think about right away are:

1. Using: https://www.setcronjob.com/  

Use an external site like this to fire off your url at set intervals

1. Using meta refresh. More here (http://www.w3schools.com/tags/att_meta_http_equiv.asp). You'd to have to open the page and leave it running.

2. Javascript/Ajax refresh. Similar to the above example.
3. Setting up a cron job. Most shared hosting do provide a way to set up cron jobs. Have a look at the cPanel of your hosting.
