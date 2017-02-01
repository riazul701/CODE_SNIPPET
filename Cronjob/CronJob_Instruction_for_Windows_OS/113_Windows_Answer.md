
I found my answer to that question at http://www.waytocode.com/2012/setup-cron-job-on-windows-server/

They provide 3 possible solutions to run cron jobs on Windows:

Solution-1 using Task scheduler

In your Windows 7/windows 2005/2008.

Go to Startmenu->All Programs->Accessories->System Tools->Task Scheduler->create Task

In the new window:

General (Give the Task name and for testing you can select “Run when User is logged in“)

Trigger (You can Select the running interval as “daily,weekly,monthly”. )

Action (This is most important part.Select a Mozilla firefox as the “program/script” and in the Argument provide the URL to fire with Mozilla firefox like http://www.waytocode.com/mycron.php).

Solution-2 using Task scheduler and PHP from your XAMPP server

In Windows Xp,no need to copy or install anything(Already PHP is installed on the server like XAMPP)

Goto Task scheduler

Create a task give Running time, then in avanced setting option in the “RUN” command textbox type

C:\xampp\php\php.exe -f c:/xampp/htdocs/waytocode/mycron.php
In Windows 7/server 2005/2008

No need to copy or install anything(Already PHP is installed on the server)

Create a task give Running time in Trigger setting.Then in Action setting option in the “Program/Script” command textbox type

C:\xampp\php\php.exe
and in the “Add arguments (optional)” type

-f c:/xampp/htdocs/mycron.php
Solution–3 install a Windows exe file that will simulate the cron job from *nix system

I don't like to install any exe file to my servers or development machine, but I'll provide the solution as they posted:

In Windows Xp,Copy all 2 DLL file with wget.exe to the C:\windows folder

Create a task give Running time then in avanced setting option in the “RUN” command textbox type

C:\Windows\wget.exe -q -O NUL http://localhost/mycron.php
In Windows 7/server 2005/2008 ,Copy all 2 DLL file with wget.exe to the C:\windows folder

Create a task give Running time then in avanced setting option in the “Program/Script” command textbox type

C:\Windows\wget.exe
and in the “Add arguments (optional)” type

-q -O NUL http://localhost/mycron.php
Solution-4 using a .bat file and the task scheduler

I found it here at Stackoverflow and it is similar to the first 2:

Create a cron.php file (the code you want to execute at a regular interval)

Create a CRON.BAT file, copy and past the below code in the file

D:\xampp\php\php.exe D:\xampp\htdocs\Application\cron.php

The path I have written is according to my xampp and cron.php file, update the path of files according to your system directory

To schedule a task Click on start > All Programs > Accessories > System Tools > Scheduled Tasks
Or you can go directly Control Panel > Scheduled Tasks

Right click in the folder New > Schedule Task

Give appropriate name to the Task. In the RUN text field… Type the complete path of the CRON.BAT file in my case it is

D:\xampp\htdocs\Application\CRON.BAT
Set the schedule of the job, you can use advanced button if required.

Solution-5

I don't like it either because one script can't depend on someone else website but it is a solution anyway.

Use an external online cron job service.

https://www.google.ca/search?q=cron+job+online+service

Chose one solution that it is more appropriate for you. Hope this will help someone.

UPDATE

Solution-6 (Based on the answers below, and works with CodeIgniter too!)

Create the cron.bat file and write the following command and save it.

@ECHO OFF
c:
cd C:\Program Files\Internet Explorer
START iexplore.exe http://localhost/path/to/cron/job/1
Create a task give Running time in Trigger setting.Then in Action setting option in the “Program/Script” command textbox type

C:\xampp\path\htdocs\folder\includes\cron.bat
END UPDATE

Answering your question:

Can it specific by php code or using another way to do this? Because i want all the work done on php / server instead of need my user config the cron job themselves. Which means i want my php code can set the cron in server and server will look at the cron?
There are other ways to do this:

Using cron manager from within PHP Using cron manager from within PHP

Managing Cron Jobs with PHP http://code.tutsplus.com/tutorials/managing-cron-jobs-with-php-2--net-19428

Unfortunately, all solutions with PHP needs a *nix server type and / or cPanel and are more or less complicated to implement.