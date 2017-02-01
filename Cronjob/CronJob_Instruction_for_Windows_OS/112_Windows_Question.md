
I am looking for a way to set cron job using PHP. All I would like to do is run a PHP script at a specific time. The user first inputs a time in a script, according to the time specified the server will run the script. I am using windows 7 and xampp.

What I have found is:

Create a php file that calls the cron.php file: Using notepad (or whatever), paste the following into a new file: $data = file(“http://pearl.supplychain.com/cron.php”); you’ll need to put it inside the regular php tags, with the “less than sign” ? php at the front, and the ? “greater than sign” at the end. (I can’t seem to just type that because it is “suspicious content” and drupal doesn’t allow it) Save it as executecron.php, into the same directory as cron.php (htdocs).

Set up a scheduled task that calls this regularly:

Open Start–All Programs–Accessories–System tools–Scheduled tasks.
Double-click on scheduled tasks.
Set up a Daily task that starts at 12:00 am and runs every half hour (or whatever) until 11:59 pm. Tell the task to “run” the following:

C:\cms\xampp\php\php.exe c:\cms\xampp\htdocs\executecron.php
(On this system, php.exe is installed in C:\cms\xampp\php, but you’ll probably have to change the path).

As you can see, to do this, one must Open Start–All Programs–Accessories–System tools–Scheduled tasks.

Can it specific by php code or using another way to do this? Because i want all the work done on php / server instead of need my user config the cron job themselves. Which means i want my php code can set the cron in server and server will look at the cron?

To stefgosselin:

To create the batch file

Open Notepad.
Paste the line "C:\xampp\php\php.exe C:\wamp\www\index.php"
Click "File" -> "Save As"
Ensure "Save as type:" is set to "All Files"
Save the file as "cron.bat" to your C drive
To schedule the batch file to run

Open Command Prompt
Paste the following "schtasks /create /sc minute /mo 20 /tn "PHP Cron Job" /tr C:\cron.bat"
Press Enter
This will make the script run every 20 minutes, the first time 20 minutes from now.
I am able to create a bath file using php, however, are there any way to Paste the following "schtasks /create /sc minute /mo 20 /tn "PHP Cron Job" /tr C:\cron.bat using php instead of using os? Thank you

Thank you