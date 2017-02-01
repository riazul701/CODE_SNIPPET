**Problem:** During list creation, when upload text file with email address, 
Software detect some text file as non-text file [Mime Type].

**Solution:**  
01. Drag and Drop text file in Google Chrome. Print the file as pdf. Pdf settings: 
```
Destination: Save as PDF
Pages: All
Layout: Portrait
Pager size: Letter
Margins: Default
Option: Header and footers [Checked]
        Background graphics [Unchecked]
```

02. Goto http://www.zamzar.com/ and convert uploaded pdf file to text file.
03. Goto receiving Email address that was entered in http://www.zamzar.com/ and Download the file.
04. Check the file type in http://www.checkfiletype.com/ File type will be
```
File Type: ASCII text, with CRLF line terminators

MIME Type: text/plain;
Suggested file extension(s): asc txt
```