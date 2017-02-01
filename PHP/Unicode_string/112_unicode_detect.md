**Source:** http://stackoverflow.com/questions/1350758/check-unicode-in-php 
###### Question
How can I check whether a character is a Unicode character or not with PHP? 

###### Answer One
Actually you don't even need the mb_string extension: 
```php
if (strlen($string) != strlen(utf8_decode($string)))
{
    echo 'is unicode';
}
```
And to find the code point of a given character:
```php
$ord = unpack('N', mb_convert_encoding($string, 'UCS-4BE', 'UTF-8'));

echo $ord[1];
```