<h1>Tree Pi</h1>
<h2>How to build a Raspberry Pi-controlled water level monitor and alert system for natural Christmas trees</h2>

<h4>Problem</h4>
As anyone who has had a natural Christmas tree for Christmas knows, it is difficult to tell when and how much to water the tree needs. If not done correctly, watering the tree can result in either a large mess to clean up or a tree without any needles.

<h4>Solution</h4>
To solve these problems, I decided to create a Christmas tree water level monitor. It would have an interactive website so you can check how much water the tree has left. It would also send email reminders with the current water level and have a visual monitor for filling up the base to prevent you from overfilling and causing a mess.

<h4>What you will need:</h4>
Raspberry Pi - The case is designed for a full-size model (I used a Raspberry Pi B+, but any model such as the 2B or 3B+ should work)<br>
SD Card - 8GB in size; for the Raspberry Pi<br>
Micro USB Power Supply - for the Raspberry Pi<br>
7x Standard 5mm LEDs - I used red color LEDs<br>
4x M2.5x7.5 machine screws<br>
Lots of wire (threaded core) - I recommend using the wire from dead Christmas lights!<br>
Lots of wire (single core) - for the water probe; this should preferably not be a material that corrodes<br>
Heat shrink tube - if you use this you will also need a heat gun or you could use tape instead<br>
Stripboard - you need a piece that is 40x5 holes<br>
2x20 Pin Female Header - to connect the stripboard to the Raspberry Pi<br>
Access to a 3D Printer and the equipment required (filament, bed adhesion, print cleanup tools etc.)<br>
Soldering Equipment - to solder the connections<br>

<h4>Hardware Setup</h4>


<h4>Software Setup</h4>

First, you need to set up the Raspberry Pi  with Raspbian Lite. See <a href="https://www.raspberrypi.org/documentation/installation/installing-images/README.md">the Raspberry Pi website for instructions.</a> 

Next, insert the SD card into your Raspberry Pi, connect a monitor, keyboard, mouse and power supply and wait for it to boot. (For advanced users: you can also run your Raspberry Pi headless. Just make sure that you have a working SSH connection before continuing!)

Once the Raspberry Pi is done booting, you will be presented with the command prompt. Now continue on to the next step to set up the software.

The very first step is to connect to wifi and get the IP address. If you do not know how, <a href="https://learn.adafruit.com/adafruits-raspberry-pi-lesson-3-network-setup/setting-up-wifi-with-raspi-config-easy">Adafruit has created a great tutorial on how to do this here.</a> Make sure to write the IP address down, as we will be using this to access the website later on!

First, install the dependencies:
  sudo apt-get install -y apache2 php libapache2-mod-php ssmtp git

Once this is done, download this repository with:
  git clone https://github.com/polarpiberry/Tree-Pi.git
  
Then move the contents of the folder to the location of the web server:
  sudo cp -r Tree-Pi/* /var/www/html/

And delete the no longer needed Tree-Pi folder:
  sudo rm -r Tree-Pi/*

Now move to the location of the web server:
  cd /var/www/html

And open the ssmtp.conf file so that you can recieve emails:
  sudo nano ssmtp.conf

Find line that starts with AuthUser and replace <YOUR_GMAIL_HERE> with your email address (must be Gmail!, example: johndoe@gmail.com)

On the next line, (starts with AuthPass) replace <YOUR_GMAIL_PASSWORD_HERE> with your Google/Gmail password

Finally, copy this file to /etc/ssmtp/ssmtp with
  sudo cp ssmtp.conf /etc/ssmtp/ssmtp.conf
  
After this, you need to change the email address that will recieve alerts. Open this file with:
  sudo nano logs/address.txt

And replace <YOUR_RECIEVING_EMAIL_HERE> with your email address that you would like to recieve the alerts on.

Finally, change the permissions of the web files (and make them executable) so that the Pi can shut itself down:
  sudo cp sudoers /etc/sudoers
  sudo chmod +x hidden/*

Shutdown the Raspberry Pi, disconnect the peripherals and place it under your Christmas tree. Insert the measuring stick into the water base and make sure that the LEDs are clearly accessible. Then plug in the power again and your Raspberry Pi Christmas tree water level monitor is ready for use!

<h4>Using Tree Pi</h4>
This system is designed to stay on all the time. When you need to shut it down, the website has a Shutdown page.
