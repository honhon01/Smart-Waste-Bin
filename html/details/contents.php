<!DOCTYPE html>
<html>
    <head>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">
		<?php require_once '../navbar.php' ?>
        <title>Contents</title>
    </head>
    <body>
		<center>
			<h1 class="title is-1">Contents</h1>
			<p class="title is-6">Trash managing device connected with sigfox network</p>				
			<div class="box" box-background-black style="width: 1000px; ">
				<article class="media">			  
				<div class="media-left"></div>
					<div class="media-content">
						<div class="content">
							<p><strong>Which microcontrollers will be used?</strong>
							<br>
							In this project, we used Arduino MKR Fox 1200, Mini Microswitch, HC-SR04 - Ultrasonic Sensor, DHT11 - Temperature and Humidity sensor, KY-026 - Flame Sensor Module and Moisture Sensor</p>

							<strong>How long does it take to make it?</strong>
							<br>
							From scratch it took us 280 hours to make the Smart Waste-Bin. However, all the source code is available on Github. So, in a day or two you will be able to make it work. https://github.com/honhon01/Smart-Waste-Bin </p>
						</div>   
					</div>
				</article>
			</div>
		<br><br>			
			<div class="box" box-background-black style="width: 1000px; ">
				<article class="media">			  
				<div class="media-left"></div>
					<div class="media-content">
						<div class="content">
							<center><p><strong>Implementation Step</strong></p></center><br>
							<p><strong>Step 1 : Understand Sigfox</strong><br>
								Sigfox is a solution to connect the device in scope of Internet of Things. It’s currently operated in 45+ countries and 3 millions + devices. The message can be up to 12 bytes which maximum of 140 uplink and 4 downlink per day.
							
							
							
							</p>
							<br>
							<p><strong>Step 2 : Hardware Lookup</strong><br>
								<center><img src="/picture/step/devices.jpg" width="600" height="400"></center>
								The hardware we use in this project are : 
								<ul>
									<li>Arduino MKR Fox 1200</li>
									<li>Mini Microswitch</li>
									<li>HC-SR04 - Ultrasonic Sensor</li>
									<li>DHT11 - Temperature and Humidity sensor</li>
									<li>KY-026 - Flame Sensor Module</li>
									<li>Moisture Sensor (Custom Made) - The normal moisture sensor can be use but, after a few months of use the two two legs of the probe will be corrosion and the thin layer of copper on its legs will be completely eat away. So, we use custom made moisture sensor that made from copper to make it last longer before corrosion. http://carrefour-numerique.cite-sciences.fr/fablab/wiki/doku.php?id=projets:moisture_sensor</li>
									<li>Raspberry Pi 3 Model B</li>
								</ul>
								In this project we use custom made moisture sensor to make it last-long before corrosion.
								
							</p>
							<br>
							<p><strong>Step 3 : Hardware Connection and Layout</strong><br>
								<center><img src="/picture/step/schema.jpg" width="600" height="400"></center>
								<strong class="title is-5">Connection to Arduino MKR Fox 1200</strong><br><br>
								<p>
									<strong>Micro Switch -> Arduino MKR Fox 1200</strong>
									<ul>
										<li>C -> GND</li>
										<li>NC -> Pin 3</li>
									</ul>
								</p>
								<p>
									<strong>DHT11 -> Arduino MKR Fox 1200</strong>
									<ul>
										<li>VCC -> 5V</li>
										<li>GND -> GND</li>
										<li>DATA -> Pin 2</li>
									</ul>
								</p>
								<p>
									<strong>HC-SR04 -> Arduino MKR Fox 1200</strong>
									<ul>
										<li>VCC -> 5V</li>
										<li>GND -> GND</li>
										<li>Trigger -> Pin 9</li>
										<li>Echo -> Pin 10</li>
									</ul>
								</p>
								<p>
									<strong>KY-026 -> Arduino MKR Fox 1200</strong>
									<ul>
										<li>VCC -> 5V</li>
										<li>GND -> GND</li>
										<li>DATA -> Pin A0</li>
									</ul>
								</p>
								<p>
									<strong>Moisture Sensor (Custom Made) -> Arduino MKR Fox 1200</strong>
									<ul>
										<li>VCC -> 5V</li>
										<li>GND -> GND</li>
										<li>DATA -> Pin A1</li>
									</ul>
								</p>
								
							
							</p>
							<br>
							<p><strong>Step 4 : Arduino Code</strong><br>
								<strong>Install Arduino IDE :</strong><br>
								Install arduino IDE from this link : https://www.arduino.cc/en/Main/Software <br>
								<strong>Get the code :</strong><br>
								GitHub : https://github.com/honhon01/Smart-Waste-Bin <br>
								<strong class="title is-5">Board and Library :</strong><br>
								Before understanding the code, You need to install the board and library.<br>
								<strong>Board : </strong><br>
								To install the board, go to “Tools > Board > Board Manager...” <br>
								<center><img src="/picture/step/board.png" width="600" height="400"></center>
								
								<strong>Board Need : </strong><br>
								<ul>
									<li>Arduino SAMD Boards (32-bits ARM Cortex-M0+)</li>
								</ul>
								<strong>Library :</strong><br>
								To install the libraries, go to “Sketch > Include Library > Manage Libraries...”
								<center><img src="/picture/step/library.png" width="600" height="400"></center>
								<strong>Libraries need : </strong><br>
								<ul>
									<li>Arduino Low Power</li>
									<li>Arduino SigFox for MKRFox1200</li>
									<li>DHT sensor library</li>
									<li>Adafruit Unified Sensor Driver</li>
									<li>RTCZero</li>
								</ul>
								<strong class="title is-5">Look into the code :</strong><br>
								<ul>
									<li>#include "SigFox.h" : Use to manage the sigfox module and send or recieve the value from device.</li>
									<li>#include "ArduinoLowPower.h" : Use for put the Module to sleep and save the battery life.</li>
									<li>#include "DHT.h" : Normally, use for DHT11 to work</li>
								</ul>
								<strong>Functions :</strong><br>
								<ul>
									<li>setup() : In this function, we check if the SigFox has begin. Also, setup the DHT11 and Ultrasonic sensor pins.</li>
									<li>loop() : In this function, we check if the button is pressed which mean the bin is closed or not. If the button is not pressed the SigFox will not send the value but, If it pressed it will get the value from all sensors and send it to sendPayload() function.</li>
									<li>sendPayload() : This function will begin the SigFox module and send all values as byte to SigFox. Then it will end the SigFox module</li>
								</ul>
								<strong>Run the Code :</strong><br>
								After you understand how the code work. Try to compile and upload the code.<br>
								Don’t forget to select the board to Arduino MKR Fox 1200 and the port to your device port.


								
							</p>
							<br>
							<p><strong>Step 5 : Activate your device</strong><br>
							After you got your device, go to this link to activate the device https://buy.sigfox.com/activate. Then, fill in the informations and you’ll got the device install.
							<center><img src="/picture/step/register.png" width="600" height="400"></center>
							
							
							
							</p>
							<br>
							<p><strong>Step 6 : Sending the Data</strong><br>
								Try to run the Arduino IDE again and this time the device will be able to send the data to SigFox. You can check if you received data in the SigFox backend  https://backend.sigfox.com/device/list
								<center><img src="/picture/step/data.png" width="600" height="400"></center>
								
								
							
							</p>
							<br>
							
							<p><strong>Step 7 : Application Server</strong><br>
								
								<strong>Raspberry Pi 3 Model B</strong> is used as Application server. Which contain Node-red, MariaDB and the Web Application.<br>
							</p>
							<br>
							<p><strong>Step 8 : Backend Using Node-Red</strong><br>
								To get the data from SigFox, we need to create our own server to receive the data. We use Node-Red as the tool to get the data from SigFox.<br>
								<strong>Install Node-Red :</strong><br>
								Follow the instructions from this link : https://nodered.org/docs/getting-started/installation <br>
								<strong>Npm Need :</strong>
								<ul>
									<li>node-red-node-mysql</li>
								</ul>
								<center><img src="/picture/step/node-red.png" width="800" height="400"></center>

							
							
							</p>
							<br>
							<p><strong>Step 9 : Database - MariaDB</strong><br>
								<strong>Install MariaDB : </strong><br>
								Raspbian Raspberry Pi : https://howtoraspberrypi.com/mariadb-raspbian-raspberry-pi/ <br>
								Others OS : https://mariadb.com/downloads <br>

							
							
							
							</p>
							<br>
							<p><strong>Step 10 : Frontend Application (Website)</strong><br>
								This is the frontend of our project. The website show the information and data send from devices.
								<center><img src="/picture/step/website.png" width="900" height="400"></center>
							
							
							
							</p>
						</div>   
					</div>
				</article>
			</div>
		</center>
		
    </body>
    <?php require_once '../footer.php' ?>
</html>
