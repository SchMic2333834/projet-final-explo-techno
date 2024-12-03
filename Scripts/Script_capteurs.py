#!/usr/bin/env python3
import mysql.connector
from datetime import datetime
import RPi.GPIO as GPIO
import time

Obstacle = 7 # pin7
Buzzer = 11 # pin11
Swicth = 13 # pin 13
Light = 15 # pin 15

def setup(pin1, pin2, pin3, pin4):
	global connection
	connection = mysql.connector.connect(
    	host="localhost",
    	user="raph",
    	password="cegep",
    	database="projet"
	)	

	
	global cursor
	global SwitchPin
	global BuzzerPin
	global ObstaclePin
	global LightPin
	cursor = connection.cursor()
	BuzzerPin = pin1
	ObstaclePin = pin2
	SwitchPin = pin3
	LightPin = pin4
	GPIO.setmode(GPIO.BOARD)       # Numbers GPIOs by physical location
	GPIO.setup(BuzzerPin, GPIO.OUT)
	GPIO.output(BuzzerPin, GPIO.HIGH)
	GPIO.setup(LightPin, GPIO.OUT)
	GPIO.output(LightPin, GPIO.LOW)
	GPIO.setup(ObstaclePin, GPIO.IN, pull_up_down=GPIO.PUD_UP)
	GPIO.setup(SwitchPin, GPIO.IN, pull_up_down=GPIO.PUD_UP)

def on():
	GPIO.output(BuzzerPin, GPIO.LOW)
	GPIO.output(LightPin, GPIO.HIGH)

def off():
	GPIO.output(BuzzerPin, GPIO.HIGH)
	GPIO.output(LightPin, GPIO.LOW)

def beep(x):
	on()
	time.sleep(x)
	off()
	time.sleep(x)

def format_time(dt):
    if dt is None:
        return ""
    fmt = "%m/%d/%Y %H:%M:%S"
    return dt.strftime(fmt)

def loop():
	activated = False
	intrusion = False
	while True:
		etat = GPIO.input(13)
		while etat == 1:
			if activated == False:
				cursor.execute('INSERT INTO tblActivation (OnOff, temps) VALUES (%s, %s)', (1, datetime.now()))
				connection.commit()
				activated = True
			etat = GPIO.input(13)
			if (0 == GPIO.input(ObstaclePin)):
				date = (datetime.now(),)
				if intrusion == False:
					cursor.execute('INSERT INTO tblDetection (temps) VALUES (%s)', (date))
					intrusion = True
				beep(0.05)
				connection.commit()
			if 1 == GPIO.input(ObstaclePin):
				intrusion = False
		if activated == True :
			cursor.execute('INSERT INTO tblActivation (OnOff, temps) VALUES (%s, %s)', (0, datetime.now()))
			connection.commit()
			activated = False

def destroy():
	if cursor is not None:
		cursor.close()
	if connection is not None:
		connection.close()
	GPIO.output(BuzzerPin, GPIO.HIGH)
	GPIO.cleanup()                     # Release resource

if __name__ == '__main__':     # Program start from here
	setup(Buzzer, Obstacle, Swicth, Light)
	try:
		loop()
	except KeyboardInterrupt:  # When 'Ctrl+C' is pressed, the child program destroy() will be  executed.
		destroy()

