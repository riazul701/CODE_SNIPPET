## Backup All Gist

1. Save all gist information (gist id, description, last version SHA1 hash) into mysql database,
    using GitHub PHP api [https://github.com/KnpLabs/php-github-api].
2. Create text file from mysql database containing gist id separated by new_line.
3. In text file after last line place a new line, otherwise it will be ignored.
4. Execute the text file using gist_clone.sh
5. Gist PHP application stored in riazul702 at bitbucket.org