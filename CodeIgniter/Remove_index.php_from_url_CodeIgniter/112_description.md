Try It.

Open config.php and do following replaces

    $config['index_page'] = "index.php"
to

    $config['index_page'] = ""  
In some cases the default setting for uri_protocol does not work properly. Just replace

    $config['uri_protocol'] ="AUTO"

by

    $config['uri_protocol'] = "REQUEST_URI"
HTACCESS

    RewriteEngine on
    RewriteCond $1 !^(index\.php|resources|robots\.txt)
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L,QSA]