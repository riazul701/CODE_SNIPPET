###### Get Cron Time
* Login to http://www.example.com/whm (User Name: root, Password: CPanel Password)
* Go To Server Configuration->Server Time 

###### Configure cPanel Cron Jobs (Source: WHM)
Cron jobs are scheduled tasks that take place at predefined times or intervals on the server. 
Set the following variables to configure the cPanel & WHM Cron Jobs below:

**Minute:** The number of minutes between each execution of the cron job, or the minute of each hour on which you wish to run the cron job. For example, 15 to run the cron job every 15 minutes.

**Hour:** The number of hours between each execution of the cron job, or the hour each day (in military format) at which you wish to run the cron job. For example, 2100 to run the cron job at 9:00pm.

**Day:** The number of days between each execution of the cron job, or the day of the month on which you wish to run the cron job. For example, 15 to run the cron job on the 15th of the month.

**Month:** The number of months between each execution of the cron job, or the month of the year in which you wish to run the cron job. For example, 7 to run the cron job in July.

**Weekday:** The day(s) of the week on which you wish to run the cron job.

Enter * to indicate that the cron job should run at each interval. For example, a value of 0 indicates Sunday, 
or a value of 6 indicates Saturday. For example, a process set to run every day at 21:15 (or 9:15pm in 12-hour format) 
would be set to Minute = 15, Hour = 21, Day = *, Month = *, Weekday = *.