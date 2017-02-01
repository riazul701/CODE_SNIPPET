###### From [Tutsplus.com](http://code.tutsplus.com/tutorials/scheduling-tasks-with-cron-jobs--net-8800)
Source:  http://code.tutsplus.com/tutorials/scheduling-tasks-with-cron-jobs--net-8800  
Wikipedia Info: https://en.wikipedia.org/wiki/Cron 

###### Syntax
Here is a simple cron job:

1. 10 * * * * /usr/bin/php /www/virtual/username/cron.php > /dev/null 2>&1  

There are two main parts:  
1. The first part is "10 * * * *". This is where we schedule the timer.  
2. The rest of the line is the command as it would run from the command line.

The command itself in this example has three parts:  
1. "/usr/bin/php". PHP scripts usually are not executable by themselves. Therefore we need to run it through the PHP parser.
2. "/www/virtual/username/cron.php". This is just the path to the script.  
3. "> /dev/null 2>&1". This part is handling the output of the script. More on this later. 
 
###### Timing Syntax
This is the first part of the cron job string, as mentioned above. It determines how often and when the cron job is going to run.

It consists of five parts:

1. minute (0-59)
2. hour (0-23)
3. day of month (1-31)
4. month (1-12)
5. day of week (0-6) (Sunday is 0)


**Asterisk**

Quite often, you will see an asterisk (*) instead of a number. This represents all possible numbers for that position. For example, asterisk in the minute position would make it run every minute.

We need to look at a few examples to fully understand this Syntax.

**Examples:**

This cron job will run every minute, all the time:   

    * * * * * [command]
This cron job will run at minute zero, every hour (i.e. an hourly cron job):

    0 * * * * [command]
This is also an hourly cron job but run at minute 15 instead (i.e. 00:15, 01:15, 02:15 etc.):

    15 * * * * [command]
This will run once a day, at 2:30am:

    30 2 * * * [command]
This will run once a month, on the second day of the month at midnight (i.e. January 2nd 12:00am, February 2nd 12:00am etc.):

    0 0 2 * * [command]
This will run on Mondays, every hour (i.e. 24 times in one day, but only on Mondays):

    0 * * * 1 [command]
You can use multiple numbers separated by commas. This will run three times every hour, at minutes 0, 10 and 20:

    0,10,20 * * * * [command]
Division operator is also used. This will run 12 times per hour, i.e. every 5 minutes:

    */5 * * * * [command]
Dash can be used to specify a range. This will run once every hour between 5:00am and 10:00am:

    0 5-10 * * * [command]
Also there is a special keyword that will let you run a cron job every time the server is rebooted:

    @reboot [command]