## Gist Backup Procedure:

01. At first Give a try using testing account.
02. Gist Backup Software Website Address: https://github.com/sanusart/gists-backup 
03. Download Node.js from this website https://nodejs.org/en/ 
04. Install node-v4.2.3-x64.msi
05. Go to -> Windows Button -> All Programs -> Node.js -> Node.js command prompt
06. Pre-run:

    ```
    Run [sudo] npm install gist-backup --global
    ```
07. Run:

    ```
    gist-backup <github-username> <github-password> <path/to/backups>
     or just
    gist-backup (will be prompted for username, password and local path to backup directory)
    ```
08. If all went well, you'll see "gists" directory populated with directories named after gist description. Gists with similar descriptions will be appended with 'duplicate N' (where N is an incremented number), gists without description will simply be called 'Untitled'.