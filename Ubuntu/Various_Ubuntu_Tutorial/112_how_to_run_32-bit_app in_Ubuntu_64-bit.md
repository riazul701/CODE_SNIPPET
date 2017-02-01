

To run a 32-bit executable file on a 64-bit multi-architecture Ubuntu system, you have to add the i386 architecture and install the three library packages  libc6:i386, libncurses5:i386, and libstdc++6:i386:

    sudo dpkg --add-architecture i386

Or if you are using Ubuntu 12.04 LTS (Precise Pangolin) or below, use this:

    echo "foreign-architecture i386" > /etc/dpkg/dpkg.cfg.d/multiarch

Then:

    sudo apt-get update
    sudo apt-get install libc6:i386 libncurses5:i386 libstdc++6:i386

After these steps, you should be able to run the 32-bit application:

    ./example32bitprogram

