<h1>Tree Pi</h1>
<h2>Build a Raspberry Pi-controlled water level monitor and alert system for natural Christmas trees!</h2>

<h3>Problem</h3>
As anyone who has had a natural Christmas tree for Christmas knows, it is difficult to tell when and how much water the tree needs. If not done correctly, watering the tree can result in either a large mess to clean up or a tree without any needles.

<h3>Solution</h3>
To solve these problems, I decided to create a Christmas tree water level monitor. It would have an interactive website so you can check how much water the tree has left. It would also send email reminders with the current water level and have a visual monitor for filling up the base to prevent you from overfilling and causing a mess.

<h3>What you will need:</h3>
Raspberry Pi - The case is designed for a full-size model (I used a Raspberry Pi B+, but any model such as the 2B or 3B+ should work)<br>
SD Card - 8GB in size; for the Raspberry Pi<br>
Micro USB Power Supply - for the Raspberry Pi<br>
A WiFi dongle - if your Raspberry Pi is not WiFi capable<br>
7x Standard 5mm LEDs - I used red color LEDs<br>
4x M2.5x7.5 machine screws<br>
Lots of wire (threaded core) - I recommend using the wire from dead Christmas lights!<br>
Lots of wire (single core) - for the water probe; this should preferably not be a material that corrodes<br>
Heat shrink tube - if you use this you will also need a heat gun or you could use tape instead<br>
Stripboard - you need a piece that is 40x5 holes<br>
2x20 Pin Female Header - to connect the stripboard to the Raspberry Pi<br>
Access to a 3D Printer and the equipment required (filament, bed adhesion, print cleanup tools etc.)<br>
Soldering Equipment - to solder the connections<br>
A Gmail Account - for email alerts<br>

<h3>Hardware Setup</h3>
First, print all of the STL files in the STL folder on your 3D printer. Make sure to print the Measuring Stick in very high quality, or threading the wires will be very difficult!
<h4>Assembling the Measuring Stick</h4>
Strip a few inches of coating off of a piece of the single-core wire. Next, thread this into one of the holes on the Measuring Stick as shown by the red lines on the picture below. Once the end of the wire appears in the correct horizontal strip (one with the red arrows), hook it out using a skewer or metal pick and weave it in and out of the holes. Then repeat those steps for the rest of the holes, until it looks like the picture below. This is a slow and painful process, but you should hopefully not have to do it again!

<img src="https://github.com/polarpiberry/Tree-Pi/blob/master/Pictures/Measuring_stick_annotated.JPG" alt="Wires highlighted in measuring stick" height="400px"/><img src="https://github.com/polarpiberry/Tree-Pi/blob/master/Pictures/Measuring_stick_back.JPG" alt="Finished measuring stick" height="400px"/>

<h4>Assembling the LED Stick</h4>

Next, we can assemble the LED stick. First, insert the LEDs into the top part (it should be a snug fit - otherwise, add some clear glue/epoxy). After the LEDs are in or the glue has dried, solder them up as shown below (with the grounds connected together and a seperate wire going to each LED's positive terminal). Thread the wires through the bottom portion of the stick, and push the top part down into the bottom part to create the finished part. (This should be another snug fit. If not, as before apply some glue.)

<img src="https://github.com/polarpiberry/Tree-Pi/blob/master/Pictures/LEDs_wiring_close.JPG" alt="Close-up of the LED wiring" height="200px"/><img src="https://github.com/polarpiberry/Tree-Pi/blob/master/Pictures/LEDs_wiring.JPG" alt="LED wiring exposed" height="200px"/><img src="https://github.com/polarpiberry/Tree-Pi/blob/master/Pictures/LEDs.JPG" alt="Finished LED stick" height="200px"/>


<h4>Assembling the Raspberry Pi Case</h4>
Finally, we can install the Raspberry Pi.

First, solder the wires and a 2x20 socket (on the underside, not visible in the pictures) to the strip board. Use the <a href="https://github.com/polarpiberry/Tree-Pi/blob/master/Wiring%20Version1.pdf">wiring diagram PDF</a> and the picture below to guide you! If you do make an error, do not worry too much. You can easily change which pin goes to which function in the src/hidden/pin_setup, src/hidden/leds_on and src/hidden/read files.

<img src="https://github.com/polarpiberry/Tree-Pi/blob/master/Pictures/Wiring.JPG" alt="Wiring" height="200px"/>

After this, insert the Raspberry Pi into the case, screw in the screws, and plug in the socket. Route the wires through the slot in the side and close the lid. The final step is the add the screws!

<h3>Software Setup</h3>

First, you need to set up the Raspberry Pi  with Raspbian Lite. See <a href="https://www.raspberrypi.org/documentation/installation/installing-images/README.md">the Raspberry Pi website for instructions.</a> 

Next, insert the SD card into your Raspberry Pi, connect a monitor, keyboard, mouse and power supply and wait for it to boot. (For advanced users: you can also run your Raspberry Pi headless. Just make sure that you have a working SSH connection before continuing!)

Once the Raspberry Pi is done booting, you will be presented with the command prompt. Now continue on to the next step to set up the software.

The very first step is to connect to WiFi and get the IP address. If you do not know how, <a href="https://learn.adafruit.com/adafruits-raspberry-pi-lesson-3-network-setup/setting-up-wifi-with-raspi-config-easy">Adafruit has created a great tutorial on how to do this here.</a> Make sure to write the IP address down, as we will be using this to access the website later on!

First, install the dependencies:
  sudo apt-get install -y apache2 php libapache2-mod-php ssmtp git

Once this is done, download this repository with:
  git clone https://github.com/polarpiberry/Tree-Pi.git
  
Then move the contents of the folder to the location of the web server:
  sudo cp -r Tree-Pi/src/* /var/www/html/

And delete the no longer needed Tree-Pi folder:
  sudo rm -r Tree-Pi/*

Now move to the location of the web server:
  cd /var/www/html

And open the ssmtp.conf file so that you can receive emails:
  sudo nano ssmtp.conf

Find line that starts with AuthUser and replace <YOUR_GMAIL_HERE> with your email address (must be Gmail!, example: johndoe@gmail.com)

On the next line, (starts with AuthPass) replace <YOUR_GMAIL_PASSWORD_HERE> with your Google/Gmail password

Finally, copy this file to /etc/ssmtp/ssmtp with
  sudo cp ssmtp.conf /etc/ssmtp/ssmtp.conf

After this, you need to change the email address that will receive alerts. Open this file with:
  sudo nano logs/address.txt

And replace <YOUR_RECIEVING_EMAIL_HERE> with your email address that you would like to receive the alerts on.

Finally, change the permissions of the web files (and make them executable) so that the Pi can shut itself down:
  sudo cp sudoers /etc/sudoers
  sudo chmod +x hidden/*

Shutdown the Raspberry Pi, disconnect the peripherals and place it under your Christmas tree. Insert the measuring stick into the water base and make sure that the LEDs are clearly accessible. Then plug in the power again and your Raspberry Pi Christmas tree water level monitor is ready for use!

<h3>Using Tree Pi</h3>
The website is accessible over the network at the Raspberry Pi's IP address and at <a href="http://raspberrypi.local">raspberrypi.local</a> for Macs and Windows computers with Bonjour. (On any web browser, navigate to http://IP_ADDRESS. Note that the connection might take some time to connect, so please be patient!)<br>The website is designed to be intuitive to use, with the a home page to display the water level and alerts, a log page to view the log of readings (taken every 15 minutes), a shutdown page to shutdown the Raspberry Pi, a settings page to change the email address, maximum level and minimum level, and an LEDs page to turn on the LED system (<b>this page will appear to hang up when you put in a time, but it is just waiting for the timeout you set to expire</b>).<br>Before using the system, you will need to configure the maximum and minimum levels on the Settings page. To do this, start with min at 1 and max at 14, see how the level changes when the tree's base is empty and full, and adjust accordingly. 
