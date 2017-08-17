**Error file log: PHP Warning:  Unknown: open_basedir restriction in effect. File(/var/cpanel/php/sessions/ea-php55) is not within the allowed path(s): (/home:/tmp:/usr) in Unknown on line 0**

**A PHP Error was encountered**

Severity: Warning

Message: mkdir(): Invalid path

Filename: drivers/Session_files_driver.php

Line Number: 117

Backtrace:

File: /home/sbsociety/public_html/software/application/controllers/Login.php
Line: 7
Function: library

File: /home/sbsociety/public_html/software/index.php
Line: 315
Function: require_once




**An uncaught Exception was encountered**

Type: Exception

Message: Session: Configured save path '' is not a directory, doesn't exist or cannot be created.

Filename: /home/sbsociety/public_html/software/system/libraries/Session/drivers/Session_files_driver.php

Line Number: 119

Backtrace:

File: /home/sbsociety/public_html/software/application/controllers/Login.php
Line: 7
Function: library

File: /home/sbsociety/public_html/software/index.php
Line: 315
Function: require_once

