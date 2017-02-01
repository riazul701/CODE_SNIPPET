#### Gmail Account Security Settings
###### Question
Im having problems with gmail smtp server.Although it is very well explained the error im getting i couldnt find a answer: 
Google SMTP just says "Please log in via your web browser and then try again". Im completely sure that the password and the email 
(both in base64) are well encoded.

###### Answer
I know this is an older issue, but I recently had the same problem and was having issues resolving it, 
despite attempting the DisplayUnlockCaptcha fix. This is how I got it alive.

Head over to Account Security Settings (https://www.google.com/settings/security/lesssecureapps) and enable 
"Access for less secure apps", this allows you to use the google smtp for clients other than the official ones.

**Update**

Google has been so kind as to list all the potential problems and fixes for us. Although I recommend trying the less secure apps setting. 
Be sure you are applying these to the correct account.

* If you've turned on 2-Step Verification for your account, you might need to enter an App password instead of your regular password.
* Sign in to your account from the web version of Gmail at https://mail.google.com. Once you’re signed in, try signing in 
  to the mail app again.
* Visit http://www.google.com/accounts/DisplayUnlockCaptcha and sign in with your Gmail username and password. If asked, enter the
  letters in the distorted picture.
* Your app might not support the latest security standards. Try changing a few settings to allow less secure apps access to your account.
* Make sure your mail app isn't set to check for new email too often. If your mail app checks for new messages more than once every 10
  minutes, the app’s access to your account could be blocked.
  