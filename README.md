# Tree-Pi
A Raspberry Pi-controlled water level monitor for Christmas trees

## Setup
## Hardware Setup
The hardware setup guide and information is <a href="https://hackaday.io/project/176144-tree-pi-raspberry-pi-christmas-tree-monitor">available on Hackaday.io</a>.

## Software Setup
First, you need to set up the Raspberry Pi with Raspbian Lite (tested on Raspbian Stretch). See <a href="https://www.raspberrypi.org/documentation/installation/installing-images/README.md">the Raspberry Pi website for instructions.</a> 

Next, insert the SD card into your Raspberry Pi, connect a monitor, keyboard, mouse and power supply and wait for it to boot.
If you want to run the Raspberry Pi headless, ensure that you have an SSH connection before continuing.

Once the Raspberry Pi is done booting, you will be presented with the command prompt. Now continue on to the next step to set up the software.

The very first step is to connect to WiFi and get the IP address. If you do not know how, <a href="https://learn.adafruit.com/adafruits-raspberry-pi-lesson-3-network-setup/setting-up-wifi-with-raspi-config-easy">Adafruit has created a great tutorial on how to do this here.</a> Make sure to write the IP address down, as we will be using this to access the website later on!

Then, install the dependencies:
  `sudo apt-get install -y npm node git`

Once this is done, download this repository with:
  `git clone https://github.com/alex-mous/Tree-Pi.git`
  
Then,move the contents of the folder to the location of the web server and delete the original folder:
```
sudo mkdir /server/
sudo chmod 755 /server/
sudo cp -r Tree-Pi/* /server/
sudo rm -r Tree-Pi
```

Now change to the location of the web server:
  `cd /server`

And open the config.json file so that you can receive emails:
  `sudo nano config.json`
  Inside of this file, replace YOUR_GMAIL_ADDRESS with your email address (must be Gmail, example: johndoe@gmail.com), YOUR_GMAIL_PASSWORD with your Google/Gmail app password, 
  YOUR_RECEIVING_ADDRESS with the email to which you would like to receive notifications and YOUR_SHUTDOWN_PASSWORD with a passphrase to prevent unauthorized shutdowns.

Next, install the startup script:
```
sudo cp server.service /etc/systemd/system/
sudo systemctl daemon-reload
sudo systemctl enable server.service
```

Then test the server by running:
  `sudo systemctl start server.service`
  
If all runs correctly, after a couple of minutes, the server should be available at http://IP_ADDRESS where IP_ADDRESS is the IP address of your Raspberry Pi.
