<h1>Tree Pi</h1>
<h2>How to build a Raspberry Pi-controlled water level monitor and alert system for natural Christmas trees</h2>

<h4>Problem</h4>
As anyone who has had a natural Christmas tree for Christmas knows, it is difficult to tell when and how much to water the tree needs. If not done correctly, watering the tree can result in either a large mess to clean up or a tree without any needles.

<h4>My Solution</h4>
To solve these problems, I decided to create a Christmas tree water level monitor. It would have an interactive website so you can check how much water the tree has left. It would also send email reminders with the current water level and have a visual monitor for filling up the base to prevent you from overfilling and causing a mess.

<h4>What you need:</h4>
Raspberry Pi - The case is designed for a full-size model (we used a Raspberry Pi B+, but any model such as the 2B or 3B+ should work)<br>
SD Card - 8GB in size; for the Raspberry Pi<br>
Micro USB Power Supply - for the Raspberry Pi<br>
7x Standard 5mm LEDs - we used red color LEDs<br>
4x M2.5x7.5 machine screws<br>
Lots of wire (threaded core) - we recommend using the wire from dead Christmas lights!<br>
Lots of wire (single core) - for the water probe; this should preferably not be a material that corrodes<br>
Heat shrink tube - if you use this you will also need a heat gun or you could use tape instead<br>
Stripboard - we need a piece that is 40x5 holes<br>
2x20 Pin Female Header - to connect the stripboard to the Raspberry Pi<br>
Access to a 3D Printer and the equipment required (filament, bed adhesion, print cleanup tools etc.)<br>
Soldering Equipment - to solder the connections<br>

<h4>Software Setup</h4>

We need to write the image to an SD card. Download Etcher from <a href="etcher.io" target="_blank">etcher.io</a>. Then, plug an SD card into your computer, open Etcher and write the disk image in the repository to your card.

<br><br>The default password is <b>treepi</b><br>

<h4>Using Tree Pi</h4>
This system is designed to stay on all the time. When you need to shut it down, the website has a Shutdown page.

<h4>The Results!</h4>
I have created an animation of the water filling process. See the screen shots of the website for information on the interface.
