**Source:** http://stackoverflow.com/questions/2138527/php-curl-http-post-sample-code 
###### Question 
Can anyone show me how to do a php curl with an HTTP POST?
I want to send data like this:
```
username=user1, password=passuser1, gender=1
```
To `www.domain.com`
I expect the curl to return a response like `result=OK`. Are there any examples? 

###### Answer One
You'll find php/curl examples here: http://curl.haxx.se/libcurl/php/examples/, 
especially http://curl.haxx.se/libcurl/php/examples/simplepost.html 
```php
<?php
//
// A very simple PHP example that sends a HTTP POST to a remote site
//

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"http://www.mysite.com/tester.phtml");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "postvar1=value1&postvar2=value2&postvar3=value3");

// in real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS, 
//          http_build_query(array('postvar1' => 'value1')));

// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

curl_close ($ch);

// further processing ....
if ($server_output == "OK") { ... } else { ... }

?>
```
