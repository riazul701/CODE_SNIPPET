LOCALLY RUNNING THE SITE (`file:///`)
Firefox comes with a very strict "file uri origin" (`file:///`) policy by default: to have it to behave just as other browsers, go to about:config, filter by fileuri and toggle the following preference:

`security.fileuri.strict_origin_policy`

Set it to **false** and you should be able to load local font resources across different path levels.

###### PUBLISHED SITE
As per my comment below, and you are experiencing this problem after deploying your site, 
you could try to add an additional header to see if your problem configures itself as a cross domain issue: 
it shouldn't, since you are specifying relative paths, but i would give it a try anyway: 
in your .htaccess file, specify you want to send an additional header for each .ttf/.otf/.eot file being requested:
```
<FilesMatch "\.(ttf|otf|eot)$">
    <IfModule mod_headers.c>
        Header set Access-Control-Allow-Origin "*"
    </IfModule>
</FilesMatch>
```
Frankly, I wouldn't expect it to make any difference, but it's so simple it's worth trying: 
else try to use base64 encoding for your font typeface, ugly but it may works too.
A nice recap is available [here](http://geoff.evason.name/2010/05/03/cross-domain-workaround-for-font-face-and-firefox/)