Solution Link: http://stackoverflow.com/questions/5208450/codeigniter-from-post-data-not-going-through 

I just had the same problem. I solved it this way. in application/config/config.php you set the base_url please be aware of, 
that this url have to be exact the same as the one you're calling your web app. For me, I called my domain with www.sdfsd.com, 
but in the config file I wrote http://sdfsd.com and so the POST of the form didn't work. So I changed this and now everything is working!!

Note that your base URL must match the action attribute of forms if you are using the full URL. 
For example if base_url = http://www.mysite.com and you use 
```
<form method="post" action="http://mysite.com/my_script"> 
```
you will receive an empty $_POST array.
