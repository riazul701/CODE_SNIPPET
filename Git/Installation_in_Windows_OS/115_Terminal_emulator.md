###### Configuring the terminal emulator to use with Git Bash

**Which terminal emulator do you want to use with your Git Bash?**

- [ ] Use MinTTY (the default terminal of MSys2)

    Git Bash will use MinTTY as terminal emulator, which sports a resizable windows, non-rectangular
    selections and a Unicode font. Windows console programs (such as interactive Python) must be 
    launched via 'winpty' to work in MinTTY.

- [ ] Use Windows' default consolde window

    Git will use the default console window of Windows ("cmd.exe"), which works well with Win32 console
    programs such as interactive Python or node.js, but has a very limited default scorll-back, needs to
    be configured to use a Unicode font in order to display non-ASCII characters correctly, and prior to
    Windows 10 its window was not freely resizable and it only allowed rectangular text selections.