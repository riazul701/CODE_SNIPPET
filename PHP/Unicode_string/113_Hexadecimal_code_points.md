**Source:** http://stackoverflow.com/questions/9990729/hexadecimal-code-points-from-string-in-php 
###### Question
I have a Greek text and I want to convert it to Hexadecimal code points without spaces. Just one big string of text.
This was exactly what I was looking for ->
[Unicode Hexadecimal code points for PHP](http://stackoverflow.com/questions/4721806/unicode-hexadecimal-code-points-for-php) 
but it doesn't provide the actual code how he did it.

###### Answer One
Based on the [original code](http://randomchaos.com/documents/?source=php_and_unicode) and the answer to this question: 
[How to get code point number for a given character in a utf-8 string?](http://stackoverflow.com/questions/395832/how-to-get-code-point-number-for-a-given-character-in-a-utf-8-string) 
I put together this function:
```php
function utf8_to_unicode($str) {

    $unicode = array();        
    $values = array();
    $lookingFor = 1;

    for ($i = 0; $i < strlen($str); $i++) {

        $thisValue = ord($str[$i]);

        if ($thisValue < 128) 
            $unicode[] = str_pad(dechex($thisValue), 4, "0", STR_PAD_LEFT);
        else {
            if (count($values) == 0) $lookingFor = ($thisValue < 224) ? 2 : 3;                
            $values[] = $thisValue;                
            if (count($values) == $lookingFor) {
                $number = ($lookingFor == 3) ?
                (($values[0] % 16) * 4096) + (($values[1] % 64) * 64) + ($values[2] % 64):
                (($values[0] % 32) * 64) + ($values[1] % 64);
                $number = strtoupper(dechex($number));
                $unicode[] = str_pad($number, 4, "0", STR_PAD_LEFT);
                $values = array();
                $lookingFor = 1;
            } // if
        } // if
    } // for
    return ($unicode);   
} // utf8_to_unicode
```

So:
```php
$greekString = "ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩ ";
$hexArray = utf8_to_unicode($greekString);
echo implode("", $hexArray);
```

Will output:
```
039103920393039403950396039703980399039A039B039C039D039E039F03A003A103A303A403A503A603A703A803A90032
```

###### Answer Two
```
header('Content-Type: text/html; charset=utf-8'); 

bin2hex(iconv('UTF-8', 'UTF-16BE', 'your message')); 
```